<?php

namespace App\Http\Livewire;

use App\Models\Actividad;
use App\Models\Fondoconcursable;
use Livewire\Component;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;
use App\Models\Presupuestoeq;
use App\Models\Presupuestogg;
use App\Models\Presupuestorh;
use App\Models\Tipoproyecto;
use App\Models\Provincia;
use App\Models\User;
use App\Models\Comuna;
use App\Models\Objetivosespecifico;
use App\Models\Organizacion;
use App\Models\Proyecto;
use App\Models\Periodopostuad;
use App\Models\Representante;
use App\Models\Documento;
use App\Models\Rrhhproyecto;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Mail\CorreoNotificacion;
use App\Models\Banco;
use App\Models\Tipocuenta;
use App\Models\Tipovia;
use Illuminate\Support\Facades\Mail;
use App\Rules\RunValidator;
use Illuminate\Validation\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\MicrosoftGraphService;
use Illuminate\Support\Facades\View;

class Postulacionasignaciondirecta extends Component
{
    use WithFileUploads;

    public $currentStep;

    //Vars Paso 0
    public $proyectos, $proyectosWithCodProyecto, $proyectosDD, $proyectosGralesNotDD, $proyectosMergeDDNotDD, $periodosPostuAD,
        $runOrganizacion, $dvRunOrganizacion, $flgDisabldBtnNvaPostulacion, $agnoActual;

    //Vars Paso 1
    public $idOrganizacion, $rutRepLegal, $dvRutRepLegal, $nombreOrganizacion, $agnosExistencia, $codTipoVia, $nombreVia, $direccionOrganizacion,
        $numDireccion, $descripTipoVia, $idProvinciaOrg, $idComunaOrg, $telefonoOrganizacion, $correoOrganizacion,
        $fecVencDirectiva, $resetValidate = "1", $flgChangeStep1, $flgChangeStep2, $flgChangeStep3, $comunasOrg,
        $idBanco, $idTipocuenta, $numeroCuenta,
        //Combobox Paso 1
        $bancos, $tipoCuentas, $tipoViasCmb,
        //Rep Legal
        $idRepLegal, $runRepLegal, $dvRepLegal, $nomRepLegal, $telefonoRepLegal, $correoRepLegal;

    //Vars Paso 2

    public $idProyecto, $codProyecto, $nombreProyecto, $nomEntidad, $tabActive, $idFondoConcursable, $montoProyecto, $duracionProyecto,
        $tipoproyecto, $idTipoProyecto, $idProvinciaProy, $cantBenefHombreProy, $cantBenefMujerProy,
        $resumenProyecto, $objetivoProyecto, $idComunaProy, $idDocumentoProy, $mensajeStep2, $moveId,
        $descripcionFondo, $montoMinFondo, $montoMaxFondo, $duracionMinMeses, $duracionMaxMeses, $cantTotalBenef,
        $descripNecesidadACubrir, $descripTerritorioBenef, $descripDifusionProy, $descripResultadoProy,
        $descripMedioVerifPostEjecuProy, $descripBienesServRRHHActividad, 
        /*MVillalobos 27-05-2025 (+)*/$montoMinTipoProyecto, $montoMaxTipoProyecto, $descripcionTipoProyecto/*MVillalobos 27-05-2025 (-)*/;  
        
    //Combobox Paso 2
    public $fondoConcursable, $provincias, $comunas;

    public ?Collection $inputsObjEspecifico = null, $inputsActividad = null, $inputsDescripRRHH = null,
        $inputsRecursosHumanos = null, $inputsGastosGenerales = null, $inputsEquipamiento = null;


    //Vars Paso 3
    public $docProyecto, $randId, $totalRRHH, $totalGG, $totalEquip, $tipoBusqueda;

    //Vars Paso 4
    public $rutaDocumento, $fechaSolicitud, $flgExeptionMailSolicitante, $idDoc;

    protected $listeners = ['fourthStep'];


    public function inicio()
    {
        $this->currentStep = 0;
        $this->agnoActual = now()->year;
        $this->inicializarInputs();
        $this->inputsRecursosHumanos = collect();
        $this->inputsGastosGenerales = collect();
        $this->inputsEquipamiento = collect();
        $this->inputsDescripRRHH = collect();
        $this->tabActive = 1;
        $this->randId = rand(0, 1000);
        $this->idDoc = "idDoc" . rand(0, 1000);
        $this->idRepLegal = 0;
        $this->fondoConcursable = Fondoconcursable::where('flgVisible', '=', 1)->where('fondoconcursables.codigoFondoConcursable', '=' ,'AD')->get();  
        $this->provincias = Provincia::all();
        $this->bancos = Banco::all();
        $this->tipoCuentas = Tipocuenta::all();
        $this->tipoViasCmb = Tipovia::all(); //MV 20-03-2024 Solicitado por Joselyn San Juan
        //$this->flgChange = false;
        $this->idProvinciaOrg = 0;
        $this->idComunaOrg = 0;
        $this->idFondoConcursable = 0;
        $this->montoMaxFondo =  0;
        $this->montoMinFondo =  0;
        $this->duracionMinMeses = 0;
        $this->duracionMaxMeses = 0;
        $this->flgDisabldBtnNvaPostulacion = true;

        $this->verificarCierrePostu();
    }

    public function verificarCierrePostu()
    {
        // $fechaActual = Carbon::parse(now())->format('Y-m-d H:i:s');
        $fechaActual = Carbon::parse(now())->format('Y-m-d');

        // dd($fechaActual, Periodospostu::where([['fechaInicioPostu', '<=', $fechaActual, ],['fechaFinPostu','>=', $fechaActual]])->toSql());

        // $this->periodosPostu =  Periodospostu::where([['fechaInicioPostu', '<=', $fechaActual, ],['fechaFinPostu','>=', $fechaActual]])->first();

        $this->periodosPostuAD =  Periodopostuad::whereRaw("DATE_FORMAT(fechaInicioPostu, '%Y-%m-%d') <= '" . $fechaActual . "' and DATE_FORMAT(fechaFinPostu, '%Y-%m-%d') >= '" . $fechaActual . "'")->first();


        if (empty($this->periodosPostuAD)) {
            $this->currentStep = -1;
        }
    }

    public function mount()
    {

        $this->inicio();

        // $this->runOrganizacion = "15954646";
        // $this->dvRunOrganizacion = "2";
        // $this->cargarDatosRun();
    }

    public function render()
    {
        return view('livewire.postulacionasignaciondirecta');
    }

    function inicializarInputs()
    {
        $this->fill([
            'inputsObjEspecifico' => collect([[
                'idObjEspecifico' => '0', 'descripcionObjEspecifico' => ''
            ]]),
        ]);

        $this->fill([
            'inputsActividad' => collect([[
                'idActividad' => '0', 'tituloActividad' => '', 'descripcionActividad' => '', 'mesesEjecuActividad' => [], 'descripBienesServRRHHActividad' => ''
            ]]),
        ]);


        // $this->fill([
        //     'inputsDescripRRHH' => collect([[
        //         'idRRHHProyecto' => '0', 'descripCargo' => '', 'descripFuncActividades' => '', 'descripPerfilCargo' => '',
        //         'totalHorasServicio' => '', 'descripPeriocidadServicio' => '', 'montoTotalServicio' => ''
        //     ]]),
        // ]);

        // $this->fill([
        //     'inputsRecursosHumanos' => collect([[
        //         'idPptoRRHH' => '0', 'perfil' => '', 'idActividad' => '0', 'idProyecto' => '0', 'canthora' => '', 'valorhora' => '', 'montototal' => '',
        //     ]]),
        // ]);

        // $this->fill([
        //     'inputsGastosGenerales' => collect([[
        //         'idPptoGG' => '0', 'idProyecto' => '0', 'detabienesservicio' => '', 'idActividad' => '0', 'descripcion' => '', 'montototal' => '',
        //     ]]),
        // ]);

        // $this->fill([
        //     'inputsEquipamiento' => collect([[
        //         'idPptoEq' => '0', 'idProyecto' => '0', 'detaequipo' => '', 'idActividad' => '0', 'cantidad' => '', 'montototal' => '',
        //     ]]),
        // ]);
    }


    public function cargarDatosProyectoSel($idProyecto)
    {
        try {

            $proyecto = Proyecto::where('idProyecto', '=', $idProyecto)->first();

            $this->idProyecto = $proyecto->idProyecto;
            $this->codProyecto = $proyecto->codProyecto;
            $this->nombreProyecto = $proyecto->nombreProyecto;
            $this->montoProyecto = $proyecto->montoProyecto;
            $this->duracionProyecto = $proyecto->duracionProyecto;
            $this->idComunaProy = $proyecto->idComunaProy;
            $this->objetivoProyecto = $proyecto->objetivoProyecto;
            $this->descripNecesidadACubrir = $proyecto->descripNecesidadACubrir;
            $this->descripTerritorioBenef = $proyecto->descripTerritorioBenef;
            $this->descripDifusionProy = $proyecto->descripDifusionProy;
            $this->descripResultadoProy = $proyecto->descripResultadoProy;
            $this->descripMedioVerifPostEjecuProy = $proyecto->descripMedioVerifPostEjecuProy;
            $this->cantBenefHombreProy = $proyecto->cantBenefHombreProy;
            $this->cantBenefMujerProy = $proyecto->cantBenefMujerProy;
            $this->cantTotalBenef = $this->cantBenefHombreProy + $this->cantBenefMujerProy;
            $this->resumenProyecto = $proyecto->resumenProyecto;
            $this->idDocumentoProy = $proyecto->idDocumentoProy;
            $this->idTipoProyecto = $proyecto->idTipoProyecto;
            $this->idProvinciaProy = $proyecto->idProvinciaProyecto;
            $this->idComunaProy = $proyecto->idComunaProyecto;
            $this->idFondoConcursable = $proyecto->idFondoConcursableProyecto;
            $this->fechaSolicitud = $proyecto->created_at;

            $this->montoMaxFondo =  0;
            $this->montoMinFondo =  0;
            $this->duracionMaxMeses = 0;
            $this->duracionMinMeses = 0;

            if ($this->idFondoConcursable > 0) {
                $fondoConcursablePaso = $this->fondoConcursable->where('idFondoConcursable', '=', $this->idFondoConcursable)->first();
                $this->montoMaxFondo =  $fondoConcursablePaso->montoMaxFondo;
                $this->montoMinFondo =  $fondoConcursablePaso->montoMinFondo;
                $this->duracionMinMeses = $fondoConcursablePaso->duracionMinMeses;
                $this->duracionMaxMeses = $fondoConcursablePaso->duracionMaxMeses;
                $this->descripcionFondo = " para el fondo: ".ucwords(mb_strtolower($fondoConcursablePaso->descripcionFondoConcursable, 'UTF-8')); 
            }

            //MV 23-05-2025 Si el tipo de proyecto y tiene un monto asignado se considera el del proyecto y no el del fondo
            if ($this->idTipoProyecto > 0) {
                $tipoProyecto = Tipoproyecto::where('idTipoProyecto', '=', $this->idTipoProyecto)->first();
                if (!empty($tipoProyecto->montoMaximo)) {
                if ($tipoProyecto->montoMaximo > 0)  {
                //Los valores son asignados a las mismas variables del fondo para reutilizar la logica de validacion existente para el fondo
                    $this->montoMaxFondo =  $tipoProyecto->montoMaximo;
                    $this->montoMinFondo =  $tipoProyecto->montoMinimo;
                    $this->duracionMinMeses = $tipoProyecto->duracionMinMeses;
                    $this->duracionMaxMeses = $tipoProyecto->duracionMaxMeses;
                    $this->descripcionFondo = " para el tipo de proyecto: ".ucwords(mb_strtolower($tipoProyecto->descripcionTipoProyecto, 'UTF-8')); 
                }
               }

            }
            //MV 23-05-2025 Si el tipo de proyecto tiene un monto asignado se toma el del proyecto y no el del fondo

            $organizacion = Organizacion::where('idOrganizacion', '=', $proyecto->idOrganizacionProyecto)->first();

            $this->idOrganizacion = $organizacion->idOrganizacion;
            $this->runOrganizacion = $organizacion->runOrganizacion;
            $this->dvRunOrganizacion = $organizacion->dvRunOrganizacion;
            $this->nombreOrganizacion = $organizacion->nombreOrganizacion;
            $this->agnosExistencia = $organizacion->agnosExistencia;
            $this->direccionOrganizacion = $organizacion->direccionOrganizacion;
            $this->codTipoVia = $organizacion->codTipoVia;
            $this->nombreVia = $organizacion->nombreVia;
            $this->numDireccion = $organizacion->numDireccion;
            $this->telefonoOrganizacion = $organizacion->telefonoOrganizacion;
            $this->correoOrganizacion = $organizacion->correoOrganizacion;
            $this->fecVencDirectiva = $organizacion->fecVencDirectiva;
            $this->idProvinciaOrg = $organizacion->idProvinciaOrg;
            $this->idComunaOrg = $organizacion->idComunaOrg;
            $this->idRepLegal = $organizacion->idRepLegal;
            $this->idBanco = $organizacion->idBanco;
            $this->idTipocuenta = $organizacion->idTipocuenta;
            $this->numeroCuenta = $organizacion->numeroCuenta;

            $this->comunasOrg = Comuna::where('idProvincia', '=', $this->idProvinciaOrg)->get();

            $representante = Representante::where('idRepLegal', '=', $this->idRepLegal)->first();
            if (!empty($representante)) {
                $this->rutRepLegal = $representante->rutRepLegal;
                $this->dvRutRepLegal = $representante->dvRutRepLegal;
                $this->nomRepLegal = $representante->nomRepLegal;
                $this->telefonoRepLegal = $representante->telefonoRepLegal;
                $this->correoRepLegal = $representante->correoRepLegal;
            }

            $this->comunas = Comuna::where('idProvincia', '=', $proyecto->idProvinciaProyecto)->get();        

            $this->tipoproyecto = Tipoproyecto::where('idFondoConcursable', '=', $proyecto->idFondoConcursableProyecto)            
                                    ->where('flgProyectoVisible', '=', 1) //MV 23-03-2024: Se agrega filtro para no mostrar proyectos de año anteriores que ya no se encuentran vigente 
                                    ->get();

            $documento = Documento::where('idDocumento', '=', $proyecto->idDocumentoProyecto)->first();
            $this->idDocumentoProy = 0;
            if (!empty($documento)) {
                $this->idDocumentoProy = $documento->idDocumento;
                $this->rutaDocumento = $documento->rutaDocumento;
            }

            $objetivoespecifico = Objetivosespecifico::where('idProyecto', '=', $proyecto->idProyecto)->get();

            if (count($objetivoespecifico) > 0) {
                $this->inputsObjEspecifico = collect($objetivoespecifico);
            }

            $actividad = Actividad::where('idProyecto', '=', $proyecto->idProyecto)->get();

            if (count($actividad) > 0) {
                $this->inputsActividad = collect($actividad); //Verificar campo mesesEjecucProyecto

                foreach ($actividad as $index => $itemAct) {
                    $this->inputsActividad[$index]['mesesEjecuActividad'] = explode(',', $itemAct->mesesEjecuActividad);
                }
            }


            $RRHHProyecto = Rrhhproyecto::where('idProyecto', '=', $proyecto->idProyecto)->get();

            if (count($RRHHProyecto) > 0) {
                $this->inputsDescripRRHH = collect($RRHHProyecto);
            }

            //Carga de Datos Paso 3
            $pptoRRHH = Presupuestorh::where('idProyecto', '=', $proyecto->idProyecto)->get();

            if (count($pptoRRHH) > 0) {
                $this->inputsRecursosHumanos = collect($pptoRRHH);
            }

            $pptoGastosGrales = Presupuestogg::where('idProyecto', '=', $proyecto->idProyecto)->get();

            if (count($pptoGastosGrales) > 0) {
                $this->inputsGastosGenerales = collect($pptoGastosGrales);
            }

            $pptoEquip = Presupuestoeq::where('idProyecto', '=', $proyecto->idProyecto)->get();

            if (count($pptoEquip) > 0) {
                $this->inputsEquipamiento = collect($pptoEquip);
            }
            $this->totalRRHH = count($this->inputsRecursosHumanos) == 0 ? 0 : $this->inputsRecursosHumanos->where('montototal', '>', 0)->sum('montototal');
            $this->totalGG = count($this->inputsGastosGenerales) == 0 ? 0 : $this->inputsGastosGenerales->where('montototal', '>', 0)->sum('montototal');
            $this->totalEquip = count($this->inputsEquipamiento) == 0 ? 0 : $this->inputsEquipamiento->where('montototal', '>', 0)->sum('montototal');
            $this->currentStep = 1;
        } catch (exception $e) {
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'error',
                'mensaje' => 'Se ha producido un error al intentar cargar los datos para el proyecto seleccionado',
            ]);
            session()->flash('exceptionMessage', $e->getMessage());
        }
    }


    // public function updatedIdFondoConcursable($idFondo)
    // {

    //     try {
    //         $this->validateFondoconcursable();
    //     } catch (exception $e) {
    //         $this->idFondoConcursable = 0;
    //         $this->dispatchBrowserEvent('swal:modal', [
    //             'icon' => 'warning',
    //             'mensaje' => $e->getMessage(),
    //         ]);
    //         $this->dispatchBrowserEvent('moveScroll', ['id' => '#datosAdmHead']);
    //     }

    //     $this->tipoproyecto = Tipoproyecto::where('idFondoConcursable', '=', $this->idFondoConcursable)->get();
    //     $this->idTipoProyecto = 0;
    // }

    public function updated($field, $value)
    {
        // dd(implode(', ', $value), $value); Input: ["ene", "abr", "jul"] Resultado: "ene, abr, jul" con explode se vuelve a convertir en array

        // dd($this->flgConfirmar);
        $this->verificarCierrePostu();

        if ($this->currentStep == -1) {
            $this->volverInicio();
        }
        if ($this->currentStep == 0) {
            $this->resetExcept('runOrganizacion', 'dvRunOrganizacion');
            $this->inicio();
            $this->validate($this->getArrValidateRun());
            $this->dvRunOrganizacion = strtoupper($this->dvRunOrganizacion);
            $this->cargarDatosRun();
            $this->flgDisabldBtnNvaPostulacion = false;
        } else
            if ($this->currentStep == 1) {
            $this->flgChangeStep1 = true;
            $this->descripTipoVia = "";
            $this->validateOnly($field, array_merge($this->getArrValidateDatosOrg(), $this->getArrValidateDatosRepLegal()));
            $this->dvRutRepLegal = strtoupper($this->dvRutRepLegal);

            if ($field == 'codTipoVia' && $value > 0) {
                $this->descripTipoVia  = (Tipovia::where('codTipoVia', '=', $this->codTipoVia)->get()->toArray())[0]['descripTipoVia'];
            }

            if ($field == 'idProvinciaOrg') {
                $this->comunasOrg  = Comuna::where('idProvincia', '=', $this->idProvinciaOrg)->get();
                $this->idComunaOrg = 0;
            }
        } else
           if ($this->currentStep == 2) {
            $this->flgChangeStep2 = true;
            $this->mensajeStep2 = "";
            $this->moveId = "";

            $indexInputHash = [];
            if (strpos($field, "inputs") > -1) {
                $arrNameInput = explode(".", $field);
                $indexInputHash =  [$arrNameInput[0]/*key*/ => $arrNameInput[1]/*Valor Indice*/];
            }

            if ($field == 'idFondoConcursable') { 
                $this->resetValidation('montoProyecto');
                $this->resetErrorBag('montoProyecto');
                $this->resetValidation('idTipoProyecto');
                $this->resetErrorBag('idTipoProyecto');
                $this->reset('tipoproyecto');                 
                $this->resetValidation('duracionProyecto');
                $this->resetErrorBag('duracionProyecto');
                $this->reset('montoMaxFondo', 'montoMinFondo', 'duracionMinMeses', 'duracionMaxMeses');
            }

           //Si las validaciones se estan realizando por tipo de proyecto y no por fondo concursable siempre se resetean (por ejemplo los tipos de proyectos correspondientes al fondo de asignacion directa) (+)
             if ($field == 'idTipoProyecto') {
                  $tipoProyecto = Tipoproyecto::where('idFondoConcursable', '=', $this->idFondoConcursable)
                                      ->where('flgProyectoVisible', '=', 1) //MV 27-05-2025: Se agrega filtro para no mostrar proyectos de año anteriores que ya no se encuentran vigente
                                      ->where('montoMaximo', '>', 0) 
                                      ->first(); //Si existe al memos un tipo de proyecto con monto maximo no se valida por el monto max min del fondo 

             
                if (!empty($tipoProyecto)) {//Si existe al menos un monto maximo mayor a cero se realiza el reseteo 
                     $this->resetValidation('montoProyecto');
                     $this->resetErrorBag('montoProyecto');
                     $this->resetValidation('duracionProyecto');
                     $this->resetErrorBag('duracionProyecto');     
                     $this->reset('montoMaxFondo', 'montoMinFondo', 'duracionMinMeses', 'duracionMaxMeses');    
                }            
             }
            //Si las validaciones se estan realizando por tipo de proyecto y no por fondo concursable siempre se resetean (por ejemplo los tipos de proyectos correspondientes al fondo de asignacion directa) (-)

            if ($field == 'cantBenefHombreProy' || $field == 'cantBenefMujerProy') {
                $this->resetValidation('cantTotalBenef');
                $this->resetErrorBag('cantTotalBenef');

                if (is_numeric($this->cantBenefHombreProy) && is_numeric($this->cantBenefMujerProy)) {
                    $this->cantTotalBenef = $this->cantBenefHombreProy + $this->cantBenefMujerProy;
                }

                if ($this->cantBenefHombreProy == "0" && $this->cantBenefMujerProy == "0") {
                    $this->addError('cantTotalBenef', 'La suma de los beneficiarios: hombres y mujeres, debe ser mayor a cero');
                }
            }

            //Crear un metodo para validar los Inputs Array, cuando sea monto de proyecto solo llamar a $this->getArrValidateDatosAdmin()
            //Verificar que no desaparezcan las validaciones de los otros campos
            if ($field == 'montoProyecto') {       
                $this->montoMaxFondo =  0;
                $this->montoMinFondo =  0;
                $this->descripcionFondo = 0;
                
                if ($this->idFondoConcursable > 0) {
                    $fondoSel = Fondoconcursable::where('idFondoConcursable', '=', $this->idFondoConcursable)->first();
                    if (!empty($fondoSel)) {
                        $this->montoMaxFondo =  $fondoSel->montoMaxFondo;
                        $this->montoMinFondo =  $fondoSel->montoMinFondo;
                        $this->duracionMinMeses = $fondoSel->duracionMinMeses;
                        $this->duracionMaxMeses = $fondoSel->duracionMaxMeses;

                        $this->descripcionFondo = ' para el fondo: "'.ucwords(mb_strtolower($fondoSel->descripcionFondoConcursable, 'UTF-8')).'"';
                    }
                } 

        //MV 23-03-2025 Si existe un tipo de proyecto seleccionado y tiene un monto minimo y maximo asignado para validar, entonces se valida por tipo de proyecto
            if ($this->idTipoProyecto > 0) { //Si se encuentra seleccionado un tipo de proyecto se busca si existen los valores minimos y maximos,
                    $tipoProyecto = Tipoproyecto::where('idTipoProyecto', '=', $this->idTipoProyecto)->first();
                    if (!empty($tipoProyecto->montoMaximo)) { //Si el tipo de proyecto tiene un monto maximo y minimo asignado se valida por el monto del tipo de proyecto 
                        //Se asignan a las mismas variables del fondo para no cambiar la logica de validacion existente para el fondo (validateOnly)
                          if ($tipoProyecto->montoMaximo > 0) {
                                 $this->resetValidation('montoProyecto'); 
                                 $this->resetErrorBag('montoProyecto');
                                 $this->resetValidation('duracionProyecto');
                                 $this->resetErrorBag('duracionProyecto');  

                                 $this->montoMaxFondo =  $tipoProyecto->montoMaximo;
                                 $this->montoMinFondo =  $tipoProyecto->montoMinimo;
                                 $this->duracionMinMeses = $tipoProyecto->duracionMinMeses;
                                 $this->duracionMaxMeses = $tipoProyecto->duracionMaxMeses;
                                 $this->descripcionFondo = ' para el tipo de proyecto: "'.ucwords(mb_strtolower($tipoProyecto->descripcionTipoProyecto, 'UTF-8')).'"';
                          }                    
                    }
            }
            //MV 23-03-2025  Si existe un tipo de proyecto seleccionado se verifica si tiene un monto minimo y maximo asignado para validar por tipo de proyecto 

                $this->validateOnly( 
                    $field,
                    //array_merge($this->getArrValidateDatosAdmin(), $this->getArrValidateDatosTecnicos()),
                    array_merge($this->getArrValidateDatosAdmin(), $this->getArrValidateDatosTecnicos(), $this->getArrValidateObjEspecificos(array_key_exists('inputsObjEspecifico',  $indexInputHash) ? $indexInputHash['inputsObjEspecifico'] : -1), $this->getArrValidateActividades(array_key_exists('inputsActividad',  $indexInputHash) ? $indexInputHash['inputsActividad'] : -1), $this->getArrValidateDescripRRHH(array_key_exists('inputsDescripRRHH',  $indexInputHash) ? $indexInputHash['inputsDescripRRHH'] : -1)),
                    [
                        'montoProyecto.min' => 'El monto minímo a financiar es de $' . number_format($this->montoMinFondo, 0, ',', '.') . $this->descripcionFondo,
                        'montoProyecto.max' => 'El monto máximo a financiar es de $' . number_format($this->montoMaxFondo, 0, ',', '.') . $this->descripcionFondo,
                    ] 
                ); 
            } else {
                $this->validateOnly(
                    $field,
                    array_merge($this->getArrValidateDatosAdmin(), $this->getArrValidateDatosTecnicos(), $this->getArrValidateObjEspecificos(array_key_exists('inputsObjEspecifico',  $indexInputHash) ? $indexInputHash['inputsObjEspecifico'] : -1), $this->getArrValidateActividades(array_key_exists('inputsActividad',  $indexInputHash) ? $indexInputHash['inputsActividad'] : -1), $this->getArrValidateDescripRRHH(array_key_exists('inputsDescripRRHH',  $indexInputHash) ? $indexInputHash['inputsDescripRRHH'] : -1))
                );
            }

            if ($field == 'idFondoConcursable') {
                try {

                    if ($this->idFondoConcursable > 0) {

                        $this->validateFondoconcursable();      

        //MV 23-03-2025 Si el tipo de proyecto tiene un monto min y max asignado se considera el del proyecto y no el del fondo (en este caso siempre que se cambie el fondo los tipos de proyectos se recargan y el valor vuelve a cero por lo tanto esto se considera para no validar por el fondo en el caso que exista al menos un tipo de proyecto con montos mayor a cero asociado al fondo seleccionado) (+)  
                  $flgValidaMontoMinMax = 0;
                  $tipoProyecto = Tipoproyecto::where('idFondoConcursable', '=', $this->idFondoConcursable)
                                              ->where('flgProyectoVisible', '=', 1) //MV 27-05-2025: Se agrega filtro para no mostrar proyectos de año anteriores que ya no se encuentran vigente
                                              ->where('montoMaximo', '>', 0) 
                                              ->first(); //Si existe al memos un tipo de proyecto con monto maximo no se valida por el monto max min del fondo 

                  if (!empty($tipoProyecto->montoMaximo)) {
                    //Si al menos un tipo de proyecto asociado al fondo seleccionado tiene un monto maximo y minimo asignado se omite la validacion de maximo y minimo por el fondo (la validacion se realiza al seleccionar un tipo de proyecto) 
                      $flgValidaMontoMinMax = 1; 
                      //Se utilizan las mismas variables para reutilizar las validaciones del fondo 
                      $this->montoMaxFondo =  $tipoProyecto->montoMaxFondo;
                      $this->montoMinFondo =  $tipoProyecto->montoMinFondo;
                      $this->duracionMinMeses = $tipoProyecto->duracionMinMeses;
                      $this->duracionMaxMeses = $tipoProyecto->duracionMaxMeses;

                  }              
        //MV 23-03-2025 Si al menos un tipo de proyecto asociado al fondo seleccionado tiene un monto maximo y minimo asignado se omite la validacion de maximo y minimo por el fondo (la validacion se realiza al seleccionar un tipo de proyecto) 
                    if ($flgValidaMontoMinMax == 0) {//MV 23-03-2025 Si el tipo de proyecto no tiene asignado un monto maximo y minimo se valida por los max min del fondo (evento change del fondo, el tipo de proyecto siempre vuelve a cero cuando se selecciona un nuevo fondo) 
                        if (strlen($this->montoProyecto) > 0) {
                            if ($this->montoProyecto > $this->montoMaxFondo) { 
                                $this->addError('montoProyecto', 'El monto máximo a financiar es de $' . number_format($this->montoMaxFondo, 0, ',', '.') . ' para el fondo "' . $this->descripcionFondo.'"');
                            } else
                         if ($this->montoProyecto < $this->montoMinFondo) {
                                $this->addError('montoProyecto', 'El monto minímo a financiar es de $' . number_format($this->montoMinFondo, 0, ',', '.') . ' para el fondo ' . $this->descripcionFondo.'"');
                            }
                        }

                        if (strlen($this->duracionProyecto) > 0) { 
                            if ($this->duracionProyecto > $this->duracionMaxMeses) {
                                $this->addError('duracionProyecto', 'La ejecución del proyecto para el fondo seleccionado máximo debe durar '.$this->duracionMaxMeses.' meses'); 
                            } else
                         if ($this->duracionProyecto < $this->duracionMinMeses) {
                                $this->addError('duracionProyecto', 'La ejecución del proyecto para el fondo seleccionado mínimo debe durar '.$this->duracionMinMeses.' meses');
                            }
                        }
                    }
                }
                } catch (exception $e) {
                    $this->idFondoConcursable = 0;
                    $this->dispatchBrowserEvent('swal:modal', [
                        'icon' => 'warning',
                        'mensaje' => $e->getMessage(),
                    ]);
                    $this->dispatchBrowserEvent('moveScroll', ['id' => '#datosAdmHead']);
                }


                $this->tipoproyecto = Tipoproyecto::where('idFondoConcursable', '=', $this->idFondoConcursable)
                                                  ->where('flgProyectoVisible', '=', 1) //MV 23-03-2024: Se agrega filtro para no mostrar proyectos de año anteriores que ya no se encuentran vigente 
                                                  ->get();

                // dd($this->tipoproyecto, $this->idFondoConcursable, Tipoproyecto::where('idFondoConcursable', '=', $this->idFondoConcursable)->where('flgProyectoVisible', '=', 1)->toSql());

                $this->idTipoProyecto = 0; 
            } else 
            if ($field == 'idTipoProyecto') {  
                try {
                  //MV 23-03-2025 Si el tipo de proyecto es mayor a cero y tiene un monto asignado se considera el del proyecto y no el del fondo

                        if ($this->idTipoProyecto > 0) {
                            $tipoProyecto = Tipoproyecto::where('idTipoProyecto', '=', $this->idTipoProyecto)->first();

                            if (!empty($tipoProyecto->montoMaximo)) {
                               if ($tipoProyecto->montoMaximo > 0) {                                  
                                  $this->montoMinFondo =  $tipoProyecto->montoMinimo;
                                  $this->montoMaxFondo =  $tipoProyecto->montoMaximo;
                                  $this->duracionMinMeses = $tipoProyecto->duracionMinMeses;
                                  $this->duracionMaxMeses = $tipoProyecto->duracionMaxMeses;
  
                                  if (strlen($this->montoProyecto) > 0) { 
                                      if ($this->montoProyecto > $this->montoMaxFondo) {
                                          $this->addError('montoProyecto', 'El monto máximo a financiar es de $' . number_format($this->montoMaxFondo, 0, ',', '.') . ' para el tipo de proyecto: "'.$tipoProyecto->descripcionTipoProyecto.'"'); 
                                      } else
                                   if ($this->montoProyecto < $this->montoMinFondo) {
                                          $this->addError('montoProyecto', 'El monto minímo a financiar es de $' . number_format($this->montoMinFondo, 0, ',', '.') . ' para el tipo de proyecto: "'.$tipoProyecto->descripcionTipoProyecto.'"');
                                      }
                                  }

                                  if (strlen($this->duracionProyecto) > 0) { 
                                      if ($this->duracionProyecto > $this->duracionMaxMeses) {
                                          $this->addError('duracionProyecto', 'La ejecución para el tipo de proyecto seleccionado máximo debe durar '.$this->duracionMaxMeses.' meses'); 
                                      } else
                                   if ($this->duracionProyecto < $this->duracionMinMeses) {
                                          $this->addError('duracionProyecto', 'La ejecución para el tipo de proyecto seleccionado mínimo debe durar '.$this->duracionMinMeses.' meses');
                                      }
                                  }
                              }
                            }
                        
                        }
                    //MV 23-03-2025 Si el tipo de proyecto tiene un monto asignado se toma el del proyecto y no el del fondo                   
                   
                } catch (exception $e) {
                    $this->idFondoConcursable = 0;
                    $this->dispatchBrowserEvent('swal:modal', [
                        'icon' => 'warning',
                        'mensaje' => $e->getMessage(),
                    ]);
                    $this->dispatchBrowserEvent('moveScroll', ['id' => '#datosAdmHead']);
                }

            }            
            else
                if ($field == 'idProvinciaProy') {
                $this->comunas = Comuna::where('idProvincia', '=', $this->idProvinciaProy)->get();
                $this->idComunaProy = 0;
            }
        } else
            if ($this->currentStep == 3) {
            $this->flgChangeStep3 = true;
            // $this->sumarDatosPresupuestarios();
            // dd($field, $value);
            //     $this->totalRRHH = empty($this->inputsRecursosHumanos)?0:$this->inputsRecursosHumanos->where('montototal', '>', 0)->sum('montototal');
            // $arrInputRRHH = explode('.', $field);
            // $this->validateOnly($field, array_merge($this->getArrValidateRRHH($arrInputRRHH[1]), $this->getArrValidateGG(), $this->getArrValidateEquip()));
            // $this->totalRRHH = empty($this->inputsRecursosHumanos)?0:$this->inputsRecursosHumanos->where('montototal', '>', 0)->sum('montototal');
        } else
            if ($this->currentStep == 4) {

            $this->validateOnly($field, [
                'docProyecto' => 'required|file|mimes:pdf|max:50720', //30MB
            ]);
        }
    }

    // public function updatedInputsObjEspecifico($value, $field)
    // {
    //     $arrInputObjEsp = explode('.', $field);
    //     $this->validateOnly('inputsObjEspecifico.' . $field, array_merge($this->getArrValidateDatosAdmin(), $this->getArrValidateDatosTecnicos(), $this->getArrValidateObjEspecificos($arrInputObjEsp[0])));
    // }

    // public function updatedInputsActividades($value, $field)
    // {
    //     $arrInputActiv = explode('.', $field);
    //     $this->validateOnly('inputsActividades.' . $field, $this->getArrValidateActividades($arrInputActiv[0]));
    // }

    // public function updatedInputsDescripRRHH($value, $field)
    // {
    //     $arrInputDesRRHH = explode('.', $field);
    //     $this->validateOnly('inputsDescripRRHH.' . $field, $this->getArrValidateDescripRRHH($arrInputDesRRHH[0]));
    // }


    public function updatedInputsRecursosHumanos($value, $field)
    {
        $arrInputRRHH = explode('.', $field);
        $this->validateOnly('inputsRecursosHumanos.' . $field, $this->getArrValidateRRHH($arrInputRRHH[0]));

        if ($arrInputRRHH[1] == 'montototal') {
            $this->totalRRHH = empty($this->inputsRecursosHumanos) ? 0 : $this->inputsRecursosHumanos->where('montototal', '>', 0)->sum('montototal');
        }
    }

    public function updatedInputsGastosGenerales($value, $field)
    {
        $arrInputGG = explode('.', $field);
        $this->validateOnly('inputsGastosGenerales.' . $field, $this->getArrValidateGG($arrInputGG[0]));

        if ($arrInputGG[1] == 'montototal') {
            $this->totalGG = empty($this->inputsGastosGenerales) ? 0 : $this->inputsGastosGenerales->where('montototal', '>', 0)->sum('montototal');
        }
    }

    public function updatedInputsEquipamiento($value, $field)
    {
        $arrInputEquip = explode('.', $field);
        $this->validateOnly('inputsEquipamiento.' . $field, $this->getArrValidateEquip($arrInputEquip[0]));

        if ($arrInputEquip[1] == 'montototal') {
            $this->totalEquip = empty($this->inputsEquipamiento) ? 0 : $this->inputsEquipamiento->where('montototal', '>', 0)->sum('montototal');
        }
    }

    public function getArrValidateRun()
    {
        return [
            'runOrganizacion' => ['required', 'integer', 'digits_between:7,9'],
            'dvRunOrganizacion' => ['required_with:runOrganizacion', 'max:1', new RunValidator],
        ];
    }

    public function cargarDatosRun()
    {
        $this->runOrganizacion = trim($this->runOrganizacion);
        //$this->runOrganizacionFmt =  number_format($this->runOrganizacion, 0, ',', '.');
        $this->dvRunOrganizacion = trim($this->dvRunOrganizacion);
        $this->resetExcept('runOrganizacion', 'dvRunOrganizacion');
        $this->inicio();

        $organizacion = Organizacion::where('runOrganizacion', '=', $this->runOrganizacion)->first();
        if (!empty($organizacion)) {
            $this->idOrganizacion = $organizacion->idOrganizacion;
            $this->runOrganizacion = $organizacion->runOrganizacion;
            $this->dvRunOrganizacion = $organizacion->dvRunOrganizacion;
            $this->nombreOrganizacion = $organizacion->nombreOrganizacion;
            $this->agnosExistencia = $organizacion->agnosExistencia;
            $this->direccionOrganizacion = $organizacion->direccionOrganizacion;
            $this->codTipoVia = $organizacion->codTipoVia;
            $this->nombreVia = $organizacion->nombreVia;
            $this->numDireccion = $organizacion->numDireccion;
            $this->telefonoOrganizacion = $organizacion->telefonoOrganizacion;
            $this->correoOrganizacion = $organizacion->correoOrganizacion;
            $this->fecVencDirectiva = $organizacion->fecVencDirectiva;
            $this->idProvinciaOrg = $organizacion->idProvinciaOrg;
            $this->idComunaOrg = $organizacion->idComunaOrg;
            $this->idRepLegal = $organizacion->idRepLegal;
            $this->idBanco = $organizacion->idBanco;
            $this->idTipocuenta = $organizacion->idTipocuenta;
            $this->numeroCuenta = $organizacion->numeroCuenta;

            $this->comunasOrg = Comuna::where('idProvincia', '=', $this->idProvinciaOrg)->get();

            $representante = Representante::where('idRepLegal', '=', $this->idRepLegal)->first();
            if (!empty($representante)) {
                $this->rutRepLegal = $representante->rutRepLegal;
                $this->dvRutRepLegal = $representante->dvRutRepLegal;
                $this->nomRepLegal = $representante->nomRepLegal;
                $this->telefonoRepLegal = $representante->telefonoRepLegal;
                $this->correoRepLegal = $representante->correoRepLegal;
            }
        }


        if ($this->idOrganizacion > 0) {
            //Se obtienen los proyectos ingresados por la organizacion el año en curso
            $this->proyectos = Proyecto::join('fondoconcursables', 'fondoconcursables.idFondoConcursable', '=', 'proyectos.idFondoConcursableProyecto', 'left outer')
                ->join('tipoproyectos', 'tipoproyectos.idTipoProyecto', '=', 'proyectos.idTipoProyecto', 'left outer')
                ->where('fondoconcursables.codigoFondoConcursable', '=', 'AD') //MV 29-08-2025 MV 
                ->where('idOrganizacionProyecto', '=', $this->idOrganizacion)
                ->whereYear('proyectos.created_at', '=', now()->year)/*Todos los proyectos ingresados el años en curso*/
                ->WhereRaw("((proyectos.codProyecto is not null) or ((proyectos.codProyecto is null) and (proyectos.created_at >= '" . $this->periodosPostuAD->fechaInicioPostu . "' and proyectos.created_at <= '" . $this->periodosPostuAD->fechaFinPostu . "')))")
                ->orderBy('proyectos.codProyecto', 'asc')
                ->get(['proyectos.*', 'fondoconcursables.descripcionFondoConcursable', 'tipoproyectos.descripcionTipoProyecto']);


            //dd($this->proyectos, $this->periodosPostu->fechaInicioPostu, $this->periodosPostu->fechaFinPostu);

            //dd($this->proyectos->toSql());
            $this->proyectosGralesNotDD = $this->proyectos->where('fondoconcursables.codigoFondoConcursable', '!=', 'DD');

            $this->proyectosDD = $this->proyectos->where('fondoconcursables.codigoFondoConcursable', '=', 'DD');

            $this->proyectosWithCodProyecto = $this->proyectos->where('codProyecto', '>', '0'); //Se obtienen todos los proyectos enviados

            // $this->proyectosPeriodo = $this->proyectos->whereRaw('codProyecto is not null and montoProyecto < 2000000'); //Se obtienen los proyectos enviados el año actual y los proyectos no concluidos correspondientes a la postulación en curso

            //dd($this->proyectosPeriodo);

            //Si existen proyectos para la organización
            if (!empty($this->proyectos)) {
                $idDiv = '#headPostulaciones';
                if (count($this->proyectos) > 4) {
                    $idDiv = '#maxPostulaciones';
                } else
                if (count($this->proyectos) > 0) {
                    $cantProyStr = count($this->proyectos) == 1 ? 'Existe un proyecto ingresado' : 'Existen ' . count($this->proyectos) . ' proyectos ingresados';
                    $msjProyStr = 'Revise la tabla y haga click sobre el nombre de el o los proyecto(s) que aún no han sido enviados para continuar con el proceso de postulación';

                    if (count($this->proyectos) < 5) {
                        $msjProyStr .= ' o bien cree uno nuevo';
                    }

                    //Incluir en el mensaje o bien Ingrese un Nuevo Proyecto
                    $this->dispatchBrowserEvent('swal:modal', [
                        'icon' => 'info',
                        'title' => '<span class="fs-5 text-success fw-bolder">' . $cantProyStr . ' de su organización. Para el año en curso</span>',
                        'mensaje' => '<span class="fs-5" style="text-align:justify;">' . $msjProyStr . '</span>',
                        'id' => $idDiv,
                    ]);
                }
                $this->dispatchBrowserEvent('moveScroll', ['id' => $idDiv]);
                $this->currentStep = 0;
            }
        }
    }

    public function ingresarProyecto()
    {
        $this->validate($this->getArrValidateRun());
        $this->currentStep = 1;
        $this->dispatchBrowserEvent('moveScroll', ['id' => '#banner01']);
    }

    public function getArrValidateDatosOrg()
    {
        return [
            'nombreOrganizacion' => 'required|string|max:150',
            'agnosExistencia' => 'required|integer|digits_between:1,3|gt:-1',
            'codTipoVia' => 'required|integer|gt:0',
            // 'direccionOrganizacion' => 'required|string|max:150',
            'nombreVia' => 'required|string|max:150',
            'numDireccion' => 'required|integer|digits_between:1,5|gt:-1',
            'idProvinciaOrg' =>  'required|integer|gt:0',
            'idComunaOrg' => 'required|integer|gt:0',
            'idTipocuenta' => 'required|integer|gt:0',
            'idBanco' => 'required|integer|gt:0',
            'numeroCuenta' => 'required|string|max:20',
            'correoOrganizacion' => 'required|email:rfc,dns|max:150',
            'telefonoOrganizacion' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:7|max:15',
        ];
    }

    public function getArrValidateDatosRepLegal()
    {
        return [
            'rutRepLegal' => 'required|integer|digits_between:6,9',
            'dvRutRepLegal' => ['required_with:rutRepLegal', 'max:1', new RunValidator],
            'nomRepLegal' => 'required|string|max:150',
            'telefonoRepLegal' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:7|max:15',
            'correoRepLegal' => 'required|email:rfc,dns|max:150',
            'fecVencDirectiva' => 'required|date_format:Y-m-d',
        ];
    }

    public function firstStep()
    {
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                $fieldsErrors = array_keys($validator->errors()->getMessages());
                if (count($fieldsErrors) > 0) {
                    $this->dispatchBrowserEvent('moveScrollByErrorId', ['id' => '#id' . $fieldsErrors[0]]); //Mover Scroll al campo con el error
                }
            });
        })->validate(array_merge($this->getArrValidateDatosOrg(), $this->getArrValidateDatosRepLegal()));

        $this->currentStep = 2;
        if ($this->flgChangeStep1) { //Flag para guardar solo cuando existan cambios
            try {
                DB::beginTransaction();

                $representante = Representante::updateOrCreate(
                    //['idRepLegal' => $this->idRepLegal, ], Comentado por MV 28-02-2023 se estaban creando un representate legal por cada proyecto
                    ['rutRepLegal' => $this->rutRepLegal], //Agregado por MV 28-02-2023
                    [
                        'rutRepLegal' => $this->rutRepLegal,
                        'dvRutRepLegal' => $this->dvRutRepLegal,
                        'nomRepLegal' => $this->nomRepLegal,
                        'telefonoRepLegal' => $this->telefonoRepLegal,
                        'correoRepLegal' => $this->correoRepLegal,
                    ]
                );

                // dd($this->codTipoVia, $this->nombreVia, $this->numDireccion);

                $organizacion = Organizacion::updateOrCreate(
                    ['idOrganizacion' => $this->idOrganizacion],
                    [
                        'runOrganizacion' => $this->runOrganizacion,
                        'dvRunOrganizacion' => $this->dvRunOrganizacion,
                        'nombreOrganizacion' => $this->nombreOrganizacion,
                        'agnosExistencia' => $this->agnosExistencia,
                        'direccionOrganizacion' => $this->direccionOrganizacion,
                        'codTipoVia' => $this->codTipoVia,
                        'nombreVia' => $this->nombreVia,
                        'numDireccion' => $this->numDireccion,
                        'telefonoOrganizacion' => $this->telefonoOrganizacion,
                        'correoOrganizacion' => $this->correoOrganizacion,
                        'fecVencDirectiva' => $this->fecVencDirectiva,
                        'idProvinciaOrg' => $this->idProvinciaOrg,
                        'idComunaOrg' => $this->idComunaOrg,
                        'idRepLegal' => $representante->idRepLegal,
                        'idBanco' => $this->idBanco,
                        'idTipocuenta' => $this->idTipocuenta,
                        'numeroCuenta' => $this->numeroCuenta,
                    ]
                );

                DB::commit();
                $this->idOrganizacion = $organizacion->idOrganizacion;
                $this->dispatchBrowserEvent('swal:information', [
                    'icon' => 'success',
                    'mensaje' => 'Se han guardado los datos del paso 1',
                ]);
                $this->dispatchBrowserEvent('moveScroll', ['id' => '#cabecera']);
                $this->flgChangeStep1 = false;
            } catch (exception $e) {
                DB::rollBack();
                session()->flash('exceptionMessage', $e->getMessage());
                $this->currentStep = 1;
            }
        } else {
            $this->dispatchBrowserEvent('moveScroll', ['id' => '#cabecera']);
        }
    }


    public function getArrValidateDatosAdmin()
    {
        $ruleMontoMaxStr = 'required|integer|digits_between:1,9';
        $ruleDuracionMaxStr = 'required|integer|digits_between:1,9';
        if ($this->idFondoConcursable > 0 || $this->idTipoProyecto > 0) {

            if (is_numeric($this->montoMaxFondo) && is_numeric($this->montoMinFondo)) { 
                if ($this->montoMaxFondo > 0) {
                   $ruleMontoMaxStr = 'required|integer|min:' . $this->montoMinFondo . '|max:' . $this->montoMaxFondo . '|digits_between:1,9';
                }
            }

            if (is_numeric($this->duracionMaxMeses) && is_numeric($this->duracionMinMeses)) {
                $ruleDuracionMaxStr = 'required|integer|min:' . $this->duracionMinMeses . '|max:' . $this->duracionMaxMeses . '|digits_between:1,9';
            }
        }

        return [
            'nombreProyecto' => 'required|string|max:150',
            'idFondoConcursable' => 'required|integer|gt:0',
            'montoProyecto' => $ruleMontoMaxStr,
            'idProvinciaProy' => 'required|integer|gt:0',
            'idComunaProy' => 'required|integer|gt:0',
            'duracionProyecto' => $ruleDuracionMaxStr,
            'idTipoProyecto' => 'required|integer|gt:0',
        ];
    }

    public function getArrValidateDatosTecnicos()
    {
        return [
            'cantBenefHombreProy' => 'required|integer|digits_between:1,7',
            'cantBenefMujerProy' => 'required|integer|digits_between:1,7',
            'resumenProyecto' => 'required|string|max:1500',
            'objetivoProyecto' => 'required|string|max:300',
            'descripNecesidadACubrir' => 'required|string|max:1000',
            'descripTerritorioBenef' => 'required|string|max:1000',
            'descripDifusionProy' => 'required|string|max:1000',
            'descripResultadoProy' => 'required|string|max:2000',
            'descripMedioVerifPostEjecuProy' => 'required|string|max:2000',
            'cantTotalBenef' => 'gt:0',
        ];
    }

    public function getArrValidateObjEspecificos($index = -1)
    {
        return [
            $index > -1 ? 'inputsObjEspecifico.' . $index . '.descripcionObjEspecifico' : 'inputsObjEspecifico.*.descripcionObjEspecifico' =>  'required|string|max:300',
        ];
    }

    public function getArrValidateActividades($index = -1)
    {
        return [
            $index > -1 ? 'inputsActividad.' . $index . '.tituloActividad' : 'inputsActividad.*.tituloActividad' =>  'required|string|max:150',
            $index > -1 ? 'inputsActividad.' . $index . '.descripcionActividad' : 'inputsActividad.*.descripcionActividad' =>  'required|string|max:2500',
            $index > -1 ? 'inputsActividad.' . $index . '.mesesEjecuActividad' : 'inputsActividad.*.mesesEjecuActividad' =>  ['required', 'array', "min:1"],
            $index > -1 ? 'inputsActividad.' . $index . '.descripBienesServRRHHActividad' : 'inputsActividad.*.descripBienesServRRHHActividad' =>  'required|string|max:200',
        ];
    }

    public function getArrValidateDescripRRHH($index = -1)
    {
        return [
            $index > -1 ? 'inputsDescripRRHH.' . $index . '.descripCargo' : 'inputsDescripRRHH.*.descripCargo' => 'required|string|max:150',
            $index > -1 ? 'inputsDescripRRHH.' . $index . '.descripPerfilCargo' : 'inputsDescripRRHH.*.descripPerfilCargo' => 'required|string|max:150',
            $index > -1 ? 'inputsDescripRRHH.' . $index . '.totalHorasServicio' : 'inputsDescripRRHH.*.totalHorasServicio' => 'required|integer|gt:0|digits_between:1,5',
            $index > -1 ? 'inputsDescripRRHH.' . $index . '.descripPeriocidadServicio' : 'inputsDescripRRHH.*.descripPeriocidadServicio' => 'required|string|max:150',
            $index > -1 ? 'inputsDescripRRHH.' . $index . '.montoTotalServicio' : 'inputsDescripRRHH.*.montoTotalServicio' => 'required|integer|gt:0|digits_between:1,7',
            $index > -1 ? 'inputsDescripRRHH.' . $index . '.descripFuncActividades' : 'inputsDescripRRHH.*.descripFuncActividades' => 'required|string|max:150',
        ];
    }

    public function validateFondoconcursable()
    {
        // try {
        //Se obtienen todos los proyectos de la organizacion
        $proyectos = Proyecto::join('fondoconcursables', 'fondoconcursables.idFondoConcursable', '=', 'proyectos.idFondoConcursableProyecto')
            ->where('fondoconcursables.codigoFondoConcursable', '=', 'AD') //29-08-2025 MVillalobos 
            ->where('idOrganizacionProyecto', '=', $this->idOrganizacion)
            ->whereNotNull('proyectos.codProyecto') //Agregado por MVillalobos el 30-08-2022
            ->whereYear('proyectos.created_at', '=', now()->year)/*Todos los proyectos ingresados el años en curso*/
            ->get(['proyectos.*', 'fondoconcursables.codigoFondoConcursable']);

        //Se obtienen todos los proyectos de fondo concursable distinto a deportista destacado DD = 1, artistas regionales AR = 11, impacto cultural = 12, Artistas Callejeros AC = 16  
        $proyectosNotDDAR = $proyectos->whereNotIn('idFondoConcursableProyecto', [1, 11, 12]);

        //Se obtienen todos los proyectos de fondo concursable deportista destacado
        $proyectosDD = $proyectos->where('idFondoConcursableProyecto', '=', 1 /*DD*/);
        //Se obtienen todos los proyectos de fondo concursable artistas regionales
        $proyectosAR = $proyectos->where('idFondoConcursableProyecto', '=', 11 /*AR*/);
        //Se obtienen todos los proyectos de fondo concursable impacto cultural 19-04-2024
        $proyectosIC = $proyectos->where('idFondoConcursableProyecto', '=', 12 /*IC*/);
           //Se obtienen todos los proyectos de fondo actividades culturales masivas 29-07-2024
        $proyectosAC = $proyectos->where('idFondoConcursableProyecto', '=', 16 /*AC*/);

      //Se obtienen todos los proyectos de fondo concursable asignacion directa 10-05-2024 
        //  $proyectosAD = $proyectos->where('idFondoConcursableProyecto', '=', 13 /*AD*/); 

        //Solo puede postular a dos proyectos de distintos fondos en el año
        //Crear un metodo para realizar esta validación en el ultimo paso si es necesario
        $this->descripcionFondo = ucwords(mb_strtolower($this->fondoConcursable->where('idFondoConcursable', $this->idFondoConcursable)->first()->descripcionFondoConcursable, 'UTF-8'));

        $this->montoMaxFondo =  0;
        $this->montoMinFondo =  0;
        $this->duracionMinMeses = 0; 
        $this->duracionMaxMeses = 0;

        if ($this->idFondoConcursable > 0) {
            $fondoConcursablePaso = $this->fondoConcursable->where('idFondoConcursable', '=', $this->idFondoConcursable)->first();
            $this->montoMaxFondo =  $fondoConcursablePaso->montoMaxFondo;
            $this->montoMinFondo =  $fondoConcursablePaso->montoMinFondo;
            $this->duracionMinMeses = $fondoConcursablePaso->duracionMinMeses;
            $this->duracionMaxMeses = $fondoConcursablePaso->duracionMaxMeses;
        } 

        // } catch (exception $e) {

        //     session()->flash('exceptionMessage', $e->getMessage());
        // }
    }

    public function secondStep()
    {
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                $fieldsErrors = array_keys($validator->errors()->getMessages());
                if (count($fieldsErrors) > 0) {
                    // dd(strpos($fieldsErrors[0], "input"), $fieldsErrors[0], $fieldsErrors);
                    if (strpos($fieldsErrors[0], "inputsObjEspecifico") > -1) {
                        $fieldName =  explode('.', $fieldsErrors[0])[2];
                        $fieldIndex =  explode('.', $fieldsErrors[0])[1];
                        $this->dispatchBrowserEvent('moveScrollByErrorId', ['id' => '#id' . $fieldName . $fieldIndex]); //Mover Scroll al campo con el error
                    } else
                    if (strpos($fieldsErrors[0], "inputsActividad") > -1 || strpos($fieldsErrors[0], "inputsDescripRRHH") > -1) {
                        $fieldIndex = 100;
                        $fieldName =  "";
                        for ($i = 0; $i < count($fieldsErrors); $i++) {
                            $fieldIndexPaso =  explode('.', $fieldsErrors[$i])[1];
                            if ($fieldIndexPaso < $fieldIndex) {
                                $fieldName =  explode('.', $fieldsErrors[$i])[2];
                                $fieldIndex =  explode('.', $fieldsErrors[$i])[1];
                            }
                        }
                        // dd('#id' . $fieldName . $fieldIndex, count($fieldsErrors));
                        $this->dispatchBrowserEvent('moveScrollByErrorId', ['id' => '#id' . $fieldName . $fieldIndex]); //Mover Scroll al campo con el error
                    } else {
                        $this->dispatchBrowserEvent('moveScrollByErrorId', ['id' => '#id' . $fieldsErrors[0]]); //Mover Scroll al campo con el error
                    }
                }
            });
        })->validate(
            array_merge($this->getArrValidateDatosAdmin(), $this->getArrValidateDatosTecnicos(), $this->getArrValidateObjEspecificos(), $this->getArrValidateActividades(), $this->getArrValidateDescripRRHH()),
            [
                'montoProyecto.min' => 'El monto minímo a financiar es de $' . number_format($this->montoMinFondo, 0, ',', '.') . $this->descripcionFondo,
                'montoProyecto.max' => 'El monto máximo a financiar es de $' . number_format($this->montoMaxFondo, 0, ',', '.') . $this->descripcionFondo,
            ]
        );

        $this->currentStep = 3;
        if ($this->flgChangeStep2) { //Flag para guardar solo cuando existan cambios
            try {
                DB::beginTransaction();

                $this->validateFondoconcursable();
                $proyecto = Proyecto::updateOrCreate(
                    ['idProyecto' => $this->idProyecto],
                    [
                        // 'codProyecto' => '', //Se genera en el ultimo paso
                        'nombreProyecto' => $this->nombreProyecto,
                        'montoProyecto' => $this->montoProyecto,
                        'duracionProyecto' => $this->duracionProyecto,
                        'objetivoProyecto' => $this->objetivoProyecto,
                        'cantBenefHombreProy' => $this->cantBenefHombreProy,
                        'cantBenefMujerProy' => $this->cantBenefMujerProy,
                        'resumenProyecto' => $this->resumenProyecto,
                        'descripNecesidadACubrir' => $this->descripNecesidadACubrir,
                        'descripTerritorioBenef'  => $this->descripTerritorioBenef,
                        'descripDifusionProy' => $this->descripDifusionProy,
                        'descripResultadoProy' => $this->descripResultadoProy,
                        'descripMedioVerifPostEjecuProy' => $this->descripMedioVerifPostEjecuProy,
                        'idOrganizacionProyecto' => $this->idOrganizacion,
                        'idDocumentoProyecto' => $this->idDocumentoProy,
                        'idProvinciaProyecto' => $this->idProvinciaProy,
                        'idComunaProyecto' => $this->idComunaProy,
                        'idFondoConcursableProyecto' => $this->idFondoConcursable,
                        'idTipoProyecto' => $this->idTipoProyecto,
                    ]
                );

                foreach ($this->inputsObjEspecifico as $index => $itemObjEsp) {
                    $objEspecifico = Objetivosespecifico::updateOrCreate(
                        ['idObjEspecifico' => $itemObjEsp['idObjEspecifico']],
                        [
                            'descripcionObjEspecifico' => $itemObjEsp['descripcionObjEspecifico'],
                            'idProyecto' => $proyecto->idProyecto,
                        ]
                    );

                    //Se actualiza el Id de la collection
                    $itemObjEsp['idObjEspecifico'] = $objEspecifico->idObjEspecifico;
                    $this->inputsObjEspecifico[$index] = $itemObjEsp;
                }

                foreach ($this->inputsActividad as $index => $itemActividad) {
                    $actividad = Actividad::updateOrCreate(
                        ['idActividad' => $itemActividad['idActividad']],
                        [
                            'tituloActividad' => $itemActividad['tituloActividad'],
                            'descripcionActividad' => $itemActividad['descripcionActividad'],
                            'mesesEjecuActividad' => implode(',', $itemActividad['mesesEjecuActividad']), //con explode se vuelve a convertir en array
                            'descripBienesServRRHHActividad' => $itemActividad['descripBienesServRRHHActividad'],
                            'idProyecto' => $proyecto->idProyecto,
                        ]
                    );


                    $itemActividad['idActividad'] = $actividad->idActividad;
                    $this->inputsActividad[$index] = $itemActividad;
                }

                foreach ($this->inputsDescripRRHH as $index => $itemRRHH) {
                    $RRHHProyecto = Rrhhproyecto::updateOrCreate(
                        ['idRRHHProyecto' => $itemRRHH['idRRHHProyecto']],
                        [
                            'descripCargo' => $itemRRHH['descripCargo'],
                            'descripFuncActividades' => $itemRRHH['descripFuncActividades'],
                            'descripPerfilCargo' =>  $itemRRHH['descripPerfilCargo'],
                            'totalHorasServicio' =>  $itemRRHH['totalHorasServicio'],
                            'descripPeriocidadServicio' => $itemRRHH['descripPeriocidadServicio'],
                            'montoTotalServicio' =>    $itemRRHH['montoTotalServicio'],
                            'idProyecto' => $proyecto->idProyecto,
                        ]
                    );

                    $itemRRHH['idRRHHProyecto'] = $RRHHProyecto->idRRHHProyecto;
                    $this->inputsDescripRRHH[$index] = $itemRRHH;
                }

                DB::commit();
                $this->idProyecto = $proyecto->idProyecto;
                $this->codProyecto = $proyecto->codProyecto;
                $this->dispatchBrowserEvent('swal:information', [
                    'icon' => 'success',
                    'mensaje' => 'Se han guardado los datos del paso 2',
                ]);
                $this->dispatchBrowserEvent('moveScroll', ['id' => '#cabecera']);
                $this->flgChangeStep2 = false;
            } catch (exception $e) {
                DB::rollBack();
                session()->flash('exceptionMessage', $e->getMessage());
                $this->currentStep = 2;
            }
        } else {
            $this->dispatchBrowserEvent('moveScroll', ['id' => '#cabecera']);
        }
    }

    public function getArrValidateRRHH($index = -1)
    {
        return
            [
                $index > -1 ? 'inputsRecursosHumanos.' . $index . '.perfil' : 'inputsRecursosHumanos.*.perfil' =>  'required|string|max:150',
                $index > -1 ? 'inputsRecursosHumanos.' . $index . '.idActividad' : 'inputsRecursosHumanos.*.idActividad' => 'required|integer|gt:0',
                $index > -1 ? 'inputsRecursosHumanos.' . $index . '.canthora' : 'inputsRecursosHumanos.*.canthora' => 'required|integer|gt:0|digits_between:1,6',
                $index > -1 ? 'inputsRecursosHumanos.' . $index . '.valorhora' : 'inputsRecursosHumanos.*.valorhora' => 'required|integer|gt:0|digits_between:1,8',
                $index > -1 ? 'inputsRecursosHumanos.' . $index . '.montototal' : 'inputsRecursosHumanos.*.montototal' => 'required|integer|gt:0|digits_between:1,8',
            ];
    }

    public function getArrValidateGG($index = -1)
    {
        return [
            $index > -1 ? 'inputsGastosGenerales.' . $index . '.detabienesservicio' : 'inputsGastosGenerales.*.detabienesservicio' => 'required|string|max:150',
            $index > -1 ? 'inputsGastosGenerales.' . $index . '.idActividad' : 'inputsGastosGenerales.*.idActividad' => 'required|integer|gt:0',
            $index > -1 ? 'inputsGastosGenerales.' . $index . '.descripcion' : 'inputsGastosGenerales.*.descripcion' => 'required|string|max:250',
            $index > -1 ? 'inputsGastosGenerales.' . $index . '.montototal' : 'inputsGastosGenerales.*.montototal' => 'required|integer|gt:0|digits_between:1,8',
        ];
    }

    public function getArrValidateEquip($index = -1)
    {
        return
            [
                $index > -1 ? 'inputsEquipamiento.' . $index . '.detaequipo' : 'inputsEquipamiento.*.detaequipo' => 'required',
                $index > -1 ? 'inputsEquipamiento.' . $index . '.idActividad' : 'inputsEquipamiento.*.idActividad' => 'required|integer|gt:0',
                $index > -1 ? 'inputsEquipamiento.' . $index . '.cantidad' : 'inputsEquipamiento.*.cantidad' => 'required|gt:0|',
                $index > -1 ? 'inputsEquipamiento.' . $index . '.montototal' : 'inputsEquipamiento.*.montototal' => 'required|integer|gt:0|digits_between:1,8',
            ];
    }

    public function thirstStep()
    {
        $flgValidateRRHH = false;
        $flgValidateGG = false;
        $flgValidateEquip = false;

        try {
            $this->validate($this->getArrValidateEquip());
        } catch (exception $e) {
            $this->tabActive = 3;
            $flgValidateEquip = true;
        }

        try {
            $this->validate($this->getArrValidateGG());
        } catch (exception $e) {
            $this->tabActive = 2;
            $flgValidateGG = true;
        }

        try {
            $this->validate($this->getArrValidateRRHH());
        } catch (exception $e) {
            $this->tabActive = 1;
            $flgValidateRRHH = true;
        }

        if ($flgValidateEquip || $flgValidateGG || $flgValidateRRHH) {
            $this->dispatchBrowserEvent('moveScroll', ['id' => '#msjErrorStep3']);
        }

        $this->validate(array_merge($this->getArrValidateRRHH(), $this->getArrValidateGG(), $this->getArrValidateEquip()));

        $flgError = false;
        try {
            $this->totalRRHH = count($this->inputsRecursosHumanos) == 0 ? 0 : $this->inputsRecursosHumanos->where('montototal', '>', 0)->sum('montototal');
            $this->totalGG = count($this->inputsGastosGenerales) == 0 ? 0 : $this->inputsGastosGenerales->where('montototal', '>', 0)->sum('montototal');
            $this->totalEquip = count($this->inputsEquipamiento) == 0 ? 0 : $this->inputsEquipamiento->where('montototal', '>', 0)->sum('montototal');
            $totalDatosPpto = $this->totalRRHH + $this->totalGG + $this->totalEquip;

            if (count($this->inputsRecursosHumanos) == 0 && count($this->inputsGastosGenerales) == 0 && count($this->inputsEquipamiento) == 0) {
                throw new Exception('Debe agregar al menos un item en: <span class="text-success fw-bolder">Recursos Humanos</span>, <span class="text-success fw-bolder">Gastos Generales</span> o <span class="text-success fw-bolder">Equipamiento</span>');
            } else {
                //Si se agrega un item en equipamiento el monto total no debe superar el 80% para DD y un 70% para los demas fondos
                if (count($this->inputsEquipamiento) > 0) {

                    $porcentajeEquip = ($this->totalEquip * 100) / $this->montoProyecto;

                    //Vivi Muñoz solicito cambiar porcentajes PM 60% y Los demas fondos 80%, modificado por MV 26-03-2025
                    // $maxPorcEquip = $this->idFondoConcursable == 1/*DD*/ ? 80:70; //Para deportistas destacados el porcentaje de equipamiento es de 80%, para los otos fondos es de 70%

                    $maxPorcEquip = $this->idFondoConcursable == 6/*PM*/ ? 60 : 80; //Para personas mayores el porcentaje en equipamiento es de 60%, para los otros fondos es de 80%


                    if ($porcentajeEquip > $maxPorcEquip) {
                        throw new Exception('<span class="text-success">El total en equipamiento ' . ($this->idFondoConcursable == 6 ? 'para el fondo <b class="text-primary">Personas Mayores</b>' : '') . ' no puede ser mayor al ' . $maxPorcEquip . '% (tope máximo: $' . number_format($this->montoProyecto * ($maxPorcEquip / 100), 0, ',', '.') . ') del monto total a financiar: $' . number_format($this->montoProyecto, 0, ',', '.') . '</span>');
                    } else
                        //Si ingresa un item en equipamiento debe ingresar un item en RRHH o GG para completar el 30%
                        if (count($this->inputsRecursosHumanos) == 0 && count($this->inputsGastosGenerales) == 0) {
                            throw new Exception('Ha agregado gastos en <span class="text-success fw-bolder">equipamiento</span>, por lo tanto, debe agregar al menos un item en <span class="text-success fw-bolder">Recursos Humanos</span> o <span class="text-success fw-bolder">Gastos Generales</span>');
                        }
                }

                if ($totalDatosPpto < $this->montoProyecto) {
                    throw new Exception('El total de los items: $' . number_format($totalDatosPpto, 0, ',', '.') . ' es menor al monto total a financiar: $' . number_format($this->montoProyecto, 0, ',', '.'));
                } else
                  if ($totalDatosPpto > $this->montoProyecto) {
                    throw new Exception('La suma total de los items: $' . number_format($totalDatosPpto, 0, ',', '.') . ' es mayor al monto total a financiar: $' . number_format($this->montoProyecto, 0, ',', '.'));
                }
            }
        } catch (exception $e) {
            $flgError = true;
            $this->dispatchBrowserEvent('moveScroll', ['id' => '#msjErrorStep3']);
            $this->dispatchBrowserEvent('swal:modal', [
                'icon' => 'error',
                'mensaje' => $e->getMessage(),
            ]);
        }

        if ($this->flgChangeStep3 && $flgError == false) { //Flag para guardar solo cuando existan cambios
            try {
                DB::beginTransaction();

                if (!empty($this->inputsRecursosHumanos)) {
                    foreach ($this->inputsRecursosHumanos as $index => $itemPptoRRHH) {
                        $pptoRRHH = Presupuestorh::updateOrCreate(
                            ['idPptoRRHH' => $itemPptoRRHH['idPptoRRHH']],
                            [
                                'idProyecto' => $this->idProyecto,
                                'perfil' => $itemPptoRRHH['perfil'],
                                'idActividad' => $itemPptoRRHH['idActividad'],
                                'canthora' => $itemPptoRRHH['canthora'],
                                'valorhora' => $itemPptoRRHH['valorhora'],
                                'montototal' => $itemPptoRRHH['montototal'],
                            ]
                        );

                        //Se actualiza el Id de la collection
                        $itemPptoRRHH['idPptoRRHH'] = $pptoRRHH->idPptoRRHH;
                        $this->inputsRecursosHumanos[$index] = $itemPptoRRHH;
                    }
                }

                if (!empty($this->inputsGastosGenerales)) {
                    foreach ($this->inputsGastosGenerales as $index => $itemGG) {
                        $pptoGG = Presupuestogg::updateOrCreate(
                            ['idPptoGG' => $itemGG['idPptoGG']],
                            [
                                'idProyecto' => $this->idProyecto,
                                'detabienesservicio' => $itemGG['detabienesservicio'],
                                'idActividad' => $itemGG['idActividad'],
                                'descripcion' => $itemGG['descripcion'],
                                'montototal' => $itemGG['montototal'],
                            ]
                        );

                        //Se actualiza el Id de la collection
                        $itemGG['idPptoGG'] = $pptoGG->idPptoGG;
                        $this->inputsGastosGenerales[$index] = $itemGG;
                    }
                }

                if (!empty($this->inputsEquipamiento)) {
                    foreach ($this->inputsEquipamiento as $index => $itemEquip) {
                        $pptoEquip = Presupuestoeq::updateOrCreate(
                            ['idPptoEq' => $itemEquip['idPptoEq']],
                            [
                                'idProyecto' => $this->idProyecto,
                                'detaequipo' => $itemEquip['detaequipo'],
                                'idActividad' => $itemEquip['idActividad'],
                                'cantidad' => $itemEquip['cantidad'],
                                'montototal' => $itemEquip['montototal'],

                            ]
                        );
                        //Se actualiza el Id de la collection
                        $itemEquip['idPptoEq'] = $pptoEquip->idPptoEq;
                        $this->inputsEquipamiento[$index] = $itemEquip;
                    }
                }

                DB::commit();
                $this->dispatchBrowserEvent('moveScroll', ['id' => '#cabecera']);
                $this->dispatchBrowserEvent('swal:information', [
                    'icon' => 'success',
                    'mensaje' => 'Se han guardado los datos del paso 3',
                ]);
                $this->flgChangeStep3 = false;
            } catch (exception $e) {
                $flgError = true;
                DB::rollBack();
                session()->flash('exceptionMessage', $e->getMessage());
            }
        }

        $this->currentStep = 3;
        if ($flgError == false) {
            $this->dispatchBrowserEvent('moveScroll', ['id' => '#cabecera']);
            $this->idDoc = "idDoc";
            $this->currentStep = 4;
        }
    }

    public function generateCodProyecto()
    {
        try {
            $fondoConcursable = Fondoconcursable::where('idFondoConcursable', '=', $this->idFondoConcursable)->first();
            //Se busca todos los proyectos enviados (codigo proyecto generado) que coincidan con el fondo concursable seleccionado para luego sacar el maximo
            $proyectosIdFondo = Proyecto::where('idFondoConcursableProyecto', '=', $this->idFondoConcursable)
                               // ->where('codProyecto', '>', '0')
                                  ->whereNotNull('codProyecto') //MVillalobos 23-04-2024
                                  ->whereYear('created_at', '=', now()->year)->get();

            //Se obtiene el max codProyecto para el fondo seleccionado
            $proyectoMaxCode = $proyectosIdFondo->where('codProyecto', '=', $proyectosIdFondo->max('codProyecto'))->first(); //Comentadoi por MVillalobos 23-04-2024 (se reversan los cambios 25-04-2024)

            //  dd($proyectoMaxCode, $proyectoIdFondo, $this->idFondoConcursable);

            return now()->year . $fondoConcursable->codigoFondoConcursable . str_pad(empty($proyectoMaxCode) ? "0001" : strval(substr($proyectoMaxCode->codProyecto, 6)) + 1, 4, '0', STR_PAD_LEFT);/*Se extrae el nro correlativo se le suma 1, luego se rellena con ceros a la izquierda*/
            // return now()->year . $fondoConcursable->codigoFondoConcursable . str_pad(empty($proyectosIdFondo) ? 1 : (count($proyectosIdFondo) + 1), 4, '0', STR_PAD_LEFT);/*Se extrae el nro correlativo se le suma 1, luego se rellena con ceros a la izquierda*/
        } catch (exception $e) {
            throw $e;
        }
    }

    // public function updatedDocProyecto($docProyecto) {
    //         $this->validate([
    //             'docProyecto' => 'required|file|mimes:pdf|max:30720', //30MB
    //         ]);
    // }
    public function fourthStep()
    {
        $this->validate([
            'docProyecto' => 'required|file|mimes:pdf|max:50720', //30MB
        ]);

        $this->flgExeptionMailSolicitante = false;

        try {

            //Buscar texto donde dice se genera en el ultimo paso
            //Si ya existe un codigo de proyecto verificar si cambio el fondo concursable y el tipo de proyecto
            //Para generar un nuevo codigo

            DB::beginTransaction();
            $this->codProyecto = $this->generateCodProyecto();

            $this->rutaDocumento = "Proyecto_Cod_" . $this->codProyecto . "." . $this->docProyecto->extension();
            $this->docProyecto->storeAs("public/docsProyectos", $this->rutaDocumento);

            $documento = Documento::updateOrCreate(
                ['idDocumento' => $this->idDocumentoProy],
                [
                    'rutaDocumento' => $this->rutaDocumento, //Se actualiza en el proximo paso
                    'checksum' => hash_file('sha256', $this->docProyecto->getRealPath()),
                ]
            );
            $this->idDocumentoProy = $documento->idDocumento;
            $this->rutaDocumento = $documento->rutaDocumento;


            Proyecto::where('idProyecto', $this->idProyecto)
                ->update([
                    'idDocumentoProyecto' => $this->idDocumentoProy,
                    'codProyecto' => $this->codProyecto,
                ]);

            $this->randId = rand(100, 1000);
            $this->dispatchBrowserEvent('moveScroll', ['id' => '#cabecera']);
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'success',
                'mensaje' => 'Su postulación ha sido recepcionada',
            ]);

            DB::commit();

            try {
                $this->enviarCorreoPostulacion();  
            } catch (exception $e) {
                throw $e;
              //session()->flash('exceptionMessage', $e->getMessage());
            }

            $this->currentStep = 5;
        } catch (exception $e) {
            DB::rollBack();
            $this->codProyecto = '';
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'error',
                'mensaje' => 'Se ha producido un error: '.$e->getMessage(),
            ]);
        }
    }

    public function enviarCorreoPostulacion() 
    {

        //En el pdf y en el correo incluir link con un token de documento adjunto en presupuesto poner el monto total a financiar
        // $this->correoOrganizacion = "mvillalobos@gorebiobio.cl";

        $proyecto = Proyecto::join('comunas', 'comunas.idComuna', '=', 'proyectos.idComunaProyecto')
            ->join('provincias', 'provincias.idProvincia', '=', 'proyectos.idProvinciaProyecto')
            ->join('fondoconcursables', 'fondoconcursables.idFondoConcursable', '=', 'proyectos.idFondoConcursableProyecto')
            ->join('tipoproyectos', 'tipoproyectos.idTipoProyecto', '=', 'proyectos.idTipoProyecto')
            ->join('organizacions', 'organizacions.idOrganizacion', '=', 'proyectos.idOrganizacionProyecto')
            ->join('tipocuentas', 'tipocuentas.idTipoCuenta', '=', 'organizacions.idTipoCuenta')
            ->join('bancos', 'bancos.idBanco', '=', 'organizacions.idBanco')
            ->join('representantes', 'representantes.idRepLegal', '=', 'organizacions.idRepLegal')
            ->join('documentos', 'documentos.idDocumento', '=', 'proyectos.idDocumentoProyecto')
            ->where('proyectos.idProyecto', '=', $this->idProyecto)->first();

        $objetivoespecifico = Objetivosespecifico::where('idProyecto', '=', $proyecto->idProyecto)->get();

        $actividad = Actividad::where('idProyecto', '=', $proyecto->idProyecto)->get();

        $RRHHProyecto = Rrhhproyecto::where('idProyecto', '=', $proyecto->idProyecto)->get();

        $pptoRRHH = Presupuestorh::where('presupuestorhs.idProyecto', '=', $proyecto->idProyecto)
            ->join('actividads', 'actividads.idActividad', '=', 'presupuestorhs.idActividad')->get();

        $pptoGastosGrales = Presupuestogg::where('presupuestoggs.idProyecto', '=', $proyecto->idProyecto)
            ->join('actividads', 'actividads.idActividad', '=', 'presupuestoggs.idActividad')->get();

        $pptoEquip = Presupuestoeq::where('presupuestoeqs.idProyecto', '=', $proyecto->idProyecto)
            ->join('actividads', 'actividads.idActividad', '=', 'presupuestoeqs.idActividad')->get();

        $data = [
            'asunto' => "Postulación de Proyecto - Gobierno Regional del Bio Bio",
            'titulo' => "Notificación: Ingreso de Postulación a Subvenciones",
            'proyecto' => $proyecto,
            'objetivoespecifico' => $objetivoespecifico,
            'actividades' => $actividad,
            'RRHHProyecto' => $RRHHProyecto,
            'pptoRRHH' => $pptoRRHH,
            'totalPptoRRHH' => $pptoRRHH->sum('montototal'), 
            'pptoGastosGrales' => $pptoGastosGrales,
            'totalPptoGastosGrales' => $pptoGastosGrales->sum('montototal'),
            'pptoEquip' => $pptoEquip,
            'totalPptoEquip' => $pptoEquip->sum('montototal'),
            'totalPpto' => $pptoRRHH->sum('montototal') + $pptoGastosGrales->sum('montototal') + $pptoEquip->sum('montototal'),
            'documentoPostulacion' => asset("/descargarDocuPostu/" . $proyecto->idDocumento . "/" . $proyecto->checksum),
        ];

        $pdfResuPostu = PDF::loadView('resumenProyectAD_PDF', $data)->output();

        // $checksum = hash('sha256', $pdfResuPostu);


         //Envío de correo con MicrosoftGraphService MV 22-05-2025 
             $resProyectoAttach = [ 
               '@odata.type' => '#microsoft.graph.fileAttachment',
               'name' => "ResumenPostulacionProy_Cod".$this->codProyecto.".pdf",
               'contentBytes' => base64_encode($pdfResuPostu), 
               'contentType' => 'application/pdf', 
              ];
  
              $graphService = new MicrosoftGraphService();
              $bodyHtml = View::make('correonotificacion', ['mailData' => $data])->render(); 
              $graphService->sendMail($data['asunto'], $bodyHtml, $this->correoOrganizacion, [$resProyectoAttach]); 
            //Envío de correo con MicrosoftGraphService MV 22-05-2025   

        try {
            //Mail al postulante
            // Mail::to($this->correoOrganizacion)->send(new CorreoNotificacion($data));
        } catch (exception $e) {
            $this->flgExeptionMailSolicitante = true;
            // session()->flash('exceptionMessage', $e->getMessage());
            throw $e;
        }

        $user = User::where('flgReceptor', '=', 1)->get();

        //Envío de correo a los admins
        $mailData['titulo'] = "Resumen de Postulación a Subvención";
        $mailData['asunto'] = "Postulación de Proyecto - " . $this->nombreOrganizacion;

        try {
            foreach ($user as $item) {
              //Envío de correo con MicrosoftGraphService MV 22-05-2025 
                $graphService = new MicrosoftGraphService();
                $bodyHtml = View::make('correonotificacion', ['mailData' => $data])->render();
                $graphService->sendMail($data['asunto'], $bodyHtml, $item->email, [$resProyectoAttach]);
              //Envío de correo con MicrosoftGraphService MV 22-05-2025

                // Mail::to($item->email)->send(new CorreoNotificacion($data));
            }
        } catch (exception $e) {
            // session()->flash('exceptionMessage', $e->getMessage());
            throw $e;
        }
    }

    public function back($step)
    {
        $this->currentStep = $step;
        $this->dispatchBrowserEvent('moveScroll', ['id' => '#cabecera']);
        $this->mensajeStep2 = "";
        $this->moveId = "";
    }

    public function addObjEspecifico()
    {
        if (count($this->inputsObjEspecifico) < 5) {
            $this->inputsObjEspecifico->add([
                'idObjEspecifico' => '0',
                'descripcionObjEspecifico' => ''
            ]);

            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'info',
                'mensaje' => 'Se ha agregado un nuevo item objetivo específico',
            ]);
            $this->dispatchBrowserEvent('moveScroll', ['id' => '#objEspecificosHead']);
            // $this->resetValidation('inputsObjEspecifico.*');
            // $this->resetErrorBag('inputsObjEspecifico.*');
            // $this->moveId = "";
        } else {
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'warning',
                'mensaje' => 'Máximo puedes agregar 5 items',
            ]);
        }
    }

    public function descargarDocuPostu($idDocumento, $checksum)
    {
        $documento = Documento::where('idDocumento', '=', $idDocumento)->first();

        if ($documento->checksum == $checksum) {
            return response()->download(storage_path('app/public/docsProyectos/' . $documento->rutaDocumento));
        } else {
            return "No autorizado";
        }
    }

    public function deleteErrorItem($collectionName, $index)
    {
        //Borrar error en el caso de que exista, del item eliminado
        //$nameInput = $collectionName.'.'.$index.'.'.$fieldName;
        $this->resetValidation($collectionName . '.' . $index . '.*');
        $this->resetErrorBag($collectionName . '.' . $index . '.*');
    }

    public function deleteItemObjEspecifico($index, $idObjEspecifico)
    {
        //Objetivosespecifico::where('idObjEspecifico', $idObjEspecifico)->delete();
        if ($idObjEspecifico > 0) {
            try {
                Objetivosespecifico::where('idObjEspecifico', '=', $idObjEspecifico)->delete();

                $this->dispatchBrowserEvent('swal:information', [
                    'icon' => 'info',
                    'mensaje' => 'Se ha eliminado un item de objetivos específicos',
                ]);
                $this->inputsObjEspecifico->pull($index);
                $this->deleteErrorItem('inputsObjEspecifico', $index);
            } catch (exception $e) {
                $this->dispatchBrowserEvent('swal:information', [
                    'icon' => 'error',
                    'mensaje' => 'Se ha producido un error al intentar eliminar el item',
                ]);
                session()->flash('exceptionMessage', $e->getMessage());
            }
        } else {
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'info',
                'mensaje' => 'Se ha quitado un item de objetivos específicos',
            ]);
            $this->inputsObjEspecifico->pull($index);
            $this->deleteErrorItem('inputsObjEspecifico', $index);
        }
    }

    public function addActividad()
    {
        if (count($this->inputsActividad) < 5) {


            $this->inputsActividad->push([
                'idActividad' => '0', 'tituloActividad' => '', 'descripcionActividad' => '', 'mesesEjecuActividad' => [], 'descripBienesServRRHHActividad' => ''
            ]);

            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'info',
                'mensaje' => 'Se ha agregado un nuevo item actividad',
            ]);


            $this->dispatchBrowserEvent('moveScroll', ['id' => '#actividadId' . count($this->inputsActividad)]);
            $this->resetValidation('inputsActividad.*');
            $this->resetErrorBag('inputsActividad.*');
            $this->moveId = "";
            //$this->dispatchBrowserEvent('moveScroll', ['id' => strval("#actividadId".(count($this->inputsActividad)-1))]);
        } else {
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'warning',
                'mensaje' => 'Máximo puedes agregar 5 items',
            ]);
        }
    }


    public function addDescripRRHH()
    {
        $maxItems = 10;
        if (count($this->inputsDescripRRHH) < $maxItems) {

            $this->inputsDescripRRHH->push([
                'idRRHHProyecto' => '0', 'descripCargo' => '', 'descripFuncActividades' => '', 'descripPerfilCargo' => '',
                'totalHorasServicio' => '', 'descripPeriocidadServicio' => '', 'montoTotalServicio' => ''
            ]);

            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'info',
                'mensaje' => 'Se ha agregado un nuevo item',
            ]);



            $this->dispatchBrowserEvent('moveScroll', ['id' => '#descripRRHHId' . count($this->inputsDescripRRHH)]);
            $this->resetValidation('inputsDescripRRHH.*');
            $this->resetErrorBag('inputsDescripRRHH.*');
            $this->moveId = "";
            //$this->dispatchBrowserEvent('moveScroll', ['id' => strval("#actividadId".(count($this->inputsActividad)-1))]);
        } else {
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'warning',
                'mensaje' => 'Máximo puedes agregar ' . $maxItems . ' items',
            ]);
        }
    }


    public function deleteActividad($index, $idActividad)
    {
        if ($idActividad > 0) {
            try {
                DB::beginTransaction();
                Actividad::where('idActividad', '=', $idActividad)->delete();

                //Se desasocioa la actividad eliminada de los items de datos presupuestarios
                Presupuestorh::where('idActividad', $idActividad)->update(['idActividad' => 0]);
                foreach ($this->inputsRecursosHumanos as $index => $itemRRHH) {
                    if ($itemRRHH['idActividad'] == $idActividad) {
                        $itemRRHH['idActividad'] = '0';
                        $this->inputsRecursosHumanos[$index] = $itemRRHH;
                    }
                }

                Presupuestogg::where('idActividad', $idActividad)->update(['idActividad' => 0]);
                foreach ($this->inputsGastosGenerales as $index => $itemGG) {
                    if ($itemGG['idActividad'] == $idActividad) {
                        $itemGG['idActividad'] = '0';
                        $this->inputsGastosGenerales[$index] = $itemGG;
                    }
                }

                Presupuestoeq::where('idActividad', $idActividad)->update(['idActividad' => 0]);
                foreach ($this->inputsEquipamiento as $index => $itemEq) {
                    if ($itemEq['idActividad'] == $idActividad) {
                        $itemEq['idActividad'] = '0';
                        $this->inputsEquipamiento[$index] = $itemEq;
                    }
                }

                $this->dispatchBrowserEvent('swal:information', [
                    'icon' => 'info',
                    'mensaje' => 'Se ha eliminado un item de actividades del proyecto',
                ]);

                DB::commit();
                $this->inputsActividad->pull($index);
                $this->deleteErrorItem('inputsActividad', $index);
            } catch (exception $e) {
                DB::rollBack();
                $this->dispatchBrowserEvent('swal:information', [
                    'icon' => 'error',
                    'mensaje' => 'Se ha producido un error al intentar eliminar el item',
                ]);

                session()->flash('exceptionMessage', $e->getMessage());
            }
        } else {
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'info',
                'mensaje' => 'Se ha quitado un item de actividades del proyecto',
            ]);
            $this->inputsActividad->pull($index);
            $this->deleteErrorItem('inputsActividad', $index);
        }
    }


    public function deleteItemDescripRRHH($index, $idRRHHProyecto)
    {
        if ($idRRHHProyecto > 0) {
            try {
                DB::beginTransaction();
                Rrhhproyecto::where('idRRHHProyecto', '=', $idRRHHProyecto)->delete();

                $this->dispatchBrowserEvent('swal:information', [
                    'icon' => 'info',
                    'mensaje' => 'Se ha eliminado un item de Recursos Humanos del proyecto',
                ]);

                DB::commit();
                $this->inputsDescripRRHH->pull($index);
                $this->deleteErrorItem('inputsDescripRRHH', $index);
            } catch (exception $e) {
                DB::rollBack();
                $this->dispatchBrowserEvent('swal:information', [
                    'icon' => 'error',
                    'mensaje' => 'Se ha producido un error al intentar eliminar el item',
                ]);

                session()->flash('exceptionMessage', $e->getMessage());
            }
        } else {
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'info',
                'mensaje' => 'Se ha quitado un item de Recursos Humanos del proyecto',
            ]);
            $this->inputsDescripRRHH->pull($index);
            $this->deleteErrorItem('inputsDescripRRHH', $index);
        }
    }


    public function addRecursoHumano()
    {
        //$this->validate(['resetValidate' => 'required',]);

        if (count($this->inputsRecursosHumanos) < 15) {
            //Con prepend se agregan los elementos al principio pero se genera incompatibilidad con el indice de la collecction errors
            $this->inputsRecursosHumanos->push([
                'idPptoRRHH' => '0', 'perfil' => '', 'idActividad' => '0', 'idProyecto' => '0', 'canthora' => '', 'valorhora' => '', 'montototal' => '',
            ]);

            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'info',
                'mensaje' => 'Se ha agregado un nuevo item a RRHH',
            ]);

            $this->dispatchBrowserEvent('iniTooltips');

            $this->dispatchBrowserEvent('moveScroll', ['id' => count($this->inputsRecursosHumanos) < 6 ? '#headRRHH' : '#ItemRRHHId' . (count($this->inputsRecursosHumanos) - 5)]); //Si es mayor a 4 se mueve el cursor a la posicion del elemento agregado con un margen de -3 items
        } else {
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'warning',
                'mensaje' => 'Máximo puedes agregar 15 items',
            ]);
        }
    }

    public function deleteRecursoHumano($index, $idPptoRRHH)
    {
        if ($idPptoRRHH > 0) {
            try {
                Presupuestorh::where('idPptoRRHH', '=', $idPptoRRHH)->delete();

                $this->dispatchBrowserEvent('swal:information', [
                    'icon' => 'info',
                    'mensaje' => 'Se ha eliminado un item de RRHH',
                ]);
                $this->inputsRecursosHumanos->pull($index);
            } catch (exception $e) {
                $this->dispatchBrowserEvent('swal:information', [
                    'icon' => 'error',
                    'mensaje' => 'Se ha producido un error al intentar eliminar el item',
                ]);

                session()->flash('exceptionMessage', $e->getMessage());
            }
        } else {
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'info',
                'mensaje' => 'Se ha quitado un item de RRHH',
            ]);
            $this->inputsRecursosHumanos->pull($index);
        }
        $this->totalRRHH = empty($this->inputsRecursosHumanos) ? 0 : $this->inputsRecursosHumanos->where('montototal', '>', 0)->sum('montototal');
    }

    public function confirmEnviarPostulacion()
    {
        $this->dispatchBrowserEvent('swal:confirmEnvioPostu', [
            'type' => 'warning',
            'title' => '¿Confirmar Envío de Postulación?',
            'text' => '<span style="text-align:justify;">Asegurese de revisar bien los datos ingresados para la postulación de su proyecto. Una vez enviados no podrá realizar modificaciones. <br>Puede navegar libremente por las distintas fases con los botones <span class="text-danger" style="font-weight:420;">Atrás</span> y <span class="text-primary" style="font-weight:420;">Siguiente</span> para revisar la información ingresada (no perderá sus datos).</span>',
        ]);

        // $this->validate([
        //     'docProyecto' => 'required|file|mimes:pdf|max:30720', //30MB
        // ]);

        // $this->dispatchBrowserEvent('swal:confirm', [
        //     'type' => 'warning',
        //     'title' => '¿Confirmar Envío de Postulación?',
        //     'text' => '<span style="text-align:justify;">Asegurese de revisar bien los datos ingresados para la postulación de su proyecto. Una vez enviados no podrá realizar modificaciones. <br>Puede navegar libremente por las distintas fases con los botones <span class="text-danger" style="font-weight:420;">Atrás</span> y <span class="text-primary" style="font-weight:420;">Siguiente</span> para revisar la información ingresada (no perderá sus datos).</span>',
        // ]);
    }


    public function addGastosGenerales()
    {
        if (count($this->inputsGastosGenerales) < 15) {
            $this->inputsGastosGenerales->push([
                'idPptoGG' => '0', 'idProyecto' => '0', 'detabienesservicio' => '', 'idActividad' => '0', 'descripcion' => '', 'montototal' => '',
            ]);

            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'info',
                'mensaje' => 'Se ha agregado un nuevo item a Gastos Generales',
            ]);

            $this->dispatchBrowserEvent('iniTooltips');

            $this->dispatchBrowserEvent('moveScroll', ['id' => count($this->inputsGastosGenerales) < 6 ? '#headGG' : '#ItemGGId' . (count($this->inputsGastosGenerales) - 5)]); //(count($this->inputsEquipamiento) < 9)?'#headGG':'#bottomGG']
        } else {
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'warning',
                'mensaje' => 'Máximo puedes agregar 15 items',
            ]);
        }
    }

    public function deleteGastosGenerales($index, $idPptoGG)
    {
        if ($idPptoGG > 0) {
            try {
                Presupuestogg::where('idPptoGG', '=', $idPptoGG)->delete();

                $this->dispatchBrowserEvent('swal:information', [
                    'icon' => 'info',
                    'mensaje' => 'Se ha eliminado un item de Gastos Generales',
                ]);
                $this->inputsGastosGenerales->pull($index);
            } catch (exception $e) {
                $this->dispatchBrowserEvent('swal:information', [
                    'icon' => 'error',
                    'mensaje' => 'Se ha producido un error al intentar eliminar el item',
                ]);

                session()->flash('exceptionMessage', $e->getMessage());
            }
        } else {
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'info',
                'mensaje' => 'Se ha quitado un item de Gastos Generales',
            ]);
            $this->inputsGastosGenerales->pull($index);
        }
        $this->totalGG = empty($this->inputsGastosGenerales) ? 0 : $this->inputsGastosGenerales->where('montototal', '>', 0)->sum('montototal');
    }


    public function addEquipamiento()
    {
        if (count($this->inputsEquipamiento) < 15) {
            $this->inputsEquipamiento->push([
                'idPptoEq' => '0', 'idProyecto' => '0', 'detaequipo' => '', 'idActividad' => '0', 'cantidad' => '', 'montototal' => '',
            ]);
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'info',
                'mensaje' => 'Se ha agregado un nuevo item a Equipamiento',
            ]);

            $this->dispatchBrowserEvent('iniTooltips');

            $this->dispatchBrowserEvent('moveScroll', ['id' =>  count($this->inputsEquipamiento) < 6 ? '#headEquip' : '#itemEquipId' . (count($this->inputsEquipamiento) - 5)]);
        } else {
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'warning',
                'mensaje' => 'Máximo puedes agregar 15 items',
            ]);
        }
    }

    public function deleteEquipamiento($index, $idPptoEq)
    {
        if ($idPptoEq > 0) {
            try {
                Presupuestoeq::where('idPptoEq', '=', $idPptoEq)->delete();

                $this->dispatchBrowserEvent('swal:information', [
                    'icon' => 'info',
                    'mensaje' => 'Se ha eliminado un item de Equipamiento',
                ]);
                $this->inputsEquipamiento->pull($index);
            } catch (exception $e) {
                $this->dispatchBrowserEvent('swal:information', [
                    'icon' => 'error',
                    'mensaje' => 'Se ha producido un error al intentar eliminar el item',
                ]);

                session()->flash('exceptionMessage', $e->getMessage());
            }
        } else {
            $this->dispatchBrowserEvent('swal:information', [
                'icon' => 'info',
                'mensaje' => 'Se ha quitado un item de Equipamiento',
            ]);
            $this->inputsEquipamiento->pull($index);
        }

        $this->totalEquip = empty($this->inputsEquipamiento) ? 0 : $this->inputsEquipamiento->where('montototal', '>', 0)->sum('montototal');
    }

    public function volverInicio()
    {
        $this->reset();
        $this->inicio();
    }

    public function getDataResumenPostuPDF($idProyecto)
    {

        $proyecto = Proyecto::join('comunas', 'comunas.idComuna', '=', 'proyectos.idComunaProyecto')
            ->join('fondoconcursables', 'fondoconcursables.idFondoConcursable', '=', 'proyectos.idFondoConcursableProyecto')
            ->join('tipoproyectos', 'tipoproyectos.idTipoProyecto', '=', 'proyectos.idTipoProyecto')
            ->join('organizacions', 'organizacions.idOrganizacion', '=', 'proyectos.idOrganizacionProyecto')
            ->where('proyectos.idProyecto', '=', $idProyecto)->first();

        $objetivoespecifico = Objetivosespecifico::where('idProyecto', '=', $proyecto->idProyecto)->get();

        $actividad = Actividad::where('idProyecto', '=', $proyecto->idProyecto)->get();

        $RRHHProyecto = Rrhhproyecto::where('idProyecto', '=', $proyecto->idProyecto)->get();

        $pptoRRHH = Presupuestorh::where('idProyecto', '=', $proyecto->idProyecto)->get();
        $pptoGastosGrales = Presupuestogg::where('idProyecto', '=', $proyecto->idProyecto)->get();
        $pptoEquip = Presupuestoeq::where('idProyecto', '=', $proyecto->idProyecto)->get();

        $data = [
            'proyecto' => $proyecto,
            'objetivoespecifico' => $objetivoespecifico,
            'actividades' => $actividad,
            'RRHHProyecto' => $RRHHProyecto,
            'pptoRRHH' => $pptoRRHH,
            'totalPptoRRHH' => $pptoRRHH->sum('montototal'),
            'pptoGastosGrales' => $pptoGastosGrales,
            'totalPptoGastosGrales' => $pptoGastosGrales->sum('montototal'),
            'pptoEquip' => $pptoEquip,
            'totalPptoEquip' => $pptoEquip->sum('montototal'),
            'totalPpto' => $pptoRRHH->sum('montototal') + $pptoGastosGrales->sum('montototal') + $pptoEquip->sum('montototal'),

        ];

        // $pdf = PDF::loadView('livewire.liquidacionPDF', $data);

        // return $pdf->download('Liquidacion.pdf');
        return $data;
    }


    public function enviarCorreoPostuTest()
    {
        $data = $this->getDataResumenPostuPDF(36);

        $pdf = PDF::loadView('resumenProyectPDF', $data);

        $mailData = [
            'asunto' => "Postulación de Proyecto - Gobierno Regional del Bio Bio",
            'titulo' => "Notificación: Ingreso de Postulación de Proyecto a Subvenciones",
            // 'tituloResumen' => "Resumen de la Postulación de su Proyecto",
            'descripcionFondo' => "Prueba",
            'nombreProyecto' => "Prueba",
            'codProyecto' => "Prueba",
            'montoProyecto' => "Prueba",
            'runOrganizacion' => "Prueba",
            'nombreOrganizacion' => "Prueba",
            'telefonoOrganizacion' =>  "Prueba",
            'correoOrganizacion' => "Prueba",
            'fecSolicitud' => "Prueba",
        ];

        $mailData['attachment'] = $pdf->output();

        Mail::to(["mvillalobos@gorebiobio.cl"])->send(new CorreoNotificacion($mailData));
    }
}
