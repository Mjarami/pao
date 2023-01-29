<?php

	/** Verifica si existe una sesion activa **/
	error_reporting(0);
	session_start();
	if($_SESSION['rol'] != null)
	{
		header('Location: destruir.php');
		exit();
	}
	$usuario="";
	$contrasena="";
	/** Verifica si se ingresaron datos de acceso **/
	if ($_POST)
	{
		$usuario = $_POST['usuario'];
		$contrasena = sha1($_POST['contrasena']);
	}
	include("../../clases/validaformu.php");
	if($usuario!="" && $contrasena!="")
	{
		require_once "../../clases/consultas.php";
    	require_once "../../clases/registros.php";
		
		/** Se valida la existencia del usuario **/
		$log=new Consulta_Personas();
    	$log->Consulta_Acceso_Persona($usuario, $contrasena);
    	$log->Consulta_General();
    	$filalog=$log->Devuelve_Consulta();
    	$log->Consulta_Paginador();
    	$num_total_registros=$log->Devuelve_Contador();
		$modulo="Acceso";

		if($num_total_registros>=1)
		{
			$rol=$filalog[0]['id_rol'];
			$ced=$filalog[0]['ced_per'];
			
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

    		/** Se procesa la auditoria **/
			if($num_total_registros2>=1)
			{
				$proceso= new Registro_Auditorias(); 
				$proceso->Registro_Proceso(1 , $id_per, $fechanew, $horanew);
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
			$_SESSION['rol']=$rol;
			$_SESSION['ced']=$ced;

			/** Segun su nivel de rol se permite el acceso **/
			if($rol==1)
			{
				echo "<script language='javascript'>
					alert ('Bienvenido $nombre su nivel actual es Administrador');
					window.location='../administrador/menu.php';
				</script>";
			}
			else
			{
				if($rol==2)
				{
					echo "<script language='javascript'>
						alert ('Bienvenido $nombre su nivel actual es Operador');
						window.location='../administrador/menu.php';
					</script>";
				}
				else
				{
					if($rol==4)
					{
						echo "<script language='javascript'>
							alert ('Bienvenido $nombre su nivel actual es Transcriptor');
							window.location='../administrador/consultas.php?registro=3';
						</script>";
					}
					else
					{
						echo "<script language='javascript'>
							alert ('Usted no posee privilegios para acceder al sistema');
							window.location='../../index.php';
						</script>";
					}
				}
			}
		}
		else
		{
			echo "<script language='javascript'>
			alert ('Datos incorrectos o se encuentra inactivo');
			window.location='../../index.php';
			</script>";
		}
	}
	else
	{
		include("../../clases/javascript.php");

		/** Formulario de accesos **/
		?>
		<!DOCTYPE html>
		<html lang="en">
			<head>
				<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
				<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
				<title>Acceso</title>
				<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
				<link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
				<link href="../../img/icon/glyphicons-45-keys.png" rel="shortcut icon" type="image/png"/>
			</head>
			<body>
				<?php
					include("../config/navbar.php");
					
				?>
				<br><br><br><br><br>	
				<div class="container-fluid">
					<div class="row vertical-offset-100">
						<div class="col-md-4 col-md-offset-4 col-sm-4">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title" align="center"><strong>Bienvenido al sistema <b>CAE PAO <?= date('Y'); ?></b></strong></h3><br>
									<h3 class="panel-title" align="center">Ingresa tus datos de acceso</h3>
								</div>
								<div class="panel-body">
									<!--Formulario de acceso-->
									<form accept-charset="UTF-8" role="form" id="forlog" name="forlog" method="post" action="login.php">
										<fieldset>
											<div style="margin-bottom: 12px" class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
												<input class="form-control" placeholder="Usuario" type="text" name="usuario" id="usuario" autocomplete="off" onkeypress="return validar4(event)"/>
											</div>

											<div style="margin-bottom: 12px" class="input-group">
                                        		<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
												<input class="form-control" placeholder="Contrase&ntilde;a" type="password" name="contrasena" id="contrasena" autocomplete="off" onkeypress="validar4(event)"/>
											</div>
												<button class="btn btn-primary btn-block" type='Submit' name='Submit' value="Ingresar" onclick="valida_envia_forlog()"><span class="glyphicon glyphicon-log-in"></span> Ingresar</button>
												<button class="btn btn-primary btn-block" type="reset" name='reset' value="Borrar"><span class="glyphicon glyphicon-repeat"></span> Borrar</button>
										</fieldset>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
					}
				?>
				<?php
					include("../config/footer.php");
				?>
				<script src="../../js/jquery-3.1.1.min.js"></script>
				<script src="../../js/bootstrap.js"></script>
				<script src="../../js/jquery-backstretch.js"></script>
				<script src="../../js/backstretch.js"></script>
				
			</body>
		</html>
