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
	include_once("../../clases/validaformu.php");
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

	$atras="consultas.php";

	/** Formularios de ediciones **/
?>
<!DOCTYPE html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<title>Editar</title>
		<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
		<link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
		<link href="../../img/icon/helmet.png" rel="shortcut icon" type="image/png"/>
    	<script> 
			function mostrarReferencia1()
			{
				if (document.FormEdiAdmin.Contrasena[1].checked == true) 
				{
					document.getElementById('desdeotro').style.display='block';
				}
				else
				{
					document.getElementById('desdeotro').style.display='none';
				}
			}
			function mostrarReferencia2()
			{
				if (document.FormEdiMesa.Contrasena[1].checked == true) 
				{
					document.getElementById('desdeotro2').style.display='block';
				}
				else
				{
					document.getElementById('desdeotro2').style.display='none';
				}
			}
			function mostrarReferencia3()
			{
				if (document.FormEdiJurado.Contrasena[1].checked == true) 
				{
					document.getElementById('desdeotro3').style.display='block';
				}
				else
				{
					document.getElementById('desdeotro3').style.display='none';
				}
			}
			function mostrarReferencia4()
			{
				if (document.FormEdiParti.Contrasena[1].checked == true) 
				{
					document.getElementById('desdeotro4').style.display='block';
				}
				else
				{
					document.getElementById('desdeotro4').style.display='none';
				}
			}
			function mostrarReferencia5()
			{
				if (document.FormEdiCadetes.Cambiomatri[1].checked == true) 
				{
					document.getElementById('cambiomatri').style.display='block';
				}
				else
				{
					document.getElementById('cambiomatri').style.display='none';
				}
			}
		</script>
	</head>
	<body>
	<?php
		include("../config/navbar3.php");
	?>
		<?php
			if($a==1)
			{
				if($_POST!=null)
				{
    				$cedula=$_POST["cedula"];
				}
				if($_GET!=null)
				{
					$cedula=$_GET["cedula"];
				}

				$data= new Consulta_Personas();
                $data->Consulta_Cedula_Rol_Administrador($cedula);
                $data->Consulta_General();
                $datos=$data->Devuelve_Consulta();
                $id_persona=$datos[0]['id_per'];
                $id_academia=$datos[0]['id_aca'];
                $academia=$datos[0]['nom_aca'];
                $id_jerarquia=$datos[0]['id_jer'];
                $jerarquia=$datos[0]['nom_jer'];
                $id_sexo=$datos[0]['id_sex'];
                $sexo=$datos[0]['nom_sex'];
                $cedula=$datos[0]['ced_per'];
                $apellidos=$datos[0]['ape_per'];
                $nombres=$datos[0]['nom_per'];
                $usuario=$datos[0]['usu_acc'];
                $habia=$academia." ".$jerarquia." ".$sexo." ".$cedula." ".$apellidos." ".$nombres." ".$usuario;
				?>	
				<br><br>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" align="center"><strong>Editar Datos del Administrador</strong></h3>
						</div>
						<div class="panel-body">	
							<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormEdiAdmin' name='FormEdiAdmin' method='post' action='proceditar.php'>
			 					<table class="table table-bordered" align="center">
			 						<tr align='center'>
			 							<td>
											<strong>Academia</strong>
										</td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Academia' id='Academia'/>
													<option value="<?php echo $id_academia; ?>"><?php echo $academia; ?></option>
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
													<option value="<?php echo $id_jerarquia; ?> "><?php echo $jerarquia; ?></option>
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
													<option value="<?php echo $id_sexo; ?>"><?php echo $sexo; ?></option>
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
										<td>
											<strong>Cédula</strong>
										</td>
										<td>
											<div class="col-xs-3">
			         							<input class="form-control" placeholder="C&eacute;dula"  type='text' name='Cedula' id='Cedula' size='10' maxlength='9' onkeypress="return validar7(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();" value="<?php echo $cedula; ?>"/>
			      							</div>
										</td>	
									</tr>
									<tr align='center'>
										<td>
											<strong>Apellidos y Nombres</strong>
										</td>		 
										<td>
											<div class="col-xs-3">  
												<input type='hidden' name='registro' id='registro' value="1"/>
												<input type='hidden' name='id_persona' id='id_persona' value="<?php echo $id_persona; ?>"/>
												<input type='hidden' name='Habia' id='Habia' value="<?php echo $habia; ?>"/>
												<input class="form-control" placeholder="Apellidos" type='text' name='Apellidos' id='Apellidos' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();" value="<?php echo $apellidos; ?>"/>
											</div>
											<div class="col-xs-3">						   
												<input class="form-control"  placeholder="Nombres"  type='text' name='Nombres' id='Nombres' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();" value="<?php echo $nombres; ?>"/>
											</div>		
										</td>
									</tr>				
									<tr align='center'>
										<td>
											<strong>Usuario</strong>
										</td>
										<td>
											<div class="col-xs-3">   
												<input placeholder="Usuario" class="form-control" type='text' name='Usuario' id='Usuario' onkeypress="return validar4(event)" value="<?php echo $usuario; ?>"/>
											</div>
										</td>
									</tr>
									<tr align='center'>
										<td>
											<strong>Contrase&ntilde;a</strong>
										</td>
										<td>
											<div class="col-xs-3">
												<input type="radio" name="Contrasena" value="No" onclick="mostrarReferencia1();"> No
												<input type="radio" name="Contrasena" value="Si" onclick="mostrarReferencia1();"> Si
											</div>
											<div id="desdeotro" style="display:none;">
												<input class="form-control" placeholder="Contrasena" type='password' name='Contrasena1' id='Contrasena1' maxlength='50' onkeypress="return validar4(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>
										</td>
									</tr>			
									<tr align='center'>
										<td colspan='2'>
											<button class="btn btn-primary" type='button' name='Submit' value="Guardar" onclick="valida_envia_foredi_admin()"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
											</form>
										</td>
									</tr>
									<tr align='center'>
										<td colspan='2'>
											<br>
											<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>?registro=1">
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
				if($_POST!=null)
				{
    				$cedula=$_POST["cedula"];
				}
				if($_GET!=null)
				{
					$cedula=$_GET["cedula"];
				}

				$data= new Consulta_Personas();
                $data->Consulta_Cedula_Rol_Asistente($cedula);
                $data->Consulta_General();
                $datos=$data->Devuelve_Consulta();
                $id_persona=$datos[0]['id_per'];
                $id_academia=$datos[0]['id_aca'];
                $academia=$datos[0]['nom_aca'];
                $id_jerarquia=$datos[0]['id_jer'];
                $jerarquia=$datos[0]['nom_jer'];
                $id_sexo=$datos[0]['id_sex'];
                $sexo=$datos[0]['nom_sex'];
                $cedula=$datos[0]['ced_per'];
                $apellidos=$datos[0]['ape_per'];
                $nombres=$datos[0]['nom_per'];
                $usuario=$datos[0]['usu_acc'];
                $habia=$academia." ".$jerarquia." ".$sexo." ".$cedula." ".$apellidos." ".$nombres." ".$usuario;
				?>	
				<br><br>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" align="center"><strong>Editar datos del Operador</strong></h3>
						</div>
						<div class="panel-body">	
							<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormEdiMesa' name='FormEdiMesa' method='post' action='proceditar.php'>
			 					<table class="table table-bordered" align="center">
			 						<tr align='center'>
			 							<td>
											<strong>Academia</strong>
										</td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Academia' id='Academia'/>
													<option value="<?php echo $id_academia; ?>"><?php echo $academia; ?></option>
							 						<?php
							 							$data=new Consultas();
    													$data->Consulta_Tabla_General2('academias');
    													$data->Consulta_General();
    													$filadata=$data->Devuelve_Consulta();
														
														foreach ($filadata as $row1):
                                							echo ("
								  								<option value=".$row1['id_aca'].">".$row1['nom_aca']."</option>
								   							");
                                						endforeach
							 						?>
												</select>
											</div>
										</td>
									</tr>
			 						<tr align='center'>
			 							<td>
											<strong>Jerarquía</strong>
										</td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Jerarquia' id='Jerarquia'/>
													<option value="<?php echo $id_jerarquia; ?>"><?php echo $jerarquia; ?></option>
							 						<?php
														$data=new Consultas();
    													$data->Consulta_Tabla_General('jerarquias');
    													$data->Consulta_General();
    													$filadata=$data->Devuelve_Consulta();
														
														foreach ($filadata as $row1):
                                							echo ("
								  								<option value=".$row1['id_jer'].">".$row1['nom_jer']."</option>
								   							");
                                						endforeach
							 						?>
												</select>
											</div>
										</td>
									</tr>
									<tr align='center'>
										<td>
											<strong>Sexo</strong>
										</td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Sexo' id='Sexo'/>
													<option value="<?php echo $id_sexo; ?>"><?php echo $sexo; ?></option>
							 						<?php
														$data=new Consultas();
    													$data->Consulta_Tabla_General('sexos');
    													$data->Consulta_General();
    													$filadata=$data->Devuelve_Consulta();
														
														foreach ($filadata as $row1):
                                							echo ("
								  								<option value=".$row1['id_sex'].">".$row1['nom_sex']."</option>
								   							");
                                						endforeach
							 						?>
												</select>
											</div>
										</td>
									</tr>
									<tr align='center'>
										<td>
											<strong>Cédula</strong>
										</td>
										<td>
											<div class="col-xs-3">
			         							<input class="form-control" placeholder="C&eacute;dula"  type='text' name='Cedula' id='Cedula' size='10' maxlength='9' onkeypress="return validar7(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();" value="<?php echo $cedula; ?>"/>
			      							</div>
										</td>	
									</tr>
									<tr align='center'>
										<td>
											<strong>Apellidos y Nombres</strong>
										</td>		 
										<td>
											<div class="col-xs-3">  
												<input type='hidden' name='registro' id='registro' value="2"/>
												<input type='hidden' name='id_persona' id='id_persona' value="<?php echo $id_persona; ?>"/>
												<input type='hidden' name='Habia' id='Habia' value="<?php echo $habia; ?>"/>
												<input class="form-control" placeholder="Apellidos" type='text' name='Apellidos' id='Apellidos' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();" value="<?php echo $apellidos; ?>"/>
											</div>
											<div class="col-xs-3">						   
												<input class="form-control"  placeholder="Nombres"  type='text' name='Nombres' id='Nombres' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();" value="<?php echo $nombres; ?>"/>
											</div>		
										</td>
									</tr>				
									<tr align='center'>
										<td>
											<strong>Usuario</strong>
										</td>
										<td>
											<div class="col-xs-3">   
												<input placeholder="Usuario" class="form-control" type='text' name='Usuario' id='Usuario' onkeypress="return validar4(event)" value="<?php echo $usuario; ?>"/>
											</div>
										</td>
									</tr>
									<tr align='center'>
										<td>
											<strong>Contrase&ntilde;a</strong>
										</td>
										<td>
											<div class="col-xs-3">
												<input type="radio" name="Contrasena" value="No" onclick="mostrarReferencia2();"> No
												<input type="radio" name="Contrasena" value="Si" onclick="mostrarReferencia2();"> Si
											</div>
											<div id="desdeotro2" style="display:none;">
												<input class="form-control" placeholder="Contrasena" type='password' name='Contrasena1' id='Contrasena1' maxlength='50' onkeypress="return validar4(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>
										</td>
									</tr>			
									<tr align='center'>
										<td colspan='2'>
												<button class="btn btn-primary" type='button' name='Submit' value="Guardar" onclick="valida_envia_foredi_Mesa()"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
											</form>
										</td>
									</tr>
									<?php
										if($_SESSION['rol']== 2)
    									{
        									?>
        									<tr align='center'>
												<td colspan='2'>
													<br>
													<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>?registro=2&buscando=<?php echo $_SESSION['ced'];?>">
														<button class="btn btn-primary" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
													</form>
												</td>
											</tr>
											<?php
    									}
    									else
    									{
    										?>
        									<tr align='center'>
												<td colspan='2'>
													<br>
													<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>?registro=2">
														<button class="btn btn-primary" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
													</form>
												</td>
											</tr>
											<?php
    									}
    								?>
								</table>
						</div>
					</div>
				</div>
				</body>
				<?php
   			}

   			if($a==3)
			{
				if($_POST!=null)
				{
    				$cedula=$_POST["Cedula"];
				}
				if($_GET!=null)
				{
					$cedula=$_GET["Cedula"];
				}

				$data= new Consulta_Personas();
                $data->Consulta_Cedula_Rol_Participante($cedula);
                $data->Consulta_General();
                $datos=$data->Devuelve_Consulta();
                $id_persona=$datos[0]['id_per'];
                $id_academia=$datos[0]['id_aca'];
                $academia=$datos[0]['nom_aca'];
                $id_compania=$datos[0]['id_com'];
                $compania=$datos[0]['nom_com'];
                $id_jerarquia=$datos[0]['id_jer'];
                $jerarquia=$datos[0]['nom_jer'];
                $id_sexo=$datos[0]['id_sex'];
                $sexo=$datos[0]['nom_sex'];
                $cedula=$datos[0]['ced_per'];
                $matricula=$datos[0]['mat_per'];
                $apellidos=$datos[0]['ape_per'];
                $nombres=$datos[0]['nom_per'];
                $usuario=$datos[0]['usu_acc'];
                $habia=$academia." ".$compania." ".$jerarquia." ".$sexo." ".$cedula." ".$matricula." ".$apellidos." ".$nombres." ".$usuario;
				?>	
				<br><br><br>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" align="center"><strong>Editar datos del Cadetes</strong></h3>
						</div>
						<div class="panel-body">	
							<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormEdiCadetes' name='FormEdiCadetes' method='post' action='proceditar.php'>
			 					<table class="table table-bordered" align="center">
			 						<tr align='center'>
			 							<td>
											<strong>Academia</strong>
										</td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Academia' id='Academia'/>
													<option value="<?php echo $id_academia; ?>"><?php echo $academia; ?></option>
							 						<?php
							 							$data=new Consultas();
    													$data->Consulta_Tabla_General2('academias');
    													$data->Consulta_General();
    													$filadata=$data->Devuelve_Consulta();
														
														foreach ($filadata as $row1):
                                							echo ("
								  								<option value=".$row1['id_aca'].">".$row1['nom_aca']."</option>
								   							");
                                						endforeach
							 						?>
												</select>
											</div>
										</td>
									</tr>
									<tr align='center'>
			 							<td>
											<strong>Compania</strong>
										</td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Compania' id='Compania'/>
													<option value="<?php echo $id_compania; ?>"><?php echo $compania; ?></option>
							 						<?php
							 							$data=new Consultas();
    													$data->Consulta_Tabla_General2('companias');
    													$data->Consulta_General();
    													$filadata=$data->Devuelve_Consulta();
														
														foreach ($filadata as $row1):
                                							echo ("
								  								<option value=".$row1['id_com'].">".$row1['nom_com']."</option>
								   							");
                                						endforeach
							 						?>
												</select>
											</div>
										</td>
									</tr>
			 						<tr align='center'>
			 							<td>
											<strong>Jerarquía</strong>
										</td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Jerarquia' id='Jerarquia'/>
													<option value="<?php echo $id_jerarquia; ?>"><?php echo $jerarquia; ?></option>
							 						<?php
														$data=new Consultas();
    													$data->Consulta_Tabla_General('jerarquias');
    													$data->Consulta_General();
    													$filadata=$data->Devuelve_Consulta();
														
														foreach ($filadata as $row1):
                                							echo ("
								  								<option value=".$row1['id_jer'].">".$row1['nom_jer']."</option>
								   							");
                                						endforeach
							 						?>
												</select>
											</div>
										</td>
									</tr>
									<tr align='center'>
										<td>
											<strong>Sexo</strong>
										</td>
										<td>
											<div class="col-xs-3">
												<select class="form-control" name='Sexo' id='Sexo'/>
													<option value="<?php echo $id_sexo; ?>"><?php echo $sexo; ?></option>
							 						<?php
														$data=new Consultas();
    													$data->Consulta_Tabla_General('sexos');
    													$data->Consulta_General();
    													$filadata=$data->Devuelve_Consulta();
														
														foreach ($filadata as $row1):
                                							echo ("
								  								<option value=".$row1['id_sex'].">".$row1['nom_sex']."</option>
								   							");
                                						endforeach
							 						?>
												</select>
											</div>
										</td>
									</tr>
									<tr align='center'>
										<td>
											<strong>Cédula</strong>
										</td>
										<td>
											<div class="col-xs-3">
			         							<input class="form-control" placeholder="C&eacute;dula"  type='text' name='Cedula' id='Cedula' size='10' maxlength='9' onkeypress="return validar7(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();" value="<?php echo $cedula; ?>"/>
			      							</div>
										</td>	
									</tr>
									<tr align='center'>
										<td>
											<strong>Matrícula</strong>
										</td>
										<td>
											<div class="col-xs-3">
												<input type="radio" name="Cambiomatri" value="No" onclick="mostrarReferencia5();"> No
												<input type="radio" name="Cambiomatri" value="Si" onclick="mostrarReferencia5();"> Si
											</div>
											<div id="cambiomatri" style="display:none;">
												<div class="col-xs-3">
			         								<input class="form-control" placeholder="Matr&iacute;cula"  type='text' name='Matricula' id='Matricula' size='10' maxlength='4' onkeypress="return validar2(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();" value="<?php echo $matricula; ?>"/>
			      								</div>
											</div>
										</td>
										<td>
											
										</td>	
									</tr>
									<tr align='center'>
										<td>
											<strong>Apellidos y Nombres</strong>
										</td>		 
										<td>
											<div class="col-xs-3">  
												<input type='hidden' name='registro' id='registro' value="3"/>
												<input type='hidden' name='id_persona' id='id_persona' value="<?php echo $id_persona; ?>"/>
												<input type='hidden' name='Habia' id='Habia' value="<?php echo $habia; ?>"/>
												<input class="form-control" placeholder="Apellidos" type='text' name='Apellidos' id='Apellidos' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();" value="<?php echo $apellidos; ?>"/>
											</div>
											<div class="col-xs-3">						   
												<input class="form-control"  placeholder="Nombres"  type='text' name='Nombres' id='Nombres' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();" value="<?php echo $nombres; ?>"/>
											</div>		
										</td>
									</tr>			
									<tr align='center'>
										<td colspan='2'>
												<button class="btn btn-primary" type='button' name='Submit' value="Guardar" onclick="valida_envia_foredi_participante()"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
											</form>
										</td>
									</tr>
									<tr align='center'>
										<td colspan='2'>
											<br>
											<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>?registro=3">
												<button class="btn btn-primary" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás </button>
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
				if($_POST!=null)
				{
    				$academia=$_POST["academia"];
				}
				if($_GET!=null)
				{
					$academia=$_GET["academia"];
				}

				$data= new Consulta_academias();
                $data->Consulta_Nombre_Academia($academia);
                $data->Consulta_General();
                $datos=$data->Devuelve_Consulta();
                $id_academia=$datos[0]['id_aca'];
                $academia=$datos[0]['nom_aca'];
                $habia=$academia;
				?>	
				<br><br>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" align="center"><strong>Editar Academia</strong></h3>
						</div>
						<div class="panel-body">	
							<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormEdiAca' name='FormEdiAca' method='post' action='proceditar.php'>
			 					<table class="table table-bordered" align="center">
			 						<tr align='center'>
			 							<td align='center'>
											<strong>Nombre</strong>
										</td>		 
										<td>
											<div class="col-xs-3">  
												<input type='hidden' name='registro' id='registro' value="4"/>
												<input type='hidden' name='id' id='id' value="<?php echo $id_academia; ?>"/>
												<input type='hidden' name='Habia' id='Habia' value="<?php echo $habia; ?>"/>
												<input class="form-control" placeholder="Academia" type='text' name='Academia' id='Academia' value="<?php echo $academia; ?>" maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>	
										</td>
									</tr>		
									<tr align='center'>
										<td colspan='2'>
											<button class="btn btn-primary" type='button' name='Submit' value="Guardar" onclick="valida_envia_foredi_academia()"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
											</form>
										</td>
									</tr>
									<tr align='center'>
										<td colspan='2'>
											<br>
											<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>?registro=6">
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

   			if($a==5)
			{
				if($_POST!=null)
				{
    				$cancha=$_POST["cancha"];
				}
				if($_GET!=null)
				{
					$cancha=$_GET["cancha"];
				}

				$data= new Consulta_Canchas();
                $data->Consulta_Nombre_Cancha($cancha);
                $data->Consulta_General();
                $datos=$data->Devuelve_Consulta();
                $id_cancha=$datos[0]['id_can'];
                $cancha=$datos[0]['nom_can'];
                $habia=$cancha;
				?>	
				<br><br>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" align="center"><strong>Editar Cancha</strong></h3>
						</div>
						<div class="panel-body">	
							<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormEdiCan' name='FormEdiCan' method='post' action='proceditar.php'>
			 					<table class="table table-bordered" align="center">
			 						<tr align='center'>
			 							<td align='center'>
											<strong>Nombre</strong>
										</td>		 
										<td>
											<div class="col-xs-3">  
												<input type='hidden' name='registro' id='registro' value="5"/>
												<input type='hidden' name='id' id='id' value="<?php echo $id_cancha; ?>"/>
												<input type='hidden' name='Habia' id='Habia' value="<?php echo $habia; ?>"/>
												<input class="form-control" placeholder="Cancha" type='text' name='Cancha' id='Cancha' value="<?php echo $cancha; ?>" maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>	
										</td>
									</tr>		
									<tr align='center'>
										<td colspan='2'>
											<button class="btn btn-primary" type='button' name='Submit' value="Guardar" onclick="valida_envia_foredi_cancha()"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
											</form>
										</td>
									</tr>
									<tr align='center'>
										<td colspan='2'>
											<br>
											<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>?registro=7">
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

   			if($a==6)
			{
				if($_POST!=null)
				{
    				$compania=$_POST["compania"];
				}
				if($_GET!=null)
				{
					$compania=$_GET["compania"];
				}

				$data= new Consulta_companias();
                $data->Consulta_Nombre_Compania($compania);
                $data->Consulta_General();
                $datos=$data->Devuelve_Consulta();
                $id_compania=$datos[0]['id_com'];
                $compania=$datos[0]['nom_com'];
                $habia=$compania;
				?>	
				<br><br>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" align="center"><strong>Editar Compañia</strong></h3>
						</div>
						<div class="panel-body">	
							<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormEdiCom' name='FormEdiCom' method='post' action='proceditar.php'>
			 					<table class="table table-bordered" align="center">
			 						<tr align='center'>
			 							<td align='center'>
											<strong>Nombre</strong>
										</td>		 
										<td>
											<div class="col-xs-3">  
												<input type='hidden' name='registro' id='registro' value="6"/>
												<input type='hidden' name='id' id='id' value="<?php echo $id_compania; ?>"/>
												<input type='hidden' name='Habia' id='Habia' value="<?php echo $habia; ?>"/>
												<input class="form-control" placeholder="Compania" type='text' name='Compania' id='Compania' value="<?php echo $compania; ?>" maxlength='50' onkeypress="return validar7(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>	
										</td>
									</tr>		
									<tr align='center'>
										<td colspan='2'>
											<button class="btn btn-primary" type='button' name='Submit' value="Guardar" onclick="valida_envia_foredi_compania()"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
											</form>
										</td>
									</tr>
									<tr align='center'>
										<td colspan='2'>
											<br>
											<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>?registro=8">
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

   			if($a==7)
			{
				if($_POST!=null)
				{
    				$jerarquia=$_POST["jerarquia"];
				}
				if($_GET!=null)
				{
					$jerarquia=$_GET["jerarquia"];
				}

				$data= new Consulta_jerarquias();
                $data->Consulta_Nombre_Jerarquia($jerarquia);
                $data->Consulta_General();
                $datos=$data->Devuelve_Consulta();
                $id_jerarquia=$datos[0]['id_jer'];
                $jerarquia=$datos[0]['nom_jer'];
                $habia=$jerarquia;
				?>	
				<br><br>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" align="center"><strong>Editar Jerarquia</strong></h3>
						</div>
						<div class="panel-body">	
							<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormEdiJer' name='FormEdiJer' method='post' action='proceditar.php'>
			 					<table class="table table-bordered" align="center">
			 						<tr align='center'>
			 							<td align='center'>
											<strong>Nombre</strong>
										</td>		 
										<td>
											<div class="col-xs-3">  
												<input type='hidden' name='registro' id='registro' value="7"/>
												<input type='hidden' name='id' id='id' value="<?php echo $id_jerarquia; ?>"/>
												<input type='hidden' name='Habia' id='Habia' value="<?php echo $habia; ?>"/>
												<input class="form-control" placeholder="Jerarquía" type='text' name='Jerarquia' id='Jerarquia' value="<?php echo $jerarquia; ?>" maxlength='50' onkeypress="return validar7(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											</div>	
										</td>
									</tr>		
									<tr align='center'>
										<td colspan='2'>
											<button class="btn btn-primary" type='button' name='Submit' value="Guardar" onclick="valida_envia_foredi_jerarquia()"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
											</form>
										</td>
									</tr>
									<tr align='center'>
										<td colspan='2'>
											<br>
											<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>?registro=9">
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

   			if($a==8)
			{
				$data=new Consulta_personas();
                $data->Consulta_Jefe_Departamento();
                $data->Consulta_General();
                $filadata=$data->Devuelve_Consulta();
                $id_jefe=$filadata[0]['id_jef'];
                $habia=$filadata[0]['nom_jer'].", ".$filadata[0]['ape_per']." ".$filadata[0]['nom_per'].", ".$filadata[0]['car_jef'];
				?>	
				<br><br>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" align="center"><strong>Editar Jefe</strong></h3>
						</div>
						<div class="panel-body">
						<!--Formulario de registro administradores -->	
			 				<table class="table table-bordered" align="center">
			 					<tr align='center'>
			 						<td><strong>Administradores</strong></td>
			 						<td>
										<div class="col-xs-3">
											<form accept-charset="UTF-8" role="form" class="form-horizontal" id='FormEdiJef' name='FormEdiJef' method='post' action='proceditar.php'>
												<fieldset>
													<select class="form-control" name='Administrador' id='Administrador'/>
							 							<?php
							 								echo "<option value=".$filadata[0]['id_per'].">".ucwords($filadata[0]['ape_per']." ".$filadata[0]['nom_per'])."</option>";
															$data2=new Consulta_Personas();
															$data2->Consulta_Personas_Rol_Administrador();
															$data2->Consulta_General();
															$filadata2=$data2->Devuelve_Consulta();
															foreach ($filadata2 as $row1):
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
												<input class="form-control" placeholder="Cargo" type='text' name='Cargo' id='Cargo' maxlength='50' onkeypress="return validar6(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();" value="<?php echo $filadata[0]['car_jef']; ?>" />
											</fieldset>
										</div>
									</td>
								</tr>
								<tr align='center'>
									<td colspan='2'>
											<input type='hidden' name='registro' id='registro' autocomplete='off' value='8' />
											<input type='hidden' name='id' id='id' value="<?php echo $id_jefe; ?>" />
											<input type='hidden' name='Habia' id='Habia' value="<?php echo $habia; ?>" />
											<button class="btn btn-primary" type='button' name='Submit' value="Guardar" onclick="valida_envia_foredi_jefe()"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
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
   		?>   
</body>
</html>
<script src="../../js/jquery-3.1.1.min.js"></script>
<script src="../../js/bootstrap.js"></script>
<script src="../../js/jquery-backstretch.js"></script>
<script src="../../js/backstretch.js"></script>
