<?php
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
include_once("../../clases/registros.php");
include_once("../../clases/consultas.php");
include_once("../../clases/actualizaciones.php");
if($_POST!=null)
{
    $envio=$_POST["registro"];
}

/** Edito administradores **/
if($envio==1)
{
    $fallo="Location: consultas.php?registro=1";
    if($_POST!=null)
    {
        $habia=$_POST["Habia"];
        $id=$_POST["id_persona"];
        $id_academia=$_POST["Academia"];
        $id_jerarquia=$_POST["Jerarquia"];
        $id_sexo=$_POST["Sexo"];
        $cedula=$_POST["Cedula"];
        $apellidos=$_POST["Apellidos"];
        $nombres=$_POST["Nombres"];
        $usuario=$_POST["Usuario"];
        $contrasena=$_POST["Contrasena"];
        if($contrasena=='Si')
        {
            $contrasena=sha1($_POST["Contrasena1"]);
        }
        else
        {
            $concontra=2;
        }
    }
    else
    {
        header($fallo);
        exit();
    }
    
    if($concontra==2)
    {
        $personas=new Editar_Persona();
        $personas->Edito_Datos_Administrador($id, $id_academia, $id_jerarquia, $id_sexo, $cedula, $nombres, $apellidos, $usuario);
        $personas->Editar_General();
    }
    else
    {
        $personas=new Editar_Persona();
        $personas->Edito_Datos_Administrador2($id, $id_academia, $id_jerarquia, $id_sexo, $cedula, $nombres, $apellidos, $usuario, $contrasena);
        $personas->Editar_General();
    }
    
    $accesos= new Consulta_Personas();
    $accesos->Consulta_Cedula_Persona($cedula);
    $accesos->Consulta_General();
    $filaaccesos=$accesos->Devuelve_Consulta();

    $id_per=$filaaccesos[0]['id_per'];
    $fechanew=date('Y-m-d');
    $horanew=date('H:i:s');
    session_start();
    $ced=$_SESSION['ced']; 

    $conced= new Consulta_Personas();
    $conced->Consulta_Acceso_Cedula($ced);
    $conced->Consulta_General();
    $filaconced=$conced->Devuelve_Consulta();

    $id_acc=$filaconced[0]['id_acc'];

    $proceso= new Registro_Auditorias(); 
    $proceso->Registro_Proceso2(3 , $id_acc, $id_per, $fechanew, $horanew);
    $proceso->Registro_General();

    $conproce= new Consulta_Auditorias();
    $conproce->Consulta_Auditoria_Proceso($id_per);
    $conproce->Consulta_General();
    $filaconproce=$conproce->Devuelve_Consulta();
    $id_pro=$filaconproce[0]['id_pro'];

    $modulo="Editar/Administrador";

    $data= new Consulta_Academias();
    $data->Consulta_Nombre_Academia($id_academia);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_academia=$datos[0]['nom_aca'];

    $data= new Consulta_Jerarquias();
    $data->Consulta_Nombre_Jerarquia($id_jerarquia);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_jerarquia=$datos[0]['nom_jer'];

    $data= new Consulta_Sexos();
    $data->Consulta_Nombre_Sexo($id_sexo);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_sexo=$datos[0]['nom_sex'];

    $modifico=$nombre_academia." ".$nombre_jerarquia." ".$nombre_sexo." ".$cedula." ".$nombres." ".$apellidos." ".$usuario;

    $auditoria= new Registro_Auditorias();
    $auditoria->Registro_Auditoria2($id_pro, 3, $modulo, $modifico, $habia);
    $auditoria->Registro_General();

    header($fallo);
    exit();
}

/** Edito operadores **/
if($envio==2)
{
    $fallo="Location: consultas.php?registro=2";
    if($_POST!=null)
    {
        $habia=$_POST["Habia"];
        $id=$_POST["id_persona"];
        $id_academia=$_POST["Academia"];
        $id_jerarquia=$_POST["Jerarquia"];
        $id_sexo=$_POST["Sexo"];
        $cedula=$_POST["Cedula"];
        $apellidos=$_POST["Apellidos"];
        $nombres=$_POST["Nombres"];
        $usuario=$_POST["Usuario"];
        $contrasena=$_POST["Contrasena"];
        if($contrasena=='Si')
        {
            $contrasena=sha1($_POST["Contrasena1"]);
        }
        else
        {
            $concontra=2;
        }
    }
    else
    {
        header($fallo);
        exit();
    }
    
    if($concontra==2)
    {
        $personas=new Editar_Persona();
        $personas->Edito_Datos_Asistente($id, $id_academia, $id_jerarquia, $id_sexo, $cedula, $nombres, $apellidos, $usuario);
        $personas->Editar_General();
    }
    else
    {
        $personas=new Editar_Persona();
        $personas->Edito_Datos_Asistente2($id, $id_academia, $id_jerarquia, $id_sexo, $cedula, $nombres, $apellidos, $usuario, $contrasena);
        $personas->Editar_General();
    }

    $accesos= new Consulta_Personas();
    $accesos->Consulta_Cedula_Persona($cedula);
    $accesos->Consulta_General();
    $filaaccesos=$accesos->Devuelve_Consulta();

    $id_per=$filaaccesos[0]['id_per'];
    $fechanew=date('Y-m-d');
    $horanew=date('H:i:s');
    session_start();
    $ced=$_SESSION['ced']; 

    $conced= new Consulta_Personas();
    $conced->Consulta_Acceso_Cedula($ced);
    $conced->Consulta_General();
    $filaconced=$conced->Devuelve_Consulta();

    $id_acc=$filaconced[0]['id_acc'];

    $proceso= new Registro_Auditorias(); 
    $proceso->Registro_Proceso2(3 , $id_acc, $id_per, $fechanew, $horanew);
    $proceso->Registro_General();

    $conproce= new Consulta_Auditorias();
    $conproce->Consulta_Auditoria_Proceso($id_per);
    $conproce->Consulta_General();
    $filaconproce=$conproce->Devuelve_Consulta();
    $id_pro=$filaconproce[0]['id_pro'];

    $modulo="Editar/Asistente";

    $data= new Consulta_Academias();
    $data->Consulta_Nombre_Academia($id_academia);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_academia=$datos[0]['nom_aca'];

    $data= new Consulta_Jerarquias();
    $data->Consulta_Nombre_Jerarquia($id_jerarquia);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_jerarquia=$datos[0]['nom_jer'];

    $data= new Consulta_Sexos();
    $data->Consulta_Nombre_Sexo($id_sexo);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_sexo=$datos[0]['nom_sex'];

    $modifico=$nombre_academia." ".$nombre_jerarquia." ".$nombre_sexo." ".$cedula." ".$nombres." ".$apellidos." ".$usuario;

    $auditoria= new Registro_Auditorias();
    $auditoria->Registro_Auditoria2($id_pro, 3, $modulo, $modifico, $habia);
    $auditoria->Registro_General();

    header($fallo);
    exit();
}

/** Edito cadetes **/
if($envio==3)
{
    $fallo="Location: consultas.php?registro=3";
    if($_POST!=null)
    {
        $habia=$_POST["Habia"];
        $id=$_POST["id_persona"];
        $id_academia=$_POST["Academia"];
        $id_compania=$_POST["Compania"];
        $id_jerarquia=$_POST["Jerarquia"];
        $id_sexo=$_POST["Sexo"];
        $cedula=$_POST["Cedula"];
        $cambiomatri=$_POST["Cambiomatri"];
        $apellidos=$_POST["Apellidos"];
        $nombres=$_POST["Nombres"];
        if($cambiomatri=='Si')
        {
            $cambiomatri=1;
            $matricula=$_POST["Matricula"];
        }
        else
        {
            $cambiomatri=2;
        }
        if($cambiomatri==1)
        {
            $personasmatricula= new Consulta_Personas();
            $personasmatricula->Consulta_Matricula_Cadete($matricula);
            $personasmatricula->Consulta_General();
            $personasmatricula->Consulta_Paginador();
            $filapersonasmatricula=$personasmatricula->Devuelve_Contador();
            if($filapersonasmatricula>=1)
            {
                echo "
                    <script language='javascript'>
                        alert ('Matricula ya existe');
                        window.location='consultas.php?registro=3';
                    </script>
                ";
                exit();
            }    
        }
    }
    else
    {
        header($fallo);
        exit();
    }
    if($cambiomatri==2)
    {
        $personas=new Editar_Persona();
        $personas->Edito_Datos_Cadete2($id, $id_academia, $id_compania, $id_jerarquia, $id_sexo, $cedula, $nombres, $apellidos);
        $personas->Editar_General();
    }
    else
    {
        $personas=new Editar_Persona();
        $personas->Edito_Datos_Cadete($id, $id_academia, $id_compania, $id_jerarquia, $id_sexo, $cedula, $matricula, $nombres, $apellidos);
        $personas->Editar_General();    
    }
    $accesos= new Consulta_Personas();
    $accesos->Consulta_Cedula_Persona($cedula);
    $accesos->Consulta_General();
    $filaaccesos=$accesos->Devuelve_Consulta();

    $id_per=$filaaccesos[0]['id_per'];
    $fechanew=date('Y-m-d');
    $horanew=date('H:i:s');
    session_start();
    $ced=$_SESSION['ced']; 

    $conced= new Consulta_Personas();
    $conced->Consulta_Acceso_Cedula($ced);
    $conced->Consulta_General();
    $filaconced=$conced->Devuelve_Consulta();

    $id_acc=$filaconced[0]['id_acc'];

    $proceso= new Registro_Auditorias(); 
    $proceso->Registro_Proceso2(3 , $id_acc, $id_per, $fechanew, $horanew);
    $proceso->Registro_General();

    $conproce= new Consulta_Auditorias();
    $conproce->Consulta_Auditoria_Proceso($id_per);
    $conproce->Consulta_General();
    $filaconproce=$conproce->Devuelve_Consulta();
    $id_pro=$filaconproce[0]['id_pro'];

    $modulo="Editar/Cadete";

    $data= new Consulta_Academias();
    $data->Consulta_Nombre_Academia($id_academia);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_academia=$datos[0]['nom_aca'];

    $data= new Consulta_companias();
    $data->Consulta_Nombre_Compania($id_compania);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_compania=$datos[0]['nom_com'];

    $data= new Consulta_Jerarquias();
    $data->Consulta_Nombre_Jerarquia($id_jerarquia);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_jerarquia=$datos[0]['nom_jer'];

    $data= new Consulta_Sexos();
    $data->Consulta_Nombre_Sexo($id_sexo);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_sexo=$datos[0]['nom_sex'];

    $modifico=$nombre_academia." ".$nombre_compania." ".$nombre_jerarquia." ".$nombre_sexo." ".$cedula." ".$matricula." ".$nombres." ".$apellidos;

    $auditoria= new Registro_Auditorias();
    $auditoria->Registro_Auditoria2($id_pro, 3, $modulo, $modifico, $habia);
    $auditoria->Registro_General();

    header($fallo);
    exit();
}

/** Edito academias **/
if($envio==4)
{
    $fallo="Location: consultas.php?registro=6";
    if($_POST!=null)
    {
        $id_academia=$_POST["id"];
        $habia=$_POST["Habia"];
        $academia=strtoupper($_POST["Academia"]);
    }
    else
    {
        header($fallo);
        exit();
    }
    
    $personas=new Editar_Academias();
    $personas->Edito_Academia($id_academia, $academia);
    $personas->Editar_General();
    
    $fechanew=date('Y-m-d');
    $horanew=date('H:i:s');
    session_start();
    $ced=$_SESSION['ced']; 

    $conced= new Consulta_Personas();
    $conced->Consulta_Acceso_Cedula($ced);
    $conced->Consulta_General();
    $filaconced=$conced->Devuelve_Consulta();

    $id_per=$filaconced[0]['id_per'];

    $proceso= new Registro_Auditorias(); 
    $proceso->Registro_Proceso(3, $id_per, $fechanew, $horanew);
    $proceso->Registro_General();

    $conproce= new Consulta_Auditorias();
    $conproce->Consulta_Auditoria_Proceso($id_per);
    $conproce->Consulta_General();
    $filaconproce=$conproce->Devuelve_Consulta();
    $id_pro=$filaconproce[0]['id_pro'];

    $modulo="Editar/Academia";

    $modifico=$academia;

    $auditoria= new Registro_Auditorias();
    $auditoria->Registro_Auditoria2($id_pro, 3, $modulo, $modifico, $habia);
    $auditoria->Registro_General();

    header($fallo);
    exit();
}

/** Edito canchas **/
if($envio==5)
{
    $fallo="Location: consultas.php?registro=7";
    if($_POST!=null)
    {
        $id_cancha=$_POST["id"];
        $habia=$_POST["Habia"];
        $cancha=strtoupper($_POST["Cancha"]);
    }
    else
    {
        header($fallo);
        exit();
    }
    
    $personas=new Editar_Canchas();
    $personas->Edito_Cancha($id_cancha, $cancha);
    $personas->Editar_General();
    
    $fechanew=date('Y-m-d');
    $horanew=date('H:i:s');
    session_start();
    $ced=$_SESSION['ced']; 

    $conced= new Consulta_Personas();
    $conced->Consulta_Acceso_Cedula($ced);
    $conced->Consulta_General();
    $filaconced=$conced->Devuelve_Consulta();

    $id_per=$filaconced[0]['id_per'];

    $proceso= new Registro_Auditorias(); 
    $proceso->Registro_Proceso(3, $id_per, $fechanew, $horanew);
    $proceso->Registro_General();

    $conproce= new Consulta_Auditorias();
    $conproce->Consulta_Auditoria_Proceso($id_per);
    $conproce->Consulta_General();
    $filaconproce=$conproce->Devuelve_Consulta();
    $id_pro=$filaconproce[0]['id_pro'];

    $modulo="Editar/Cancha";

    $modifico=$cancha;

    $auditoria= new Registro_Auditorias();
    $auditoria->Registro_Auditoria2($id_pro, 3, $modulo, $modifico, $habia);
    $auditoria->Registro_General();

    header($fallo);
    exit();
}

/** Edito compañias **/
if($envio==6)
{
    $fallo="Location: consultas.php?registro=8";
    if($_POST!=null)
    {
        $id_compania=$_POST["id"];
        $habia=$_POST["Habia"];
        $compania=strtoupper($_POST["Compania"]);
    }
    else
    {
        header($fallo);
        exit();
    }
    
    $personas=new Editar_Companias();
    $personas->Edito_Compania($id_compania, $compania);
    $personas->Editar_General();
    
    $fechanew=date('Y-m-d');
    $horanew=date('H:i:s');
    session_start();
    $ced=$_SESSION['ced']; 

    $conced= new Consulta_Personas();
    $conced->Consulta_Acceso_Cedula($ced);
    $conced->Consulta_General();
    $filaconced=$conced->Devuelve_Consulta();

    $id_per=$filaconced[0]['id_per'];

    $proceso= new Registro_Auditorias(); 
    $proceso->Registro_Proceso(3, $id_per, $fechanew, $horanew);
    $proceso->Registro_General();

    $conproce= new Consulta_Auditorias();
    $conproce->Consulta_Auditoria_Proceso($id_per);
    $conproce->Consulta_General();
    $filaconproce=$conproce->Devuelve_Consulta();
    $id_pro=$filaconproce[0]['id_pro'];

    $modulo="Editar/Compania";

    $modifico=$compania;

    $auditoria= new Registro_Auditorias();
    $auditoria->Registro_Auditoria2($id_pro, 3, $modulo, $modifico, $habia);
    $auditoria->Registro_General();

    header($fallo);
    exit();
}

/** Edito jerarquías **/
if($envio==7)
{
    $fallo="Location: consultas.php?registro=9";
    if($_POST!=null)
    {
        $id_jerarquia=$_POST["id"];
        $habia=$_POST["Habia"];
        $jerarquia=strtoupper($_POST["Jerarquia"]);
    }
    else
    {
        header($fallo);
        exit();
    }
    
    $personas=new Editar_Jerarquias();
    $personas->Edito_Jerarquia($id_jerarquia, $jerarquia);
    $personas->Editar_General();
    
    $fechanew=date('Y-m-d');
    $horanew=date('H:i:s');
    session_start();
    $ced=$_SESSION['ced']; 

    $conced= new Consulta_Personas();
    $conced->Consulta_Acceso_Cedula($ced);
    $conced->Consulta_General();
    $filaconced=$conced->Devuelve_Consulta();

    $id_per=$filaconced[0]['id_per'];

    $proceso= new Registro_Auditorias(); 
    $proceso->Registro_Proceso(3, $id_per, $fechanew, $horanew);
    $proceso->Registro_General();

    $conproce= new Consulta_Auditorias();
    $conproce->Consulta_Auditoria_Proceso($id_per);
    $conproce->Consulta_General();
    $filaconproce=$conproce->Devuelve_Consulta();
    $id_pro=$filaconproce[0]['id_pro'];

    $modulo="Editar/Jerarquia";

    $modifico=$jerarquia;

    $auditoria= new Registro_Auditorias();
    $auditoria->Registro_Auditoria2($id_pro, 3, $modulo, $modifico, $habia);
    $auditoria->Registro_General();

    header($fallo);
    exit();
}

/** Edito jefe **/
if($envio==8)
{
    $fallo="Location: consultas.php?registro=12";
    if($_POST!=null)
    {
        $id_jefe=$_POST["id"];
        $id=$_POST["Administrador"];
        $cargo=$_POST["Cargo"];
        $habia=$_POST["Habia"];
    }
    else
    {
        header($fallo);
        exit();
    }
    
    $personas=new Editar_Persona();
    $personas->Edito_Jefe($id_jefe, $id, $cargo);
    $personas->Editar_General();
    
    $fechanew=date('Y-m-d');
    $horanew=date('H:i:s');
    session_start();
    $ced=$_SESSION['ced']; 

    $conced= new Consulta_Personas();
    $conced->Consulta_Acceso_Cedula($ced);
    $conced->Consulta_General();
    $filaconced=$conced->Devuelve_Consulta();

    $id_per=$filaconced[0]['id_per'];

    $proceso= new Registro_Auditorias(); 
    $proceso->Registro_Proceso(3, $id_per, $fechanew, $horanew);
    $proceso->Registro_General();

    $conproce= new Consulta_Auditorias();
    $conproce->Consulta_Auditoria_Proceso($id_per);
    $conproce->Consulta_General();
    $filaconproce=$conproce->Devuelve_Consulta();
    $id_pro=$filaconproce[0]['id_pro'];

    $modulo="Editar/Jefe";

    $data=new Consulta_personas();
    $data->Consulta_Jefe_Departamento();
    $data->Consulta_General();
    $filadata=$data->Devuelve_Consulta();
    $modifico=$filadata[0]['nom_jer'].", ".$filadata[0]['ape_per']." ".$filadata[0]['nom_per'].", ".$filadata[0]['car_jef'];

    $auditoria= new Registro_Auditorias();
    $auditoria->Registro_Auditoria2($id_pro, 3, $modulo, $modifico, $habia);
    $auditoria->Registro_General();

    header($fallo);
    exit();
}

//Edito por lista de cadetes compañia
if($envio==9)
{
    $fallo="Location: consultas.php?registro=3";
    if($_POST!=null)
    {
        if (isset($_POST['submit']))
        {
            $tmpcadetescsv = $_FILES['cadetescsv']['tmp_name']; 
            $namecadetescsv = $_FILES['cadetescsv']['name'];
            $ext=explode(".",$namecadetescsv);
            $ext2 = strtolower($ext[1]);
            if($ext2 != "csv")
            {
                echo "<script language='javascript'>
                    alert ('Archivo invalido');
                    window.location='consultas.php?registro=3';
                </script>";     
            }
            else
            {
                if (is_uploaded_file($tmpcadetescsv))
                {
                    $handle=fopen($tmpcadetescsv, "r");
                    $totalC=array();
                    $limite=0;
                    while (($data=fgetcsv($handle, 1000, ","))!== FALSE)
                    {
                        $limite=$limite++;
                        $ecom=trim($data[1]);
                        if(is_numeric($ecom))
                        {
                            $necom=1;
                        }
                        else
                        {
                            $necom=2;
                        }
                        if($necom==2)
                        {
                            echo "<script language='javascript'>
                                alert ('El campo Compañia solo debe contener los Id correspondientes');
                                window.location='consultas.php?registro=3';
                                </script>";
                            exit();
                        }
                        if($limite==201)
                        {
                            echo "<script language='javascript'>
                                alert ('El documento supera el máximo de usuarios permitidos');
                                window.location='consultas.php?registro=3';
                                </script>";
                            exit();
                        }
                    }
                    fclose($handle);
                    ?>
                    <!DOCTYPE html>
                        <head>
                            <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>ediciones</title>
                            <link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
                            <link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
                            <link rel="shortcut icon" type="image/png" href="../../img/icon/helmet.png"/>
                        </head>
                        <body>
                            <?php
                                include("../config/navbar.php");
                            ?>
                            <br><br>
                            <div class="col-md-10 col-md-offset-1">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title" align="center"><strong>Edición de Cadetes</strong></h3>
                                    </div>
                                    <div class="panel-body">
                    <?php
                            $handle=fopen($tmpcadetescsv, "r");
                            $totalC=array();
                            echo "<table class='table'>";
                            echo "<thead>";
                            echo "<tr><th>N°</th><th>Cédula</th><th>Compañia</th></tr>";
                            echo "</thead><tbody>";
                            $error=null;
                            $i=0;
                            while (($data=fgetcsv($handle, 1000, ","))!== FALSE)
                            {
                                $i++;
                                $cedula=trim($data[0]);
                                $compania=trim($data[1]);

                                $cedula=str_replace('.','',$cedula);
                                $compania=str_replace('"',' ',$compania);

                                $existcedula= new Consulta_Personas();
                                $existcedula->Consulta_Cedula_Persona($cedula);
                                $existcedula->Consulta_General();
                                $existcedula->Consulta_Paginador();
                                $ecedula=$existcedula->Devuelve_Contador();

                                $existcia= new Consulta_companias();
                                $existcia->Consulta_Nombre_Compania($compania);
                                $existcia->Consulta_General();
                                $existcia->Consulta_Paginador();
                                $ecia=$existcia->Devuelve_Contador();
                                $filaexistcia=$existcia->Devuelve_Consulta();
                                $ncompania=$filaexistcia[0]['nom_com'];

                                //Verficia existencia del cadete
                                if($compania=="" || $cedula=="")
                                {
                                    header($fallo);
                                    exit();
                                }
                                else
                                {
                                    if($ecedula>=1)
                                    {
                                       //Verifica existencia de la Compañia
                                        if($ncompania!=null)
                                        {
                                            $personas=new Editar_Persona();
                                            $personas->Edito_Datos_Cadete3($compania, $cedula);
                                            $personas->Editar_General();

                                            $accesos= new Consulta_Personas();
                                            $accesos->Consulta_Cedula_Persona($cedula);
                                            $accesos->Consulta_General();
                                            $filaaccesos=$accesos->Devuelve_Consulta();

                                            $id_per=$filaaccesos[0]['id_per'];
                                            $fechanew=date('Y-m-d');
                                            $horanew=date('H:i:s');
                                            $ced=$_SESSION['ced']; 

                                            $conced= new Consulta_Personas();
                                            $conced->Consulta_Acceso_Cedula($ced);
                                            $conced->Consulta_General();
                                            $filaconced=$conced->Devuelve_Consulta();
                                            $id_acc=$filaconced[0]['id_acc'];

                                            $proceso= new Registro_Auditorias(); 
                                            $proceso->Registro_Proceso2(3 , $id_acc, $id_per, $fechanew, $horanew);
                                            $proceso->Registro_General();

                                            $conproce= new Consulta_Auditorias();
                                            $conproce->Consulta_Auditoria_Proceso($id_per);
                                            $conproce->Consulta_General();
                                            $filaconproce=$conproce->Devuelve_Consulta();
                                            $id_pro=$filaconproce[0]['id_pro'];

                                            $modulo="Edito/Participante";
                                            $auditoria= new Registro_Auditorias();
                                            $auditoria->Registro_Auditoria($id_pro, 3, $modulo);
                                            $auditoria->Registro_General();
                                            ?>
                                            <tr title="Carga Exitosa" class="success">
                                                <td style="vertical-align: middle;"><?= $i ?></td>
                                                <td style="vertical-align: middle;"><?= $cedula ?></td>
                                                <td style="vertical-align: middle;"><?= $ncompania ?></td>
                                            </tr>
                                            <?php
                                        }
                                        //Deniega Registro por Compañía inexistente
                                        else
                                        {
                                            ?>
                                            <tr title="Compañia no existe" class="danger" style="font-weight:700">
                                                <td style="vertical-align: middle;"><?= $i ?></td>
                                                <td style="vertical-align: middle;"><?= $cedula ?></td>
                                            <td style="vertical-align: middle;"><?= $ncompania ?></td>
                                        </tr>
                                        <?php
                                            $error=$error."
                                                <tr title='Compañia no existe' class='danger' style='font-weight:700'>
                                                    <td style='vertical-align: middle;'>".$i."</td>
                                                    <td style='vertical-align: middle;'>".$cedula."</td>
                                                    <td style='vertical-align: middle;'>".$ncompania."</td>
                                                    <td style='vertical-align: middle;'>Compañia no existe</td>
                                                </tr>
                                            ";
                                        } 
                                    }
                                    else
                                    {
                                        ?>
                                        <tr title="Cedula No existe" class="danger" style="font-weight:700">
                                            <td style="vertical-align: middle;"><?= $i ?></td>
                                            <td style="vertical-align: middle;"><?= $cedula ?></td>
                                            <td style="vertical-align: middle;"><?= $ncompania ?></td>
                                        </tr>
                                        <?php
                                        $error=$error."
                                            <tr title='Cedula No existe' class='danger' style='font-weight:700'>
                                                <td style='vertical-align: middle;'>".$i."</td>
                                                <td style='vertical-align: middle;'>".$cedula."</td>
                                                <td style='vertical-align: middle;'>".$ncompania."</td>
                                                <td style='vertical-align: middle;'>Cedula No existe</td>
                                            </tr>
                                        ";
                                    }
                                }
                            }
                            echo "</tbody></table>";
                            fclose($handle);
                            echo "<br/><h2>Leido Exitosamente</h2>";
                    ?>
                                        </div>
                                    </div>
                                    <center>
                                    <table>
                                        <tr>
                                            <td align='center' colspan='7'>
                                                <br>
                                                <form data-ajax='false' id='forimprimirparte' name='forimprimirparte' method='post' action='imprimirerrorcsv.php'>
                                                    <input type='hidden' name='error' id='error' autocomplete='off' value="<?php echo $error;?>" />
                                                    <input type='hidden' name='ecsv' id='ecsv' autocomplete='off' value='3'/>
                                                    <button class="btn btn-lg btn-primary btn-block" type='submit' name='Submit' value='Imprimir'><span class="glyphicon glyphicon-print"></span> Imprimir</button>
                                                </form>
                                            </td>
                                            <td>
                                                <br>
                                                <form data-ajax='false' id='ForConCad' name='ForConCad' method='post' action="consultas.php?registro=3">
                                                    <button class="btn btn-lg btn-primary btn-block" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-search"></span> Consultar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                    </center>
                                </div>
                            </body>
                        </body>
                        <script src="../../js/jquery-3.1.1.min.js"></script>
                        <script src="../../js/bootstrap.js"></script>
                        <script src="../../js/jquery-backstretch.js"></script>
                        <script src="../../js/backstretch.js"></script>
                    </html>
                    <?php
                }
            }
        }
        else
        {
            header($fallo);
            exit();
        }
    }
    else
    {
        header($fallo);
        exit();
    }
}

//Edito rol de cadetes
if($envio==10)
{
    $fallo="Location: consultas.php?registro=3";

    if($_POST!=null)
    {
        $id_persona=$_POST["id_per"];
        $rol=$_POST["rol"];
        $cedula=$_POST["cedula"];
        $habia=$_POST["habia"];
    }
    else
    {
        header($fallo);
        exit();
    }
    
    $personas=new Editar_Persona();
    $personas->Edito_Datos_Cadete4($id_persona, $rol);
    $personas->Editar_General();

    $accesos= new Consulta_Personas();
    $accesos->Consulta_Cedula_Persona($cedula);
    $accesos->Consulta_General();
    $filaaccesos=$accesos->Devuelve_Consulta();

    $id_per=$filaaccesos[0]['id_per'];
    $fechanew=date('Y-m-d');
    $horanew=date('H:i:s');
    session_start();
    $ced=$_SESSION['ced']; 

    $conced= new Consulta_Personas();
    $conced->Consulta_Acceso_Cedula($ced);
    $conced->Consulta_General();
    $filaconced=$conced->Devuelve_Consulta();

    $id_acc=$filaconced[0]['id_acc'];

    $proceso= new Registro_Auditorias(); 
    $proceso->Registro_Proceso2(3 , $id_acc, $id_per, $fechanew, $horanew);
    $proceso->Registro_General();

    $conproce= new Consulta_Auditorias();
    $conproce->Consulta_Auditoria_Proceso($id_per);
    $conproce->Consulta_General();
    $filaconproce=$conproce->Devuelve_Consulta();
    $id_pro=$filaconproce[0]['id_pro'];

    $modulo="Editar/Participante";

    $data= new Consulta_roles();
    $data->Consulta_Nombre_rol($rol);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_rol=$datos[0]['nom_rol'];

    $auditoria= new Registro_Auditorias();
    $auditoria->Registro_Auditoria2($id_pro, 3, $modulo, $nombre_rol, $habia);
    $auditoria->Registro_General();

    header($fallo);
    exit();
}
?>
