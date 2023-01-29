<?php

	/** Verifica la sesion, marca la salida y procesa la destruccion de las variables **/
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
	session_start();
	$ced=$_SESSION['ced'];
	$modulo="Acceso";

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
		$proceso->Registro_Proceso(2, $id_per, $fechanew, $horanew);
		$proceso->Registro_General();

		$conproce= new Consulta_Auditorias();
		$conproce->Consulta_Auditoria_Proceso($id_per);
		$conproce->Consulta_General();
		$filaconproce=$conproce->Devuelve_Consulta();
		$id_pro=$filaconproce[0]['id_pro'];

		$auditoria= new Registro_Auditorias();
		$auditoria->Registro_Auditoria($id_pro, 3, $modulo);
		$auditoria->Registro_General();
	}
	header('Location: ../logeo/destruir.php');
	exit();	
?>
