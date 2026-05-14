<!DOCTYPE html>
<html>

<head>
  <title>Gobierno Regional del Bio Bío</title>

  <style>
    #table2 {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 600px;
    }

    #table2 td,
    th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    hr {
      color: #D8DCE2;
    }
  </style>

</head>

<body>
  <center>
    <table width="640">
      <tr>
        <td colspan="2">
          <hr>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="margin:0px;padding:0px;">
          <img alt="" height="160" width="650" src="{{ asset('images/encabezadocorreo.png')}}">
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <hr>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="padding-top:10px;padding-bottom:11px;color:#3980BB;font-size:20px;font-weight:550;font-family: arial, sans-serif;text-align:justify;">
          {{ $mailData['titulo'] }}
        </td>
      </tr>
      <tr>
        <td colspan="2" height="15">
          <hr>
        </td>
      </tr>
    </table>
  </center>
  <br>
  <center>
    <table id="table2">
      <tr>
        <td style="color:#3980BB;text-align:center;background-color: #F8F9FA;" height="40" colspan="2">
          <b>Resumen de su postulación</b>
        </td>
      </tr>
      <tr>
        <td style="color:#282D33;width:185px;"><b>Fondo Concursable:</b></td>
        <td style="color:#746873">{{ $mailData['proyecto']['descripcionFondoConcursable'] }}</td>
      </tr>
      <tr>
        <td><b>Código del Proyecto:</b></td>
        <td style="color:#746873">{{ $mailData['proyecto']['codProyecto'] }}</td>
      </tr>
      <tr>
        <td><b>Nombre del Proyecto:</b></td>
        <td style="color:#746873">{{ $mailData['proyecto']['nombreProyecto'] }}</td>
      </tr>
      <tr>
        <td><b>Monto Total:</b></td>
        <td style="color:#746873">
          ${{ number_format($mailData['proyecto']['montoProyecto'],0,',','.') }}
        </td>
      </tr>
      <tr>
        <td><b>Fecha de solicitud:</b></td>
        <td style="color:#746873">
        {{\Carbon\Carbon::parse($mailData['proyecto']['created_at'])->format('d-m-Y H:i')}}
        </td>
      </tr>
      <tr>
        <td><b>Documento Postulación</b></td>
        <td>
          <a href="{{$mailData['documentoPostulacion']}}" target="_blank" class="d-inline text-decoration-none link-primary">
            Descargar Documento <i class="bi bi-filetype-pdf"></i>
          </a>
        </td>
      </tr>
      <tr>
        <td><b>Run Organización:</b></td>
        <td style="color:#746873">
        {{ number_format($mailData['proyecto']['runOrganizacion'],0,',','.') }}-{{ $mailData['proyecto']['dvRunOrganizacion'] }}
        </td>
      </tr>
      <tr>
        <td><b>Teléfono Organización:</b></td>
        <td style="color:#746873">{{$mailData['proyecto']['telefonoOrganizacion']}}</td>
      </tr>
      <tr>
        <td><b>Correo Organización:</b></td>
        <td style="color:#746873;text-align:justify;">{{ $mailData['proyecto']['correoOrganizacion'] }}</td>
      </tr>
    </table>
  </center>
  <center>
    <table width="640">
      <tr>
        <td colspan="2" style="padding-top:50px;">
          <img alt="" height="160" width="650" src="{{ asset('images/footer_gore.jpg')}}">
        </td>
      </tr>
      <tr>
        <td colspan="2" style="font-size:15px;">
          <hr>
          <br>
          <center style="padding-top: 35px;padding-bottom: 10px;color:#746873;">
            © {{ \Carbon\Carbon::parse(Carbon\Carbon::now())->format('Y')}} Postulación Subvenciones - Desarrollo Interno Unidad de Informática.
          </center>
          <center style="padding-bottom: 35px;color:#746873;">Gobierno Regional del Biobío - Avenida Prat 525 - Mesa Central 56-41-2405700</center>
          <center style="color:#746873;">Concepción, Región del Biobío, Chile.</center>
          <br>
          <hr>
        </td>
      </tr>
    </table>
  </center>
  <br><br><br><br><br><br>
</body>

</html>
