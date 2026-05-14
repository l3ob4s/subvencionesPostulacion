<!DOCTYPE html>
<html>

<head>
    <title>Reporte {{ $proyecto->codProyecto }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="width: 100%; height: 15px; background: #789829"></div>
            <br>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table" style="text-align: center">
                    <tr>
                        <td><img src="{{ public_path('images/logo_gore.png') }}" width="80" /></td>
                        <td style="padding-top: 60px">
                            <h3>Código {{ $proyecto->codProyecto }}</h3>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <hr>
                <center><strong>Datos Organización</strong></center>
                <hr>
            </div>
            <div class="col-md-12">
                <table class="table table-striped table-sm" style="font-size:10px;text-align: justify">
                    <tr>
                        <td style="width: 150px;"><strong>Rut Organización</strong></td>
                        <td>{{ number_format($proyecto->runOrganizacion,0,',','.') }}-{{ $proyecto->dvRunOrganizacion }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nombre Organización</strong></td>
                        <td>{{ $proyecto->nombreOrganizacion }}</td>
                    </tr>
                    <tr>
                        <td><strong>Años de Existencia Legal</strong></td>
                        <td>{{ $proyecto->agnosExistencia }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dirección Organización</strong></td>
                        <td>
                            @if(!empty($proyecto->direccionOrganizacion))
                              {{ $proyecto->direccionOrganizacion }}
                            @else
                              {{ $proyecto->tipoVia}} {{ $proyecto->nombreVia}} {{ $proyecto->numDireccion}}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Provincia</strong></td>
                        <td>{{ $proyecto->descripcionProvincia }}</td>
                    </tr>
                    <tr>
                        <td><strong>Comuna Organización</strong></td>
                        <td>{{ $proyecto->descripcionComuna }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tipo de Cuenta</strong></td>
                        <td>{{ $proyecto->tipoCuenta }}</td>
                    </tr>
                    <tr>
                        <td><strong>Banco</strong></td>
                        <td>{{ $proyecto->nombreBanco }}</td>
                    </tr>
                    <tr>
                        <td><strong>Número de Cuenta</strong></td>
                        <td>{{ $proyecto->numeroCuenta }}</td>
                    </tr>
                    <tr>
                        <td><strong>Correo Organización</strong></td>
                        <td>{{ $proyecto->correoOrganizacion }}</td>
                    </tr>
                    <tr>
                        <td><strong>Teléfono Organización</strong></td>
                        <td>{{ $proyecto->telefonoOrganizacion }}</td>
                    </tr>
                </table>
            </div>

            <br>
            <div class="col-md-12">
                <hr>
                <center><strong>Datos Representante Legal</strong></center>
                <hr>
            </div>
            <div class="col-md-12">
                <table class="table table-striped table-sm" style="font-size:10px;text-align: justify">
                    <tr>
                        <td style="width: 150px;"><strong>Rut Representante Legal</strong></td>
                        <td>{{ number_format($proyecto->rutRepLegal,0,',','.') }}-{{ $proyecto->dvRutRepLegal }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nombre Representante Legal</strong></td>
                        <td>{{ $proyecto->nomRepLegal }}</td>
                    </tr>
                    <tr>
                        <td><strong>Teléfono Representante Legal</strong></td>
                        <td>{{ $proyecto->telefonoRepLegal }}</td>
                    </tr>
                    <tr>
                        <td><strong>Correo Representante Legal</strong></td>
                        <td>{{ $proyecto->correoRepLegal }}</td>
                    </tr>
                    <tr>
                        <td><strong>Fecha Venc. Directiva Actual</strong></td>
                        <td>{{\Carbon\Carbon::parse($proyecto->fecVencDirectiva)->format('d-m-Y')}}</td>
                    </tr>
                </table>
            </div>
            <div style="page-break-after:always;"></div> <!-- Salto de pagina -->
            <div class="col-md-12">
                <hr>
                <center><strong>Datos Administrativos del Proyecto</strong></center>
                <hr>
            </div>
            <div class="col-md-12">
                <table class="table table-striped table-sm" style="font-size:10px;text-align: justify">
                    <tr>
                        <td><strong>Nombre del Proyecto</strong></td>
                        <td>{{ $proyecto->nombreProyecto }}</td>
                    </tr>
                    <tr>
                        <td style="width: 150px;"><strong>Fondo Concursable</strong></td>
                        <td>{{ $proyecto->descripcionFondoConcursable }}</td>
                    </tr>
                    <tr>
                        <td><strong>Monto del Proyecto</strong></td>
                        <td>${{ number_format($proyecto->montoProyecto,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Fecha Solicitud</strong></td>
                        <td>{{\Carbon\Carbon::parse($proyecto->created_at)->format('d-m-Y H:i')}}</td>
                    </tr>
                    <tr>
                        <td><strong>Documento Postulación</strong></td>
                        <td>
                            <a href="{{$documentoPostulacion}}" target="_blank" class="d-inline text-decoration-none link-primary">
                                Descargar Documento
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Comuna a Intervenir</strong></td>
                        <td>{{ $proyecto->descripcionComuna }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tipo de Proyecto</strong></td>
                        <td>{{ $proyecto->descripcionTipoProyecto }}</td>
                    </tr>

                </table>
            </div>
            <div class="col-md-12">
                <hr>
                <center><strong>Datos Técnicos del Proyecto</strong></center>
                <hr>
            </div>
            <div class="col-md-12">
                <table class="table table-striped table-sm" style="font-size:10px;text-align: justify">
                    <tr>
                        <td><strong>Beneficiarios Hombres</strong></td>
                        <td>{{ $proyecto->cantBenefHombreProy }}</td>
                    </tr>
                    <tr>
                        <td style="width: 150px;"><strong>Beneficiarios Mujeres</strong></td>
                        <td>{{ $proyecto->cantBenefMujerProy }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Beneficiarios</strong></td>
                        <td>{{ ($proyecto->cantBenefMujerProy + $proyecto->cantBenefHombreProy) * 1 }}</td>
                    </tr>
                    <tr>
                        <td><strong>Descripción del Proyecto</strong></td>
                        <td>{{ $proyecto->resumenProyecto }}</td>
                    </tr>
                    <tr>
                        <td><strong>Objetivo General del Proyecto</strong></td>
                        <td>{{ $proyecto->objetivoProyecto }}</td>
                    </tr>
                    <tr>
                        <td><strong>Descripción de la Necesidad</strong></td>
                        <td>{{ $proyecto->descripNecesidadACubrir }}</td>
                    </tr>
                    <tr>
                        <td><strong>Descripción del Territorio y Beneficiarios</strong></td>
                        <td>{{ $proyecto->descripTerritorioBenef }}</td>
                    </tr>
                    <tr>
                        <td><strong>Difusión del Proyecto</strong></td>
                        <td>{{ $proyecto->descripDifusionProy }}</td>
                    </tr>
                    <tr>
                        <td><strong>Resultados y/o Productos Esperados</strong></td>
                        <td>{{ $proyecto->descripResultadoProy}}</td>
                    </tr>
                    <tr>
                        <td><strong>Medios de Verificación de Actividades</strong></td>
                        <td>{{ $proyecto->descripMedioVerifPostEjecuProy}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12">
                <hr>
                <center><strong>Objetivos Específicos</strong></center>
                <hr>
            </div>
            <div class="col-md-12">
                <table class="table table-striped table-sm" style="font-size:10px;text-align: justify">
                    @foreach($objetivoespecifico as $itemObj)
                    <tr>
                        <td>{{ $itemObj->descripcionObjEspecifico }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-md-12">
                <hr>
                <center><strong>Actividades</strong></center>
                <hr>
            </div>
            <div class="col-md-12">
                <table class="table table-striped table-sm" style="font-size:10px;text-align:justify">
                    @foreach($actividades as $actividad)
                    <tr>
                        <td style="width: 150px;"><strong>{{ $actividad->tituloActividad }}</strong></td>
                        <td>{{ $actividad->descripcionActividad }}</td>
                    </tr>
                    <tr>
                        <td><strong>Meses en los cuales se llevará a cabo la actividad</strong></td>
                        <td>{{ str_replace(",", ", ", $actividad->mesesEjecuActividad) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Descripción de los Bienes, Servicios y/o RRHH</strong></td>
                        <td>{{ $actividad->descripBienesServRRHHActividad }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-md-12">
                <hr>
                <center><strong>Descripción del Recurso Humano del Proyecto</strong></center>
                <hr>
            </div>
            <div class="col-md-12">
                <table class="table table-striped table-sm" style="font-size:10px;text-align: justify">
                    @foreach ($RRHHProyecto as $itemRRHHProy)
                    <tr>
                        <td><strong>Cargo a Contratar</strong></td>
                        <td>{{ $itemRRHHProy->descripCargo }}</td>
                    </tr>
                    <tr>
                        <td><strong>Perfil del Cargo</strong></td>
                        <td>{{ $itemRRHHProy->descripPerfilCargo }}</td>
                    </tr>
                    <tr>
                        <td><strong>Periocidad del Servicio</strong></td>
                        <td>{{ $itemRRHHProy->descripPeriocidadServicio }}</td>
                    </tr>
                    <tr>
                        <td><strong>Cantidad de Horas</strong></td>
                        <td>{{ $itemRRHHProy->totalHorasServicio }}</td>
                    </tr>
                    <tr>
                        <td><strong>Monto Total a Pagar</strong></td>
                        <td>${{ number_format($itemRRHHProy->montoTotalServicio,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Funciones o Actividades a Realizar</strong></td>
                        <td>{{ $itemRRHHProy->descripFuncActividades }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-md-12">
                <hr>
                <center><strong>Datos Presupuestarios</strong></center>
                <hr>
            </div>
            <div class="col-md-12">
                <table class="table table-striped table-sm" style="font-size:10px;text-align: justify">
                    <th>Item</th>
                    <th>Monto Total</th>
                    <tr>
                        <td>Recurso Humano</td>
                        <td>${{ number_format($totalPptoRRHH,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td>Gastos Generales</td>
                        <td>${{ number_format($totalPptoGastosGrales,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td>Equipamiento</td>
                        <td>${{ number_format($totalPptoEquip,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td><b>Total Presupuesto</b></td>
                        <td><b>${{ number_format($totalPpto,0,',','.') }}</b></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12">
                <hr>
                <center><strong>Presupuesto Recursos Humanos</strong></center>
                <hr>
            </div>
            <div class="col-md-12">
                <table class="table table-striped table-sm" style="font-size:10px;text-align: justify">
                    <tr>
                        <th>Perfil RRHH</th>
                        <th>Actividad Asociada</th>
                        <th>Horas RRHH</th>
                        <th>Valor Hora</th>
                        <th>Monto Total</th>
                    </tr>
                    @if(!empty($pptoRRHH) && count($pptoRRHH) > 0)
                    @foreach($pptoRRHH as $itemRRHH)
                    <tr>
                        <td>{{ $itemRRHH->perfil }}</td>
                        <td>{{ $itemRRHH->tituloActividad }}</td>
                        <td>{{ $itemRRHH->canthora }}</td>
                        <td>${{ number_format($itemRRHH->valorhora,0,',','.')  }}</td>
                        <td>${{ number_format($itemRRHH->montototal,0,',','.')  }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4"><strong>Total</strong></td>
                        <td><strong>${{ number_format($totalPptoRRHH,0,',','.') }}</strong></td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="5">
                            <center>No existe información para mostrar.</center>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
            <div class="col-md-12">
                <hr>
                <center><strong>Presupuesto Gastos Generales</strong></center>
                <hr>
            </div>
            <div class="col-md-12">
                <table class="table table-striped table-sm" style="font-size:10px;text-align: justify">
                    <tr>
                        <th>Detalle Bienes o Servicios</th>
                        <th>Actividad Asociada</th>
                        <th>Descripción</th>
                        <th>Monto Total</th>
                    </tr>
                    @if(!empty($pptoGastosGrales) && count($pptoGastosGrales) > 0)
                    @foreach($pptoGastosGrales as $itemGastosGrales)
                    <tr>
                        <td>{{ $itemGastosGrales->detabienesservicio }}</td>
                        <td>{{ $itemGastosGrales->tituloActividad }}</td>
                        <td>{{ $itemGastosGrales->descripcion }}</td>
                        <td>${{ number_format($itemGastosGrales->montototal,0,',','.') }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td><strong>${{ number_format($totalPptoGastosGrales,0,',','.') }}</strong></td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="4">
                            <center>No existe información para mostrar.</center>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
            <div class="col-md-12">
                <hr>
                <center><strong>Equipamiento para Ejecutar el Proyecto</strong></center>
                <hr>
            </div>
            <div class="col-md-12">
                <table class="table table-striped table-sm" style="font-size:10px;text-align: justify">
                    <tr>
                        <th>Equipamiento</th>
                        <th>Actividad Asociada</th>
                        <th>Cantidad</th>
                        <th>Monto</th>
                    </tr>
                    @if(!empty($pptoEquip) && count($pptoEquip) > 0)
                    @foreach($pptoEquip as $itemEquip)
                    <tr>
                        <td>{{ $itemEquip->detaequipo }}</td>
                        <td>{{ $itemEquip->tituloActividad }}</td>
                        <td>{{ $itemEquip->cantidad }}</td>
                        <td>${{ number_format($itemEquip->montototal,0,',','.') }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td><strong>${{ number_format($totalPptoEquip,0,',','.') }}</strong></td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="4">
                            <center>No existe información para mostrar.</center>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
        <br><br><br>
        <div class="row">
            <div class="col-md-12 text-end">
                <table>
                    <tr>
                    <td style="width:420px;" align="right">
                           &nbsp;
                        </td>
                        <td style="width:50px;" align="right">
                            <!-- para generar el pdf cambiar public_path por public_path -->
                            <img src="{{ public_path('images/timbre_subvenciones.png') }}" height="130" width="130">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
