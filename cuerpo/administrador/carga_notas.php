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

	$atras="menunot.php";

	/** Formularios para la carga de calificaciones **/
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	    <title>Carga de Calificaciones</title>
		<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
		<link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
		<link href="../../img/icon/helmet.png" rel="shortcut icon" type="image/png"/>
	</head>
	<body>
<?php
	include("../config/navbar3.php");
?>
		<?php
			if($a==1)
			{
				?>	
				<br><br><br><br>
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" align="center"><strong>Carga de Calificaciones</strong></h3>
						</div>
						<div class="panel-body">
							<form id='FormBusCed' name='FormBusCed' role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action='carga_notas.php'>
			 					<table class="table table-bordered" align="center">
			 						<tr align='center'>
										<td>
											<input class="form-control" type='text' name='cedula' id='cedula' size='10' list="lisced" maxlength='9' onkeypress="return validar7(event)" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();"/>
											<datalist id="lisced">
                  								<?php
                  									$data=new Consulta_Personas();
    												$data->Consulta_personas_Rol_Participante();
    												$data->Consulta_General();
    												$filadata=$data->Devuelve_Consulta();
														
													foreach ($filadata as $row1):
                                						echo ("
								  							<option value=".$row1['ced_per'].">".$row1['ced_per']." ".$row1['mat_per']." ".$row1['ape_per']." ".$row1['nom_per']."</option>
								   						");
                                					endforeach
                  								?>
               								</datalist>
										</td>
									</tr>
									<tr align='center'>
                              			<td colspan='4'>
                                 			<input type='hidden' name='registro' id='registro' autocomplete='off' value='1'/>
                                 			<button class="btn btn-primary" type='submit' name='Submit' value='Buscar'><span class="glyphicon glyphicon-search"></span> Buscar</button>
                              			</td>
                           			</tr>
								</table>
							</form>
								<?php	
									if($_POST["cedula"]!=null || $_GET["cedula"]!=null)
                  					{
                  						if($_POST!=null)
										{
    										$cedula=$_POST["cedula"];
    									}
										if($_GET!=null)
										{
    										$cedula=$_GET["cedula"];
										}
                  						?>
                  						<br>
										<center>
											<?php
                              					$busced2=new Consulta_personas();
                              					$busced2->Consulta_Cedula_Rol_Participante($cedula);
    											$busced2->Consulta_General();
    											$filadata_busced2=$busced2->Devuelve_Consulta();
    											$busced2->Consulta_Paginador();
                              					$num_total_registros_busced2=$busced2->Devuelve_Contador();

    											$jerarquia=$filadata_busced2[0]['nom_jer'];
    											$apellido=$filadata_busced2[0]['ape_per'];
    											$nombre=$filadata_busced2[0]['nom_per'];
    											$cedula=$filadata_busced2[0]['ced_per'];
    											$matricula=$filadata_busced2[0]['mat_per'];
    											$academia=$filadata_busced2[0]['nom_aca'];
    											$compania=$filadata_busced2[0]['nom_com'];
    											$sexo=$filadata_busced2[0]['nom_sex'];

    											if($num_total_registros_busced2>0)
    											{
    												echo ("
								  						".$jerarquia." ".$apellido." ".$nombre."
								  						<br><br>
								  						Cedula: ".$cedula."
								  						<br>
								  						Matrícula: ".$matricula."
								  						<br>
								  						Academia: ".$academia."
								  						<br>
								  						Compañia: ".$compania."
								  						<br>
								  						Sexo: ".$sexo."
								   					");
								   				}
								   				else
								   				{
								   					echo "<script language='javascript'>
														alert ('".$cedula." Este cadete no esta registrado');
														window.location='carga_notas.php?registro=1';
													</script>";
								   				}
							 				?>
										</center>
										<br><br>
										<table class="table table-bordered" align="center">
											<tr align='center'>
                           						<td>
                              						<strong>Cancha</strong>
                           						</td>
                           						<td>
                              						<strong>Calificación</strong>
                           						</td>
                           						<td>
                              						<strong>Proceso</strong>
                           						</td>
                        					</tr>
                        					<?php
    											$data=new Consultas();
    											$data->Consulta_Tabla_General2('canchas');
    											$data->Consulta_General();
    											$filadata=$data->Devuelve_Consulta();
												
												$nota2=$_POST["nota2"];
												$cancha2=$_POST["cancha2"];
												$habia2=$_POST["habia2"];
												$pulsado=$_POST["pulsado"];
												foreach ($filadata as $row1)
												{
													$busced=new Consulta_Evaluaciones();
    												$busced->Consulta_Evaluacion_General_Cedula($cedula, $row1['id_can']);
    												$busced->Consulta_General();
    												$filadata_busced=$busced->Devuelve_Consulta();
    												
                                					echo ("
								  						<tr align='center'>
                           									<td>
                           										<br>
                              									".$row1['nom_can']."
                           									</td>
                           							");
                                					if($row1['nom_can']==$filadata_busced[0]['nom_can'])
                                					{
                                						$eva=$filadata_busced[0]['not_eva'];
                                					}
                                					else
                                					{
                                						$eva=null;
                                					}
                                					if ($eva!=null)
                                					{
                                						if($pulsado!=null)
                                						{
                                							?>
                                							<script language='Javascript'> 
                    											function confirmar()
                    											{
                        											confirmar=confirm('Editar una nota existente es un acto que se considera sancionable ya que compromete tanto la ética como la fiabilidad de los datos en el sistema, presiona el botón Aceptar solo si estas seguro de lo que haces'); 
                        											if (confirmar) 
                        											{
                            											window.location='preguntaeditar.php?registro=1&cedula=<?php echo $cedula;?>&nota=<?php echo $nota2;?>&habia=<?php echo $habia2;?>&cancha=<?php echo $cancha2;?>';
                        											}
                        											else
                        											{	
                            											window.location='carga_notas.php?registro=1&cedula=<?php echo $cedula;?>';
                        											}
                    											} 
                											</script>
                											<?php
                											echo "
                												<script>
																	javascript:confirmar();
																</script>
															";
                											$pulsado=null;
                                						}
                                						else
                                						{
                           									echo ("
                           										<td>
                           											<br>
                           											<form id='ForEdiAdm' name='ForEdiAdm' method='post' action='carga_notas.php'>
                              											<input class='form-control' placeholder='Calificación' type='text' name='nota2' id='nota2' size='2' maxlength='2' onkeypress='return validar2(event)' style='text-transform:lowercase;' onkeyup='javascript:this.value=this.value.toLowerCase();' value='".$eva."'/>
                           										</td>
                           										<td>
                                    									<input type='hidden' name='registro' id='registro' value='1'/>
                                    									<input type='hidden' name='pulsado' id='pulsado' value='1'/>
                                    									<input type='hidden' name='cancha2' id='cancha2' autocomplete='off' value='".$row1['id_can']."'/>
                                    									<input type='hidden' name='cedula' id='cedula' autocomplete='off' value='".$cedula."'/>
                                    									<input type='hidden' name='habia2' id='habia2' autocomplete='off' value='".$eva."'/>
                                    									<br>
                                    									<button type='submit' class='btn btn-primary' value='Subir' name='submit'><span class='glyphicon glyphicon-circle-arrow-up'></span> Cargar</button>
                                 										</form>
                              										</td>
                        										</tr>
								   							");
								   						}
                                					}
                                					else
                                					{
                                						echo ("
                           										<td>
                           											<br>
                           											<form id='ForEdiAdm' name='ForEdiAdm' method='post' action='pronotas.php'>
                              											<input class='form-control' placeholder='Calificación' type='text' name='nota' id='nota' size='2' maxlength='2' onkeypress='return validar2(event)' style='text-transform:lowercase;' onkeyup='javascript:this.value=this.value.toLowerCase();' value='".$eva."'/>
                           										</td>
                           										<td>
                                    									<input type='hidden' name='registro' id='registro' value='1'/>
                                    									<input type='hidden' name='cancha' id='cancha' autocomplete='off' value='".$row1['id_can']."'/>
                                    									<input type='hidden' name='cedula' id='cedula' autocomplete='off' value='".$cedula."'/>
                                    									<input type='hidden' name='habia' id='habia' autocomplete='off' value='".$eva."'/>
                                    									<br>
                                    									<button type='submit' class='btn btn-primary' value='Subir' name='submit'><span class='glyphicon glyphicon-circle-arrow-up'></span> Cargar</button>
                                 									</form>
                              									</td>
                        									</tr>
								   						");
                                					}
                                				}
							 				?>
										</table>
										<?php
									}
								?>
							<table class="table table-bordered" align="center">
								<tr align='center'>
									<td colspan='2'>
										<br>
										<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>">               
											<button class="btn btn-primary" type="submit" name='Submit' value="Atras"><span class="glyphicon glyphicon-circle-arrow-left
"></span> Atrás</button>
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
							<h3 class="panel-title" align="center"><strong>Carga de Calificaciones</strong></h3>
						</div>
						<div class="panel-body">
							<form id='FormRegPar' name='FormRegPar' role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action='pronotas.php'>
			 					<table class="table table-bordered" align="center">
			 						<tr align='center'>
										<td>
											<input type='hidden' name='registro' id='registro' value="2"/>
											<input type="file" class="btn btn-link" name="notacsv" title="Hacer click para buscar archivo:" />
										</td>
									</tr>
									<tr align='center'>
										<td>
    										<button type="submit" class="btn btn-primary btn-block" value="Subir" name="submit"><span class="glyphicon glyphicon-circle-arrow-up"></span> Cargar Calificaciones</button>
    										</form>
										</td>
									</tr>
									<tr>
										<td colspan='2'>
											<br>
											<form data-ajax='false' id='forvolver' name='forvolver' method='post' action="<?php echo $atras;?>">               
											<button class="btn btn-primary btn-block" type="submit" name='Submit' value="Atras"><span class="glyphicon glyphicon-circle-arrow-left
"></span> Atrás</button>
											</form>
										</td>
									</tr>
									<tr>
										<td>
											<div class="col-sm-12">
      											<h2>Leer Importante:</h2>
 												<p>
 													Antes de buscar y cargar el archivo .csv para la subida de <b>Calificaciones</b>, debe tomar en cuenta estas consideraciones:
 												</p>
 												<ol>
 													<li>
 														El archivo csv debe tener solo (3) columnas o (3) separaciones:
 														<b>
 															Cédula o Matrícula, Código de la Cancha, Calificación.
 														</b>
 														Elimine las columnas o espacios que no esten dentro de estas (3) columnas o (3) separaciones.
 													</li>
 													<li>
 														<b>
 															Ejemplos:
 														</b>
 														<br>
 														123456789, 10, 18 <b>O</b> 0154,9,20
 													</li>
 													<li>
 														El Sistema marca en Verde las filas que se han cargado exitosamente, tambien al posicionar el cursor encima de la fila podrá observar la palabra "Carga Exitosa", de igual manera se marcara en rojo las filas que tenga algún error.
 													</li>
 													<li>
    													El limite máximo de cargas permitidas por archivo es de 200
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
   		?>
<?php
	include("../config/footer.php");
?>   
</body>
</html>
<script src="../../js/jquery-3.1.1.min.js"></script>
<script src="../../js/bootstrap.js"></script>
<script src="../../js/jquery-backstretch.js"></script>
<script src="../../js/backstretch.js"></script>
