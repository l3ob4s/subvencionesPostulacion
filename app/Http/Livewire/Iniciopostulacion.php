<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Periodospostu;
use App\Models\Periodopostuad; 
use Carbon\Carbon;

class Iniciopostulacion extends Component
{
    public $flgActivAsigDirecta, $flgActivSubvenciones, $fecDesdePostuSubvenciones, $fecHastaPostuSubvenciones, $fecDesdePostuAsigDirecta, $fecHastaPostuAsigDirecta;
    public function mount() {
        $fechaActual = Carbon::parse(now())->format('Y-m-d');
        $periodosPostu =  Periodospostu::whereRaw("DATE_FORMAT(fechaInicioPostu, '%Y-%m-%d') <= '" . $fechaActual . "' and DATE_FORMAT(fechaFinPostu, '%Y-%m-%d') >= '" . $fechaActual . "'")->first();
        $this->flgActivSubvenciones = false;

        if (!empty($periodosPostu)) {
            $this->flgActivSubvenciones = true;
        } 

        // $this->flgActivSubvenciones = false; //quitar esta línea una vez que se terminen las pruebas  
        // else {
        //     $this->flgActivSubvenciones = false;

            //Hacer un select a la tabla de periodos de postulacion para el maximo de fechaFinPostu para mostrarlo en la página de inicio 
            //   $fecDesdeFmt = Carbon::parse($jefeDirecto->fecDesdeAus)->locale('es');
            //   $fecHastaFmt = Carbon::parse($jefeDirecto->fecHastaAus)->locale('es'); 
            //   $fecDesdeSubEsFmt = ucfirst($fecDesdeFmt->dayName) . " " . ucfirst($fecDesdeFmt->day) . " de " . ucfirst($fecDesdeFmt->monthName) . " del " . $fecDesdeFmt->year;
            //   $fecHastaSubEsFmt = ucfirst($fecHastaFmt->dayName) . " " . ucfirst($fecHastaFmt->day) . " de " . ucfirst($fecHastaFmt->monthName) . " del " . $fecHastaFmt->year;
        // }

        $periodosPostuAD =  Periodopostuad::whereRaw("DATE_FORMAT(fechaInicioPostu, '%Y-%m-%d') <= '" . $fechaActual . "' and DATE_FORMAT(fechaFinPostu, '%Y-%m-%d') >= '" . $fechaActual . "'")->first();
        $this->flgActivAsigDirecta = false;

        if (!empty($periodosPostuAD)) {
            $this->flgActivAsigDirecta = true;
        }    
    }

    public function render()
    {

        return view('livewire.iniciopostulacion');
    }

    public function ingresarProyecto($selTipoProyecto) {
        if ($selTipoProyecto == 1) {
             return redirect()->intended('/postulacionsubvenciones');
        } else 
        if ($selTipoProyecto == 2) {  
            return redirect()->intended('/postulacionasignaciondirecta');  
        }
    }
}
