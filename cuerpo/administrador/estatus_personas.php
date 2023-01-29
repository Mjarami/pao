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

/** Edito administrador **/
if($envio==1)
{
    $fallo="Location: consultas.php?registro=1";
    if($_POST!=null)
    {
        $id_persona=$_POST["id_per"];
        $estatus=$_POST["estatus"];
        $cedula=$_POST["cedula"];
        $habia=$_POST["habia"];
    }
    else
    {
        header($fallo);
        exit();
    }
    
    $personas=new Editar_Persona();
    $personas->Edito_Estatus_Persona($id_persona, $estatus);
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

    $modulo="Editar/Administrador";

    $data= new Consulta_Estatus();
    $data->Consulta_Nombre_Estatus($estatus);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_estatus=$datos[0]['nom_est'];

    $auditoria= new Registro_Auditorias();
    $auditoria->Registro_Auditoria2($id_pro, 3, $modulo, $nombre_estatus, $habia);
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
        $id_persona=$_POST["id_per"];
        $estatus=$_POST["estatus"];
        $cedula=$_POST["cedula"];
        $habia=$_POST["habia"];
    }
    else
    {
        header($fallo);
        exit();
    }
    $personas=new Editar_Persona();
    $personas->Edito_Estatus_Persona($id_persona, $estatus);
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
    $modulo="Editar/Asistente";
    $data= new Consulta_Estatus();
    $data->Consulta_Nombre_Estatus($estatus);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_estatus=$datos[0]['nom_est'];
    $auditoria= new Registro_Auditorias();
    $auditoria->Registro_Auditoria2($id_pro, 3, $modulo, $nombre_estatus, $habia);
    $auditoria->Registro_General();
    if($_SESSION['rol']== 2)
    {
        header("Location: consultas.php?registro=2&buscando=".$ced);
    }
    else
    {
        header($fallo);
        exit();
    }
}

/** Edito cadetes **/
if($envio==3)
{
    $fallo="Location: consultas.php?registro=3";

    if($_POST!=null)
    {
        $id_persona=$_POST["id_per"];
        $estatus=$_POST["estatus"];
        $cedula=$_POST["cedula"];
        $habia=$_POST["habia"];
    }
    else
    {
        header($fallo);
        exit();
    }
    
    $personas=new Editar_Persona();
    $personas->Edito_Estatus_Persona($id_persona, $estatus);
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

    $data= new Consulta_Estatus();
    $data->Consulta_Nombre_Estatus($estatus);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_estatus=$datos[0]['nom_est'];

    $auditoria= new Registro_Auditorias();
    $auditoria->Registro_Auditoria2($id_pro, 3, $modulo, $nombre_estatus, $habia);
    $auditoria->Registro_General();

    header($fallo);
    exit();
}

/** Edito academias **/
if($envio==4)
{
    $fallo="Location: consultas.php?registro=6";
    //***Registro Persona***//
    if($_POST!=null)
    {
        $estatus=$_POST["estatus"];
        $academia=$_POST["academia"];
        $habia=$_POST["Habia"];
    }
    else
    {
        header($fallo);
        exit();
    }
    
    $personas=new Editar_Academias();
    $personas->Edito_Academia_Estatus($estatus, $academia);
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

    $modulo="Editar/Estatus_Academia";

    $data= new Consulta_Estatus();
    $data->Consulta_Nombre_Estatus($estatus);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_estatus=$datos[0]['nom_est'];

    $data2= new Consulta_Estatus();
    $data2->Consulta_Nombre_Estatus($habia);
    $data2->Consulta_General();
    $datos2=$data2->Devuelve_Consulta();
    $habia=$datos2[0]['nom_est'];

    $modifico=$nombre_estatus;

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
    //***Registro Persona***//
    if($_POST!=null)
    {
        $estatus=$_POST["estatus"];
        $cancha=$_POST["cancha"];
        $habia=$_POST["Habia"];
    }
    else
    {
        header($fallo);
        exit();
    }
    
    $personas=new Editar_Canchas();
    $personas->Edito_Cancha_Estatus($estatus, $cancha);
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

    $modulo="Editar/Estatus_Cancha";

    $data= new Consulta_Estatus();
    $data->Consulta_Nombre_Estatus($estatus);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_estatus=$datos[0]['nom_est'];

    $data2= new Consulta_Estatus();
    $data2->Consulta_Nombre_Estatus($habia);
    $data2->Consulta_General();
    $datos2=$data2->Devuelve_Consulta();
    $habia=$datos2[0]['nom_est'];

    $modifico=$nombre_estatus;

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
    //***Registro Persona***//
    if($_POST!=null)
    {
        $estatus=$_POST["estatus"];
        $compania=$_POST["compania"];
        $habia=$_POST["Habia"];
    }
    else
    {
        header($fallo);
        exit();
    }
    
    $personas=new Editar_Companias();
    $personas->Edito_Compania_Estatus($estatus, $compania);
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

    $modulo="Editar/Estatus_Compania";

    $data= new Consulta_Estatus();
    $data->Consulta_Nombre_Estatus($estatus);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_estatus=$datos[0]['nom_est'];

    $data2= new Consulta_Estatus();
    $data2->Consulta_Nombre_Estatus($habia);
    $data2->Consulta_General();
    $datos2=$data2->Devuelve_Consulta();
    $habia=$datos2[0]['nom_est'];

    $modifico=$nombre_estatus;

    $auditoria= new Registro_Auditorias();
    $auditoria->Registro_Auditoria2($id_pro, 3, $modulo, $modifico, $habia);
    $auditoria->Registro_General();

    header($fallo);
    exit();
}

/** Edito jerarquias **/
if($envio==7)
{
    $fallo="Location: consultas.php?registro=9";
    //***Registro Persona***//
    if($_POST!=null)
    {
        $estatus=$_POST["estatus"];
        $jerarquia=$_POST["jerarquia"];
        $habia=$_POST["Habia"];
    }
    else
    {
        header($fallo);
        exit();
    }
    
    $personas=new Editar_Jerarquias();
    $personas->Edito_Jerarquia_Estatus($estatus, $jerarquia);
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

    $modulo="Editar/Estatus_Jerarquia";

    $data= new Consulta_Estatus();
    $data->Consulta_Nombre_Estatus($estatus);
    $data->Consulta_General();
    $datos=$data->Devuelve_Consulta();
    $nombre_estatus=$datos[0]['nom_est'];

    $data2= new Consulta_Estatus();
    $data2->Consulta_Nombre_Estatus($habia);
    $data2->Consulta_General();
    $datos2=$data2->Devuelve_Consulta();
    $habia=$datos2[0]['nom_est'];

    $modifico=$nombre_estatus;

    $auditoria= new Registro_Auditorias();
    $auditoria->Registro_Auditoria2($id_pro, 3, $modulo, $modifico, $habia);
    $auditoria->Registro_General();

    header($fallo);
    exit();
}
?>
