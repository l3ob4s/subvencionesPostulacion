<div>
    <div class="row mb-2 mb-md-3 text-center">
        <div class="col-12 text-center">
              <div class="alert alert-info border border-info mb-5 shadow mt-4 mx-4" role="alert">
                        <h4 class="alert-heading text-center fw-bold fs-5">Selección de Iniciativa</h4>
                        <hr>
                        <p class="fs-5 fst-italic px-4" style="text-align:justify;text-indent: 30px;">
                            <span class="fw-bold fs-3 text-white"
                                style="background-color:#17a2b8;border:2px solid;border-radius:5px;padding-left:4px;padding-right:8px;font-family:Nunito-ExtraLightItalic;">
                                L</span><span class="fs-6">as postulaciones al fondo <b>Asignación Directa</b> estará disponible hasta el viernes 31 de Octubre del 2025. En cuanto a los otros
                                fondos concursables de <b>Subvenciones</b>, las postulaciones estarán abiertas desde el lunes 1 de Septiembre hasta el martes 30 de Septiembre del 2025 inclusive.</span><br><br>
                        </p>
                        </div>
        </div>
              <div class="col-12 mb-4">      
                @if ($flgActivAsigDirecta == true)       
                <button class="btn btn-primary nextBtn btn-lg pull-right ms-2" type="button" id="btnAsigDirecta" name="btnAsigDirecta" wire:loading.attr="disabled" wire:click="ingresarProyecto(2)">
                    <span wire:loading.class="spinner-border spinner-border-sm" wire:target="ingresarProyecto(2)" role="status" aria-hidden="true"></span>
                    Asignación Directa
                </button>
                @else 
                   <button class="btn btn-primary nextBtn btn-lg pull-right ms-2" type="button" id="btnAsigDirectaDisab" name="btnAsigDirecta" disabled>
                      Asignación Directa
                   </button>
                @endif

                @if ($flgActivSubvenciones == true)  
                <button class="btn btn-primary nextBtn btn-lg pull-right mt-md-0 mt-2" type="button" id="btnSubvenciones" name="btnSubvencionesDisab" wire:loading.attr="disabled" wire:click="ingresarProyecto(1)">
                    <span wire:loading.class="spinner-border spinner-border-sm" wire:target="ingresarProyecto(1)" role="status" aria-hidden="true"></span>
                    Subvenciones
                </button>
                 @else
                   <button class="btn btn-primary nextBtn btn-lg pull-right ms-2 mt-md-0 mt-2" type="button" id="btnSubvencionesDisab" name="btnSubvencionesDisab" disabled>
                       Subvenciones
                   </button>
                @endif
            </div>
</div>
</div>
