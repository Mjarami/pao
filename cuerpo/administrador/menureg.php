<?php
/** Valida el rol del usuario **/
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

/** Menu de registros **/
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Panel de Registros</title>
	<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
	<link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
	<link rel="shortcut icon" type="image/png" href="../../img/icon/soldier_2.png"/>
</head>
<body>
	<?php
		include("../config/navbar3.php");
		include("../config/navbar2.php");
	?>
	<br><br>
	<!--Menu de opciones de registro -->
	<div class="container">
		<div class="row vertical-offset-100">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title" align="center"><strong>Registros</strong></h2><br>
						<h3 class="panel-title" align="center">Selecciona la opci&oacute;n a ejecutar:</h3>
					</div>
					<div class="panel-body">
					<?php
						if($permi==0)
						{
					?>
						<form accept-charset="UTF-8" role="form" id="ForMenReg" name="ForMenReg" method="post" action="registros.php">
							<fieldset>
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit" name='Submit' value="Administradores"><span class="glyphicon glyphicon-user"></span> Administradores</button>
									<input type='hidden' name='registro' id='registro' autocomplete='off' value='1'/>
								</div>
							</fieldset>
						</form>
						<form accept-charset="UTF-8" role="form" id="ForConAud" name="ForConAud" method="post" action="registros.php">
							<fieldset>
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit" name='Submit' value="Asistentes"><span class="glyphicon glyphicon-user"></span> Operadores</button>
									<input type='hidden' name='registro' id='registro' autocomplete='off' value='2'/>
								</div>
							</fieldset>
						</form>
					<?php
						}
					?>
						<form accept-charset="UTF-8" role="form" id="ForConAud" name="ForConAud" method="post" action="registros.php">
							<fieldset>
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit" name='Submit' value="Participantes individuales"><span class="glyphicon glyphicon-user"></span> Cadetes</button>
									<input type='hidden' name='registro' id='registro' autocomplete='off' value='3'/>
								</div>
							</fieldset>
						</form>
						<form accept-charset="UTF-8" role="form" id="ForConAud" name="ForConAud" method="post" action="registros.php">
							<fieldset>
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit"  name='Submit' value="Participantes por lista"><span class="glyphicon glyphicon-user"></span> Lista de Cadetes (Registrar)</button>
									<input type='hidden' name='registro' id='registro' autocomplete='off' value='4'/>
								</div>
							</fieldset>
						</form>
						<form accept-charset="UTF-8" role="form" id="ForConAud" name="ForConAud" method="post" action="registros.php">
							<fieldset>
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit"  name='Submit' value="Participantes por lista"><span class="glyphicon glyphicon-user"></span> Lista de Cadetes (Editar compañia)</button>
									<input type='hidden' name='registro' id='registro' autocomplete='off' value='10'/>
								</div>
							</fieldset>
						</form>
						<form accept-charset="UTF-8" role="form" id="ForMenReg" name="ForMenReg" method="post" action="registros.php">
							<fieldset>
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit" name='Submit' value="Academias"><span class="glyphicon glyphicon-user"></span> Academias</button>
									<input type='hidden' name='registro' id='registro' autocomplete='off' value='5'/>
								</div>
							</fieldset>
						</form>
						<form accept-charset="UTF-8" role="form" id="ForConAud" name="ForConAud" method="post" action="registros.php">
							<fieldset>
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit" name='Submit' value="Canchas"><span class="glyphicon glyphicon-user"></span> Canchas</button>
									<input type='hidden' name='registro' id='registro' autocomplete='off' value='6'/>
								</div>
							</fieldset>
						</form>
						<form accept-charset="UTF-8" role="form" id="ForConAud" name="ForConAud" method="post" action="registros.php">
							<fieldset>
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit" name='Submit' value="Compañias"><span class="glyphicon glyphicon-user"></span> Compañias</button>
									<input type='hidden' name='registro' id='registro' autocomplete='off' value='7'/>
								</div>
							</fieldset>
						</form>
						<form accept-charset="UTF-8" role="form" id="ForConAud" name="ForConAud" method="post" action="registros.php">
							<fieldset>
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit" name='Submit' value="Jerarquías"><span class="glyphicon glyphicon-user"></span> Jerarquías</button>
									<input type='hidden' name='registro' id='registro' autocomplete='off' value='8'/>
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
