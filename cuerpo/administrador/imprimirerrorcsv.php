<?php
  error_reporting(0);
  session_start();
  if($_SESSION['rol']== 1 || $_SESSION['rol']==2)
  {
	 if($_SESSION['rol']==2)
	 {
	   $permi=1;
	 }
	 else
	 {
	   $permi=0;
	 }
  }
  else
  {
	 header('Location: ../logeo/login.php');
	 exit();
  }
  include_once("../../clases/registros.php");
  include_once("../../clases/consultas.php");
  $ced=$_SESSION['ced'];
  $modulo="Errores_CSV/Registro_Lista_Cadetes_PDF";
  $conadm= new Consulta_Personas();
  $conadm->Consulta_Cedula_Persona($ced);
  $conadm->Consulta_General();
  $filaconadm=$conadm->Devuelve_Consulta();
  $id_per=$filaconadm[0]['id_per'];
  $nombre=$filaconadm[0]['nom_per']." ".$filaconadm[0]['ape_per'];
  $fechanew=date('Y-m-d');
  $horanew=date('h:i:s');
  $conadm->Consulta_Paginador();
  $num_total_registros2=$conadm->Devuelve_Contador();
  if($num_total_registros2>=1)
  {
    $proceso= new Registro_Auditorias(); 
    $proceso->Registro_Proceso(3 , $id_per, $fechanew, $horanew);
    $proceso->Registro_General();
    $conproce= new Consulta_Auditorias();
    $conproce->Consulta_Auditoria_Proceso($id_per);
    $conproce->Consulta_General();
    $filaconproce=$conproce->Devuelve_Consulta();
    $id_pro=$filaconproce[0]['id_pro'];
    $auditoria= new Registro_Auditorias();
    $auditoria->Registro_Auditoria($id_pro, 5, $modulo);
    $auditoria->Registro_General();
  }
  $fecha=date('Y-m-d');
  if($_POST!=null)
  {
    $ecsv=$_POST["ecsv"];
  }
  if($_GET!=null)
  {
    $ecsv=$_GET["ecsv"];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reportes</title>
  <link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
  <link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
  <link href="../../img/icon/helmet.png" rel="shortcut icon" type="image/png"/> 
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
<br>
<center>
  <table>
    <tr>
      <td>
        <?php
          if($ecsv==1)
          {
            $volver="registros.php?registro=4";
            $irconsulta="consultas.php?registro=3";
          }
          elseif($ecsv==2)
          {
            $volver="carga_notas.php?registro=2";
            $irconsulta="consultas.php?registro=4";
          }
          elseif($ecsv==3)
          {
            $irconsulta="consultas.php?registro=3";
          }
          if($ecsv==3)
          {
          }
          else
          {
            ?>
            <form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $volver;?>">
              <button class="btn btn-primary" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
            </form>
            <?php
          }
        ?>
      </td>
      <td>
        <div style="display:block; text-align:center;">
          <!-- <input type="button" id="export" value="Generar Archivo" />-->
          <button  class="btn btn-primary" onclick="imprimir()"> PDF</button>
        </div>
      </td>
      <td>
        <form data-ajax='false' id='ForConCad' name='ForConCad' method='post' action="<?php echo $irconsulta;?>">
          <button class="btn btn-primary" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-search"></span> Consultar</button>
        </form>
      </td>
    </tr>
  </table>
</center>
<br>
<div class="consulta" id="consulta">
  <!--<table id='tblExport' class="table table-bordered">-->
  <div class="panel-heading">
    <h3 class="panel-title" align="center"><strong>Reporte del Modulo de errores del CSV  de la fecha <?php echo $fecha; ?> y Hora <?php echo $horanew;?></strong></h3>
  </div>
  <table class="table table-bordered" align="center">
    <thead>
      <?php
        if($ecsv==1 || $ecsv==3)
        {
          ?>
          <tr>
            <th align='center'>
              <strong>N°</strong>
            </th>
            <th align='center'>
              <strong>Cédula</strong>
            </th>
            <th align='center'>
              <strong>Matrícula</strong>
            </th>
            <th align='center'>
              <strong>Nombre</strong>
            </th>
            <th align='center'>
              <strong>Apellido</strong>
            </th>
            <th align='center'>
              <strong>Jerarquía</strong>
            </th>
            <th align='center'>
              <strong>Academia</strong>
            </th>
            <th align='center'>
              <strong>Compañia</strong>
            </th>
            <th align='center'>
              <strong>Sexo</strong>
            </th>
            <th align='center'>
              <strong>Error</strong>
            </th>
          </tr>
          <?php
        }
        elseif($ecsv==2)
        {
          ?>
          <tr>
            <th align='center'>
              <strong>N°</strong>
            </th>
            <th align='center'>
              <strong>Cédula</strong>
            </th>
            <th align='center'>
              <strong>Cancha</strong>
            </th>
            <th align='center'>
              <strong>Calificación</strong>
            </th>
            <th align='center'>
              <strong>Error</strong>
            </th>
          </tr>
          <?php
        }
      ?>
    </thead>
    <tbody>
      <?php
        if($_POST!=null)
        {
          $error=$_POST['error'];
        }
        if($error==null)
        {
          if($ecsv==1 || $ecsv==3)
          {
            $error="
              <tr>
                <td colspan='8'>
                  No existen errores
                <td>
              <tr>
            ";
          }
          elseif($ecsv==2)
          {
            $error="
              <tr>
                <td colspan='4'>
                  No existen errores
                <td>
              <tr>
            ";
          }
        }
        else
        {
          echo $error;  
        }
        session_start();
        $cedula=$_SESSION['ced'];
        $conadm= new Consulta_Personas();
        $conadm->Consulta_Cedula_Persona($cedula);
        $conadm->Consulta_General();
        $filaconadm=$conadm->Devuelve_Consulta();
        $nombre=$filaconadm[0]['nom_per'];
        list($nombre1, $nombre2)=explode(" ",$nombre);
        $apellido=$filaconadm[0]['ape_per'];
        list($apellido1, $apellido2)=explode(" ",$apellido);

        $data=new Consulta_personas();
        $data->Consulta_Jefe_Departamento();
        $data->Consulta_General();
        $filadata=$data->Devuelve_Consulta();
        $data->Consulta_Paginador();
        $num_total_registros = $data->Devuelve_Contador();
        if($num_total_registros>=1)
        {
          $cargo=strtoupper($filadata[0]['car_jef']);
          $jerarquia_jefe=$filadata[0]['nom_jer'];
          $nombre_jefe=strtoupper($filadata[0]['nom_per'])." ".strtoupper($filadata[0]['ape_per']);
          $jefe=1;
        }
        else
        {
          $jefe=2;
          $resultado_jefe="No hay un jefe asignado";
        }
      ?>
      <div class="letterhead" style="margin-bottom:80px;">
        <table border="0" width="100%">
          <tr>
            <td align="center">
              <div class="text">
                <br><br><br><br><br><br>
                <?php
                  if($jefe==1)
                  {
                    echo $nombre_jefe."<br>".$jerarquia_jefe."<br>".$cargo."<br><br>";
                  }
                  else
                  {
                    echo $resultado_jefe."<br><br>";
                  }
                ?>
                ¡CHÁVEZ VIVE… LA PATRIA SIGUE!<br>
                “INDEPENDENCIA Y PATRIA SOCIALISTA… VIVIREMOS Y VENCEREMOS”<br>
                LA FORTUNA AYUDA A LOS AUDACES
                <strong style="font-size:20px;"></strong>
              </div>
            </td>
          </tr>
          <tr>
            <td align="center" colspan='2'>
              <div class="left">
                <br><br><br>
                <?php
                  echo strtoupper($nombre1[0]).strtoupper($nombre2[0]).strtoupper($apellido1[0]).strtoupper($apellido2[0]);
                ?>
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
<script src="../../js/jquery-3.1.1.min.js"></script>
<script src="../../js/bootstrap.js"></script>
</body>
</html>
