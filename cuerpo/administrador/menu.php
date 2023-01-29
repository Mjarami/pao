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

	/** Menu de Administradores y operadores **/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Panel del Administrador</title>
	<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
	<link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
	<link rel="shortcut icon" type="image/png" href="../../img/icon/granade.png"/>
</head>
<body>
	<?php
		include("../config/navbar3.php");
		include("../config/navbar2.php");
	?>
	<br>
	<!-- Menu de opciones administrativas -->
	<div class="container-fluid">
		<div class="row vertical-offset-100">
			<div class="col-md-4 col-md-offset-4 col-lg-4 col-sm-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title" align="center"><strong>Panel Principal del Administrador</strong></h2><br>
						<h3 class="panel-title" align="center">Selecciona la opci&oacute;n a ejecutar:</h3>
					</div>
					<div class="panel-body">
						<form accept-charset="UTF-8" role="form" id="ForMenReg" name="ForMenReg" method="post" action="menureg.php">
							<fieldset>
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit" name='Submit' value="Registros"><span class="glyphicon glyphicon-user"></span> Registros</button>
								</div>
							</fieldset>
						</form>
						<form accept-charset="UTF-8" role="form" id="ForMenCon" name="ForMenCon" method="post" action="menucon.php">
							<fieldset>
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit" name='Submit' value="Consultas"><span class="glyphicon glyphicon-search"></span> Consultas</button>
								</div>
							</fieldset>
						</form>
						<form accept-charset="UTF-8" role="form" id="ForMenNot" name="ForMenNot" method="post" action="menunot.php">
							<fieldset>
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit" name='Submit' value="Notas"><span class="glyphicon glyphicon-book"></span> Calificaciones</button>
								</div>
							</fieldset>
						</form>
						<?php
							if($permi==0)
							{
						?>
						<form accept-charset="UTF-8" role="form" id="ForConAud" name="ForConAud" method="post" action="../auditoria/menu.php">
							<fieldset>
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit" name='Submit' value="Auditorias"><span class="glyphicon glyphicon-eye-open"></span> Auditorías</button>
								</div>
							</fieldset>
						</form>
						<form accept-charset="UTF-8" role="form" id="ForJefDep" name="ForJefDep" method="post" action="consultas.php">
						<fieldset>
							<div class="form-group">
								<input type='hidden' name='registro' id='registro' autocomplete='off' value='12'/>
								<button class="btn btn-primary btn-block" type="submit" name='Submit' value="Consultas"><span class="glyphicon glyphicon-search"></span> Jefe de Departamento</button>
							</div>
						</fieldset>
					</form>
						<?php
							}
						?>
						<form accept-charset="UTF-8" role="form" id="ForSalir" name="ForSalir" method="post" action="../logeo/cerrar.php">
							<fieldset>
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="submit" name='Submit' value="Cerrar Sesi&oacute;n"><span class="glyphicon glyphicon-off"></span> Cerrar Sesi&oacute;n</button>
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
