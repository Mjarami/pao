   <?php

	error_reporting(0);
	include_once("../../clases/consultas.php");


	$data= new Consulta_Personas();
 	$data->Consulta_Personas_Rol_Administrador();
    $data->Consulta_General();
    $data->Consulta_Paginador();
    $num_total_registros_administradores=$data->Devuelve_Contador();

    $data->Consulta_personas_Rol_Asistente();
    $data->Consulta_General();
    $data->Consulta_Paginador();
    $num_total_registros_asistentes=$data->Devuelve_Contador();

    $data->Consulta_personas_Rol_Participante();
    $data->Consulta_General();
    $data->Consulta_Paginador();
    $num_total_registros_participantes=$data->Devuelve_Contador();

    $data=new Consultas();
    $data->Consulta_Tabla_General2('academias');
    $data->Consulta_General();
    $data->Consulta_Paginador();
    $num_total_registros_academias=$data->Devuelve_Contador();

    $data->Consulta_Tabla_General2('canchas');
    $data->Consulta_General();
    $data->Consulta_Paginador();
    $num_total_registros_canchas=$data->Devuelve_Contador();

    $data->Consulta_Tabla_General2('companias');
    $data->Consulta_General();
    $data->Consulta_Paginador();
    $num_total_registros_companias=$data->Devuelve_Contador();
	
	session_start();
	$ced=$_SESSION['ced'];
	$conadm= new Consulta_Personas();
	$conadm->Consulta_Cedula_Persona($ced);
	$conadm->Consulta_General();
	$filaconadm=$conadm->Devuelve_Consulta();
	$nombre=$filaconadm[0]['ape_per']." ".$filaconadm[0]['nom_per'];
?>
<link href="../../css/panel.css" rel="stylesheet">
<nav class="navbar navbar-default nav-top-two">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-6">
			<span class="sr-only">Toggle navigation</span>
			<span>Men&uacute;</span>
          </button>
        </div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-6">
		
			<ul class="nav navbar-default nav-justified top-superior">
				<li <?php if(!is_null($_GET['participante'])){echo 'class="active"';} ?>><a href="../administrador/consultas.php?registro=3"><h2><?php echo $num_total_registros_participantes?></h2><span> Cadetes </span></a>
				</li>

				<li <?php if(!is_null($_GET['canchas'])){echo 'class="active"';} ?>><a href="../administrador/consultas.php?registro=7"><h2><?php echo $num_total_registros_canchas;?></h2><span> Canchas </span></a>
				</li>

				<li <?php if(!is_null($_GET['companias'])){echo 'class="active"';} ?>><a href="../administrador/consultas.php?registro=8"><h2><?php echo $num_total_registros_companias?></h2><span> Compañias </span></a>
				</li>

				<li <?php if(!is_null($_GET['academias'])){echo 'class="active"';} ?>><a href="../administrador/consultas.php?registro=6"><h2><?php echo $num_total_registros_academias;?></h2><span>Academias</span></a></li>
				<?php
                    if($_SESSION['rol']== 1)
                    {
                    	?>
						<li <?php if(!is_null($_GET['administradores'])){echo 'class="active"';} ?>><a href="../administrador/consultas.php?registro=1"><h2><?php echo $num_total_registros_administradores;?></h2><span> Administradores </span></a>
						</li>

						<li <?php if(!is_null($_GET['operadores'])){echo 'class="active"';} ?>><a href="../administrador/consultas.php?registro=2"><h2><?php echo $num_total_registros_asistentes;?></h2><span> Operadores </span></a>
						</li>
						<li <?php if(!is_null($_GET['activo'])){echo 'class="active"';} ?>><a href="consultas.php?registro=1&buscando=<?php echo $ced;?>"><h2><?php echo $nombre;?></h2><span> Usuario Activo </span></a>
						</li>
						<?php
					}
					else
					{
						?>
						<li <?php if(!is_null($_GET['activo'])){echo 'class="active"';} ?>><a href="consultas.php?registro=2&buscando=<?php echo $ced;?>"><h2><?php echo $nombre;?></h2><span> Usuario Activo </span></a>
						</li>
						<?php
					}
				?>
			</ul>
        </div><!-- /.navbar-collapse -->
      </div>
    </nav>	
