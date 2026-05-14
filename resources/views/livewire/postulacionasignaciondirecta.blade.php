<div>
    <div class="card shadow" id="cabecera">
            <div class="card-header text-center h4 py-3">
                Postulaci&oacute;n de iniciativas a Fondo concursable <b class="text-primary">Asignación Directa</b>
            </div>
            <div class="card-body">
    <form>
        @csrf
        @if ($currentStep > 0)
        <div class="container-md px-3">
            <div class="row px-4 stepwizard @if($currentStep == 5) displayNone @endif">
                <div class="col-12 stepwizard-row">
                    <div class="row">
                        <div class="stepwizard-step col-12 col-md-3">
                            <a href="#step-1" type="button" class="btn btn-circle {{ $currentStep != 1 ? 'btn-default' : 'btn-primary'}}">1</a>
                            <p class="{{ $currentStep != 1 ? '' : 'negritaverde'}}">Datos Organización</p>
                        </div>
                        <div class="stepwizard-step col-12 col-md-3">
                            <a href="#step-2" type="button" class="btn btn-circle {{ $currentStep != 2 ? 'btn-default' : 'btn-primary' }}">2</a>
                            <p class="{{ $currentStep != 2 ? '' : 'negritaverde'}}">Datos Administrativos</p>
                        </div>
                        <div class="stepwizard-step col-12 col-md-3">
                            <a href="#step-3" type="button" class="btn btn-circle {{ $currentStep != 3 ? 'btn-default' : 'btn-primary' }}">3</a>
                            <p class="{{ $currentStep != 3 ? '' : 'negritaverde'}}">Datos Presupuestarios</p>
                        </div>
                        <div class="stepwizard-step col-12 col-md-3">
                            <a href="#step-4" type="button" class="btn btn-circle {{ $currentStep != 4 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">4</a>
                            <p class="{{ $currentStep != 4 ? '' : 'negritaverde'}}">Datos Adjuntos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row mb-3 mt-2 mb-md-3 mt-md-2">
            <div class="col-9 offset-1 col-md-8 offset-md-3">
                <div wire:offline>
                    <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                            <use xlink:href="#exclamation-triangle-fill" />
                        </svg>
                        <div>
                            Sin Conexi&oacute;n a Internet
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inicio Postulaciones cerradas -->
        <div class="{{ $currentStep != -1 ? 'displayNone' : '' }}" id="step-1">
            <div class="row mb-5 justify-content-center">
                <div class="col-10 col-md-10 mb-3">
                    <div class="alert alert-info border border-info my-3 mx-3 my-md-4 mx-md-4 text-center" role="alert">
                        <span class="fs-4 pe-2 pe-md-3"><i class="bi bi-info-circle-fill"></i></span>
                        <span class="fs-6 fst-italic pt-4">
                            <!-- Las postulaciones volverán a estar disponibles según calendario de postulaciones. -->
                            Calendario de postulaciones para fondo de <b>asignación directa</b> {{ $agnoActual }} pronto a informar. 
                        </span>
                    </div>
                </div>
                <!-- <div class="col-11 p-1 col-md-10 p-md-3 card ">
                    <img src="{{ asset('images/calendariopostulaciones.jpg') }}" class="img-fluid rounded">
                </div> -->
            </div>
        </div>
        <!-- Fin Postulaciones cerradas -->



        <div class="{{ $currentStep != 0 ? 'displayNone' : '' }}" id="step-0">
            <div class="row ms-0 mb-2 ms-md-4 mb-md-3">
                <div class="col-12 mb-2 mt-3 col-md-4 offset-md-3 mb-md-3 mt-md-4">
                    Ingrese RUN de la Organizaci&oacute;n
                </div>
                <div class="col-8 pe-1 col-md-4 offset-md-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="number" id="runOrganizacion" maxlength="8" onkeydown="return onlyNumberKey(event, this);" onkeyup="focusDV(event, this, document.forms[0].dvRunOrganizacion);" wire:model.lazy="runOrganizacion" wire:loading.attr="disabled" wire:target="ingresarProyecto" class="form-control" placeholder="Sin puntos ni guión" autocomplete="off" data-tippy-content="Ingrese RUN sin puntos ni guión Ej: 76000000">
                    </div>
                </div>
                <div class="col-3 ps-1 col-md-1 ps-md-2">
                    <input type="text" id="dvRunOrganizacion" maxlength="1" onkeydown="return onlyAlphaNumDVKey(event, this);" class="form-control" wire:model.lazy="dvRunOrganizacion" wire:loading.attr="disabled" wire:target="ingresarProyecto" autocomplete="off" data-tippy-content="Dígito verificador RUN.">
                </div>
                <div class="col-1 col-md-4">
                    &nbsp;
                </div>
                @error('runOrganizacion')
                <div class="col-1 col-md-3">
                    &nbsp;
                </div>
                <div class="col-10 col-md-9">
                    <span class="colorerror">{{ $message }}</span>
                </div>
                @enderror
                @error('dvRunOrganizacion')
                <div class="col-1 col-md-3">
                    &nbsp;
                </div>
                <div class="col-10 col-md-9">
                    <span class="colorerror">{{ $message }}</span>
                </div>
                @enderror
            </div>
            <div class="row">

                @if (!empty($proyectos) && count($proyectos) > 4)
                <div class="col-12 px-5" id="maxPostulaciones">
                    <div class="alert alert-info border border-info d-flex align-items-center" role="alert" id="datosAdministrativos">
                        <span class="fs-4 pe-2"><i class="bi bi-info-circle-fill"></i></span>
                        <span class="fs-6 fst-italic pt-1" style="text-align:justify;text-indent:10px;">
                            Usted ha realizado el máximo de postulaciones para el año en curso, sólo puede editar los proyectos que aún no han sido enviados
                        </span>
                    </div>
                </div>
                @endif

                @if (!empty($proyectos) && count($proyectos) > 0)
                <div class="col-12">
                    <div class="card mx-4 mt-3 mb-4" id="headPostulaciones">
                        <div class="card-header">
                            <div class="row mt-4 mb-3">
                                <div class="col-12 px-3 h5 text-center">
                                    Postulaciones Realizadas Por Su Organización el Año en Curso
                                </div>
                            </div>
                        </div>
                        <div class="card-body m-0 p-0">
                            <!-- Inicio TABLA -->
                            <div class="table-responsive">
                                <table class="table table-borderless card-1 p-3">
                                    <thead>
                                        <tr class="border-bottom bg-light">
                                            <th class="col-4 ps-3 pe-2">
                                                Nombre del Proyecto
                                            </th>
                                            <th class="col-3">
                                                Fondo Concursable
                                            </th>
                                            <th class="col-3">
                                                Tipo de Proyecto
                                            </th>
                                            <th class="col-1">
                                                Fec.Ingreso
                                            </th>
                                            <th class="col-1">
                                                Fec.Modifi.
                                            </th>
                                            <th class="col-1">
                                                Estado
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($proyectos as $index => $itemProy)
                                        <tr class="border border-bottom-0 border-start-0 border-end-0 text-secondary">
                                            <td class="ps-3 py-2">
                                                @if(strlen($itemProy->codProyecto) > 1)
                                                <div id="Id{{$itemProy->idProyecto}}" data-tippy-content="El proyecto ya fue enviado, su código de proyecto es: {{$itemProy->codProyecto}}">
                                                    {{$itemProy->nombreProyecto}}
                                                </div>
                                                @else
                                                <div wire:click="cargarDatosProyectoSel({{$itemProy->idProyecto}})" id="Id{{$itemProy->idProyecto}}" class="text-primary" style="cursor:pointer" data-tippy-content="Haga Click para continuar con el proceso de postulación se cargarán todos los datos del proyecto ingresados previamente.">
                                                    {{$itemProy->nombreProyecto}}
                                                </div>
                                                @endif
                                            </td>
                                            <td class="px-1 py-2">
                                                {{$itemProy->descripcionFondoConcursable}}
                                            </td>
                                            <td class="px-1 py-2">
                                                {{$itemProy->descripcionTipoProyecto}}
                                            </td>
                                            <td class="px-1 py-2">
                                                {{\Carbon\Carbon::parse($itemProy->created_at)->format('d/m/Y')}}
                                            </td>
                                            <td class="px-1 py-2">
                                                {{\Carbon\Carbon::parse($itemProy->updated_at)->format('d/m/Y')}}
                                            </td>
                                            <td>
                                                @if(strlen($itemProy->codProyecto) > 1)
                                                Enviado
                                                @else
                                                Sin Concluir
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- <div class="col-md-5 mt-3">
                   <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" wire:loading.attr="disabled" wire:target="enviarCorreoPostuTest" wire:click="enviarCorreoPostulacion">
                       Enviar correo con Resumen PDF
                    </button>

                    <a href="/descargarDocuPostu/35/1" target="_blank" class="btn btn-primary btn-sm mt-3" data-tippy-content="Descargar resumen de la solicitud en formato PDF."><i class="bi bi-filetype-pdf"></i> Descargar Doc Postu</a>
                </div> -->


                @if (empty($proyectos) || (!empty($proyectos) && count($proyectos) < 5)) <div class="col-12 @if (!empty($proyectos) && count($proyectos) > 0) ps-3 @else ps-5 @endif  mt-3 mb-5 col-md-5 offset-md-3 text-md-center">
                    <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" id="btnNuevaPostulacion" name="btnNuevaPostulacion" wire:loading.attr="disabled" wire:target="ingresarProyecto, runOrganizacion, dvRunOrganizacion" wire:click="ingresarProyecto" @if($flgDisabldBtnNvaPostulacion==true) disabled @endif>
                        <span wire:loading.class="spinner-border spinner-border-sm" wire:target="ingresarProyecto" role="status" aria-hidden="true"></span>
                        Comenzar @if (!empty($proyectos) && count($proyectos) > 0) Nueva @endif Postulación
                    </button>
            </div>
            @endif
        </div>
</div>

<div class="row {{ $currentStep != 1 ? 'displayNone' : '' }}" id="step-1">
    <div class="col-12 col-md-12">
        <div class="container pt-3">
            <div class="card" id="datosOrganizacion">
                <div class="card-header h4">
                    <div class="row py-2">
                        <div class="col-12 col-md-7 offset-md-2 text-center">
                            Datos Organización Postulante Subvención
                        </div>
                        <div class="col-12 pt-3 text-center col-md-3 pt-md-0">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="moveScrollById('#datosRepLegal')"><i class="bi bi-chevron-double-down"></i> Datos Representante Legal</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row ms-0 mb-2 ms-md-4 mt-md-4">
                        <div class="col-12 pt-3 mb-1 col-md-4 pt-md-0 mb-md-2">
                            <div class="row">
                                <div class="col-12">
                                    Rut Organización
                                </div>
                                <div class="col-12 h4">
                                    {{number_format(is_numeric($runOrganizacion)?$runOrganizacion:0, 0, ',', '.')}}-{{$dvRunOrganizacion}}
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="row pe-0 pt-0 pe-md-4">
                                <div class="col-12" id="idnombreOrganizacion">
                                    <label>Nombre Organización</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input type="text" id="nombreOrganizacion" wire:model.debounce.250ms="nombreOrganizacion" wire:loading.attr="disabled" wire:target="firstStep" maxlength="150" class="form-control" placeholder="Ingrese Nombre de la Organización">
                                    </div>
                                </div>
                                @error('nombreOrganizacion')
                                <div class="col-12" id="idnombreOrganizacionError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row ms-0 mb-2 ms-md-4 mb-md-3">
                        <div class="col-12 col-md-4">
                            <div class="row pe-0 pt-2 pt-md-0">
                                <div class="col-12" id="idagnosExistencia">
                                    <label>Años de Existencia Legal</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-clock-history"></i>
                                        </span>
                                        <input type="text" id="agnosExistencia" wire:model.debounce.250ms="agnosExistencia" wire:loading.attr="disabled" wire:target="firstStep" onkeydown="return onlyNumberKey(event, this);" maxlength="3" class="form-control" placeholder="Cantidad Años" data-tippy-content="Ingrese cantidad de años de existencia legal de la institución (minimo 2)." autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <span class="text-success" style="font-size:14px;font-style: italic;">(Si es menos de 1 año ingrese cero)</span>
                                </div>

                                @error('agnosExistencia')
                                <div class="col-12" id="idagnosExistenciaError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-8">
                        <div class="row pe-0 pt-3 pe-md-0 pt-md-0">
                                <div class="col-3 pe-0 pe-md-0" id="idcodTipoVia">
                                <label>Tipo de Vía</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                           <i class="bi bi-signpost-2"></i>
                                        </span>
                                        <select wire:model="codTipoVia" wire:loading.attr="disabled" wire:target="firstStep" class="form-select">
                                            <option value="0">Sel.</option>
                                            @foreach($tipoViasCmb as $itemTipoVia)
                                            <option value="{{$itemTipoVia->codTipoVia}}">{{$itemTipoVia->descripTipoVia}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- <div class="col-5" id="iddireccionOrganizacion">
                                    <label>Nombre {{$descripTipoVia}}</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-signpost-2"></i>
                                        </span>
                                        <input type="text" id="direccionOrganizacion" wire:model.debounce.250ms="direccionOrganizacion" wire:loading.attr="disabled" wire:target="firstStep" maxlength="150" class="form-control" placeholder="Nombre {{$descripTipoVia}}">
                                    </div>
                                </div> -->
                                 <div class="col-5" id="idnombreVia">
                                    <label>Nombre {{$descripTipoVia}}</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-signpost-2"></i>
                                        </span>
                                        <input type="text" id="nombreVia" wire:model.debounce.250ms="nombreVia" wire:loading.attr="disabled" wire:target="firstStep" maxlength="150" class="form-control" placeholder="Nombre {{$descripTipoVia}}">
                                    </div>
                                </div>

                                <div class="col-2" id="idnumDireccion">
                                    <label>Número</label>
                                        <input type="text" wire:model.debounce.250ms="numDireccion" onkeydown="return onlyNumberKey(event, this);" maxlength="5" wire:loading.attr="disabled" wire:target="firstStep" class="form-control" placeholder="Número">
                                </div>

                                @error('codTipoVia')
                                <div class="col-12" id="idcodTipoViaError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror

                                @error('nombreVia')
                                <div class="col-12" id="idnombreViaError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror

                                @error('numDireccion')
                                <div class="col-12" id="idnumDireccionError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror

                                @error('direccionOrganizacion')
                                <div class="col-12" id="iddireccionOrganizacionError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror


                            </div>
                        </div>
                    </div>
                    <div class="row ms-0 mb-0 ms-md-4 mb-md-3">
                        <div class="col-12 col-md-4">
                            <div class="row pe-0 pt-1 pt-md-0">
                                <div class="col-12" id="ididProvinciaOrg">
                                    <label>Provincia</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-signpost-2"></i>
                                        </span>
                                        <select id="idProvinciaOrg" wire:model="idProvinciaOrg" wire:loading.attr="disabled" wire:target="firstStep" class="form-select">
                                            <option value="0">Sel. Provincia</option>
                                            @foreach($provincias as $itemProvi)
                                            <option value="{{$itemProvi->idProvincia}}">{{$itemProvi->descripcionProvincia}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('idProvinciaOrg')
                                <div class="col-12" id="ididProvinciaOrgError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="row pe-0 pt-3 pe-md-4 pt-md-0">
                                <div class="col-12 col-md-8" id="ididComunaOrg">
                                    <label>Comuna (Domicilio de la Organización)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-signpost-2"></i>
                                        </span>
                                        <select id="idComunaOrg" wire:model="idComunaOrg" wire:loading.attr="disabled" wire:target="firstStep" class="form-select">
                                            <option value="0">Seleccione Comuna</option>
                                            @if (!empty($comunasOrg))
                                               @foreach($comunasOrg as $itemComuna)
                                                   <option value="{{$itemComuna->idComuna}}">{{$itemComuna->descripcionComuna}}</option>
                                               @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @error('idComunaOrg')
                                <div class="col-12" id="ididComunaOrgError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row ms-0 mb-0 ms-md-4 mb-md-3">
                        <div class="col-12 col-md-4">
                            <div class="row pe-0 pt-3 pt-md-0">
                                <div class="col-12" id="ididTipocuenta">
                                    <label>Tipo de Cuenta</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-cash-coin"></i>
                                        </span>
                                        <select id="idTipocuenta" wire:model="idTipocuenta" wire:loading.attr="disabled" wire:target="firstStep" class="form-select">
                                            <option value="0">Sel. Tipo Cuenta</option>
                                            @foreach($tipoCuentas as $itemTipoCuenta)
                                            <option value="{{$itemTipoCuenta->idTipocuenta}}">{{$itemTipoCuenta->tipoCuenta}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('idTipocuenta')
                                <div class="col-12" id="ididTipocuentaError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="row pe-0 pt-3 pe-md-4 pt-md-0">
                                <div class="col-12" id="ididBanco">
                                    <label>Banco</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-bank"></i>
                                        </span>
                                        <select id="idBanco" wire:model="idBanco" wire:loading.attr="disabled" wire:target="firstStep" class="form-select">
                                            <option value="0">Seleccione Banco</option>
                                            @foreach($bancos as $itemBanco)
                                            <option value="{{$itemBanco->idBanco}}">{{$itemBanco->nombreBanco}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('idBanco')
                                <div class="col-12" id="ididBancoError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row ms-0 mb-0 ms-md-4 mb-md-3">
                        <div class="col-12 col-md-4">
                            <div class="row pt-3 pt-md-0">
                                <div class="col-12" id="idnumeroCuenta">
                                    <label>Número de Cuenta</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-piggy-bank"></i>
                                        </span>
                                        <input type="text" wire:model.debounce.250ms="numeroCuenta" wire:loading.attr="disabled" wire:target="firstStep" maxlength="20" class="form-control" placeholder="">
                                    </div>
                                </div>
                                @error('numeroCuenta')
                                <div class="col-12" id="idnumeroCuentaError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-8">
                            <div class="row pe-0 pt-3 pe-md-4 pt-md-0">
                                <div class="col-12" id="idcorreoOrganizacion">
                                    <label>Correo Electrónico Organización</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="text" wire:model.debounce.250ms="correoOrganizacion" wire:loading.attr="disabled" wire:target="firstStep" maxlength="150" class="form-control" placeholder="">
                                    </div>
                                </div>
                                @error('correoOrganizacion')
                                <div class="col-12" id="idcorreoOrganizacionError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row ms-0 mb-3 ms-md-4">
                        <div class="col-12 col-md-4">
                            <div class="row pt-3 pt-md-0">
                                <div class="col-12" id="idtelefonoOrganizacion">
                                    <label>Teléfono Organización</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-telephone"></i>
                                        </span>
                                        <input type="text" wire:model.debounce.250ms="telefonoOrganizacion" wire:loading.attr="disabled" wire:target="firstStep" maxlength="15" class="form-control" placeholder="">
                                    </div>
                                </div>
                                @error('telefonoOrganizacion')
                                <div class="col-12" id="idtelefonoOrganizacionError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-5" id="datosRepLegal">
                <div class="card-header h4">
                    <div class="row py-2">
                        <div class="col-12 text-center col-md-5 offset-md-3">
                            Datos del Representante Legal
                        </div>
                        <div class="col-12 pt-3 text-center col-md-4 ps-md-4">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="moveScrollById('#datosOrganizacion')"><i class="bi bi-chevron-double-up"></i> Datos Organización</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row ms-0 mb-2 ms-md-4 mt-md-4">
                        <div class="col-12 pt-0 mb-1 col-md-4 mb-md-2">
                            <div class="row" id="iddvRutRepLegal">
                                <div class="col-12" id="idrutRepLegal">
                                    Rut Representante Legal
                                    <input type="hidden" wire:model.debounce.250ms="idRepLegal" />
                                </div>
                                <div class="col-9 pe-1">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input type="number" id="rutRepLegal" onkeydown="return onlyNumberKey(event, this);" onkeyup="focusDV(event, this, document.forms[0].dvRutRepLegal);" wire:model="rutRepLegal" wire:loading.attr="disabled" wire:target="firstStep" maxlength="8" class="form-control" placeholder="Sin puntos ni guión" autocomplete="off" data-tippy-content="Ingrese Rut sin puntos ni guión Ej: 14213732">
                                    </div>
                                </div>
                                <div class="col-3 ps-1">
                                    <input type="text" class="form-control" id="dvRutRepLegal" maxlength="1" onkeydown="return onlyAlphaNumDVKey(event, this);" wire:model.debounce.250ms="dvRutRepLegal" wire:loading.attr="disabled" wire:target="firstStep" autocomplete="off" data-tippy-content="Dígito verificador Rut.">
                                </div>
                                @error('rutRepLegal')
                                <div class="col-12" id="idrutRepLegalError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                                @error('dvRutRepLegal')
                                <div class="col-12" id="iddvRutRepLegalError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="row pt-3 pe-0 pe-md-4 pt-md-0">
                                <div class="col-12" id="idnomRepLegal">
                                    <label>Nombre Representante Legal</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input type="text" wire:model.debounce.250ms="nomRepLegal" wire:loading.attr="disabled" wire:target="firstStep" maxlength="50" class="form-control" placeholder="">
                                    </div>
                                </div>
                                @error('nomRepLegal')
                                <div class="col-12" id="idnomRepLegalError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row ms-0 mb-2 ms-md-4 mb-md-3">
                        <div class="col-12 col-md-4">
                            <div class="row pt-3 pt-md-0">
                                <div class="col-12" id="idtelefonoRepLegal">
                                    <label>Teléfono Representante Legal</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-telephone"></i>
                                        </span>
                                        <input type="text" wire:model.debounce.250ms="telefonoRepLegal" wire:loading.attr="disabled" wire:target="firstStep" maxlength="15" class="form-control" placeholder="">
                                    </div>
                                </div>
                                @error('telefonoRepLegal')
                                <div class="col-12" id="idtelefonoRepLegalError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-8">
                            <div class="row">
                                <div class="col-12 pt-3 pe-0 pe-md-4 pt-md-0" id="idcorreoRepLegal">
                                    <label>Correo Electrónico Representante Legal</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input type="text" wire:model.debounce.250ms="correoRepLegal" wire:loading.attr="disabled" wire:target="firstStep" maxlength="150" class="form-control" placeholder="Ingrese Correo Rep.Legal">
                                    </div>
                                </div>
                                @error('correoRepLegal')
                                <div class="col-12" id="idcorreoRepLegalError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row ms-0 mb-2 ms-md-4">
                        <div class="col-12 mb-2 col-md-6">
                            <div class="row">
                                <div class="col-12 pt-3 col-md-8 pt-md-2" id="idfecVencDirectiva">
                                    <label>Fecha Vencimiento Directiva Actual</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-calendar4"></i>
                                        </span>
                                        <input type="date" id="fecVencDirectiva" wire:model.debounce.250ms="fecVencDirectiva" wire:loading.attr="disabled" wire:target="firstStep" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                @error('fecVencDirectiva')
                                <div class="col-8" id="idfecVencDirectivaError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-4 ms-md-5 mt-md-5 mb-md-5">
                <!-- <div class="col-12 mb-2 offset-0 col-md-2 mb-md-0 offset-md-3">
                            <button class="btn btn-danger nextBtn btn-lg pull-right" style="width:150px;" type="button" wire:click="volverInicio" wire:loading.attr="disabled" wire:target="volverInicio,firstStep">
                                <span wire:loading.class="spinner-border spinner-border-sm" wire:target="volverInicio" role="status" aria-hidden="true"></span>
                                Atr&aacute;s
                            </button>
                        </div> -->
                <div class="col-12 text-center col-md-4 offset-md-3 ps-md-4">
                    <button class="btn btn-primary btn-lg" type="button" wire:click="firstStep" wire:loading.attr="disabled" wire:target="firstStep,volverInicio">
                        Siguiente
                        <span wire:loading.remove wire:target="firstStep"><i class="bi bi-arrow-right"></i></span>
                        <span wire:loading.class="spinner-border spinner-border-sm" wire:target="firstStep" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row {{ $currentStep != 2 ? 'displayNone' : '' }}" id="step-2">
    <div class="col-12">
        <div class="container pt-3 px-2 px-md-4">
            <div class="card mb-5" id="datosAdmHead">
                <div class="card-header text-center">
                    <div class="row h4 pt-3 pt-md-2">
                        <div class="col-12">
                            Datos Administrativos del Proyecto
                        </div>
                    </div>
                    <div class="row py-md-1">
                        <div class="col-0 col-md-3 ms-md-3">&nbsp;</div>
                        <div class="col-12 pb-2 col-md-1 pb-md-0 text-nowrap me-md-5 text-center">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="moveScrollById('#datosTecnicos')"><i class="bi bi-chevron-double-down"></i>Datos Técnicos</button>
                        </div>
                        <div class="col-12 pb-2 col-md-2 pb-md-0 text-nowrap ms-md-4 me-md-1 px-md-0 text-center">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="moveScrollById('#objEspecificosHead')"><i class="bi bi-chevron-double-down"></i>Objetivos Específicos</button>
                        </div>
                        <div class="col-12 pb-2 col-md-1 pb-md-0 text-nowrap ms-md-0 text-center">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="moveScrollById('#actividadesHead')"><i class="bi bi-chevron-double-down"></i>Actividades</button>
                        </div>
                        <div class="col-12 pb-2 col-md-1 pb-md-0 text-nowrap ps-md-5 text-center">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="moveScrollById('#rrhhProyHead')"><i class="bi bi-chevron-double-down"></i>Descrip. RRHH</button>
                        </div>
                    </div>
                </div>

                <div class="card-body py-4 py-md-5">
                    <div class="row ms-0 mb-3 ms-md-4 mb-md-4">
                        <div class="col-12 col-md-11" id="idnombreProyecto">
                            <label>Nombre del Proyecto</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" id="nombreProyecto" wire:model.debounce.250ms="nombreProyecto" wire:loading.attr="disabled" wire:target="secondStep" maxlength="150" class="form-control" placeholder="Ingrese Nombre del Proyecto">
                            </div>
                            @error('nombreProyecto')
                            <div class="col-12" id="idnombreProyectoError">
                                <span class="colorerror">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row ms-0 ms-md-4">
                        <div class="col-12 mb-3 col-md-5 mb-md-4">
                            <div class="row">
                                <div class="col-12" id="ididFondoConcursable">
                                    <label>Fondo Concursable Subvención</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-currency-dollar"></i>
                                        </span>
                                        <select id="idFondoConcursable" wire:model.debounce.250ms="idFondoConcursable" wire:loading.attr="disabled" wire:target="secondStep" class="form-select">
                                            <option value="0">Seleccione Fondo Concursable</option>
                                            @foreach($fondoConcursable as $itemFondo)
                                            <option value="{{$itemFondo->idFondoConcursable}}">{{$itemFondo->descripcionFondoConcursable}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('idFondoConcursable')
                                <div class="col-12" id="ididFondoConcursableError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 mb-3 col-md-6 mb-md-4">
                            <div class="row">
                                <div class="col-12 col-md-12" id="idmontoProyecto">
                                    <label>Monto del Proyecto</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-currency-dollar"></i>
                                        </span>
                                        <input type="text" id="montoProyecto" wire:model.debounce.250ms="montoProyecto" wire:loading.attr="disabled" wire:target="secondStep" onkeydown="return onlyNumberKey(event, this);" maxlength="9" class="form-control" placeholder="Ingrese Monto" autocomplete="off">
                                    </div>
                                </div>
                                @error('montoProyecto')
                                <div class="col-12" id="idmontoProyectoError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row ms-0 ms-md-4">
                        <div class="col-12 col-md-5 ">
                            <div class="row mb-3 mb-md-4">
                                <div class="col-12" id="ididProvinciaProy">
                                    <label>Provincia</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-signpost-2"></i>
                                        </span>
                                        <select id="idProvinciaProy" wire:model="idProvinciaProy" wire:loading.attr="disabled" wire:target="secondStep" class="form-select">
                                            <option value="0">Seleccione Provincia</option>
                                            @foreach($provincias as $itemProvi)
                                            <option value="{{$itemProvi->idProvincia}}">{{$itemProvi->descripcionProvincia}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('idProvinciaProy')
                                <div class="col-12" id="ididProvinciaProyError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6 ">
                            <div class="row mb-3 mb-md-4">
                                <div class="col-12" id="ididComunaProy">
                                    <label>Comuna a Intervenir</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-signpost-2"></i>
                                        </span>
                                        <select id="idComunaProy" wire:model="idComunaProy" wire:loading.attr="disabled" wire:target="secondStep" class="form-select">
                                            <option value="0">Seleccione Comuna</option>
                                            @if (!empty($comunas))
                                            @foreach($comunas as $itemComuna)
                                            <option value="{{$itemComuna->idComuna}}">{{$itemComuna->descripcionComuna}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @error('idComunaProy')
                                <div class="col-12 offset-0" id="idComunaProyError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row ms-0 ms-md-4">
                        <div class="col-12 mb-3 mb-md-4 col-md-4">
                            <div class="row">
                                <div class="col-12" id="idduracionProyecto">
                                    <label>Duración del Proyecto(meses)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-hourglass-split"></i>
                                        </span>
                                        <input type="text" id="duracionProyecto" wire:model.debounce.250ms="duracionProyecto" wire:loading.attr="disabled" wire:target="secondStep" class="form-control" onkeydown="return onlyNumberKey(event, this);" maxlength="2" data-tippy-content="Cantidad de meses que durará el proyecto" placeholder="Cantidad de Meses" autocomplete="off">
                                    </div>
                                </div>
                                @error('duracionProyecto')
                                <div class="col-12" id="idduracionProyectoError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 mb-3 mb-md-4 col-md-6 offset-md-1">
                            <div class="row">
                                <div class="col-12" id="ididTipoProyecto">
                                    <label>Tipo de Proyecto (Según Instructivo Anual)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-bricks"></i>
                                        </span>
                                        <select id="idTipoProyecto" wire:model="idTipoProyecto" wire:loading.attr="disabled" wire:target="secondStep" class="form-select">
                                            <option value="0">Seleccione el Tipo de Proyecto</option>
                                            @if (!empty($tipoproyecto))
                                            @foreach($tipoproyecto as $itemTipoProy)
                                            <option value="{{$itemTipoProy->idTipoProyecto}}">
                                                {{$itemTipoProy->descripcionTipoProyecto}}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @error('idTipoProyecto')
                                <div class="col-12" id="ididTipoProyectoError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-1 mb-5" id="datosTecnicos">
                <div class="card-header">
                    <div class="row h4 pt-2">
                        <div class="col-12 text-center">
                            Datos Técnicos del Proyecto
                        </div>
                    </div>
                    <div class="row py-1">
                        <div class="col-12 text-center">
                            <button type="button" class="btn btn-outline-secondary btn-sm d-inline" onclick="moveScrollById('#datosAdmHead')"><i class="bi bi-chevron-double-up"></i>Datos Administrativos</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm d-inline mt-2 mt-md-0" onclick="moveScrollById('#objEspecificosHead')"><i class="bi bi-chevron-double-down"></i>Objetivos Específicos</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm d-inline mt-2 mt-md-0" onclick="moveScrollById('#actividadesHead')"><i class="bi bi-chevron-double-down"></i>Actividades</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm d-inline mt-2 mt-md-0" onclick="moveScrollById('#rrhhProyHead')"><i class="bi bi-chevron-double-down"></i>Descrip. RRHH</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row ms-0 mb-2 ms-md-4 mb-md-3 mt-md-4">
                        <div class="col-12 text-center col-md-11 text-md-start h5">
                            Beneficiarios (Directos, Características de Los Beneficiarios o Población Objetivo)
                        </div>
                    </div>
                    <div class="row ms-0 mb-2 ms-md-4 mb-md-3">
                        <div class="col-12 mt-3 col-md-4 mt-md-0">
                            <div class="row" id="idcantTotalBenef">
                                <div class="col-12" id="idcantBenefHombreProy">
                                    <label>Cobertura Hombres Directos</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-people"></i>
                                        </span>
                                        <input type="text" id="cantBenefHombreProy" wire:model.debounce.250ms="cantBenefHombreProy" onkeydown="return onlyNumberKey(event, this);" maxlength="7" wire:loading.attr="disabled" wire:target="secondStep, back" class="form-control" placeholder="Cantidad">
                                    </div>
                                </div>
                                @error('cantBenefHombreProy')
                                <div class="col-12 offset-0" id="idcantBenefHombreProyError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror

                                @error('cantTotalBenef')
                                <div class="col-12 offset-0" id="idcantTotalBenefError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 mt-3 col-md-4 mt-md-0">
                            <div class="row">
                                <div class="col-12" id="idcantBenefMujerProy">
                                    <label>Cobertura Mujeres Directas</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-people"></i>
                                        </span>
                                        <input type="text" id="cantBenefMujerProy" wire:model.debounce.250ms="cantBenefMujerProy" onkeydown="return onlyNumberKey(event, this);" maxlength="7" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" placeholder="Cantidad">
                                    </div>
                                </div>
                                @error('cantBenefMujerProy')
                                <div class="col-12 offset-0" id="idcantBenefMujerProyError">
                                    <span class="colorerror">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row ms-0 ms-md-4 mt-md-5">
                        <div class="col-12 col-md-10 h5" id="idresumenProyecto">
                            Breve Resumen del Proyecto o Descripción del Proyecto
                        </div>
                    </div>
                    <div class="row ms-0 mb-2 ms-md-4 mb-md-3">
                        <div class="col-12 pe-md-5">
                            <textarea wire:model="resumenProyecto" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" placeholder="Ingrese un breve resumen del proyecto (máximo 1500 caracteres)" maxlength="1500" rows="7"></textarea>
                        </div>
                        @error('resumenProyecto')
                        <div class="col-12 pe-md-5" id="idresumenProyectoError">
                            <span class="colorerror">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                    <div class="row ms-0 mb-2 ms-md-4 mb-md-1 mt-md-4">
                        <div class="col-12 col-md-10 h5" id="idobjetivoProyecto">
                            Objetivo General del Proyecto
                        </div>
                    </div>
                    <div class="row ms-0 mb-2 ms-md-4 mb-md-3">
                        <div class="col-12 pe-md-5">
                            <textarea wire:model="objetivoProyecto" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" maxlength="300" placeholder="Ingrese el objetivo general del proyecto (máximo 300 caracteres)" rows="6"></textarea>
                        </div>
                        @error('objetivoProyecto')
                        <div class="col-12 pe-md-5" id="idobjetivoProyectoError">
                            <span class="colorerror">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                    <!-- Agregado el 15-02-2023 por MVillalobos -->
                    <div class="row ms-0 mb-2 ms-md-4 mb-md-1 mt-md-4">
                        <div class="col-12 col-md-10 h5" id="iddescripNecesidadACubrir">
                            Descripción de la Necesidad a Cubrir o Problemática en el Territorio
                        </div>
                    </div>
                    <div class="row ms-0 mb-2 ms-md-4 mb-md-3">
                        <div class="col-12 pe-md-5">
                            <textarea wire:model="descripNecesidadACubrir" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" maxlength="1000" placeholder="Describa las necesidades del territorio beneficiario del proyecto, o la problemática del territorio a intervenir, que hace que el proyecto sea necesario (máximo 1000 caracteres)" rows="6"></textarea>
                        </div>
                        @error('descripNecesidadACubrir')
                        <div class="col-12 pe-md-5" id="iddescripNecesidadACubrirError">
                            <span class="colorerror">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                    <div class="row ms-0 mb-2 ms-md-4 mb-md-1 mt-md-4">
                        <div class="col-12 col-md-10 h5" id="iddescripTerritorioBenef">
                            Descripción del Territorio y Beneficiarios
                        </div>
                    </div>
                    <div class="row ms-0 mb-2 ms-md-4 mb-md-3">
                        <div class="col-12 pe-md-5">
                            <textarea wire:model="descripTerritorioBenef" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" maxlength="1000" placeholder="Describa el territorio a intervenir en relación a sus características geográficas, sociales, de infraestructura, económicos, servicios básicos, entre otros, así como también, en cuanto a la caracterización de los beneficiarios del proyecto, tanto directos como indirectos, en relación a su género, edades, tipos de familias, recursos económicos, apoyos sociales, estudios, etc. (máximo 1000 caracteres)" rows="6"></textarea>
                        </div>
                        @error('descripTerritorioBenef')
                        <div class="col-12 pe-md-5" id="iddescripTerritorioBenefError">
                            <span class="colorerror">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>


                    <div class="row ms-0 mb-2 ms-md-4 mb-md-1 mt-md-4">
                        <div class="col-12 col-md-10 h5" id="iddescripDifusionProy">
                            Difusión del Proyecto
                        </div>
                    </div>
                    <div class="row ms-0 mb-2 ms-md-4 mb-md-3">
                        <div class="col-12 pe-md-5">
                            <textarea wire:model="descripDifusionProy" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" maxlength="1000" placeholder="Debe informar el tipo de difusión o medios de difusión que tendrá su proyecto y que servicios contratará para ello. (máximo 1000 caracteres)" rows="6"></textarea>
                        </div>
                        @error('descripDifusionProy')
                        <div class="col-12 pe-md-5" id="iddescripDifusionProyError">
                            <span class="colorerror">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <div class="row ms-0 mb-2 ms-md-4 mb-md-1 mt-md-4">
                        <div class="col-12 col-md-10 h5" id="iddescripResultadoProy">
                            Resultados y/o Productos Esperados
                        </div>
                    </div>
                    <div class="row ms-0 mb-2 ms-md-4 mb-md-3">
                        <div class="col-12 pe-md-5">
                            <textarea wire:model="descripResultadoProy" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" maxlength="2000" placeholder="Describa cuales serán los resultados que se esperan del proyecto y/o los productos esperados del mismo. (máximo 2000 caracteres)" rows="6"></textarea>
                        </div>
                        @error('descripResultadoProy')
                        <div class="col-12 pe-md-5" id="iddescripResultadoProyError">
                            <span class="colorerror">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <div class="row ms-0 mb-2 ms-md-4 mb-md-1 mt-md-4">
                        <div class="col-12 col-md-10 h5" id="iddescripMedioVerifPostEjecuProy">
                            Medios de Verificación de Actividades y/o Productos a Obtener Post Ejecución del Proyecto
                        </div>
                    </div>
                    <div class="row ms-0 mb-2 ms-md-4 mb-md-3">
                        <div class="col-12 pe-md-5">
                            <textarea wire:model="descripMedioVerifPostEjecuProy" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" maxlength="2000" placeholder="Describa los medios de verificación que serán presentados si su proyecto es financiado y ejecutado, para demostrar si se cumplieron los objetivos y actividades del mismo.  Estos deberán coincidir con los presentados posteriormente. (máximo 2000 caracteres)" rows="6"></textarea>
                        </div>
                        @error('descripMedioVerifPostEjecuProy')
                        <div class="col-12 pe-md-5" id="iddescripMedioVerifPostEjecuProyError">
                            <span class="colorerror">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                    <!-- Fin Agregado el 15-02-2023 por MVillalobos -->

                </div>
            </div>

            <div class="card mt-2 mb-5" id="objEspecificosHead">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-light">
                        <div class="row pt-3">
                            <div class="col-12 text-center col-md-8 text-md-end h4">
                                Objetivos Específicos del Proyecto
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="row">
                                    <div class="col-12 col-md-10 text-center" wire:click="addObjEspecifico" style="cursor:pointer">
                                        <span class="btn btn-circleTramo btn-success">+</span>
                                        <span class="text-primary" style="font-size:14px;font-weight: 600;">
                                            Agregar Objetivo Específico
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 ps-4 text-center col-md-11 ps-md-2">
                                        <span style="font-size:12px;">
                                            (Puede agregar máximo 5 items)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row py-1">
                            <div class="col-11 ms-3 text-center ps-md-0">
                                <button type="button" class="btn btn-outline-secondary btn-sm d-inline mt-2 mt-md-0" onclick="moveScrollById('#datosAdmHead')"><i class="bi bi-chevron-double-up"></i>Datos Administrativos</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm d-inline mt-2 mt-md-0" onclick="moveScrollById('#datosTecnicos')"><i class="bi bi-chevron-double-up"></i>Datos Técnicos</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm d-inline mt-2 mt-md-0" onclick="moveScrollById('#actividadesHead')"><i class="bi bi-chevron-double-down"></i>Actividades</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm d-inline mt-2 mt-md-0" onclick="moveScrollById('#rrhhProyHead')"><i class="bi bi-chevron-double-down"></i>Descrip. RRHH</button>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ms-1 me-1 ms-md-4 me-md-1">
                        @foreach($inputsObjEspecifico as $index => $itemObjEspecifico)
                        <div class="row my-3">
                            <div class="col-11 pe-1 pe-md-2" id="iddescripcionObjEspecifico{{$index}}">
                                <textarea wire:model="inputsObjEspecifico.{{$index}}.descripcionObjEspecifico" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" maxlength="300" rows="3" placeholder="Ingrese Objetivo Específico (máximo 300 caracteres)"></textarea>
                            </div>
                            <div class="col-1 ps-0 ps-md-1 text-danger">
                                @if (count($inputsObjEspecifico) > 1)
                                <div id="eliminarObjEsp{{$index}}" class="m-0 p-0" wire:click="deleteItemObjEspecifico({{$index}}, {{$itemObjEspecifico['idObjEspecifico']}})" class="text-danger text-center" style="cursor:pointer" data-tippy-content="Click para eliminar el item.">
                                    <i class="bi bi-trash fs-4"></i>
                                </div>
                                @endif
                            </div>
                            @error('inputsObjEspecifico.'.$index.'.descripcionObjEspecifico')
                            <div class="col-12" id="iddescripcionObjEspecifico{{$index}}Error">
                                <span class="colorerror">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                        @endforeach
                    </li>
                </ul>
            </div>

            <div class="card mt-1" id="actividadesHead">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-light">
                        <div class="row pt-3">
                            <div class="col-12 text-center col-md-8 text-md-end h4">
                                Actividades y Cronograma del Proyecto
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="row">
                                    <div class="col-12 col-md-10 text-center" wire:click="addActividad" style="cursor:pointer">
                                        <span class="btn btn-circleTramo btn-success">+</span>
                                        <span class="text-primary" style="font-size:14px;font-weight: 600;">
                                            Agregar Actividad
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 ps-5 col-md-11 ps-md-5">
                                        <span style="font-size:12px;">
                                            (Puede agregar máximo 5 items)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-1">
                            <div class="col-10 offset-1 text-center">
                                <button type="button" class="btn btn-outline-secondary btn-sm d-inline mt-2 mt-md-0" onclick="moveScrollById('#datosAdmHead')"><i class="bi bi-chevron-double-up"></i>Datos Administrativos</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm d-inline mt-2 mt-md-0" onclick="moveScrollById('#datosTecnicos')"><i class="bi bi-chevron-double-up"></i>Datos Técnicos</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm d-inline mt-2 mt-md-0" onclick="moveScrollById('#objEspecificosHead')"><i class="bi bi-chevron-double-up"></i>Objetivos Específicos</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm d-inline mt-2 mt-md-0" onclick="moveScrollById('#rrhhProyHead')"><i class="bi bi-chevron-double-down"></i>Descrip. RRHH</button>
                            </div>
                        </div>
                    </li>
                    @foreach($inputsActividad as $index => $itemActividad)
                    <li class="list-group-item ms-1 me-1 ms-md-4 me-md-1" id="actividadId{{$loop->index+1}}">
                        <div class="row my-3">
                            <div class="col-11 pe-1 pe-md-2" id="idtituloActividad{{$index}}">
                                <label>Título Actividad</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="titActividadIcon{{$loop->index}}">
                                        <i class="bi bi-list-task"></i>
                                    </span>
                                    <input type="text" id="titActividad{{$loop->index}}" wire:model.debounce.250ms="inputsActividad.{{$index}}.tituloActividad" maxlength="150" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" placeholder="Título de la Actividad (máximo 150 caracteres)">
                                </div>
                            </div>
                            @if (count($inputsActividad) > 1)
                            <div class="col-1 ps-1 text-danger m-0 p-0" wire:click="deleteActividad({{$index}}, {{$itemActividad['idActividad']}})" style="cursor:pointer" id="eliminarActividad{{$index}}" data-tippy-content="Click para eliminar el item">
                                <i class="bi bi-trash fs-4"></i>
                            </div>
                            @endif
                            @error('inputsActividad.'.$index.'.tituloActividad')
                            <div class="col-11" id="idtituloActividad{{$index}}Error">
                                <span class="colorerror">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                        <div class="row my-3">
                            <div class="col-11 pe-1 pe-md-2" id="iddescripcionActividad{{$index}}">
                                <label>Descripción de la Actividad</label>
                                <textarea wire:model="inputsActividad.{{$index}}.descripcionActividad" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" maxlength="2500" rows="6" placeholder="Ingrese descripción de la actividad (máximo 2500 caracteres)"></textarea>
                            </div>
                            @error('inputsActividad.'.$index.'.descripcionActividad')
                            <div class="col-11 col-md-11" id="iddescripcionActividad{{$index}}Error">
                                <span class="colorerror">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <!-- Agregado por MVillalobos el 20-02-2023 -->
                        <div class="row my-3" id="idmesesEjecuActividad{{$index}}">
                            <div class="col-11 pe-1 pe-md-2">
                                <div class="card">
                                    <div class="card-header" style="text-align:justify;">
                                        Seleccione los meses en los cuales se llevará a cabo esta actividad
                                    </div>
                                    <div class="card-body pt-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="checkbox" wire:model.debounce.250ms="inputsActividad.{{$index}}.mesesEjecuActividad" class="btn-check" id="mes{{$index}}1" value="1">
                                                <label class="btn btn-sm btn-outline-primary" for="mes{{$index}}1">Mes 1</label>

                                                <input type="checkbox" wire:model.debounce.250ms="inputsActividad.{{$index}}.mesesEjecuActividad" class="btn-check" id="mes{{$index}}2" value="2">
                                                <label class="btn btn-sm btn-outline-primary" for="mes{{$index}}2">Mes 2</label>

                                                <input type="checkbox" wire:model.debounce.250ms="inputsActividad.{{$index}}.mesesEjecuActividad" class="btn-check" id="mes{{$index}}3" value="3">
                                                <label class="btn btn-sm btn-outline-primary" for="mes{{$index}}3">Mes 3</label>

                                                <input type="checkbox" wire:model.debounce.250ms="inputsActividad.{{$index}}.mesesEjecuActividad" class="btn-check" id="mes{{$index}}4" value="4">
                                                <label class="btn btn-sm btn-outline-primary" for="mes{{$index}}4">Mes 4</label>

                                                <input type="checkbox" wire:model.debounce.250ms="inputsActividad.{{$index}}.mesesEjecuActividad" class="btn-check" id="mes{{$index}}5" value="5">
                                                <label class="btn btn-sm btn-outline-primary" for="mes{{$index}}5">Mes 5</label>

                                                <input type="checkbox" wire:model.debounce.250ms="inputsActividad.{{$index}}.mesesEjecuActividad" class="btn-check" id="mes{{$index}}6" value="6">
                                                <label class="btn btn-sm btn-outline-primary" for="mes{{$index}}6">Mes 6</label>

                                                <input type="checkbox" wire:model.debounce.250ms="inputsActividad.{{$index}}.mesesEjecuActividad" class="btn-check" id="mes{{$index}}7" value="7">
                                                <label class="btn btn-sm btn-outline-primary" for="mes{{$index}}7">Mes 7</label>
                                            </div>
                                            @error('inputsActividad.'.$index.'.mesesEjecuActividad')
                                            <div class="col-12 pt-1" id="idmesesEjecuActividad{{$index}}Error">
                                                <span class="colorerror">{{ $message }}</span>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="col-11 pe-1 pe-md-2" id="iddescripBienesServRRHHActividad{{$index}}">
                                <label>Descripción de los Bienes, Servicios Y/O RRHH necesarios para ejecutar la actividad</label>
                                <textarea wire:model="inputsActividad.{{$index}}.descripBienesServRRHHActividad" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" maxlength="200" rows="3" placeholder="Ingrese Bienes, Servicios Y/O RRHH necesarios para ejecutar la actividad. Sólo señalar el tipo, el cuál debe coincidir con: lo descrito en la actividad, el presupuesto y otros de la postulación. (máximo 200 caracteres)"></textarea>
                            </div>
                            @error('inputsActividad.'.$index.'.descripBienesServRRHHActividad')
                            <div class="col-11 col-md-11" id="iddescripBienesServRRHHActividad{{$index}}Error">
                                <span class="colorerror">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                        <!-- Fin Agregado por MVillalobos el 20-02-2023 -->
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="card mt-5" id="rrhhProyHead">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-light">
                        <div class="row pt-3">
                            <div class="col-12 text-center col-md-8 text-md-end h4">
                                <div class="pe-md-0">Descripción del Recurso Humano del Proyecto</div>
                                <div class="text-center text-md-end pe-md-5 text-primary" style="font-size:14px;">(Los campos de esta sección no son obligatorios)</div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="row">
                                    <div class="col-12 col-md-10 text-center" wire:click="addDescripRRHH" style="cursor:pointer">
                                        <span class="btn btn-circleTramo btn-success">+</span>
                                        <span class="text-primary" style="font-size:14px;font-weight: 600;">
                                            Agregar Item
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 ps-5 col-md-11 ps-md-5">
                                        <span style="font-size:12px;">
                                            (Puede agregar máximo 10 items)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-1">
                            <div class="col-10 offset-1 text-center">
                                <button type="button" class="btn btn-outline-secondary btn-sm d-inline  mt-2 mt-md-0" onclick="moveScrollById('#datosAdmHead')"><i class="bi bi-chevron-double-up"></i>Datos Administrativos</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm d-inline  mt-2 mt-md-0" onclick="moveScrollById('#datosTecnicos')"><i class="bi bi-chevron-double-up"></i>Datos Técnicos</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm d-inline mt-2 mt-md-0" onclick="moveScrollById('#objEspecificosHead')"><i class="bi bi-chevron-double-up"></i>Objetivos Específicos</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm d-inline  mt-2 mt-md-0" onclick="moveScrollById('#actividadesHead')"><i class="bi bi-chevron-double-up"></i>Actividades</button>
                            </div>
                        </div>
                    </li>

                    @if (!empty($inputsDescripRRHH) && count($inputsDescripRRHH) > 0)
                    @foreach($inputsDescripRRHH as $index => $itemDescripRRHH)
                    <li class="list-group-item ms-1 me-1 ms-md-4 me-md-1" id="descripRRHHId{{$loop->index+1}}">
                        <div class="row my-3">
                            <div class="col-11 pe-1 pe-md-2" id="iddescripCargo{{$index}}">
                                <label>Cargo a Contratar</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="descripCargoProyIcon{{$loop->index}}">
                                        <i class="bi bi-list-task"></i>
                                    </span>
                                    <input type="text" id="descripCargoProy{{$loop->index}}" wire:model.debounce.250ms="inputsDescripRRHH.{{$index}}.descripCargo" maxlength="50" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" placeholder="Ingrese Descripción del Cargo a Contratar Via Proyecto">
                                </div>
                            </div>
                            @error('inputsDescripRRHH.'.$index.'.descripCargo')
                            <div class="col-11" id="iddescripCargo{{$index}}Error">
                                <span class="colorerror">{{ $message }}</span>
                            </div>
                            @enderror

                            <div class="col-11 pe-1 pe-md-2 mt-3" id="iddescripPerfilCargo{{$index}}">
                                <!-- <label class="h5">Cargo a Contratar Via Proyecto</label> -->
                                <label>Perfil del Cargo</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="descripPerfilCargoIcon{{$loop->index}}">
                                        <i class="bi bi-list-task"></i>
                                    </span>
                                    <input type="text" id="descripPerfilCargo{{$loop->index}}" wire:model.debounce.250ms="inputsDescripRRHH.{{$index}}.descripPerfilCargo" maxlength="50" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" placeholder="Describa el perfil del cargo">
                                </div>
                            </div>
                            @error('inputsDescripRRHH.'.$index.'.descripPerfilCargo')
                            <div class="col-11" id="iddescripPerfilCargo{{$index}}Error">
                                <span class="colorerror">{{ $message }}</span>
                            </div>
                            @enderror

                            <div class="col-11 pe-1 pe-md-2 mt-3" id="iddescripPeriocidadServicio{{$index}}">
                                <label>Periodicidad del Servicio <!-- (Ej: todos los lunes, martes y miercoles, de lunes a viernes) --></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-list-task"></i>
                                    </span>
                                    <input type="text" id="descripPeriocidadServicio{{$loop->index}}" wire:model.debounce.250ms="inputsDescripRRHH.{{$index}}.descripPeriocidadServicio" maxlength="50" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" placeholder="Describa la periocidad del servicio">
                                </div>
                            </div>
                            @error('inputsDescripRRHH.'.$index.'.descripPeriocidadServicio')
                            <div class="col-11" id="iddescripPeriocidadServicio{{$index}}Error">
                                <span class="colorerror">{{ $message }}</span>
                            </div>
                            @enderror

                            <div class="col-11 col-md-5 mt-3 pe-1 pe-md-0">
                                <div class="row">
                                    <div class="col-12" id="idtotalHorasServicio{{$index}}">
                                        <label>Cantidad de Horas</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="totalHorasServicioIcon{{$loop->index}}">
                                                <i class="bi bi-alarm"></i>
                                            </span>
                                            <input type="text" id="totalHorasServicio{{$loop->index}}" wire:model.debounce.250ms="inputsDescripRRHH.{{$index}}.totalHorasServicio" onkeydown="return onlyNumberKey(event, this);" maxlength="5" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" placeholder="Cant. Horas Servicio">
                                        </div>
                                    </div>
                                    @error('inputsDescripRRHH.'.$index.'.totalHorasServicio')
                                    <div class="col-12" id="idtotalHorasServicio{{$index}}Error">
                                        <span class="colorerror">{{ $message }}</span>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-11 col-md-6 mt-3 pe-1 pe-md-2">
                                <div class="row">
                                    <div class="col-12" id="idmontoTotalServicio{{$index}}">
                                        <label>Monto Total a Pagar</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="montoTotalServicioIcon{{$loop->index}}">
                                                <i class="bi bi-currency-dollar"></i>
                                            </span>
                                            <input type="text" id="montoTotalServicio{{$loop->index}}" wire:model.debounce.250ms="inputsDescripRRHH.{{$index}}.montoTotalServicio" onkeydown="return onlyNumberKey(event, this);" maxlength="7" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" placeholder="Total a pagar">
                                        </div>
                                    </div>
                                    @error('inputsDescripRRHH.'.$index.'.montoTotalServicio')
                                    <div class="col-12" id="idmontoTotalServicio{{$index}}Error">
                                        <span class="colorerror">{{ $message }}</span>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-11 pe-1 pe-md-2 mt-3" id="iddescripFuncActividades{{$index}}">
                                <label>Funciones o Actividades a Realizar</label>
                                <textarea wire:model="inputsDescripRRHH.{{$index}}.descripFuncActividades" wire:loading.attr="disabled" wire:target="secondStep,back" class="form-control" maxlength="100" rows="3" placeholder="Describa las actividades a realizar por el profesional en el proyecto"></textarea>
                            </div>
                            @error('inputsDescripRRHH.'.$index.'.descripFuncActividades')
                            <div class="col-11 col-md-11" id="iddescripFuncActividades{{$index}}Error">
                                <span class="colorerror">{{ $message }}</span>
                            </div>
                            @enderror

                            <!-- si (count(inputsDescripRRHH) > 1) -->
                            <div class="col-1 ps-1 text-danger m-0 p-0 mt-5" wire:click="deleteItemDescripRRHH({{$index}}, {{$itemDescripRRHH['idRRHHProyecto']}})" style="cursor:pointer" id="eliminarDescripRRHH{{$index}}" data-tippy-content="Click para eliminar el item">
                                <i class="bi bi-trash fs-4"></i>
                            </div>
                        </div>

                    </li>
                    @endforeach
                   @endif
                </ul>
            </div>
            <!-- <div class="row ps-3 ms-4 mt-4 mb-4 ms-md-4 mt-md-5 mb-md-5 ps-md-0"> -->
            <div class="row ps-4 mt-4 mb-4 mt-md-5 mb-md-5 ps-md-0">
                <div class="col-9 offset-2 mb-2 col-md-2 mb-md-0 offset-md-3">
                    <button class="btn btn-danger btn-lg" style="width:160px;" type="button" wire:click="back(1)" wire:loading.attr="disabled" wire:target="back,secondStep">
                        <span wire:loading.class="spinner-border spinner-border-sm" wire:target="back" role="status" aria-hidden="true"></span>
                        <span wire:loading.remove wire:target="back"><i class="bi bi-arrow-left"></i></span>
                        Atr&aacute;s
                    </button>
                </div>
                <div class="col-9 offset-2 col-md-2 ps-md-3 offset-md-0">
                    <button class="btn btn-primary btn-lg" style="width:160px;" type="button" wire:click="secondStep" wire:loading.attr="disabled" wire:target="secondStep,back,idFondoConcursable">
                        Siguiente
                        <span wire:loading.remove wire:target="secondStep"><i class="bi bi-arrow-right"></i></span>
                        <span wire:loading.class="spinner-border spinner-border-sm" wire:target="secondStep" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row {{ $currentStep != 3 ? 'displayNone' : '' }}" id="msjErrorStep3">
    <div class="col-12" id="ppto{{$randId}}">
        <div class="container pt-3">
            @php($countErrors = 0)
            @if(($errors->has('inputsRecursosHumanos.*') )
            || ($errors->has('inputsGastosGenerales.*'))
            || ($errors->has('inputsEquipamiento.*')))
            <div class="row mt-3 mb-0">
                <div class="col-12">
                    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                        <span class="ps-3">
                            Los Datos Presupuestarios de:
                            <span class="fw-bold">
                                @if ($errors->has('inputsRecursosHumanos.*'))
                                Recursos Humanos,
                                @php($countErrors += 1)
                                @endif
                                @if ($errors->has('inputsGastosGenerales.*'))
                                Gastos Generales,
                                @php($countErrors += 1)
                                @endif
                                @if ($errors->has('inputsEquipamiento.*'))
                                Equipamiento,
                                @php($countErrors += 1)
                                @endif
                            </span>

                            @if($countErrors > 1) presentan @else presenta @endif errores, por favor corregir.
                        </span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab">
                            <button wire:click="$set('tabActive', 1)" class="nav-link @if($tabActive == 1) active h6 text-success @endif @if ($errors->has('inputsRecursosHumanos.*')) text-danger @endif" id="nav-home-tab" type="button">
                                Recursos Humanos
                            </button>
                            <button wire:click="$set('tabActive', 2)" class="nav-link @if($tabActive == 2) active h6 text-success @endif @if ($errors->has('inputsGastosGenerales.*')) text-danger @endif" id="nav-profile-tab" type="button">
                                Gastos Generales
                            </button>
                            <button wire:click="$set('tabActive', 3)" class="nav-link @if($tabActive == 3) active h6 text-success @endif @if ($errors->has('inputsEquipamiento.*')) text-danger @endif" id="nav-contact-tab" type="button">
                                Equipamiento
                            </button>
                        </div>
                    </nav>
                    <div class="row pt-3 ps-2 fw-bold">
                        <div class="col-12">Total Recursos Humanos: ${{number_format($totalRRHH, 0, ',', '.')}}</div>
                        <div class="col-12">Total Gastos Generales: ${{number_format($totalGG, 0, ',', '.')}}</div>
                        <div class="col-12">Total Gastos Equipamiento: ${{number_format($totalEquip, 0, ',', '.')}}</div>
                        <div class="col-12">Monto Total a Financiar: ${{number_format(is_numeric($montoProyecto)?$montoProyecto:0, 0, ',', '.')}}</div>
                    </div>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade @if($tabActive == 1) show active @endif" id="nav-home">
                            <div class="card my-4 mx-2">
                                <div class="card-header" id="headRRHH">
                                    <div class="row mt-4 mb-3">
                                        <div class="col-12 text-center col-md-7 offset-md-1 text-md-end h5">
                                            Recursos Humanos para Ejecutar el Proyecto
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-12 ps-0 col-md-8 m-0 text-center ps-md-5" wire:click="addRecursoHumano" style="cursor:pointer">
                                                    <span class="btn btn-circleTramo btn-success">+</span>
                                                    <span class="text-primary" style="font-size:14px;font-weight: 600;">
                                                        Agregar Item
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-10 text-center">
                                                    <span style="font-size:12px;">
                                                        (Puede agregar máximo 15 items)
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body m-0 p-0">
                                    <!-- Inicio TABLA -->
                                    <div class="table-responsive">
                                        <table class="table table-borderless card-1 p-3 mb-1">
                                            <thead>
                                                <tr class="border-bottom bg-light">
                                                    <th class="col-md-3 ps-3 pe-2">
                                                        Perfil
                                                    </th>
                                                    <th class="col-md-3">
                                                        Actividad Asociada
                                                    </th>
                                                    <th class="col-md-2">
                                                        Horas RRHH
                                                    </th>
                                                    <th class="col-md-2">
                                                        Valor Hora
                                                    </th>
                                                    <th class="col-md-2">
                                                        Monto Total
                                                    </th>
                                                    <th class="col-md-1 pe-3">
                                                        Acción
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($inputsRecursosHumanos))
                                                @foreach($inputsRecursosHumanos as $index => $itemRRHH)
                                                @php($indexPaso = $index)
                                                <tr class="border border-bottom-0 border-start-0 border-end-0 text-secondary" id="ItemRRHHId{{$loop->index}}">
                                                    <td class="px-1 py-2 ps-3">
                                                        <input type="text" id="RRHH{{$indexPaso}}perfil" wire:model.debounce.250ms="inputsRecursosHumanos.{{$indexPaso}}.perfil" maxlength="150" wire:loading.attr="disabled" wire:target="thirdStepSubmit,back" class="form-control" placeholder="Descripción del RR.HH" data-tippy-content="Ingrese la profesión u oficio del recurso humano.">
                                                        @error('inputsRecursosHumanos.'.$indexPaso.'.perfil')
                                                        <span class="colorerror">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="px-1 py-2">
                                                        <select wire:model="inputsRecursosHumanos.{{$indexPaso}}.idActividad" id="inputsRecursosHumanos_{{$index}}_idActividad" wire:loading.attr="disabled" wire:target="thirdStepSubmit,back" class="form-select" data-tippy-content="Seleccione la actividad a la cual estará asociado el recurso humano.">
                                                            <option value="0">Seleccione Actividad</option>
                                                            @foreach($inputsActividad as $index => $inputAct)
                                                            <option value="{{$inputAct['idActividad']}}">{{$inputAct['tituloActividad']}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('inputsRecursosHumanos.'.$indexPaso.'.idActividad')
                                                        <span class="colorerror">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="px-1 py-2">
                                                        <input type="text" id="canthora{{$indexPaso}}" wire:model.debounce.250ms="inputsRecursosHumanos.{{$indexPaso}}.canthora" onkeydown="return onlyNumberKey(event, this);" maxlength="5" wire:loading.attr="disabled" wire:target="thirdStepSubmit,back" class="form-control" placeholder="Cantidad" data-tippy-content="Ingrese la cantidad de horas requeridas por el recurso humano.">
                                                        @error('inputsRecursosHumanos.'.$indexPaso.'.canthora')
                                                        <span class="colorerror">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="px-1 py-2">
                                                        <input type="text" id="RRHH{{$indexPaso}}valorhora" wire:model.debounce.250ms="inputsRecursosHumanos.{{$indexPaso}}.valorhora" onkeydown="return onlyNumberKey(event, this);" maxlength="7" wire:loading.attr="disabled" wire:target="thirdStepSubmit,back" class="form-control" placeholder="Valor" data-tippy-content="Ingrese el valor hora del recurso humano.">
                                                        @error('inputsRecursosHumanos.'.$indexPaso.'.valorhora')
                                                        <span class="colorerror">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="px-1 py-2">
                                                        <input type="text" id="RRHH{{$indexPaso}}montototal" wire:model.debounce.250ms="inputsRecursosHumanos.{{$indexPaso}}.montototal" onkeydown="return onlyNumberKey(event, this);" maxlength="8" wire:loading.attr="disabled" wire:target="thirdStepSubmit,back" class="form-control" placeholder="Monto" data-tippy-content="Ingrese costo total del recurso humano.">
                                                        @error('inputsRecursosHumanos.'.$indexPaso.'.montototal')
                                                        <span class="colorerror">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="px-1 py-2 text-danger">
                                                        <div id="eliminarItemRRHH{{$indexPaso}}" wire:click="deleteRecursoHumano({{$indexPaso}}, {{$itemRRHH['idPptoRRHH']}})" class="text-danger text-center" style="cursor:pointer" data-tippy-content="Click para eliminar el item">
                                                            <i class="bi bi-trash fs-4"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <div id="bottomRRHH"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade @if($tabActive == 2) show active @endif" id="nav-profile">
                            <div class="card my-4 mx-2">
                                <div class="card-header" id="headGG">
                                    <div class="row mt-4 mb-3">
                                        <div class="col-12 text-center col-md-5 offset-md-2 text-md-end h5">
                                            Gastos Generales del Proyecto
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-12 ps-0 col-md-8 m-0 text-center ps-md-5" wire:click="addGastosGenerales" style="cursor:pointer">
                                                    <span class="btn btn-circleTramo btn-success">+</span>
                                                    <span class="text-primary" style="font-size:14px;font-weight: 600;">
                                                        Agregar Item
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-10 text-center">
                                                    <span style="font-size:12px;">
                                                        (Puede agregar máximo 15 items)
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>



                                <div class="card-body m-0 p-0">
                                    <!-- Inicio TABLA -->
                                    <div class="table-responsive">
                                        <table class="table table-borderless card-1 p-3 mb-1">
                                            <thead>
                                                <tr class="border-bottom bg-light">
                                                    <th class="col-3 ps-3 pe-2">
                                                        Detalle Bienes o Servicios
                                                    </th>
                                                    <th class="col-3">
                                                        Actividad Asociada
                                                    </th>
                                                    <th class="col-3">
                                                        Descripción
                                                    </th>
                                                    <th class="col-2">
                                                        Monto Total
                                                    </th>
                                                    <th class="col-1 pe-3">
                                                        Acción
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($inputsGastosGenerales))
                                                @foreach($inputsGastosGenerales as $index => $itemGG)
                                                @php($indexPaso = $index)
                                                <tr class="border border-bottom-0 border-start-0 border-end-0 text-secondary" id="ItemGGId{{$loop->index}}">
                                                    <td class="px-1 py-2 ps-3">
                                                        <input type="text" id="inputsGastosGenerales_{{$indexPaso}}_detabienesservicio" wire:model.debounce.250ms="inputsGastosGenerales.{{$indexPaso}}.detabienesservicio" maxlength="150" wire:loading.attr="disabled" wire:target="thirdStepSubmit,back" class="form-control" placeholder="Nombre del Bien o Servicio" data-tippy-content="Ingrese nombre del bien o servicio.">
                                                        @error('inputsGastosGenerales.'.$indexPaso.'.detabienesservicio')
                                                        <span class="colorerror">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="px-1 py-2">
                                                        <select wire:model="inputsGastosGenerales.{{$indexPaso}}.idActividad" id="inputsGastosGenerales_{{$index}}_idActividad" wire:loading.attr="disabled" wire:target="thirdStepSubmit,back" class="form-select" data-tippy-content="Seleccione la actividad a la cual estará asociado el bien o servicio.">
                                                            <option value="0">Seleccione Actividad</option>
                                                            @foreach($inputsActividad as $index => $inputAct)
                                                            <option value="{{$inputAct['idActividad']}}">{{$inputAct['tituloActividad']}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('inputsGastosGenerales.'.$indexPaso.'.idActividad')
                                                        <span class="colorerror">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="px-1 py-2">
                                                        <input type="text" id="inputsGastosGenerales_{{$indexPaso}}_descripcion" wire:model.debounce.250ms="inputsGastosGenerales.{{$indexPaso}}.descripcion" maxlength="250" wire:loading.attr="disabled" wire:target="thirdStepSubmit,back" class="form-control" placeholder="Descripción del Bien o Servicio" data-tippy-content="Ingrese descripción del bien o servicio.">
                                                        @error('inputsGastosGenerales.'.$indexPaso.'.descripcion')
                                                        <span class="colorerror">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="px-1 py-2">
                                                        <input type="text" id="inputsGastosGenerales_{{$indexPaso}}_montototal" wire:model.debounce.250ms="inputsGastosGenerales.{{$indexPaso}}.montototal" onkeydown="return onlyNumberKey(event, this);" maxlength="8" wire:loading.attr="disabled" wire:target="thirdStepSubmit,back" class="form-control" placeholder="Monto Total" data-tippy-content="Ingrese monto total del bien o servicio.">
                                                        @error('inputsGastosGenerales.'.$indexPaso.'.montototal')
                                                        <span class="colorerror">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="px-1 py-2 text-danger">
                                                        <div id="eliminarItemGG{{$indexPaso}}" wire:click="deleteGastosGenerales({{$indexPaso}}, {{$itemGG['idPptoGG']}})" class="text-danger text-center" style="cursor:pointer" data-tippy-content="Click para eliminar el item">
                                                            <i class="bi bi-trash fs-4"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <div id="bottomGG"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade @if($tabActive == 3) show active @endif" id="nav-contact">
                            <div class="card my-4 mx-2">
                                <div class="card-header" id="headEquip">
                                    <div class="row mt-4 mb-3">
                                        <div class="col-md-7 offset-md-1 text-end h5">
                                            Equipamiento Necesario para Ejecutar el Proyecto
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-8 m-0 text-center ps-5" wire:click="addEquipamiento" style="cursor:pointer">
                                                    <span class="btn btn-circleTramo btn-success">+</span>
                                                    <span class="text-primary" style="font-size:14px;font-weight: 600;">
                                                        Agregar Item
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-10 text-center">
                                                    <span style="font-size:12px;">
                                                        (Puede agregar máximo 15 items)
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body m-0 p-0">
                                    <!-- Inicio TABLA -->
                                    <div class="table-responsive">
                                        <table class="table table-borderless card-1 p-3 mb-1">
                                            <thead>
                                                <tr class="border-bottom bg-light">
                                                    <th class="col-3 ps-3 pe-2">
                                                        Detalle Equipamiento
                                                    </th>
                                                    <th class="col-3">
                                                        Actividad Asociada
                                                    </th>
                                                    <th class="col-2">
                                                        Cantidad
                                                    </th>
                                                    <th class="col-2">
                                                        Monto Total
                                                    </th>
                                                    <th class="col-1 pe-3">
                                                        Acción
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($inputsEquipamiento))
                                                @foreach($inputsEquipamiento as $index => $itemEquip)
                                                @php($indexPaso = $index)
                                                <tr class="border border-bottom-0 border-start-0 border-end-0 text-secondary" id="itemEquipId{{$loop->index}}">
                                                    <td class="px-1 py-2 ps-3">
                                                        <input type="text" id="inputsEquipamiento_{{$indexPaso}}_detaequipo" wire:model.debounce.250ms="inputsEquipamiento.{{$indexPaso}}.detaequipo" maxlength="150" wire:loading.attr="disabled" wire:target="thirdStepSubmit,back" class="form-control" placeholder="Detalle Equipo" data-tippy-content="Ingrese detalle del equipo.">
                                                        @error('inputsEquipamiento.'.$indexPaso.'.detaequipo')
                                                        <span class="colorerror">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="px-1 py-2">
                                                        <select wire:model="inputsEquipamiento.{{$indexPaso}}.idActividad" id="inputsEquipamiento_{{$index}}_idActividad" wire:loading.attr="disabled" wire:target="thirdStepSubmit,back" class="form-select" data-tippy-content="Seleccione la actividad a la cual estará asociado el equipo.">
                                                            <option value="0">Seleccione Actividad</option>
                                                            @foreach($inputsActividad as $index => $inputAct)
                                                            <option value="{{$inputAct['idActividad']}}">{{$inputAct['tituloActividad']}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('inputsEquipamiento.'.$indexPaso.'.idActividad')
                                                        <span class="colorerror">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="px-1 py-2">
                                                        <input type="text" id="inputsEquipamiento_{{$indexPaso}}_cantidad" wire:model.debounce.250ms="inputsEquipamiento.{{$indexPaso}}.cantidad" onkeydown="return onlyNumberKey(event, this);" maxlength="6" wire:loading.attr="disabled" wire:target="thirdStepSubmit,back" class="form-control" placeholder="Cantidad" data-tippy-content="Ingrese cantidad del item.">
                                                        @error('inputsEquipamiento.'.$indexPaso.'.cantidad')
                                                        <span class="colorerror">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="px-1 py-2">
                                                        <input type="text" id="inputsEquipamiento_{{$indexPaso}}_montototal" wire:model.debounce.250ms="inputsEquipamiento.{{$indexPaso}}.montototal" onkeydown="return onlyNumberKey(event, this);" maxlength="8" wire:loading.attr="disabled" wire:target="thirdStepSubmit,back" class="form-control" placeholder="Monto Total" data-tippy-content="Ingrese el monto total utilizado en el equipo.">
                                                        @error('inputsEquipamiento.'.$indexPaso.'.montototal')
                                                        <span class="colorerror">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="px-1 py-2 text-danger">
                                                        <div id="eliminarItemEquip{{$indexPaso}}" wire:click="deleteEquipamiento({{$indexPaso}}, {{$itemEquip['idPptoEq']}})" class="text-danger text-center" style="cursor:pointer" data-tippy-content="Click para eliminar el item">
                                                            <i class="bi bi-trash fs-4"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <div id="bottomEquip"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-4  ms-md-5 mt-md-5 mb-md-5">
                <div class="col-8 mb-2 offset-3 col-md-2 mb-md-0 offset-md-3">
                    <button class="btn btn-danger btn-lg" style="width:160px;" type="button" wire:click="back(2)" wire:loading.attr="disabled" wire:target="thirstStep,back">
                        <span wire:loading.class="spinner-border spinner-border-sm" wire:target="back" role="status" aria-hidden="true"></span>
                        <span wire:loading.remove wire:target="back"><i class="bi bi-arrow-left"></i></span>
                        Atr&aacute;s
                    </button>
                </div>
                <div class="col-8 offset-3 col-md-2 offset-md-0 ps-md-4">
                    <button class="btn btn-primary btn-lg" style="width:160px;" type="button" wire:click="thirstStep" wire:loading.attr="disabled" wire:target="thirstStep,back">
                        Siguiente
                        <span wire:loading.remove wire:target="thirstStep"><i class="bi bi-arrow-right"></i></span>
                        <span wire:loading.class="spinner-border spinner-border-sm" wire:target="thirstStep" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row {{ $currentStep != 4 ? 'displayNone' : '' }} ms-1 pe-3 ms-md-5 pe-md-3" id="step-4">
    <div class="col-12 offset-0 col-md-7 offset-md-2">
        <div class="card">
            <div class="card-body">
                <div class="row mt-4 mb-5">
                    <div class="col-12 ps-5 pe-5">
                        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <div class="row">
                                <div class="col-12">
                                    <label>
                                        Adjuntar documentación del Proyecto
                                    </label>
                                    <div class="input-group mt-1">
                                        <span class="input-group-text">
                                            <i class="bi bi-filetype-pdf"></i>
                                        </span>
                                        <input type="file" title="" name="docProyecto" wire:model.debounce.250ms="docProyecto" wire:loading.attr="disabled" wire:target="back,fourthStep,docProyecto,confirmEnviarPostulacion" class="form-control" id="{{$idDoc}}" data-tippy-content="Adjunte documentación en formato PDF">
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div x-show="isUploading">
                                        <div class="progress mt-2" style="height: 10px;">
                                            <div class="progress-bar progress-bar-striped" role="progressbar" x-bind:style="`width:${progress}%`" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('docProyecto')
                    <div class="col-12 ps-5">
                        <span class="colorerror">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 mb-4 ms-md-5 mt-md-5 mb-md-5">
        <div class="col-10 offset-2 col-md-3 offset-md-2">
            <button id="backFourthStep" class="btn btn-danger btn-lg" style="width:200px;" type="button" wire:click="back(3)" wire:loading.attr="disabled" wire:target="back,fourthStep,docProyecto,confirmEnviarPostulacion">
                <span wire:loading.class="spinner-border spinner-border-sm" wire:target="back" role="status" aria-hidden="true"></span>
                <span wire:loading.remove wire:target="back"><i class="bi bi-arrow-left"></i></span>
                Atr&aacute;s
            </button>
        </div>
        <div class="col-10 offset-1 mt-2 col-md-3 offset-md-0 mt-md-0 ps-md-0">
            <button class="btn btn-primary btn-lg" style="width:250px;" id="enviarPostulacion" type="button" wire:click="confirmEnviarPostulacion" wire:loading.attr="disabled" wire:target="back,fourthStep,docProyecto,confirmEnviarPostulacion">
                Enviar Postulación
                <span id="spinnerEnvPost" wire:loading.class="spinner-border spinner-border-sm" wire:target="confirmEnviarPostulacion,fourthStep" role="status" aria-hidden="true"></span>
                <span id="sendIcon" wire:loading.remove wire:target="confirmEnviarPostulacion,fourthStep"><i class="bi bi-send"></i></span>
            </button>
        </div>
    </div>
</div>

<!-- Mensaje final de exito -->
<div class="{{ $currentStep != 5 ? 'displayNone' : '' }}">
    <div class="row d-flex justify-content-center">
        <div class="col-12 mt-1 col-md-6 mt-md-2">
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </svg>
                <span class="ps-3">Su postulación ha sido recepcionada</span>
            </div>
        </div>
        <div class="col-11 offset-1 mb-4 col-md-10 mb-md-4">
            @if (! $flgExeptionMailSolicitante)
            <i class="bi bi-envelope"></i>
            Se ha enviado un comprobante al siguiente correo: {{$correoOrganizacion}}
            @else
            <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <span class="ps-2">No fue posible enviar una copia de su postulación al correo: {{$correoOrganizacion}}</span>
            </div>
            @endif
        </div>
    </div>
    <div class="row ms-0 mb-2 ms-md-4 mb-md-3">
        <div class="col-12 col-md-7 offset-md-3 h4">
            Resumen de la postulación de su proyecto
        </div>
    </div>
    <div class="row mb-2 mt-2 mb-md-2 mt-md-3 fs-6">
        <div class="col-10 offset-1 col-md-4 text-md-end pe-md-1 fw-normal">
            Fondo Concursable:
        </div>
        <div class="col-11 offset-1 col-md-7 ps-md-1 offset-md-0 fw-light">
            {{$descripcionFondo}}
        </div>
    </div>
    <div class="row mb-2 mt-2 mb-md-2 mt-md-3 fs-6">
        <div class="col-10 offset-1 col-md-4 text-md-end pe-md-1 fw-normal">
            Código del Proyecto:
        </div>
        <div class="col-11 offset-1 col-md-7 ps-md-1 offset-md-0 fw-light">
            {{$codProyecto}}
        </div>
    </div>
    <div class="row mb-2 mt-2 mb-md-2 mt-md-3 fs-6">
        <div class="col-10 offset-1 col-md-4 text-md-end pe-md-1 fw-normal">
            Nombre del Proyecto:
        </div>
        <div class="col-11 offset-1 col-md-7 ps-md-1 offset-md-0 fw-light">
            {{$nombreProyecto}}
        </div>
    </div>
    <div class="row mb-2 mt-2 mb-md-2 mt-md-3 fs-6">
        <div class="col-10 offset-1 col-md-4 text-md-end pe-md-1 fw-normal">
            Monto Total:
        </div>
        <div class="col-11 offset-1 col-md-7 ps-md-1 offset-md-0 fw-light">
            ${{number_format(is_numeric($montoProyecto)?$montoProyecto:0, 0, ',', '.')}}
        </div>
    </div>
    <div class="row mb-2 mt-2 mb-md-2 mt-md-3 fs-6">
        <div class="col-10 offset-1 col-md-4 text-md-end pe-md-1 fw-normal">
            Fecha de Postulación:
        </div>
        <div class="col-11 offset-1 col-md-7 ps-md-1 offset-md-0 fw-light">
            {{ \Carbon\Carbon::parse($fechaSolicitud)->format('d/m/Y H:i')}}
        </div>
    </div>
    <div class="row mb-2 mt-2 mb-md-2 mt-md-3 fs-6">
        <div class="col-10 offset-1 col-md-4 text-md-end pe-md-1 fw-normal">
            Run Organización:
        </div>
        <div class="col-11 offset-1 col-md-7 ps-md-1 offset-md-0 fw-light">
            {{number_format(is_numeric($runOrganizacion)?$runOrganizacion:0, 0, ',', '.')}}-{{$dvRunOrganizacion}}
        </div>
    </div>
    <div class="row mb-2 mt-2 mb-md-2 mt-md-3 fs-6">
        <div class="col-10 offset-1 col-md-4 text-md-end pe-md-1 fw-normal">
            Nombre Organización:
        </div>
        <div class="col-11 offset-1 col-md-7 ps-md-1 offset-md-0 fw-light">
            {{$nombreOrganizacion}}
        </div>
    </div>
    <div class="row mb-2 mt-2 mb-md-2 mt-md-3 fs-6">
        <div class="col-10 offset-1 col-md-4 text-md-end pe-md-1 fw-normal">
            Teléfono Organización:
        </div>
        <div class="col-11 offset-1 col-md-7 ps-md-1 offset-md-0 fw-light">
            {{$telefonoOrganizacion}}
        </div>
    </div>
    <div class="row mb-2 mt-2 mb-md-2 mt-md-3 fs-6">
        <div class="col-10 offset-1 col-md-4 text-md-end pe-md-1 fw-normal">
            Correo Organización:
        </div>
        <div class="col-11 offset-1 col-md-7 ps-md-1 offset-md-0 fw-light">
            {{$correoOrganizacion}}
        </div>
    </div>
    <div class="row mt-5 mb-5 ps-3 mt-md-5 mb-md-5 ps-md-2 justify-content-md-center">
        <div class="col-8 offset-2 col-md-4 offset-md-1">
            <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" wire:loading.attr="disabled" wire:target="volverInicio" wire:click="volverInicio()">
                <span wire:loading.class="spinner-border spinner-border-sm" wire:target="volverInicio" role="status" aria-hidden="true"></span>
                Volver al Inicio
            </button>
        </div>
    </div>
</div>
<!-- Fin Mensaje final de exito -->

<div class="row mb-3 mt-2 mb-md-3 mt-md-2">
    <div class="col-9 offset-1 col-md-6 offset-md-3">
        <div wire:offline>
            <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div>
                    Sin Conexi&oacute;n a Internet
                </div>
            </div>
        </div>
    </div>
</div>

@if (session()->has('exceptionMessage'))
<div class="row">
    <div class="col-12">
        <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div>
                {{ session('exceptionMessage') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    window.addEventListener('moveScroll', event => {
        // alert(event.detail.id);
        const element = document.querySelector(event.detail.id)
        const topPos = element.getBoundingClientRect().top + window.pageYOffset

        window.scrollTo({
            top: topPos,
            behavior: 'smooth'
        })
    });

    // const nodeList = document.querySelectorAll(".example");
    // for (i = 0; i < nodeList.length; i++) {
    //     nodeList[i].style.backgroundColor = "red";
    // }

    function moveScrollById(id) {
        const element = document.querySelector(id);
        const topPos = element.getBoundingClientRect().top + window.pageYOffset;

        window.scrollTo({
            top: topPos,
            behavior: 'smooth'
        });
    }

    window.addEventListener('moveScrollByErrorId', event => {
        moveScrollById(event.detail.id);

        setTimeout(function() {
            document.querySelector(event.detail.id + 'Error').classList.add("shake-effect");
        }, 1000);
        document.querySelector(event.detail.id + 'Error').classList.remove("shake-effect");
    });

    window.addEventListener('swal:modal', event => {
        Swal.fire({
            position: 'top',
            icon: event.detail.icon,
            //iconColor:'#ffc107',
            title: event.detail.title,
            html: event.detail.mensaje,
            showConfirmButton: true,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#0d6efd',
            showCloseButton: true,
            timer: 0
        }).then((result) => {
            if (result.isConfirmed) {
                //moveScrollById(event.detail.id);
            }
        })
    });

    window.addEventListener('swal:confirm', event => {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary m-2',
                cancelButton: 'btn btn-danger m-2'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: event.detail.title,
            html: event.detail.text,
            icon: 'warning',
            showCancelButton: true,
            showCloseButton: true,
            confirmButtonText: 'Confirmar Postulación',
            cancelButtonText: 'Cancelar',
            reverseButtons: false,
            closeOnClickOutside: false,
        }).then((result) => {
            if (result.isConfirmed) {
                    window.livewire.emit('fourthStep');
            }
        })
    });


    window.addEventListener('swal:confirmEnvioPostu', event => {
        (async () => {

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary mb-3',
                    cancelButton: 'btn btn-danger ms-3 mb-3',
                    inputPlaceholder: 'negritaverde'
                },
                buttonsStyling: false
            })

            const {
                value: accept
            } = await swalWithBootstrapButtons.fire({
                title: event.detail.title,
                html: event.detail.text,
                icon: 'warning',
                input: 'checkbox',
                inputValue: 0,
               inputPlaceholder: '<div style="text-align:justify;margin-left:0.8rem;font-weight: 400;font-style: italic;"> He revisado y me he cerciociorado que tanto el documento adjunto como la información están correctamente ingresados.</div>',
            //    inputPlaceholder: ' He revisado y me he cerciociorado que tanto el documento adjunto como la información están correctamente ingresados.',
                showCancelButton: true,
                showCloseButton: true,
                confirmButtonText: 'Confirmar <i class="fa fa-arrow-right"></i>',
                cancelButtonText: 'Cancelar',
                inputValidator: (result) => {
                    return !result && 'Debe marcar la casilla'
                }
            })

            if (accept) {
                window.livewire.emit('fourthStep');
            }

        })()
    });

    document.addEventListener('livewire:load', () => {
        window.livewire.on('fourthStep', () => {
            var element = document.getElementById("spinnerEnvPost");
            var element2 = document.getElementById("sendIcon");
            element.classList.add("spinner-border");
            element.classList.add("spinner-border-sm");
            element2.classList.add("d-none");
            document.getElementById("enviarPostulacion").disabled = true;
            document.getElementById("backFourthStep").disabled = true;
            //document.getElementById("docProyecto").disabled = true;
            document.forms[0].docProyecto.disabled = true;
        });
    });

    window.addEventListener('swal:information', event => {
        const Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            // timer: 3000,
            timerProgressBar: false,
            showCloseButton: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: event.detail.icon,
            title: event.detail.mensaje,
            text: '',
        })
    });

    function onlyNumberKey(evt, obj) {

        var ASCIICode = (evt.which) ? evt.which : evt.keyCode;
        var flgAsciiNumberOK = false;

        if (ASCIICode == 8 /*Borrar <-*/ || ASCIICode == 46 /*Supr*/ || ASCIICode == 37 /*Atras*/ || ASCIICode == 39 /*Adelante*/ || ASCIICode == 9 /*Tab*/ ) {
            return true;
        }

        if (obj.value.length >= obj.maxLength) {
            return false;
        }

        if ((ASCIICode > 47 && ASCIICode < 58) || (ASCIICode > 95 && ASCIICode < 106)) {
            return true;
        } else {
            return false;
        }
    }


    function onlyAlphaNumDVKey(evt, obj) {
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode;
        var flgAsciiNumberOK = false;
        if (ASCIICode == 8 /*Borrar <-*/ || ASCIICode == 46 /*Supr*/ || ASCIICode == 37 /*Atras*/ || ASCIICode == 39 /*Adelante*/ || ASCIICode == 9 /*Tab*/ ) {
            return true;
        }

        if (obj.value.length >= obj.maxLength) {
            return false;
        }


        if ((ASCIICode > 47 && ASCIICode < 58) || (ASCIICode > 95 && ASCIICode < 106) || ASCIICode == 75 || ASCIICode == 107) {
            return true;
        } else {
            return false;
        }
    }


    function focusDV(evt, objRut, objDV) {
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode;

        if (ASCIICode == 8 /*Borrar <-*/ || ASCIICode == 46 /*Supr*/ || ASCIICode == 37 /*Atras*/ || ASCIICode == 39 /*Adelante*/ ) {
            return false; //No dar el foco en DV
        }
        if (objRut.value.length >= objRut.maxLength) {
            objDV.focus();
        }
    }

    initToolTips();

    window.addEventListener('iniTooltips', event => {
        initToolTips();
    });

    function initToolTips() {
        tippy('[data-tippy-content]', {
            touch: true, //Habilita Toolstips para moviles
            animation: 'scale-extreme',
            placement: 'bottom',
            duration: 450, //Tiempo que se demora el despliegue
            delay: 500, //Tiempo que se demora en aparecer
        });
    }


    // document.getElementById("enviarPostulacion").addEventListener('click', swalConfirmPostulacion);

    // function swalConfirmPostulacion() {
    //     const swalWithBootstrapButtons = Swal.mixin({
    //         customClass: {
    //             confirmButton: 'btn btn-primary m-2',
    //             cancelButton: 'btn btn-danger m-2'
    //         },
    //         buttonsStyling: false
    //     })

    //     swalWithBootstrapButtons.fire({
    //         title: '¿Confirmar Envío de Postulación?',
    //         html: 'Asegurese de revisar bien los datos ingresados para la postulación de su proyecto. Una vez enviados no podrá realizar modificaciones. <br>Puede navegar libremente por las distintas fases, para revisar la información ingresada (no perderá sus datos)',
    //         icon: 'warning',
    //         showCancelButton: true,
    //         showCloseButton: true,
    //         confirmButtonText: 'Confirmar Postulación',
    //         cancelButtonText: 'Cancelar',
    //         reverseButtons: false
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             window.livewire.emit('fourthStep');
    //         }
    //     })
    // }
</script>
</form>
</div>
</div>
