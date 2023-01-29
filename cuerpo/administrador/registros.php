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
	include_once("../../clases/consultas.php");
	include_once("../../clases/javascript.php");
	if($_POST!=null)
	{
    	$a=$_POST["registro"];
	}
	if($_GET!=null)
	{
		$a=$_GET["registro"];
	}
	$anoa=date('Y');
	$mesa=date('m');
	$diaa=date('d');
	$fecha=$anoa."-".$mesa."-".$diaa;

	$atras="menureg.php";
?>
<!DOCTYPE html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title>Registro.</title>
		<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
		<link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
		<link rel="shortcut icon" type="image/png" href="../../img/icon/tank.png"/>
	</head>
	<body>
	<?php
		include("../config/navbar3.php");
		/** Formularios de registro **/
	?>
		<?php
			if($a==1)
			{
				?>	
				<br><br>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" align="center"><strong><img src="../../img/icon/soldier.png"/> Registro de Administrador</strong></h3>
						</div>
						<div class="panel-body">

						<!--Formulario de registro administradores -->	
							<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormRegAdmin' name='FormRegAdmin' method='post' action='proregistros.php'>
			 					<table class="table table-bordered" align="center">
			 						<tr align='center'>
			 							<td><strong>Academia</strong></td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Academia' id='Academia'/>
													<option value="">Seleccione</option>
														<?php
															$data=new Consultas();
															$data->Consulta_Tabla_General2('academias');
															$data->Consulta_General();
															$filadata=$data->Devuelve_Consulta();
														
															foreach ($filadata as $row1):
																echo ("<option value=".$row1['id_aca'].">".$row1['nom_aca']."</option>");
															endforeach
														?>
												</select>
											</div>
										</td>
									</tr>
			 						<tr align='center'>
			 							<td><strong>Jerarquía</strong></td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Jerarquia' id='Jerarquia'/>
													<option value="">Seleccione</option>
							 						<?php
														$data=new Consultas();
														$data->Consulta_Tabla_General('jerarquias');
														$data->Consulta_General();
														$filadata=$data->Devuelve_Consulta();
														
														foreach ($filadata as $row1):
															echo ("<option value=".$row1['id_jer'].">".$row1['nom_jer']."</option>");
														endforeach
													?>
												</select>
											</div>
										</td>
									</tr>
									<tr align='center'>
										<td><strong>Sexo</strong></td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Sexo' id='Sexo'/>
													<option value="">Seleccione</option>
							 						<?php
														$data=new Consultas();
														$data->Consulta_Tabla_General('sexos');
														$data->Consulta_General();
														$filadata=$data->Devuelve_Consulta();
														
														foreach ($filadata as $row1):
															echo ("<option value=".$row1['id_sex'].">".$row1['nom_sex']."</option>");
														endforeach
							 						?>
												</select>
											</div>
										</td>
									</tr>
									<tr align='center'>
										<td><strong>Cédula</strong></td>
										<td>
											<div class="col-xs-3">
												<input class="form-control" placeholder="C&eacute;dula" type='text' name='Cedula' id='Cedula' size='10' maxlength='9' onkeypress="return validar7(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>
										</td>	
									</tr>
									<tr align='center'>
										<td><strong>Apellidos y Nombres</strong></td>		 
										<td>
											<div class="col-xs-3">
												<input type='hidden' name='registro' id='registro' value="1"/>
												<input class="form-control" placeholder="Apellidos" type='text' name='Apellido' id='Apellido' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>
											<div class="col-xs-3"> 
												<input class="form-control" placeholder="Nombres" type='text' name='Nombre' id='Nombre' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>		
										</td>
									</tr>				
									<tr align='center'>
										<td>
											<strong>Usuario</strong>
										</td>
										<td>
											<div class="col-xs-3">
												<input placeholder="Usuario" class="form-control" type='text' name='Usuario' id='Usuario' onkeypress="return validar4(event)"/>
											</div>
										</td>
									</tr>
									<tr align='center'>
										<td>
											<strong>Contrase&ntilde;a</strong>
										</td>
										<td>
											<div class="col-xs-3">
						 						<input class="form-control" placeholder="Contrase&ntilde;a" type='password' name='Contrasena' id='Contrasena' onkeypress="return validar4(event)"/>
											</div>
										</td>
									</tr>			
									<tr align='center'>
										<td colspan='2'>
												<button class="btn btn-md btn-primary" type='button' name='Submit' value="Guardar" onclick="valida_envia_forreg_admin()"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>

											</form>
										</td>
									</tr>
									<tr align='center'>
										<td colspan='2'>
											<br>
											<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>">
												<button class="btn btn-primary" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
											</form>
										</td>
									</tr>
								</table>
						</div>
					</div>
				</div>
				</body>
				<?php
 			}

	 		if($a==2)
			{
				?>	
				<br><br>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" align="center"><strong><img src="../../img/icon/soldier.png"/>Registro de Operadores</strong></h3>
						</div>
						<div class="panel-body">	
							<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormRegMez' name='FormRegMez' method='post' action='proregistros.php'>
			 					<table class="table table-bordered" align="center">
			 						<tr align='center'>
			 							<td><strong>Academia</strong></td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Academia' id='Academia'/>
													<option value="">Seleccione</option>
														<?php
															$data=new Consultas();
															$data->Consulta_Tabla_General2('academias');
															$data->Consulta_General();
															$filadata=$data->Devuelve_Consulta();
														
															foreach ($filadata as $row1):
																echo ("<option value=".$row1['id_aca'].">".$row1['nom_aca']."</option>");
															endforeach
														?>
												</select>
											</div>
										</td>
									</tr>
			 						<tr align='center'>
			 							<td><strong>Jerarquía</strong></td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Jerarquia' id='Jerarquia'/>
													<option value="">Seleccione</option>
							 						<?php
							 							$data=new Consultas();
	 													$data->Consulta_Tabla_General('jerarquias');
	 													$data->Consulta_General();
														$filadata=$data->Devuelve_Consulta();
														
														foreach ($filadata as $row1):
															echo ("<option value=".$row1['id_jer'].">".$row1['nom_jer']."</option>");
														endforeach
							 						?>
												</select>
											</div>
										</td>
									</tr>
									<tr align='center'>
										<td><strong>Sexo</strong></td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Sexo' id='Sexo'/>
													<option value="">Seleccione</option>
							 						<?php
							 							$data=new Consultas();
														$data->Consulta_Tabla_General('sexos');
 														$data->Consulta_General();
	 													$filadata=$data->Devuelve_Consulta();
														
														foreach ($filadata as $row1):
															echo ("<option value=".$row1['id_sex'].">".$row1['nom_sex']."</option>");
														endforeach
							 						?>
												</select>
											</div>
										</td>
									</tr>
									<tr align='center'>
										<td><strong>Cédula</strong></td>
										<td>
											<div class="col-xs-3">
					 							<input class="form-control" placeholder=" C&eacute;dula" type='text' name='Cedula' id='Cedula' size='10' maxlength='9' onkeypress="return validar7(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>
										</td>	
									</tr>
									<tr align='center'>
										<td><strong>Apellidos y Nombres</strong></td>		 
										<td>
											<div class="col-xs-3">
												<input type='hidden' name='registro' id='registro' value="2"/>
												<input class="form-control" placeholder="Apellidos" type='text' name='Apellido' id='Apellido' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>
											<div class="col-xs-3">
												<input class="form-control" placeholder="Nombres" type='text' name='Nombre' id='Nombre' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>		
										</td>
									</tr>				
									<tr align='center'>
										<td><strong>Usuario</strong></td>
										<td>
											<div class="col-xs-3">
												<input placeholder="Usuario" class="form-control" type='text' name='Usuario' id='Usuario' onkeypress="return validar4(event)"/>
											</div>
										</td>
									</tr>
									<tr align='center'>
										<td><strong>Contrase&ntilde;a</strong></td>
										<td>
											<div class="col-xs-3">
						 						<input class="form-control" placeholder="Contrase&ntilde;a" type='password' name='Contrasena' id='Contrasena' onkeypress="return validar4(event)"/>
											</div>
										</td>
									</tr>	
									<tr align='center'>
										<td colspan='2'>
												<button class="btn btn-primary" type='button' name='Submit' value="Guardar" onclick="valida_envia_forreg_Mesa()"><span class="glyphicon glyphicon-floppy-save"></span> Guardar	</button>
											</form>
										</td>
									</tr>
									<tr align='center'>
										<td colspan='2'>
											<br>
											<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>">
												<button class="btn btn-primary" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
											</form>
										</td>
									</tr>
								</table>
						</div>
					</div>
				</div>
				</body>
				<?php
			}
			if($a==3)
			{
				?>	
				<br><br>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" align="center"><strong><img src="../../img/icon/soldier.png"/>Registro de Cadetes</strong></h3>
						</div>
						<div class="panel-body">	
							<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormRegPar' name='FormRegPar' method='post' action='proregistros.php'>
			 					<table class="table table-bordered" align="center">
			 						<tr align='center'>
			 							<td><strong>Academia</strong></td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Academia' id='Academia'/>
													<option value="">Seleccione</option>
							 						<?php
														$data=new Consultas();
														$data->Consulta_Tabla_General2('academias');
														$data->Consulta_General();
														$filadata=$data->Devuelve_Consulta();
														
														foreach ($filadata as $row1):
															echo ("<option value=".$row1['id_aca'].">".$row1['nom_aca']."</option>");
														endforeach
							 						?>
												</select>
											</div>
										</td>
									</tr>
									<tr align='center'>
			 							<td><strong>Compañia</strong></td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Compania' id='Compania'/>
													<option value="">Seleccione</option>
							 						<?php
														$data=new Consultas();
														$data->Consulta_Tabla_General2('companias');
														$data->Consulta_General();
														$filadata=$data->Devuelve_Consulta();
														
														foreach ($filadata as $row1):
															echo ("<option value=".$row1['id_com'].">".$row1['nom_com']."</option>");
														endforeach
							 						?>
												</select>
											</div>
										</td>
									</tr>
									<tr align='center'>
			 							<td><strong>Jerarquía</strong></td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Jerarquia' id='Jerarquia'/>
													<option value="">Seleccione</option>
							 						<?php
														$data=new Consultas();
														$data->Consulta_Tabla_General('jerarquias');
														$data->Consulta_General();
														$filadata=$data->Devuelve_Consulta();

														foreach ($filadata as $row1):
															echo ("<option value=".$row1['id_jer'].">".$row1['nom_jer']."</option>");
														endforeach
							 						?>
												</select>
											</div>
										</td>
									</tr>
									<tr align='center'>
										<td><strong>Sexo</strong></td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Sexo' id='Sexo'/>
													<option value="">Seleccione</option>
							 						<?php
														$data=new Consultas();
														$data->Consulta_Tabla_General('sexos');
														$data->Consulta_General();
														$filadata=$data->Devuelve_Consulta();
													
														foreach ($filadata as $row1):
															echo ("<option value=".$row1['id_sex'].">".$row1['nom_sex']."</option>");
														endforeach
							 						?>
												</select>
											</div>
										</td>
									</tr>
									<tr align='center'>
										<td><strong>Cédula</strong></td>
										<td>
											<div class="col-xs-3">
												<input class="form-control" placeholder=" C&eacute;dula"  type='text' name='Cedula' id='Cedula' size='10' maxlength='9' onkeypress="return validar7(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>
										</td>	
									</tr>
									<tr align='center'>
										<td>
											<strong>Matrícula</strong>
										</td>
										<td>
											<div class="col-xs-3">
			         							<input class="form-control" placeholder="Matr&iacute;cula"  type='text' name='Matricula' id='Matricula' size='10' maxlength='4' onkeypress="return validar2(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
			      							</div>
										</td>
									</tr>
									<tr align='center'>
										<td><strong>Apellidos y Nombres</strong></td>		 
										<td>
											<div class="col-xs-3">
												<input type='hidden' name='registro' id='registro' value="3"/>
												<input class="form-control" placeholder="Apellidos" type='text' name='Apellido' id='Apellido' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>
											<div class="col-xs-3">
												<input class="form-control" placeholder="Nombres" type='text' name='Nombre' id='Nombre' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>		
										</td>
									</tr>
									<tr align='center'>
										<td colspan='2'>
												<button class="btn btn-primary" type='button' name='Submit' value="Guardar" onclick="valida_envia_forreg_participante()"><span class="glyphicon glyphicon-floppy-save"></span> Guardar	</button>
											</form>
										</td>
									</tr>
									<tr align='center'>
										<td colspan='2'>
											<br>
											<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>">
											<button class="btn btn-primary" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
											</form>
										</td>
									</tr>
								</table>
						</div>
					</div>
				</div>
				</body>
				<?php
				}
				if($a==4)
				{
				?>	
				<br><br>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" align="center"><img src="../../img/icon/soldier.png"/><strong> Registro de Cadetes</strong></h3>
						</div>
						<div class="panel-body">
							<form id='FormRegPar' name='FormRegPar' role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action='proregistros.php'>
			 					<table class="table table-bordered" align="center">
			 						<tr align='center'>
										<td>
											<input type='hidden' name='registro' id='registro' value="4"/>
											<input type="file" class="btn btn-link" name="cadetescsv" title="Hacer click para buscar archivo:" />
										</td>
									</tr>
									<tr align='center'>
										<td>
    										<button type="submit" class="btn btn-lg btn-primary btn-block" value="Subir" name="submit"><span class="glyphicon glyphicon-circle-arrow-up"></span> Subir</button>
    										</form>
										</td>
									</tr>
									<tr>
										<td colspan='2'>
											<br>
											<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>">
												<button class="btn btn-lg btn-primary btn-block" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
											</form>
										</td>
									</tr>
									<tr>
										<td>
											<div class="col-sm-12">
      											<h2>Leer Importante:</h2>
 												<p>
 													Antes de buscar y cargar el archivo .csv para el registro de <b>Cadetes</b>, debe tomar en cuenta estas consideraciones:
 												</p>
 												<ol>
													<li>
															El archivo csv debe tener solo (8) columnas o (8) separaciones:
														<b>
															Cédula, Matrícula, Nombres, Apellidos, Jerarquía, Academia, Compañia, Sexo
														</b>
															Elimine las columnas o espacios que no esten dentro de estas (8) columnas o (8) separaciones.
													</li>
													<li>
														Debe tener en cuenta que al colocar las columnas de Academia, Compañia, Jerarquía y Sexo el sistema solo tomara en cuenta el Id de dichos campos, es decir que no se admitiran letras de ningún tipo.
													</li>
													<li>
														<b>
															Ejemplo:
														</b>
															18639004,0001,JORGE LEONARDO,REYES PEREZ,10,1,1,1
													</li>
													<li>
															Recuerde que EXCEL exportará el archivo .CSV separado por (;) punto y coma,  mientras que el archivo a cargar las columnas debe tener la separación por (,) coma simple.
													</li>
													<li>
															El Sistema marca en VERDE las filas que se han cargado exitosamente, tambien al posicionar el cursor encima de la fila verá la palabra "Carga Exitosa", de igual manera se marcara en ROJO las filas que tenga algún error, Ejemplo: Registro duplicado.
													</li>
													<li>
															El limite máximo de registros permitidos por archivo es de 200
													</li>
												</ol>
												<br/>
											</div>
										</td>
									</tr>
								</table>
						</div>
					</div>
				</div>
				</body>
				<?php
 			}
 			if($a==5)
			{
				?>	
				<br><br>
			<body>
			<div class="container-fluid">
				<div class="row vertical-offset-100">
					<div class="col-md-4 col-md-offset-4 col-sm-4">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title" align="center"><strong><img src="../../img/icon/soldier.png"/> Registro de Academia</strong></h3>
							</div>
							<div class="panel-body">
								<!--Formulario de registro academia -->
								<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormRegAca' name='FormRegAca' method='post' action='proregistros.php'>
									<fieldset>
										<div class="form-group">
											<label for="concept" class="col-sm-3 control-label">Nombre de la Academia</label>
											<div class="col-xs-9">
												<input type='hidden' name='registro' id='registro' value="5"/>
												<input class="form-control" placeholder="Academia" type='text' name='Academia' id='Academia' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>
										</div>

										<button class="btn btn-primary btn-block"  type='button' name='Submit' value="Guardar" onclick="valida_envia_forreg_academia()">
											<span class="glyphicon glyphicon-floppy-save"></span> Guardar
										</button>
									</fieldset>
								</form>
								<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>">
									<fieldset>
										<div class="form-group">
											<button class="btn btn-primary btn-block"  type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
										</div>
									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			</body>
			<?php
			}
			if($a==6)
			{
			?>
			<br><br>
			<body>
			<div class="container-fluid">
				<div class="row vertical-offset-100">
					<div class="col-md-4 col-md-offset-4 col-sm-4">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title" align="center"><strong><img src="../../img/icon/soldier.png"/> Registro de Canchas</strong></h3>
							</div>
							<div class="panel-body">
							<!--Formulario de registro canchas -->

							<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormRegCan' name='FormRegCan' method='post' action='proregistros.php'>
								<fieldset>
									<div class="form-group">
											<label for="concept" class="col-sm-3 control-label">Nombre de la Cancha</label>
											<div class="col-xs-9">
												<input type='hidden' name='registro' id='registro' value="6"/>
												<input class="form-control" placeholder="Cancha" type='text' name='Cancha' id='Cancha' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>
									</div>
										<button class="btn btn-primary btn-block" type='button' name='Submit' value="Guardar" onclick="valida_envia_forreg_cancha()">
											<span class="glyphicon glyphicon-floppy-save"></span> Guardar
										</button>
								</fieldset>
							</form>

							<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>">
								<fieldset>
									<button class="btn btn-primary btn-block" type='submit' name='Submit' value='Atr&aacute;s'>
										<span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás
									</button>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		</body>
		<?php
 			}
 			if($a==7)
			{
		?>
				<br><br><br><br>
				<body>
				<div class="container-fluid">
					<div class="row vertical-offset-100">
						<div class="col-md-4 col-md-offset-4 col-sm-4">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title" align="center"><strong><img src="../../img/icon/soldier.png"/> Registro de Compañias</strong></h3>
								</div>
								<div class="panel-body">
									<!--Formulario de registro compañias -->
									<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormRegCom' name='FormRegCom' method='post' action='proregistros.php'>
										<fieldset>
											<div class="form-group">
												<label for="concept" class="col-sm-3 control-label">Nombre de la Compañia</label>
												<div class="col-xs-9">
													<input type='hidden' name='registro' id='registro' value="7"/>
													<input class="form-control" placeholder="Compañia" type='text' name='Compania' id='Compania' maxlength='50' onkeypress="return validar7(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
												</div>
											</div>
											<button class="btn btn-primary btn-block" type='button' name='Submit' value="Guardar" onclick="valida_envia_forreg_companias()">
												<span class="glyphicon glyphicon-floppy-save"></span> Guardar
											</button>
										</fieldset>
									</form>
									<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>">
										<fieldset>
											<button class="btn btn-primary btn-block" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
										</fieldset>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				</body>
			<?php
 			}

 			if($a==8)
			{
			?>
				<br><br><br><br>
				<body>
				<div class="container-fluid">
					<div class="row vertical-offset-100">
						<div class="col-md-4 col-md-offset-4 col-sm-4">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title" align="center"><strong><img src="../../img/icon/soldier.png"/> Registro de Jerarquías</strong></h3>
								</div>
								<div class="panel-body">
								<!--Formulario de registro compañias -->
									<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormRegJer' name='FormRegJer' method='post' action='proregistros.php'>
										<fieldset>
											<div class="form-group">
												<label for="concept" class="col-sm-3 control-label">Nombre de la Jerarquía</label>
												<div class="col-xs-9">
													<input type='hidden' name='registro' id='registro' value="8"/>
													<input class="form-control" placeholder="Jerarquía" type='text' name='Jerarquia' id='Jerarquia' maxlength='50' onkeypress="return validar10(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>

												</div>
											</div>
											<button class="btn btn-md btn-primary btn-block" type='button' name='Submit' value="Guardar" onclick="valida_envia_forreg_jerarquias()">
												<span class="glyphicon glyphicon-floppy-save"></span> Guardar
											</button>
										</fieldset>
									</form>
									<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>">
										<fieldset>
											<button class="btn btn-primary btn-block" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
										</fieldset>
									</form>
								</div>
							</div>
						</div>
				</body>
			<?php
 			}
 			if($a==9)
			{
				?>	
				<br><br>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" align="center"><strong><img src="../../img/icon/soldier.png"/> Registro de Jefe</strong></h3>
						</div>
						<div class="panel-body">
						<!--Formulario de registro administradores -->	
			 				<table class="table table-bordered" align="center">
			 					<tr align='center'>
			 						<td><strong>Administradores</strong></td>
			 						<td>
										<div class="col-xs-3">
											<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormRegJef' name='FormRegJef' method='post' action='proregistros.php'>
												<fieldset>
													<select class="form-control" name='Administrador' id='Administrador'/>
														<option value="">Seleccione</option>
							 							<?php
															$data=new Consulta_Personas();
															$data->Consulta_Personas_Rol_Administrador();
															$data->Consulta_General();
															$filadata=$data->Devuelve_Consulta();
															foreach ($filadata as $row1):
																echo ("<option value=".$row1['id_per'].">".ucwords($row1['ape_per'])." ".ucwords($row1['nom_per'])."</option>");
															endforeach
														?>
													</select>
										</div>
									</td>
			 					</tr>
			 					<tr align='center'>
									<td><strong>Cargo</strong></td>
									<td>
										<div class="col-xs-3">
											<fieldset>
												<input class="form-control" placeholder="Cargo" type='text' name='Cargo' id='Cargo' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</fieldset>
										</div>
									</td>
								</tr>
								<tr align='center'>
									<td colspan='2'>
											<input type='hidden' name='registro' id='registro' autocomplete='off' value='9' />
											<button class="btn btn-md btn-primary btn-block" type='button' name='Submit' value="Guardar" onclick="valida_envia_forreg_jefe()">
												<span class="glyphicon glyphicon-floppy-save"></span> Guardar
											</button>
										</form>
									</td>
								</tr>
								<tr align='center'>
									<td colspan='2'>
										<br>
										<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="consultas.php">
											<input type='hidden' name='registro' id='registro' autocomplete='off' value='12' />
											<button class="btn btn-primary" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
										</form>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				</body>
				<?php
 			}
 			if($a==10)
				{
				?>	
				<br><br>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" align="center"><img src="../../img/icon/soldier.png"/><strong>  Edición por lista</strong></h3>
						</div>
						<div class="panel-body">
							<form id='FormRegPar' name='FormRegPar' role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action='proceditar.php'>
                           		<table class="table table-bordered" align="center">
                              		<tr align='center'>
                                 		<td>
                                    		<input type='hidden' name='registro' id='registro' value="9"/>
                                    		<input type="file" class="btn btn-link" name="cadetescsv" title="Hacer click para buscar archivo:" />
                                 		</td>
                              		</tr>
                              		<tr align='center'>
                                 		<td>
                                    		<button type="submit" class="btn btn-lg btn-primary btn-block" value="Subir" name="submit"><span class="glyphicon glyphicon-circle-arrow-up"></span> Subir</button>
                                    		</form>   
                                 		</td>
                              		</tr>
                              		<tr>
										<td colspan='2'>
											<br>
											<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>">
												<button class="btn btn-lg btn-primary btn-block" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
											</form>
										</td>
									</tr>
                              		<tr>
                              			<td>
                                 			<div class="col-sm-12">
                                       			<h2>Leer Importante:</h2>
                                    			<p>
                                       				Antes de buscar y cargar el archivo .csv para la edición de <b>Cadetes</b>, debe tomar en cuenta estas consideraciones:
                                    			</p>
                                    			<ol>
                                       				<li>
                                             			El archivo csv debe tener solo (2) columnas o (2) separaciones:
                                          				<b>
                                             				Cédula, Compañia
                                          				</b>
                                             			Elimine las columnas o espacios que no esten dentro de estas (2) columnas o (2) separaciones.
                                       				</li>
                                       				<li>
                                          				Debe tener en cuenta que al colocar las columnas de Id, Academia, Compañia, Jerarquía y Sexo el sistema solo tomara en cuenta el Id de dichos campos, es decir que no se admitiran letras de ningún tipo.
                                       				</li>
                                       				<li>
                                          				<b>
                                             				Ejemplo:
                                          				</b>
                                             			186390041,1
                                       				</li>
                                       				<li>
                                             			Recuerde que EXCEL exportará el archivo .CSV separado por (;) punto y coma,  mientras que el archivo a cargar las columnas debe tener la separación por (,) coma simple.
                                       				</li>
                                       				<li>
                                             			El Sistema marca en VERDE las filas que se han cargado exitosamente, tambien al posicionar el cursor encima de la fila verá la palabra "Carga Exitosa", de igual manera se marcara en ROJO las filas que tenga algún error, Ejemplo: Id no existe.
                                       				</li>
                                       				<li>
                                             			El limite máximo de ediciones permitidas por archivo es de 200
                                       				</li>
                                    			</ol>
                                 			</div>
                              			</td>
                           			</tr>
                           		</table>
						</div>
					</div>
				</div>
				</body>
				<?php
 			}
 			include("../config/footer.php");
			?>
</body>
</html>
<script src="../../js/jquery-3.1.1.min.js"></script>
<script src="../../js/bootstrap.js"></script>
<script src="../../js/jquery-backstretch.js"></script>
<script src="../../js/backstretch.js"></script>
