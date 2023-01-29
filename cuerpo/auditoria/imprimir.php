<?php
session_start();
if($_SESSION['rol'] != 1)
{
    header('Location: ../../index.php');
    exit();
}
include_once("../../clases/consultas.php");
include_once("../../clases/javascript.php");
$a=$_GET["auditar"];
$fecha=date('Y-m-d');
if($a==1 || $a==2)
{
   $Reporte="Modulo Acceso";
}
if($a==3)
{
   $Reporte="Modulo Consultas";
}
if($a==4)
{
   $Reporte="Modulo Registro";
}
if($a==5)
{
   $Reporte="Modulo edi_audr";
}

/** Consultas para imprimir **/
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CAE PAO</title>
    <link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" type="image/png" href="../../img/icon/helmet.png"/>
    <script>
        $(document).ready(function()
        {
            $("#export").click(function(e)
            {
                window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('#consulta').html()));
                e.preventDefault();
            });
        });
    </script>
</head>
<body>
<div class="letterhead" style="margin-bottom:80px;">
    <table border="0" width="100%">
        <tr>
            <td align="left">
                <div class="img"><img src="../../img/escudo_umbv.jpg" border="0" width='100' height='100'/></div>
            </td>
            <td align="center">
                <div class="text">
                    Rep&uacute;blica Bolivariana de Venezuela<br>
                    Ministerio del Poder Popular para la Defensa<br>
                    Viceministerio del Poder Popular para la Defensa<br>
                    Universidad Militar Bolivariana de Venezuela<br>
                    Academia Militar de la Aviación Bolivariana<br>
                           Dirección<br><br>
                    <strong style="font-size:20px;"></strong>
                </div>
            </td>
            <td align="right">
                <div class="img"><img src="../../img/escudo_amab.jpg" border="0" width='100' height='100'/></div>
            </td>
        </tr>
    </table>
</div>

<div style="display:block; text-align:center;">
    <!-- <input type="button" id="export" value="Generar Archivo" />-->
    <button  class="btn btn-primary" onclick="imprimir()">Reporte del <?php echo $Reporte; ?>  de la fecha <?php echo $fecha; ?></button>
</div>
<br>

<div class="consulta" id="consulta">
  <!--<table id='tblExport' class="table table-bordered">-->
  <?php
    if($a==1 || $a==2 || $a==3)
    {
      ?>
      <div class="panel-heading">
        <h3 class="panel-title" align="center"><strong><?php if($a==1){echo "Accesos al sistema";}elseif($a==2){echo "Salidas del sistema";}elseif($a==3){echo "Reportes generados";}?></strong></h3>
      </div>
      <table class="table table-bordered" align="center">
        <tr align='center'>
          <td>
            <strong>Fecha</strong>
          </td>
          <td>
            <strong>Hora</strong>
          </td>
          <td>
            <strong>Motivo</strong>
          </td>
          <td>
            <strong>Cedula</strong>
          </td>
          <td>
            <strong>Usuario</strong>
          </td>
          <td>
            <strong>Acción</strong>
          </td>
          <td>
            <strong>Lugar</strong>
          </td>
        </tr>
        <?php
    }
    if($a==4)
    {
      ?>
      <div class="panel-heading">
        <h3 class="panel-title" align="center"><strong>Registros realizados</strong></h3>
      </div>
      <table class="table table-bordered" align="center">
        <tr align='center'>
          <td>
          </td>
          <td>
          </td>
          <td>
          </td>
          <td colspan='2'>
            <strong>Afectado</strong>
          </td>
          <td>
          </td>
          <td>
          </td>
          <td colspan='2'>
            <strong>Autor</strong>
          </td>
        </tr>
        <tr align='center'>
          <td>
            <strong>Fecha</strong>
          </td>
          <td>
            <strong>Hora</strong>
          </td>
          <td>
            <strong>Motivo</strong>
          </td>
          <td>
            <strong>Cedula</strong>
          </td>
          <td>
            <strong>Nombre</strong>
          </td>
          <td>
            <strong>Acción</strong>
          </td>
          <td>
            <strong>Lugar</strong>
          </td>
          <td>
            <strong>Cedula</strong>
          </td>
          <td>
            <strong>Usuario</strong>
          </td>
        </tr>
        <?php
    }
    if($a==5)
    {
      ?>
      <div class="panel-heading">
        <h3 class="panel-title" align="center"><strong>Registros realizados</strong></h3>
      </div>
      <table class="table table-bordered" align="center">
        <tr align='center'>
          <td>
          </td>
          <td>
          </td>
          <td>
          </td>
          <td colspan='2'>
            <strong>Afectado</strong>
          </td>
          <td>
          </td>
          <td>
          </td>
          <td colspan='2'>
            <strong>Autor</strong>
          </td>
        </tr>
        <tr align='center'>
          <td>
            <strong>Fecha</strong>
          </td>
          <td>
            <strong>Hora</strong>
          </td>
          <td>
            <strong>Motivo</strong>
          </td>
          <td>
            <strong>Cedula</strong>
          </td>
          <td>
            <strong>Nombre</strong>
          </td>
          <td>
            <strong>Acción</strong>
          </td>
          <td>
            <strong>Lugar</strong>
          </td>
          <td>
            <strong>Cedula</strong>
          </td>
          <td>
            <strong>Usuario</strong>
          </td>
          <td>
            <strong>Consulta</strong>
          </td>
          <td>
            <strong>edi_auddo</strong>
          </td>
          <td>
            <strong>Observación</strong>
          </td>
        </tr>
        <?php
    }
  ?>
  <tbody>
    <?php
      if($a==1)
      {
        $data= new Consulta_Auditorias();
        $data->Consulta_Auditoria_Entradas();
        $data->Consulta_General();
        $filadata=$data->Devuelve_Consulta();
        $data->Consulta_Paginador();
        $num_total_registros = $data->Devuelve_Contador();

        if($num_total_registros>=1)
        {
          ?>
          <?php foreach ($filadata as $row1): ?>
            <tr align='center'>
              <td><?php echo ucwords($row1['fec_pro']); ?></td>
              <td><?php echo ucwords($row1['hor_pro']); ?></td>
              <td><?php echo ucwords($row1['nom_mot']); ?></td>
              <td><?php echo ucwords($row1['ced_per']); ?></td>
              <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']);?></td>
              <td><?php echo ucwords($row1['nom_aci']); ?></td>
              <td><?php echo ucwords($row1['lug_aud']); ?></td>
            </tr><!-- /TROW -->
          <?php endforeach ?>
          <?php
          echo ("
            </table>
            <table align='center'>
              <tr>
                <td align='center'>
          ");
        }
        else
        {
          ?>
            <tr align='center'>
              <td colspan='7'>No se encontraron registros</td>
            </tr>
          </table>
          <?php
        }
        ?>
        </table>
        <?php
      }
      if($a==2)
      {
        $data= new Consulta_Auditorias();
        $data->Consulta_Auditoria_Salidas();
        $data->Consulta_General();
        $filadata=$data->Devuelve_Consulta();
        $data->Consulta_Paginador();
        $num_total_registros = $data->Devuelve_Contador();

        if($num_total_registros>=1)
        {
          ?>
          <?php foreach ($filadata as $row1): ?>
            <tr align='center'>
              <td><?php echo ucwords($row1['fec_pro']); ?></td>
              <td><?php echo ucwords($row1['hor_pro']); ?></td>
              <td><?php echo ucwords($row1['nom_mot']); ?></td>
              <td><?php echo ucwords($row1['ced_per']); ?></td>
              <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']);?></td>
              <td><?php echo ucwords($row1['nom_aci']); ?></td>
              <td><?php echo ucwords($row1['lug_aud']); ?></td>
            </tr><!-- /TROW -->
          <?php endforeach ?>
          <?php
          echo ("
            </table>
            <table align='center'>
              <tr>
                <td align='center'>
          ");
        }
        else
        {
          ?>
            <tr align='center'>
              <td colspan='10'>No se encontraron registros</td>
            </tr>
          </table>
          <?php
        }
        ?>
        </table>
        <?php
      }
      if($a==3)
      {
        $data= new Consulta_Auditorias();
        $data->Consulta_Auditoria_Reportes();
        $data->Consulta_General();
        $filadata=$data->Devuelve_Consulta();
        $data->Consulta_Paginador();
        $num_total_registros = $data->Devuelve_Contador();

        if($num_total_registros>=1)
        {
          ?>
          <?php foreach ($filadata as $row1): ?>
            <tr align='center'>
              <td><?php echo ucwords($row1['fec_pro']); ?></td>
              <td><?php echo ucwords($row1['hor_pro']); ?></td>
              <td><?php echo ucwords($row1['nom_mot']); ?></td>
              <td><?php echo ucwords($row1['ced_per']); ?></td>
              <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']);?></td>
              <td><?php echo ucwords($row1['nom_aci']); ?></td>
              <td><?php echo ucwords($row1['lug_aud']); ?></td>
            </tr><!-- /TROW -->
          <?php endforeach ?>
          <?php
          echo ("
            </table>
            <table align='center'>
              <tr>
                <td align='center'>
          ");
        }
        else
        {
          ?>
            <tr align='center'>
              <td colspan='7'>No se encontraron registros</td>
            </tr>
          </table>
          <?php
        }
        ?>
        </table>
        <?php
      }
      if($a==4)
      {
        $data= new Consulta_Auditorias();
        $data->Consulta_Auditoria_Registros();
        $data->Consulta_General();
        $data->Consulta_Paginador();
        $num_total_registros = $data->Devuelve_Contador();
        $filadata=$data->Devuelve_Consulta();
        if($num_total_registros>=1)
        {
          foreach ($filadata as $row1)
          {
            ?>
            <tr align='center'>
              <td><?php echo ucwords($row1['fec_pro']);?></td>
              <td><?php echo ucwords($row1['hor_pro']);?></td>
              <td><?php echo ucwords($row1['nom_mot']);?></td>
              <td><?php echo ucwords($row1['afectado']);?></td>
              <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']);?></td>
              <td><?php echo ucwords($row1['nom_aci']);?></td>
              <td><?php echo ucwords($row1['lug_aud']);?></td>
              <td><?php echo ucwords($row1['autor']);?></td>
              <td><?php echo ucwords($row1['usu_acc']);?></td>
            </tr>
            <?php
          }
          echo ("
            </table>
            <table align='center'>
              <tr>
                <td align='center'>
          ");
        }
        else
        {
          ?>
            <tr align='center'>
              <td colspan='9'>No se encontraron registros</td>
            </tr>
          </table>
          <?php
        }
        ?>
        </table>
        <?php
      }
      if($a==5)
      {
        $data= new Consulta_Auditorias();
        $data->Consulta_Auditoria_Ediciones();
        $data->Consulta_General();
        $data->Consulta_Paginador();
        $num_total_registros = $data->Devuelve_Contador();
        $filadata=$data->Devuelve_Consulta();
        if($num_total_registros>=1)
        {
          foreach ($filadata as $row1)
          {
            ?>
            <tr align='center'>
              <td><?php echo ucwords($row1['fec_pro']);?></td>
              <td><?php echo ucwords($row1['hor_pro']);?></td>
              <td><?php echo ucwords($row1['nom_mot']);?></td>
              <td><?php echo ucwords($row1['afectado']);?></td>
              <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']);?></td>
              <td><?php echo ucwords($row1['nom_aci']);?></td>
              <td><?php echo ucwords($row1['lug_aud']);?></td>
              <td><?php echo ucwords($row1['autor']);?></td>
              <td><?php echo ucwords($row1['usu_acc']);?></td>
              <td><?php echo ucwords($row1['hab_aud']);?></td>
              <td><?php echo ucwords($row1['edi_aud']);?></td>
              <td><?php echo ucwords($row1['obs_aud']);?></td>
            </tr>
            <?php
          }
          echo ("
            </table>
            <table align='center'>
              <tr>
                <td align='center'>
          ");
        }
        else
        {
          ?>
            <tr align='center'>
              <td colspan='12'>No se encontraron registros</td>
            </tr>
          </table>
          <?php
        }
        ?>
        </table>
        <?php
      }
    ?>
    <div class="letterhead" style="margin-bottom:80px;">
      <table border="0" width="100%">
        <tr>
          <td align="center">
            <div class="text">
              <br><br>
              ¡CHAVEZ VIVE… LA PATRIA SIGUE!<br>
              “INDEPENDENCIA Y PATRIA SOCIALISTA… VIVIREMOS Y VENCEREMOS”<br>
              LA FORTUNA AYUDA A LOS AUDACES
              <strong style="font-size:20px;"></strong>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </tbody>
</table>
</div>
<script>
    $(document).ready(function ()
    {
        $("#btnExport").click(function ()
        {
            $("#tblExport").btechco_excelexport(
                {
                    containerid: "tblExport", datatype: $datatype.Table
                });
        });
    });
    function imprimir()
    {
      window.print();
    }
</script>
</body>
</html>
