<?php

use App\Http\Livewire\Postulacionsubvenciones;
use App\Http\Livewire\Postulacionasignaciondirecta;
use App\Http\Livewire\Iniciopostulacion;
use App\Http\Livewire\EmailForm;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('plantillabase');
});

Route::get('/iniciopostulacion', Iniciopostulacion::class)->name('iniciopostulacion'); 

Route::get('/postulacionsubvenciones', Postulacionsubvenciones::class)->name('postulacionsubvenciones');

Route::get('/postulacionasignaciondirecta', Postulacionasignaciondirecta::class)->name('postulacionasignaciondirecta');

Route::get('/descargarDocuPostu/{idDocumento}/{checksum}', [Postulacionsubvenciones::class, 'descargarDocuPostu'])
->name('descargarDocuPostu');

Route::get('/emailprueba', EmailForm::class)->name('emailprueba');



