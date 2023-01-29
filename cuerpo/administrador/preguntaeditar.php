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
	include("../../clases/validaformu.php");
	$registro=$_GET["registro"];
	$cedula=$_GET["cedula"];
    $cancha=$_GET["cancha"];
    $nota=$_GET["nota"];
    $habia=$_GET["habia"];
    $anoa=date('Y');
	$mesa=date('m');
	$diaa=date('d');
	$fecha=$anoa."-".$mesa."-".$diaa;
	echo "
		<!DOCTYPE html>
			<html lang='en'>
				<head>
					<meta http-equiv='Content-type' content='text/html; charset=utf-8'/>
					<meta name='viewport' content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
	    			<title>Motivo de la edici&oacute;n</title>
					<link href='../../css/bootstrap.css' rel='stylesheet' type='text/css'/>
					<link href='../../css/sb-admin.css' rel='stylesheet' type='text/css'/>
					<link href='../../img/icon/helmet.png' rel='shortcut icon' type='image/png'/>
				</head>
				<body>
	";
	include("../config/navbar3.php");
	?>
		<br><br><br><br>
		<div class='col-md-12 col-md-offset-0'>
			<div class='panel panel-primary'>
				<div class='panel-heading'>
					<h3 class='panel-title' align='center'><img src='../../img/icon/worker.png'/><strong>¿Por qu&eacute editas?</strong></h3>
				</div>
				<div class='panel-body'>
					<form id='FormEdiNot' name='FormEdiNot' role='form' class='form-horizontal' method='post' enctype='multipart/form-data' action='pronotas.php'>
			 			<table class='table table-bordered' align='center'>
			 				<tr align='center'>
								<td colspan='2'>
									<textarea placeholder='Describa aquí su observaci&oacute;n' name='Observa' id='Observa' rows='5' cols='130' onkeypress='return validar4(event)' onkeyup='javascript:this.value=this.value.toLowerCase();'></textarea>
								</td>
							</tr>
							<tr align='center'>
                              	<td>
                                 	<input type='hidden' name='registro' id='registro' autocomplete='off' value="<?php echo $registro; ?>"/>
                                 	<input type='hidden' name='cedula' id='cedula' autocomplete='off' value="<?php echo $cedula; ?>"/>
                                 	<input type='hidden' name='cancha' id='cancha' autocomplete='off' value="<?php echo $cancha; ?>"/>
                                 	<input type='hidden' name='nota' id='nota' autocomplete='off' value="<?php echo $nota; ?>"/>
                                 	<input type='hidden' name='habia' id='habia' autocomplete='off' value="<?php echo $habia; ?>"/>
                                 	<a TITLE='Click para proceder con la edici&oacute;n'>
                                 		<button class='btn btn-primary' type='submit' name='Submit' value='Continuar'><span class='glyphicon glyphicon-eye-open'></span> Continuar</button>
                                 	</a>
                              	</td>
                    </form>
								<td>
									<form id='FormCanEdi' name='FormCanEdi' role='form' class='form-horizontal' method='post' enctype='multipart/form-data' action='carga_notas.php'>
										<a TITLE='Click para cancelar la edici&oacute;n'>
											<input type='hidden' name='registro' id='registro' autocomplete='off' value="<?php echo $registro; ?>"/>
                                 			<input type='hidden' name='cedula' id='cedula' autocomplete='off' value="<?php echo $cedula; ?>"/>
											<button class='btn btn-primary' type='submit' name='Submit' value='Cancelar'><span class='glyphicon glyphicon-circle-arrow-left'></span> Cancelar</button>
										</a>
									</form>
								</td>
							</tr>
						</table>
				</div>
			</div>
		</div>
	<?php
	include("../config/footer.php");
	echo "
			</body>
		</html>
		<script src='../../js/jquery-3.1.1.min.js'></script>
		<script src='../../js/bootstrap.js'></script>
		<script src='../../js/jquery-backstretch.js'></script>
		<script src='../../js/backstretch.js'></script>
	";