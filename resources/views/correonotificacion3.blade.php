<!DOCTYPE html>
<html>

<head>
    <title>Gobierno Regional del Bio Bio</title>
</head>
<body>
<!-- https://sitio.gorebiobio.cl/wp-content/themes/html5blank/img/auxi/logo-header-200x300.png -->
    <table>
      <tr>
        <td rowspan="14" width="35"></td>
      </tr>
      <tr>
        <td><img src="https://sitio.gorebiobio.cl/wp-content/themes/html5blank/img/auxi/logo-header-200x300.png" alt="" height="160" width="120"></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="2" height="10">
          <h3>{{ $mailData['titulo'] }}</h3>
        </td>
      </tr>
      <tr>
        <td colspan="2" height="15">
          <hr>
        </td>
      </tr>
      <tr>       
        <td><b>Fondo Concursable:</b></td>
        <td>{{ $mailData['descripcionFondo'] }}</td>        
      </tr>
      <tr>       
        <td><b>Código del Proyecto:</b></td>
        <td>{{ $mailData['codProyecto'] }}</td>        
      </tr>
      <tr>       
        <td><b>Nombre del Proyecto:</b></td>
        <td>{{ $mailData['nombreProyecto'] }}</td>        
      </tr>
      <tr>       
        <td><b>Monto Total:</b></td>
        <td>{{ $mailData['montoProyecto'] }}</td>
      </tr>
      <tr>
        <td><b>Fecha de solicitud:</b></td>
        <td>{{ $mailData['fecSolicitud'] }}</td>
      </tr>
      <tr>
        <td><b>Run Organización:</b></td>
        <td>{{ $mailData['runOrganizacion'] }}</td> 
      </tr>
      <tr>
        <td><b>Nombre Organización:</b></td>
        <td>{{ $mailData['nombreOrganizacion'] }}</td>
      </tr>
      <tr>
        <td><b>Teléfono Organización:</b></td>
        <td>{{ $mailData['telefonoOrganizacion'] }}</td>
      </tr>
      <tr>
        <td><b>Correo Organización:</b></td>
        <td>{{ $mailData['correoOrganizacion'] }}</td>
      </tr>
      <tr>
        <td colspan="2"><hr></td>
      </tr>
    </table>  
</body>
</html>