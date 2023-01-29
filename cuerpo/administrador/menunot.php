<?php
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Calificaciones</title>
	<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
	<link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
	<link href="../../img/icon/helmet.png" rel="shortcut icon" type="image/png"/>
</head>
<body>
<?php
	include("../config/navbar3.php");
	include("../config/navbar2.php");
	include_once("../../clases/borrar.php");

	/** Menu de calificaciones **/
?>
<br><br>
<div class="container">
	<div class="row vertical-offset-100">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title" align="center"><strong>Calificaciones</strong></h2><br>
					<h3 class="panel-title" align="center">Selecciona la opci&oacute;n a ejecutar:</h3>
				</div>
				<div class="panel-body">
					<form accept-charset="UTF-8" role="form" id="ForCarInd" name="ForCarInd" method="post" action="carga_notas.php">
						<fieldset>
							<div class="form-group">
								<input type='hidden' name='registro' id='registro' autocomplete='off' value='1'/>
								<button class="btn btn-primary btn-block" type="submit"  name='Submit' value="Cargar"><span class="glyphicon glyphicon-circle-arrow-up"></span> Cargar Calificaciones Individual</button>
							</div>
						</fieldset>
					</form>
					<form accept-charset="UTF-8" role="form" id="ForCarLis" name="ForCarLis" method="post" action="carga_notas.php">
						<fieldset>
							<div class="form-group">
								<input type='hidden' name='registro' id='registro' autocomplete='off' value='2'/>
								<button class="btn btn-primary btn-block" type="submit"  name='Submit' value="Cargar"><span class="glyphicon glyphicon-circle-arrow-up"></span> Cargar Calificaciones por Lista</button>
							</div>
						</fieldset>
					</form>
					<form accept-charset="UTF-8" role="form" id="ForConCal" name="ForConCal" method="post" action="consultas.php">
						<fieldset>
							<div class="form-group">
								<input type='hidden' name='registro' id='registro' autocomplete='off' value='4'/>
								<button class="btn btn-primary btn-block" type="submit"  name='Submit' value="Evaluaciones"><span class="glyphicon glyphicon-list-alt"></span> Calificaciones</button>
							</div>
						</fieldset>
					</form>
					<form accept-charset="UTF-8" role="form" id="ForConCal0" name="ForConCal0" method="post" action="consultas.php">
						<fieldset>
							<div class="form-group">
								<input type='hidden' name='registro' id='registro' autocomplete='off' value='5'/>
								<button class="btn btn-primary btn-block" type="submit"  name='Submit' value="Calificacion_en_0"><span class="glyphicon glyphicon-list-alt"></span> Calificaciones en 0</button>
							</div>
						</fieldset>
					</form>
					<form accept-charset="UTF-8" role="form" id="ForConCalCan" name="ForConCalCan" method="post" action="consultas.php">
						<fieldset>
							<div class="form-group">
								<?php
									    $promedio= new Borrar_Promedios();
    									$promedio->Borrar_Promedio();
    									$promedio->Borrar_General();
								?>
								<input type='hidden' name='registro' id='registro' autocomplete='off' value='10'/>
								<button class="btn btn-primary btn-block" type="submit"  name='Submit' value="Calificacion_por_cancha"><span class="glyphicon glyphicon-list-alt"></span> Calificaciones por cancha</button>
							</div>
						</fieldset>
					</form>
					<form accept-charset="UTF-8" role="form" id="ForSalir" name="ForSalir" method="post" action="menu.php">
						<fieldset>
							<div class="form-group">
								<button class="btn btn-primary btn-block" type="submit" name='Submit' value="Atras"><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	include("../config/footer.php");
?>
<script src="../../js/jquery-3.1.1.min.js"></script>
<script src="../../js/bootstrap.js"></script>
<script src="../../js/jquery-backstretch.js"></script>
<script src="../../js/backstretch.js"></script>
</body>
</html>