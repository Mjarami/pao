<?php
error_reporting(0);
session_start();
if($_SESSION['rol']== 1 || $_SESSION['rol']==2 || $_SESSION['rol']==4)
{
	if($_SESSION['rol']==2 || $_SESSION['rol']==4)
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
include_once("../../clases/consultas.php");
include_once("../../clases/javascript.php");
$a=$_GET["auditar"];
$fecha=date('Y-m-d');
if($a==1 || $a==2 || $a==3)
{
  $Reporte="Modulo de Consultas";
  if($a==1)
  {
    $titu='Administradores';
  }
  if($a==2)
  {
    $titu='Operadores';
  }
  if($a==3)
  {
    $titu='Cadetes';
  }

}
if($a==4 || $a==5 || $a==10 || $a==11)
{
   $Reporte="Modulo de Calificaciones";
}
if($a==6 || $a==7 || $a==8 || $a==9)
{
   $Reporte="Modulo de Sistema";
   if($a==6)
  {
    $titu='Academias';
  }
   if($a==7)
  {
    $titu='Canchas';
  }
  if($a==8)
  {
    $titu='Compañias';
  }
  if($a==9)
  {
    $titu='Jerarquías';
  }
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

<div style="display:block; text-align:center;">
    <!-- <input type="button" id="export" value="Generar Archivo" />-->
    <button  class="btn btn-primary" onclick="imprimir()">Reporte del <?php echo $Reporte; ?>  de la fecha <?php echo $fecha; ?></button>
</div>
<br>

<div class="consulta" id="consulta">
  <!--<table id='tblExport' class="table table-bordered">-->
  <?php
    if($a==1)
    {
      ?>
      <div class="panel-heading">
        <h3 class="panel-title" align="center"><strong><?php echo $titu;?></strong></h3>
      </div>
      <table class="table table-bordered" align="center">
        <tr align='center'>
          <td>
            <strong>Rol</strong>
          </td>
          <td>
            <strong>Academia</strong>
          </td>
          <td>
            <strong>Jerarquía</strong>
          </td>
          <td>
            <strong>Sexo</strong>
          </td>
          <td>
            <strong>Cédula</strong>
          </td>
          <td>
            <strong>Nombre</strong>
          </td>
          <td>
            <strong>Usuario</strong>
          </td>
        </tr>
        <?php
    }

    if($a==2)
    {
      ?>
      <div class="panel-heading">
        <h3 class="panel-title" align="center"><strong><?php echo $titu;?></strong></h3>
      </div>
      <table class="table table-bordered" align="center">
        <tr align='center'>
          <td>
            <strong>Rol</strong>
          </td>
          <td>
            <strong>Academia</strong>
          </td>
          <td>
            <strong>Jerarquía</strong>
          </td>
          <td>
            <strong>Sexo</strong>
          </td>
          <td>
            <strong>Cédula</strong>
          </td>
          <td>
            <strong>Nombre</strong>
          </td>
          <td>
            <strong>Usuario</strong>
          </td>
        </tr>
        <?php
    }

    if($a==3)
    {
      $consurc=$_GET["consurc"];
      $academiac=$_GET["academiac"];
      $companiac=$_GET["companiac"];
      $jerarquiac=$_GET["jerarquiac"];
      $ano=$_GET["anoc"];
      $sexoc=$_GET["sexoc"];
      $estatusc=$_GET["estatusc"];
      $data=new Consulta_academias();
      $data->Consulta_Nombre_Academia($academiac);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $academia=$filadatabus[0]['nom_aca'];
      $data=new Consulta_companias();
      $data->Consulta_Nombre_Compania($companiac);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $compania=$filadatabus[0]['nom_com'];
      $data=new Consulta_jerarquias();
      $data->Consulta_Nombre_Jerarquia($jerarquiac);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $jerarquia=$filadatabus[0]['nom_jer'];
      $data=new Consulta_sexos();
      $data->Consulta_Nombre_Sexo($sexoc);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $sexo=$filadatabus[0]['nom_sex'];
      $data=new Consulta_estatus();
      $data->Consulta_Nombre_Estatus($estatusc);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $estatus=$filadatabus[0]['nom_est'];
      if($consurc==1)
      {
        $tituconsurc='Academia: '.$academia;
      }
      elseif($consurc==2)
      {
        $tituconsurc='Compañia: '.$compania;
      }
      elseif($consurc==3)
      {
        $tituconsurc='Jerarquía: '.$jerarquia;
      }
      elseif($consurc==4)
      {
        $tituconsurc='Año: '.$ano;
      }
      elseif($consurc==5)
      {
        $tituconsurc='Sexo: '.$sexo;
      }
      elseif($consurc==6)
      {
        $tituconsurc='Estatus: '.$estatus;
      }
      elseif($consurc==7)
      {
        $tituconsurc='Academia: '.$academia.' y Compañia: '.$compania;
      }
      elseif($consurc==8)
      {
        $tituconsurc='Academia: '.$academia.' y Jerarquía: '.$jerarquia;
      }
      elseif($consurc==9)
      {
        $tituconsurc='Academia: '.$academia.' y Año: '.$ano;
      }
      elseif($consurc==10)
      {
        $tituconsurc='Academia: '.$academia.' y Sexo: '.$sexo;
      }
      elseif($consurc==11)
      {
        $tituconsurc='Academia: '.$academia.' y Estatus: '.$estatus;
      }
      elseif($consurc==12)
      {
        $tituconsurc='Compañia: '.$compania.' y Jerarquía: '.$jerarquia;
      }
      elseif($consurc==13)
      {
        $tituconsurc='Compañia: '.$compania.' y Año: '.$ano;
      }
      elseif($consurc==14)
      {
        $tituconsurc='Compañia: '.$compania.' y Sexo: '.$sexo;
      }
      elseif($consurc==15)
      {
        $tituconsurc='Jerarquía: '.$jerarquia.' y Sexo: '.$sexo;
      }
      elseif($consurc==16)
      {
        $tituconsurc='Año: '.$ano.' y Sexo: '.$sexo;
      }
      elseif($consurc==17)
      {
        $tituconsurc='Academia: '.$academia.', Compañia: '.$compania.' y Jerarquía: '.$jerarquia;
      }
      elseif($consurc==18)
      {
        $tituconsurc='Academia: '.$academia.', Compañia: '.$compania.' y Año: '.$ano;
      }
      elseif($consurc==19)
      {
        $tituconsurc='Academia: '.$academia.', Compañia: '.$compania.' y Sexo: '.$sexo;
      }
      elseif($consurc==20)
      {
        $tituconsurc='Academia: '.$academia.', Jerarquía: '.$jerarquia.' y Sexo: '.$sexo;
      }
      elseif($consurc==21)
      {
        $tituconsurc='Academia: '.$academia.', Año: '.$ano.' y Sexo: '.$sexo;
      }
      elseif($consurc==22)
      {
        $tituconsurc='Compañia: '.$compania.', Jerarquía: '.$jerarquia.' y Sexo: '.$sexo;
      }
      elseif($consurc==23)
      {
        $tituconsurc='Compañia: '.$compania.', Año: '.$ano.' y Sexo: '.$sexo;
      }
      elseif($consurc==24)
      {
        $tituconsurc='Academia: '.$academia.', Compañia: '.$compania.', Jerarquía: '.$jerarquia.' y Sexo: '.$sexo;
      }
      elseif($consurc==25)
      {
        $tituconsurc='Academia: '.$academia.', Compañia: '.$compania.', Año: '.$ano.' y Sexo: '.$sexo;
      }
      ?>
      <div class="panel-heading">
        <h3 class="panel-title" align="center"><strong><?php echo $titu;?></strong></h3>
        <h3 class="panel-title" align="center"><strong><?php echo $tituconsurc;?></strong></h3>
      </div>
      <table class="table table-bordered" align="center">
        <tr align='center'>
          <td>
            <strong>Rol</strong>
          </td>
          <td>
            <strong>Cédula</strong>
          </td>
          <td>
            <strong>Matrícula</strong>
          </td>
          <td>
            <strong>Nombre</strong>
          </td>
          <td>
            <strong>Jerarquía</strong>
          </td>
          <td>
            <strong>Academia</strong>
          </td>
          <td>
            <strong>Compañia</strong>
          </td>
          <td>
            <strong>Sexo</strong>
          </td>  
        </tr>
        <?php
    }

    if($a==4)
    {
      $data=new Consulta_academias();
      $data->Consulta_Nombre_Academia($_GET['academias']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $busaca=$filadatabus[0]['nom_aca'];

      $data=new Consulta_Canchas();
      $data->Consulta_Nombre_Cancha($_GET['canchas']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $buscan=$filadatabus[0]['nom_can'];

      $data=new Consulta_sexos();
      $data->Consulta_Nombre_Sexo($_GET['sexos']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $bussex=$filadatabus[0]['nom_sex'];

      $data=new Consulta_companias();
      $data->Consulta_Nombre_Compania($_GET['companias']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $buscom=$filadatabus[0]['nom_com'];

      $data=new Consulta_jerarquias();
      $data->Consulta_Nombre_Jerarquia($_GET['jerarquias']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $busjer=$filadatabus[0]['nom_jer'];

      $consur=$_GET["consur"];
      if($consur==0)
      {
          $titu="Orden de Mérito";
      }
      else if($consur==1)
      {
          $titu="Por Academia ".$busaca;
      }
      else if($consur==2)
      {
          $titu="Por Cancha ".$buscan;
      }
      else if($consur==3)
      {
          $titu="Por Sexo ".$bussex;
      }
      else if($consur==4)
      {
          $titu="Por Compañia ".$buscom;
      }
      else if($consur==5)
      {
          $titu="Por Jerarquía ".$busjer;
      }
      else if($consur==6)
      {
          $titu="Por Academia ".$busaca." y Cancha ".$buscan;
      }
      else if($consur==7)
      {
          $titu="Por Academia ".$busaca." y Sexo ".$bussex;
      }
      else if($consur==8)
      {
          $titu="Por Academia ".$busaca." y Compañia ".$buscom;
      }
      else if($consur==9)
      {
          $titu="Por Academia ".$busaca." y Jerarquía ".$busjer;
      }
      else if($consur==10)
      {
          $titu="Por Cancha ".$buscan." y Sexo ".$bussex;
      }
      else if($consur==11)
      {
          $titu="Por Cancha ".$buscan." y Compañia ".$buscom;
      }
      else if($consur==12)
      {
          $titu="Por Cancha ".$buscan." y Jerarquía ".$busjer;
      }
      else if($consur==13)
      {
          $titu="Por Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==14)
      {
          $titu="Por Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==15)
      {
          $titu="Por Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==16)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan." y Sexo ".$bussex;
      }
      else if($consur==17)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan." y Compañia ".$buscom;
      }
      else if($consur==18)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan." y Jerarquía ".$busjer;
      }
      else if($consur==19)
      {
          $titu="Por Academia ".$busaca.", Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==20)
      {
          $titu="Por Academia ".$busaca.", Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==21)
      {
          $titu="Por Cancha ".$buscan.", Compañia ".$buscom." y Compañia ".$buscom;
      }
      else if($consur==22)
      {
          $titu="Por Cancha ".$buscan.", Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==23)
      {
          $titu="Por Cancha ".$buscan.", Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==24)
      {
          $titu="Por Cancha ".$buscan.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==25)
      {
          $titu="Por Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==26)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==27)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==28)
      {
          $titu="Por Academia ".$busaca.", Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==29)
      {
          $titu="Por Cancha ".$buscan.", Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==30)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==31)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      ?>
      <div class="panel-heading">
        <h3 class="panel-title" align="center"><strong><?php echo $titu;?></strong></h3>
      </div>
      <table class="table table-bordered" align="center">
        <tr align='center'>
          <td>
            <strong>N°</strong>
          </td>
          <td>
            <strong>Academia</strong>
          </td>
          <td>
            <strong>Compañia</strong>
          </td>
          <td>
            <strong>Jerarquía</strong>
          </td>
          <td>
            <strong>Sexo</strong>
          </td>
          <td>
            <strong>Cédula</strong>
          </td>
          <td>
            <strong>Matrícula</strong>
          </td>
          <td>
            <strong>Nombre</strong>
          </td>
          <td>
            <strong>Calificación</strong>
          </td>
        </tr>
      <?php
    }
	
	if($a==5)
    {
      $data=new Consulta_academias();
      $data->Consulta_Nombre_Academia($_GET['academias']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $busaca=$filadatabus[0]['nom_aca'];

      $data=new Consulta_Canchas();
      $data->Consulta_Nombre_Cancha($_GET['canchas']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $buscan=$filadatabus[0]['nom_can'];

      $data=new Consulta_sexos();
      $data->Consulta_Nombre_Sexo($_GET['sexos']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $bussex=$filadatabus[0]['nom_sex'];

      $data=new Consulta_companias();
      $data->Consulta_Nombre_Compania($_GET['companias']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $buscom=$filadatabus[0]['nom_com'];

      $data=new Consulta_jerarquias();
      $data->Consulta_Nombre_Jerarquia($_GET['jerarquias']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $busjer=$filadatabus[0]['nom_jer'];

      $consur=$_GET["consur"];
      if($consur==0)
      {
          $titu="Orden de Mérito";
      }
      else if($consur==1)
      {
          $titu="Por Academia ".$busaca;
      }
      else if($consur==2)
      {
          $titu="Por Cancha ".$buscan;
      }
      else if($consur==3)
      {
          $titu="Por Sexo ".$bussex;
      }
      else if($consur==4)
      {
          $titu="Por Compañia ".$buscom;
      }
      else if($consur==5)
      {
          $titu="Por Jerarquía ".$busjer;
      }
      else if($consur==6)
      {
          $titu="Por Academia ".$busaca." y Cancha ".$buscan;
      }
      else if($consur==7)
      {
          $titu="Por Academia ".$busaca." y Sexo ".$bussex;
      }
      else if($consur==8)
      {
          $titu="Por Academia ".$busaca." y Compañia ".$buscom;
      }
      else if($consur==9)
      {
          $titu="Por Academia ".$busaca." y Jerarquía ".$busjer;
      }
      else if($consur==10)
      {
          $titu="Por Cancha ".$buscan." y Sexo ".$bussex;
      }
      else if($consur==11)
      {
          $titu="Por Cancha ".$buscan." y Compañia ".$buscom;
      }
      else if($consur==12)
      {
          $titu="Por Cancha ".$buscan." y Jerarquía ".$busjer;
      }
      else if($consur==13)
      {
          $titu="Por Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==14)
      {
          $titu="Por Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==15)
      {
          $titu="Por Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==16)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan." y Sexo ".$bussex;
      }
      else if($consur==17)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan." y Compañia ".$buscom;
      }
      else if($consur==18)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan." y Jerarquía ".$busjer;
      }
      else if($consur==19)
      {
          $titu="Por Academia ".$busaca.", Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==20)
      {
          $titu="Por Academia ".$busaca.", Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==21)
      {
          $titu="Por Academia ".$busaca.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==22)
      {
          $titu="Por Cancha ".$buscan.", Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==23)
      {
          $titu="Por Cancha ".$buscan.", Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==24)
      {
          $titu="Por Cancha ".$buscan.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==25)
      {
          $titu="Por Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==26)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==27)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==28)
      {
          $titu="Por Academia ".$busaca.", Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==29)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==30)
      {
          $titu="Por Cancha ".$buscan.", Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==31)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      ?>
      <div class="panel-heading">
        <h3 class="panel-title" align="center"><strong><?php echo $titu;?></strong></h3>
      </div>
      <table class="table table-bordered" align="center">
        <tr align='center'>
          <td>
            <strong>Academia</strong>
          </td>
          <td>
            <strong>Compañia</strong>
          </td>
          <td>
            <strong>Jerarquía</strong>
          </td>
          <td>
            <strong>Sexo</strong>
          </td>
          <td>
            <strong>Cédula</strong>
          </td>
          <td>
            <strong>Matrícula</strong>
          </td>
          <td>
            <strong>Nombre</strong>
          </td>
          <td>
            <strong>Cancha</strong>
          </td>
          <td>
            <strong>Calificación</strong>
          </td>
        </tr>
      <?php
    }

    if($a==6)
    {
      ?>
      <div class="panel-heading">
        <h3 class="panel-title" align="center"><strong><?php echo $titu;?></strong></h3>
      </div>
      <table class="table table-bordered" align="center">
        <tr align='center'>
          <td>
            <strong>Id</strong>
          </td>
          <td>
            <strong>Academia</strong>
          </td>
        </tr>
        <?php
    }

    if($a==7)
    {
      ?>
      <div class="panel-heading">
        <h3 class="panel-title" align="center"><strong><?php echo $titu;?></strong></h3>
      </div>
      <table class="table table-bordered" align="center">
        <tr align='center'>
          <td>
            <strong>Id</strong>
          </td>
          <td>
            <strong>Cancha</strong>
          </td>
        </tr>
        <?php
    }

    if($a==8)
    {
      ?>
      <div class="panel-heading">
        <h3 class="panel-title" align="center"><strong><?php echo $titu;?></strong></h3>
      </div>
      <table class="table table-bordered" align="center">
        <tr align='center'>
          <td>
            <strong>Id</strong>
          </td>
          <td>
            <strong>Compañia</strong>
          </td>
        </tr>
        <?php
    }

    if($a==9)
    {
      ?>
      <div class="panel-heading">
        <h3 class="panel-title" align="center"><strong><?php echo $titu;?></strong></h3>
      </div>
      <table class="table table-bordered" align="center">
        <tr align='center'>
          <td>
            <strong>Id</strong>
          </td>
          <td>
            <strong>Jerarquía</strong>
          </td>
        </tr>
        <?php
    }

    if($a==10)
    {
      $data=new Consulta_academias();
      $data->Consulta_Nombre_Academia($_GET['academias']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $busaca=$filadatabus[0]['nom_aca'];

      $data=new Consulta_Canchas();
      $data->Consulta_Nombre_Cancha($_GET['canchas']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $buscan=$filadatabus[0]['nom_can'];

      $data=new Consulta_sexos();
      $data->Consulta_Nombre_Sexo($_GET['sexos']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $bussex=$filadatabus[0]['nom_sex'];

      $data=new Consulta_companias();
      $data->Consulta_Nombre_Compania($_GET['companias']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $buscom=$filadatabus[0]['nom_com'];

      $data=new Consulta_jerarquias();
      $data->Consulta_Nombre_Jerarquia($_GET['jerarquias']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $busjer=$filadatabus[0]['nom_jer'];

      $consur=$_GET["consur"];
      if($consur==0)
      {
          $titu="Orden de Mérito";
      }
      else if($consur==1)
      {
          $titu="Por Academia ".$busaca;
      }
      else if($consur==2)
      {
          $titu="Por Cancha ".$buscan;
      }
      else if($consur==3)
      {
          $titu="Por Sexo ".$bussex;
      }
      else if($consur==4)
      {
          $titu="Por Compañia ".$buscom;
      }
      else if($consur==5)
      {
          $titu="Por Jerarquía ".$busjer;
      }
      else if($consur==6)
      {
          $titu="Por Academia ".$busaca." y Cancha ".$buscan;
      }
      else if($consur==7)
      {
          $titu="Por Academia ".$busaca." y Sexo ".$bussex;
      }
      else if($consur==8)
      {
          $titu="Por Academia ".$busaca." y Compañia ".$buscom;
      }
      else if($consur==9)
      {
          $titu="Por Academia ".$busaca." y Jerarquía ".$busjer;
      }
      else if($consur==10)
      {
          $titu="Por Cancha ".$buscan." y Sexo ".$bussex;
      }
      else if($consur==11)
      {
          $titu="Por Cancha ".$buscan." y Compañia ".$buscom;
      }
      else if($consur==12)
      {
          $titu="Por Cancha ".$buscan." y Jerarquía ".$busjer;
      }
      else if($consur==13)
      {
          $titu="Por Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==14)
      {
          $titu="Por Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==15)
      {
          $titu="Por Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==16)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan." y Sexo ".$bussex;
      }
      else if($consur==17)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan." y Compañia ".$buscom;
      }
      else if($consur==18)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan." y Jerarquía ".$busjer;
      }
      else if($consur==19)
      {
          $titu="Por Academia ".$busaca.", Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==20)
      {
          $titu="Por Academia ".$busaca.", Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==21)
      {
          $titu="Por Academia ".$busaca.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==22)
      {
          $titu="Por Cancha ".$buscan.", Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==23)
      {
          $titu="Por Cancha ".$buscan.", Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==24)
      {
          $titu="Por Cancha ".$buscan.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==25)
      {
          $titu="Por Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==26)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==27)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==28)
      {
          $titu="Por Academia ".$busaca.", Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==29)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==30)
      {
          $titu="Por Cancha ".$buscan.", Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==31)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      ?>
      <div class="panel-heading">
        <h3 class="panel-title" align="center"><strong><?php echo $titu;?></strong></h3>
      </div>
      <table class="table table-bordered" align="center">
        <tr align='center'>
          <td>
            <strong>Academia</strong>
          </td>
          <td>
            <strong>Compañia</strong>
          </td>
          <td>
            <strong>Jerarquía</strong>
          </td>
          <td>
            <strong>Sexo</strong>
          </td>
          <td>
            <strong>Cédula</strong>
          </td>
          <td>
            <strong>Matrícula</strong>
          </td>
          <td>
            <strong>Nombre</strong>
          </td>
          <td>
            <strong>Cancha</strong>
          </td>
          <td>
            <strong>Calificación</strong>
          </td>
        </tr>
      <?php
    }

    if($a==11)
    {
      $data=new Consulta_academias();
      $data->Consulta_Nombre_Academia($_GET['academias']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $busaca=$filadatabus[0]['nom_aca'];

      $data=new Consulta_Canchas();
      $data->Consulta_Nombre_Cancha($_GET['canchas']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $buscan=$filadatabus[0]['nom_can'];

      $data=new Consulta_sexos();
      $data->Consulta_Nombre_Sexo($_GET['sexos']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $bussex=$filadatabus[0]['nom_sex'];

      $data=new Consulta_companias();
      $data->Consulta_Nombre_Compania($_GET['companias']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $buscom=$filadatabus[0]['nom_com'];

      $data=new Consulta_jerarquias();
      $data->Consulta_Nombre_Jerarquia($_GET['jerarquias']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $busjer=$filadatabus[0]['nom_jer'];

      $consur=$_GET["consur"];
      if($consur==0)
      {
          $titu="Por Cédula";
      }
      else if($consur==1)
      {
          $titu="Por Academia ".$busaca;
      }
      else if($consur==2)
      {
          $titu="Por Cancha ".$buscan;
      }
      else if($consur==3)
      {
          $titu="Por Sexo ".$bussex;
      }
      else if($consur==4)
      {
          $titu="Por Compañia ".$buscom;
      }
      else if($consur==5)
      {
          $titu="Por Jerarquía ".$busjer;
      }
      else if($consur==6)
      {
          $titu="Por Academia ".$busaca." y Cancha ".$buscan;
      }
      else if($consur==7)
      {
          $titu="Por Academia ".$busaca." y Sexo ".$bussex;
      }
      else if($consur==8)
      {
          $titu="Por Academia ".$busaca." y Compañia ".$buscom;
      }
      else if($consur==9)
      {
          $titu="Por Academia ".$busaca." y Jerarquía ".$busjer;
      }
      else if($consur==10)
      {
          $titu="Por Cancha ".$buscan." y Sexo ".$bussex;
      }
      else if($consur==11)
      {
          $titu="Por Cancha ".$buscan." y Compañia ".$buscom;
      }
      else if($consur==12)
      {
          $titu="Por Cancha ".$buscan." y Jerarquía ".$busjer;
      }
      else if($consur==13)
      {
          $titu="Por Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==14)
      {
          $titu="Por Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==15)
      {
          $titu="Por Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==16)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan." y Sexo ".$bussex;
      }
      else if($consur==17)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan." y Compañia ".$buscom;
      }
      else if($consur==18)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan." y Jerarquía ".$busjer;
      }
      else if($consur==19)
      {
          $titu="Por Academia ".$busaca.", Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==20)
      {
          $titu="Por Academia ".$busaca.", Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==21)
      {
          $titu="Por Academia ".$busaca.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==22)
      {
          $titu="Por Cancha ".$buscan.", Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==23)
      {
          $titu="Por Cancha ".$buscan.", Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==24)
      {
          $titu="Por Cancha ".$buscan.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==25)
      {
          $titu="Por Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==26)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Sexo ".$bussex." y Compañia ".$buscom;
      }
      else if($consur==27)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Sexo ".$bussex." y Jerarquía ".$busjer;
      }
      else if($consur==28)
      {
          $titu="Por Academia ".$busaca.", Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==29)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==30)
      {
          $titu="Por Cancha ".$buscan.", Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      else if($consur==31)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Sexo ".$bussex.", Compañia ".$buscom." y Jerarquía ".$busjer;
      }
      ?>
      <div class="panel-heading">
        <h3 class="panel-title" align="center"><strong><?php echo $titu;?></strong></h3>
      </div>
      <table class="table table-bordered" align="center">
        <tr align='center'>
          <td>
            <strong>Academia</strong>
          </td>
          <td>
            <strong>Compañia</strong>
          </td>
          <td>
            <strong>Jerarquía</strong>
          </td>
          <td>
            <strong>Sexo</strong>
          </td>
          <td>
            <strong>Cédula</strong>
          </td>
          <td>
            <strong>Matrícula</strong>
          </td>
          <td>
            <strong>Nombre</strong>
          </td>
          <td>
            <strong>Cancha</strong>
          </td>
          <td>
            <strong>Calificación</strong>
          </td>
        </tr>
      <?php
    }
  ?>
  <tbody>
    <?php
      if($a==1)
      {
        $data= new Consulta_Personas();
        $data->Consulta_Personas_Rol_Administrador();
        $data->Consulta_General();
        $filadata=$data->Devuelve_Consulta();
        $data->Consulta_Paginador();
        $num_total_registros = $data->Devuelve_Contador();

        if($num_total_registros>=1)
        {
          foreach ($filadata as $row1)
          {
            ?>
            <tr align='center'>
              <td><?php echo ucwords($row1['nom_rol']); ?></td>
              <td><?php echo ucwords($row1['nom_aca']); ?></td>
              <td><?php echo ucwords($row1['nom_jer']); ?></td>
              <td><?php echo ucwords($row1['nom_sex']); ?></td>
              <td><?php echo $row1['ced_per']; ?></td>
              <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']).""; ?></td>
              <td><?php echo ($row1['usu_acc']); ?></td>
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
        $data= new Consulta_Personas();
        $data->Consulta_personas_Rol_Asistente();
        $data->Consulta_General();
        $filadata=$data->Devuelve_Consulta();
        $data->Consulta_Paginador();
        $num_total_registros = $data->Devuelve_Contador();

        if($num_total_registros>=1)
        {
          foreach ($filadata as $row1)
          {
            ?>
            <tr align='center'>
              <td><?php echo ucwords($row1['nom_rol']); ?></td>
              <td><?php echo ucwords($row1['nom_aca']); ?></td>
              <td><?php echo ucwords($row1['nom_jer']); ?></td>
              <td><?php echo ucwords($row1['nom_sex']); ?></td>
              <td><?php echo $row1['ced_per']; ?></td>
              <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']).""; ?></td>
              <td><?php echo ucwords($row1['usu_acc']); ?></td>
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
              <td colspan='8'>No se encontraron registros</td>
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
		    if($_GET['buscando']!=null)
        {
          $buscando=$_GET['buscando'];
          $data= new Consulta_Personas();
        	$data->Consulta_personas_Rol_Participante_Buscador($buscando);
        	$data->Consulta_General();
        	$filadata=$data->Devuelve_Consulta();
        	$data->Consulta_Paginador();
        	$num_total_registros = $data->Devuelve_Contador();
		    }
        elseif($consurc==1)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Transcriptor($academia);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias($academia);  
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==2)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Companias_Transcriptor($compania);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Companias($compania);  
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==3)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Jerarquias_Transcriptor($jerarquia);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Jerarquias($jerarquia);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==4)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Anos_Transcriptor($ano);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Anos($ano);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==5)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Sexos_Transcriptor($sexo);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Sexos($sexo);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==6)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Estatus_Transcriptor($estatus);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Estatus($estatus);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==7)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Transcriptor($academia, $compania);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias($academia, $compania);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==8)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Jerarquias_Transcriptor($academia, $jerarquia);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Jerarquias($academia, $jerarquia);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==9)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Anos_Transcriptor($academia, $ano);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Anos($academia, $ano);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==10)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Sexos_Transcriptor($academia, $sexo);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Sexos($academia, $sexo);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==11)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Estatus_Transcriptor($academia, $estatus);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Estatus($academia, $estatus);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==12)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Companias_Jerarquias_Transcriptor($compania, $jerarquia);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Companias_Jerarquias($compania, $jerarquia);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==13)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Companias_Anos_Transcriptor($compania, $ano);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Companias_Anos($compania, $ano);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==14)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Companias_Sexos_Transcriptor($compania, $sexo);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Companias_Sexos($compania, $sexo);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==15)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Jerarquias_Sexos_Transcriptor($jerarquia, $sexo);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Jerarquias_Sexos($jerarquia, $sexo);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==16)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Anos_Sexos_Transcriptor($ano, $sexo);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Anos_Sexos($ano, $sexo);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==17)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Jerarquias_Transcriptor($academia, $compania, $jerarquia);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Jerarquias($academia, $compania, $jerarquia);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==18)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Anos_Transcriptor($academia, $compania, $ano);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Anos($academia, $compania, $ano);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==19)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Sexos_Transcritor($academia, $compania, $sexo);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Sexos($academia, $compania, $sexo);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==20)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Jerarquias_Sexos_Transcriptor($academia, $jerarquia, $sexo);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Jerarquias_Sexos($academia, $jerarquia, $sexo);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==21)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Anos_Sexos_Transcriptor($academia, $ano, $sexo);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Anos_Sexos($academia, $ano, $sexo);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==22)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Companias_Jerarquias_Sexos_Transcriptor($compania, $jerarquia, $sexo);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Companias_Jerarquias_Sexos($compania, $jerarquia, $sexo);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==23)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Companias_Anos_Sexos_Transcriptor($compania, $ano, $sexo);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Companias_Anos_Sexos($compania, $ano, $sexo);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==24)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Jerarquias_Sexos_Transcriptor($academia, $compania, $jerarquia, $sexo);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Jerarquias_Sexos($academia, $compania, $jerarquia, $sexo);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        elseif($consurc==25)
        {
          $data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Anos_Sexos_Transcriptor($academia, $compania, $ano, $sexo);
          }
          else
          {
            $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Anos_Sexos($academia, $compania, $ano, $sexo);
          }
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
		    else
		    {
        	$data= new Consulta_Personas();
          if($_GET['transcriptor']==1)
          {
            $data->Consulta_personas_Rol_Participante_Transcriptor();
          }
          else
          {
            $data->Consulta_personas_Rol_Participante();
          }
        	$data->Consulta_General();
        	$filadata=$data->Devuelve_Consulta();
        	$data->Consulta_Paginador();
        	$num_total_registros = $data->Devuelve_Contador();
		    }

        if($num_total_registros>=1)
        {
          foreach ($filadata as $row1)
          {
            ?>
            <tr align='center'>
              <td><?php echo ucwords($row1['nom_rol']); ?></td>
              <td><?php echo $row1['ced_per']; ?></td>
              <td><?php echo $row1['mat_per']; ?></td>
              <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']).""; ?></td>
              <td><?php echo ucwords($row1['nom_jer']); ?></td>
              <td><?php echo ucwords($row1['nom_aca']); ?></td>
              <td><?php echo ucwords($row1['nom_com']); ?></td>
              <td><?php echo ucwords($row1['nom_sex']); ?></td>
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
        $academia=$_GET["academias"];
        $cancha=$_GET["canchas"];
        $sexo=$_GET["sexos"];
        $compania=$_GET["companias"];
        $jerarquia=$_GET["jerarquias"];

        $ncan= new Consulta_Evaluaciones();
        $ncan->Consulta_Tabla_General2('canchas');
        $ncan->Consulta_General();
        $ncan->Consulta_Paginador();
        $total_ncan=$ncan->Devuelve_Contador();

        if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia($academia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha($cancha, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Sexo($sexo, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Compania($compania, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Jerarquia($jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }

        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha($academia, $cancha, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Sexo($academia, $sexo, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Compania($academia, $compania, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Jerarquia($academia, $jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha_Sexo($cancha, $sexo, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha_Compania($cancha, $compania, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha_Jerarquia($cancha, $jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Sexo_Compania($sexo, $compania, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Sexo_Jerarquia($sexo, $jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Compania_Jerarquia($compania, $jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha_Sexo($academia, $cancha, $sexo, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha_Compania($academia, $cancha, $compania, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha_Jerarquia($academia, $cancha, $jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Sexo_Compania($academia, $sexo, $compania, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Sexo_Jerarquia($academia, $sexo, $jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Compania_Jerarquia($academia, $compania, $jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha_Sexo_Compania($cancha, $sexo, $compania, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha_Sexo_Jerarquia($cancha, $sexo, $jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha_Compania_Jerarquia($cancha, $compania, $jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Sexo_Compania_Jerarquia($sexo, $compania, $jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha_Sexo_Compania($academia, $cancha, $sexo, $compania, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha_Sexo_Jerarquia($academia, $cancha, $sexo, $jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Sexo_Compania_Jerarquia($academia, $sexo, $compania, $jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha_Sexo_Compania_Jerarquia($cancha, $sexo, $compania, $jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha_Compania_Jerarquia($academia, $cancha, $compania, $jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha_Sexo_Compania_Jerarquia($academia, $cancha, $sexo, $compania, $jerarquia, $total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_General($total_ncan);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        if($num_total_registros>=1)
        {
          
          $inicio=0;
          $primeros=$_GET["3primeros"];
          foreach ($filadata as $row1)
          {
            if($notaposicion==$row1['t_nota'])
            {
              $inicio=$inicio;
            }
            else
            {
              $inicio=$inicio+1;
            }
            $notaposicion=$row1['t_nota'];
            if($primeros==1)
            {
              $pri=$pri++;
              if($inicio>3)
              {
              }
              else
              {
                ?>
                <tr align='center'>
                  <td><?php echo $inicio; ?></td>
                  <td><?php echo ucwords($row1['nom_aca']); ?></td>
                  <td><?php echo ucwords($row1['nom_com']); ?></td>
                  <td><?php echo ucwords($row1['nom_jer']); ?></td>
                  <td><?php echo ucwords($row1['nom_sex']); ?></td>
                  <td><?php echo $row1['ced_per']; ?></td>
                  <td><?php echo $row1['mat_per']; ?></td>
                  <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']).""; ?></td>
                  <td><?php echo ucwords($row1['t_nota']); ?></td>
                </tr>
                <?php 
              }
            }
            else
            {
              ?>
              <tr align='center'>
                <td><?php echo $inicio; ?></td>
                <td><?php echo ucwords($row1['nom_aca']); ?></td>
                <td><?php echo ucwords($row1['nom_com']); ?></td>
                <td><?php echo ucwords($row1['nom_jer']); ?></td>
                <td><?php echo ucwords($row1['nom_sex']); ?></td>
                <td><?php echo $row1['ced_per']; ?></td>
                <td><?php echo $row1['mat_per']; ?></td>
                <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']).""; ?></td>
                <td><?php echo ucwords($row1['t_nota']); ?></td>
              </tr>
              <?php 
            }
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
              <td colspan='17'>No se encontraron registros</td>
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
        $academia=$_GET["academias"];
        $cancha=$_GET["canchas"];
        $sexo=$_GET["sexos"];
        $compania=$_GET["companias"];
        $jerarquia=$_GET["jerarquias"];

        if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_0($academia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha_0($cancha);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Sexo_0($sexo);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Compania_0($compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Jerarquia_0($jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha_0($academia, $cancha);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)

        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Sexo_0($academia, $sexo);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Compania_0($academia, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Jerarquia_0($academia, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha_Sexo_0($cancha, $sexo);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha_Compania_0($cancha, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha_Jerarquia_0($cancha, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Sexo_Compania_0($sexo, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Sexo_Jerarquia_0($sexo, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Compania_Jerarquia_0($compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha_Sexo_0($academia, $cancha, $sexo);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha_Compania_0($academia, $cancha, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha_Jerarquia_0($academia, $cancha, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Sexo_Compania_0($academia, $sexo, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Sexo_Jerarquia_0($academia, $sexo, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Compania_Jerarquia_0($academia, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha_Sexo_Compania_0($cancha, $sexo, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha_Sexo_Jerarquia_0($cancha, $sexo, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha_Compania_Jerarquia_0($cancha, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Sexo_Compania_Jerarquia_0($sexo, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha_Sexo_Compania_0($academia, $cancha, $sexo, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha_Sexo_Jerarquia_0($academia, $cancha, $sexo, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Sexo_Compania_Jerarquia_0($academia, $sexo, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha_Compania_Jerarquia_0($academia, $cancha, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Cancha_Sexo_Compania_Jerarquia_0($cancha, $sexo, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_por_Academia_Cancha_Sexo_Compania_Jerarquia_0($academia, $cancha, $sexo, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_General_0();
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        if($num_total_registros>=1)
        {
          foreach ($filadata as $row1)
          {
            ?>
            <tr align='center'>
              <td><?php echo ucwords($row1['nom_aca']); ?></td>
              <td><?php echo ucwords($row1['nom_com']); ?></td>
              <td><?php echo ucwords($row1['nom_jer']); ?></td>
              <td><?php echo ucwords($row1['nom_sex']); ?></td>
              <td><?php echo $row1['ced_per']; ?></td>
              <td><?php echo $row1['mat_per']; ?></td>
              <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']).""; ?></td>
              <td><?php echo ucwords($row1['nom_can']); ?></td>
              <td><?php echo ucwords($row1['not_eva']); ?></td>
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
              <td colspan='8'>No se encontraron registros</td>
            </tr>
          </table>
          <?php
        }
        ?>
        </table>
        <?php
      }

      if($a==6)
      {
        $data= new Consultas();
        $data->Consulta_Tabla_General2('academias');
        $data->Consulta_General();
        $filadata=$data->Devuelve_Consulta();
        $data->Consulta_Paginador();
        $num_total_registros = $data->Devuelve_Contador();

        if($num_total_registros>=1)
        {
          foreach ($filadata as $row1)
          {
            ?>
            <tr align='center'>
              <td><?php echo ucwords($row1['id_aca']); ?></td>
              <td><?php echo ucwords($row1['nom_aca']); ?></td>
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
              <td colspan='2'>No se encontraron registros</td>
            </tr>
          </table>
          <?php
        }
        ?>
        </table>
        <?php
      }

      if($a==7)
      {
        $data= new Consultas();
        $data->Consulta_Tabla_General2('canchas');
        $data->Consulta_General();
        $filadata=$data->Devuelve_Consulta();
        $data->Consulta_Paginador();
        $num_total_registros = $data->Devuelve_Contador();

        if($num_total_registros>=1)
        {
          foreach ($filadata as $row1)
          {
            ?>
            <tr align='center'>
              <td><?php echo ucwords($row1['id_can']); ?></td>
              <td><?php echo ucwords($row1['nom_can']); ?></td>
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
              <td colspan='2'>No se encontraron registros</td>
            </tr>
          </table>
          <?php
        }
        ?>
        </table>
        <?php
      }

      if($a==8)
      {
        $data= new Consultas();
        $data->Consulta_Tabla_General2('companias');
        $data->Consulta_General();
        $filadata=$data->Devuelve_Consulta();
        $data->Consulta_Paginador();
        $num_total_registros = $data->Devuelve_Contador();

        if($num_total_registros>=1)
        {
          foreach ($filadata as $row1)
          {
            ?>
            <tr align='center'>
              <td><?php echo ucwords($row1['id_com']); ?></td>
              <td><?php echo ucwords($row1['nom_com']); ?></td>
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
              <td colspan='2'>No se encontraron registros</td>
            </tr>
          </table>
          <?php
        }
        ?>
        </table>
        <?php
      }

      if($a==9)
      {
        $data= new Consultas();
        $data->Consulta_Tabla_General2('jerarquias');
        $data->Consulta_General();
        $filadata=$data->Devuelve_Consulta();
        $data->Consulta_Paginador();
        $num_total_registros = $data->Devuelve_Contador();

        if($num_total_registros>=1)
        {
          foreach ($filadata as $row1)
          {
            ?>
            <tr align='center'>
              <td><?php echo ucwords($row1['id_jer']); ?></td>
              <td><?php echo ucwords($row1['nom_jer']); ?></td>
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
              <td colspan='2'>No se encontraron registros</td>
            </tr>
          </table>
          <?php
        }
        ?>
        </table>
        <?php
      }

      if($a==10)
      {
        $academia=$_GET["academias"];
        $cancha=$_GET["canchas"];
        $sexo=$_GET["sexos"];
        $compania=$_GET["companias"];
        $jerarquia=$_GET["jerarquias"];

        if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias($academia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas($cancha);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Sexos($sexo);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Companias($compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Jerarquias($jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas($academia, $cancha);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)

        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos($academia, $sexo);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Companias($academia, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Jerarquias($academia, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos($cancha, $sexo);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Companias($cancha, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Jerarquias($cancha, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Companias($sexo, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Jerarquias($sexo, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Companias_Jerarquias($compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos($academia, $cancha, $sexo);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Compania($academia, $cancha, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Jerarquias($academia, $cancha, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Companias($academia, $sexo, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Jerarquias($academia, $sexo, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Companias_Jerarquias($academia, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Companias($cancha, $sexo, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Jerarquias($cancha, $sexo, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Companias_Jerarquias($cancha, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Companias_Jerarquias($sexo, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Companias($academia, $cancha, $sexo, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Jerarquias($academia, $cancha, $sexo, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Companias_Jerarquias($academia, $sexo, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Companias_Jerarquias($academia, $cancha, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Companias_Jerarquias($cancha, $sexo, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Companias_Jerarquias($academia, $cancha, $sexo, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_General_Por_Canchas();
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        if($num_total_registros>=1)
        {
          foreach ($filadata as $row1)
          {
            ?>
            <tr align='center'>
              <td><?php echo ucwords($row1['nom_aca']); ?></td>
              <td><?php echo ucwords($row1['nom_com']); ?></td>
              <td><?php echo ucwords($row1['nom_jer']); ?></td>
              <td><?php echo ucwords($row1['nom_sex']); ?></td>
              <td><?php echo $row1['ced_per']; ?></td>
              <td><?php echo $row1['mat_per']; ?></td>
              <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']).""; ?></td>
              <td><?php echo ucwords($row1['nom_can']); ?></td>
              <td><?php echo ucwords($row1['not_eva']); ?></td>
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
              <td colspan='8'>No se encontraron registros</td>
            </tr>
          </table>
          <?php
        }
        ?>
        </table>
        <?php
      }
      
      if($a==11)
      {
        $academia=$_GET["academias"];
        $cancha=$_GET["canchas"];
        $sexo=$_GET["sexos"];
        $compania=$_GET["companias"];
        $jerarquia=$_GET["jerarquias"];

        if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sin_Notas($academia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sin_Notas($cancha);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Sin_Notas($sexo);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Companias_Sin_Notas($compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Jerarquias_Sin_Notas($jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sin_Notas($academia, $cancha);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)

        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Sin_Notas($academia, $sexo);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Companias_Sin_Notas($academia, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Jerarquias_Sin_Notas($academia, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Sin_Notas($cancha, $sexo);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Companias_Sin_Notas($cancha, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Jerarquias_Sin_Notas($cancha, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Companias_Sin_Notas($sexo, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Jerarquias_Sin_Notas($sexo, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Companias_Jerarquias_Sin_Notas($compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Sin_Notas($academia, $cancha, $sexo);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Compania_Sin_Notas($academia, $cancha, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Jerarquias_Sin_Notas($academia, $cancha, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Companias_Sin_Notas($academia, $sexo, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Jerarquias_Sin_Notas($academia, $sexo, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Companias_Jerarquias_Sin_Notas($academia, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Companias_Sin_Notas($cancha, $sexo, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Jerarquias_Sin_Notas($cancha, $sexo, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Companias_Jerarquias_Sin_Notas($cancha, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Companias_Jerarquias_Sin_Notas($sexo, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Companias_Sin_Notas($academia, $cancha, $sexo, $compania);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Jerarquias_Sin_Notas($academia, $cancha, $sexo, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Companias_Jerarquias_Sin_Notas($academia, $sexo, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Companias_Jerarquias_Sin_Notas($academia, $cancha, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Companias_Jerarquias_Sin_Notas($cancha, $sexo, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Companias_Jerarquias_Sin_Notas($academia, $cancha, $sexo, $compania, $jerarquia);
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        else
        {
          $data= new Consulta_Evaluaciones();
          $data->Consulta_Evaluacion_Lista_Por_Canchas_Sin_Notas();
          $data->Consulta_General();
          $filadata=$data->Devuelve_Consulta();
          $data->Consulta_Paginador();
          $num_total_registros = $data->Devuelve_Contador();
        }
        if($num_total_registros>=1)
        {
          foreach ($filadata as $row1)
          {
            ?>
            <tr align='center'>
              <td><?php echo ucwords($row1['nom_aca']); ?></td>
              <td><?php echo ucwords($row1['nom_com']); ?></td>
              <td><?php echo ucwords($row1['nom_jer']); ?></td>
              <td><?php echo ucwords($row1['nom_sex']); ?></td>
              <td><?php echo $row1['ced_per']; ?></td>
              <td><?php echo $row1['mat_per']; ?></td>
              <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']).""; ?></td>
              <td><?php echo ucwords($row1['nom_can']); ?></td>
              <td><?php echo ucwords($row1['not_eva']); ?></td>
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
              <td colspan='8'>No se encontraron registros</td>
            </tr>
          </table>
          <?php
        }
        ?>
        </table>
        <?php
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
          <td align="left">
            <div class="text">
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
