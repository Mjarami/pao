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
include_once("../../clases/javascript.php");
include_once("../../clases/registros.php");
include_once("../../clases/consultas.php");
include_once("../../clases/actualizaciones.php");
if($_POST!=null)
{
    $envio=$_POST["registro"];
}
if($_GET!=null)
{
    $envio=$_GET["registro"];
}

/** Carga de notas **/
if($envio==1)
{
    $fallo="Location: carga_notas.php?registro=1";
    //***Carga de notas***//
    if($_POST!=null)
    {
        $observa=$_POST["Observa"];
        $cedula=$_POST["cedula"];
        $cancha=$_POST["cancha"];
        $nota=$_POST["nota"];
        $habia=$_POST["habia"];

        if($nota>20)
        {
            echo "
                <script language='javascript'>
                    alert ('Excede el maximo de nota permitido');
                    window.location='carga_notas.php?registro=1&cedula=$cedula';
                </script>
            ";
            exit();
        }
        else
        {
            if($nota<0)
            {
                echo "
                    <script language='javascript'>
                        alert ('Excede el minimo de nota permitido');
                        window.location='carga_notas.php?registro=1&cedula=$cedula';
                    </script>
                ";
                exit();
            }
            else
            {
                $correcto="Location: carga_notas.php?registro=1&cedula=$cedula";

                $personas= new Consulta_Personas();
                $personas->Consulta_Cedula_Persona($cedula);
                $personas->Consulta_General();
                $filapersona=$personas->Devuelve_Consulta();
                $personas->Consulta_Paginador();
                $filapersonas=$personas->Devuelve_Contador();
                if($filapersonas>=1)
                {
                    $id_per=$filapersona[0]['id_per'];

                    $coneva= new Consulta_Evaluaciones();
                    $coneva->Consulta_Evaluacion_Cancha($id_per, $cancha);
                    $coneva->Consulta_General();
                    $filaconeva=$coneva->Devuelve_Consulta();
                    $coneva->Consulta_Paginador();
                    $filaconeva2=$coneva->Devuelve_Contador();

                    $canchas= new Consulta_Canchas();
                    $canchas->Consulta_Nombre_Cancha($cancha);
                    $canchas->Consulta_General();
                    $filacancha=$canchas->Devuelve_Consulta();

                    $nom_cancha=$filacancha[0]['nom_can'];

                    if($filaconeva2>=1)
                    {
                        $id_eva=$filaconeva[0]['id_eva'];

                        $revalua= new Editar_Evaluaciones();
                        $revalua->Edito_Evaluacion($id_eva, $nota);
                        $revalua->Editar_General();
                        $modulo="Edita/Nota/".$nom_cancha."";
                    }
                    else
                    {
                        $revalua= new Registro_Evaluacion();
                        $revalua->Registro_De_Evaluacion($id_per, $cancha, $nota);
                        $revalua->Registro_General();
                        $modulo="Carga/Nota/".$nom_cancha."";
                    }

                    $fechanew=date('Y-m-d');
                    $horanew=date('H:i:s');
                    session_start();
                    $ced=$_SESSION['ced']; 

                    $conced= new Consulta_Personas();
                    $conced->Consulta_Acceso_Cedula($ced);
                    $conced->Consulta_General();
                    $filaconced=$conced->Devuelve_Consulta();
                    $id_acc=$filaconced[0]['id_acc'];

                    $proceso= new Registro_Auditorias(); 
                    $proceso->Registro_Proceso2(3 , $id_acc, $id_per, $fechanew, $horanew);
                    $proceso->Registro_General();

                    $conproce= new Consulta_Auditorias();
                    $conproce->Consulta_Auditoria_Proceso($id_per);
                    $conproce->Consulta_General();
                    $filaconproce=$conproce->Devuelve_Consulta();
                    $id_pro=$filaconproce[0]['id_pro'];
                    if($observa!=null)
                    {
                        $auditoria= new Registro_Auditorias();
                        $auditoria->Registro_Auditoria3($id_pro, 3, $modulo, $nota, $habia, $observa);
                        $auditoria->Registro_General();
                    }
                    else
                    {
                        $auditoria= new Registro_Auditorias();
                        $auditoria->Registro_Auditoria2($id_pro, 3, $modulo, $nota, $habia);
                        $auditoria->Registro_General();
                    }

                    header($correcto);
                    exit();
                }
            }
        }
    }
    else
    {
        header($fallo);
        exit();
    }
}

if($envio==2)
{
    $fallo="Location: carga_notas.php?registro=2";
    //***Carga de notas***//
    if($_POST!=null)
    {
        if (isset($_POST['submit']))
        {
            $tmpnotacsv = $_FILES['notacsv']['tmp_name']; 
            $namenotacsv = $_FILES['notacsv']['name'];
            $ext=explode(".",$namenotacsv);
            $ext2 = strtolower($ext[1]);
            if($ext2 != "csv")
            {
                echo "<script language='javascript'>
                    alert ('Archivo invalido');
                    window.location='carga_notas.php?registro=2';
                </script>";    
            }
            else
            {
                if (is_uploaded_file($tmpnotacsv))
                {
                    $handle=fopen($tmpnotacsv, "r");
                    $totalC=array();
                    $limite=0;
                    while (($data = fgetcsv($handle, 1000, ","))!== FALSE)
                    {
                        $limite=$limite++;
                        $rcan=trim($data[1]);
                        $rnot=trim($data[2]);
                        
                        if(is_numeric($rcan))
                        {
                            $nrcan=1;
                        }
                        else
                        {
                            $nrcan=2;
                        }
                        if(is_numeric($rnot))
                        {
                            $nrnot=1;
                        }
                        else
                        {
                            $nrnot=2;
                        }
                        if($nrcan==2 || $nrnot==2)
                        {
                            echo "<script language='javascript'>
                                alert ('Los campos Canchas y Notas solo deben contener digitos');
                                window.location='carga_notas.php?registro=1';
                            </script>";
                            exit();
                        }
                        if($limite==201)
                        {
                            echo "<script language='javascript'>
                                alert ('El documento supera el máximo de registros permitidos');
                                window.location='carga_notas.php?registro=1';
                            </script>";
                            exit();
                        }
                    }
                    fclose($handle);
                    ?>
                    <!DOCTYPE html>
                        <head>
                            <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
                            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                            <title>Calificaciones</title>
                            <link href="../../css/bootstrap.css" rel="stylesheet">
                            <link href="../../css/sb-admin.css" rel="stylesheet">
                        </head>
                        <body>
						<?php
							include("../config/navbar.php");
						?>
						<br><br>
							<div class="col-md-10 col-md-offset-1">
								<div class="panel panel-primary">
									<div class="panel-heading">
                                        <h3 class="panel-title" align="center"><strong>Carga de Calificaciones</strong></h3>
                                    </div>
                                    <div class="panel-body">
						<?php
                        $handle=fopen($tmpnotacsv, "r");
                        $totalC=array();
                        echo "<table class='table'>";
                        echo "<thead>";
                        echo "<tr><th>N°</th><th>Cedula</th><th>Cancha</th><th>Calificación</th></tr>";
                        echo "</thead><tbody>";
                        $error=null;
                        while (($data = fgetcsv($handle, 1000, ","))!== FALSE)
                        {
                            $i++;
                            $cedula=$data[0];
                            $idcancha=$data[1];
                            $nota=$data[2];

                            $nnota=str_replace(",",".",$nota);
                            $cedula=str_replace('"',' ',$cedula);

                            if (isset($cedula))
                            {
                                $id=$cedula;
                                if(isset($totalC[$id]))
                                {
                                    $duple=$id;
                                }
                                else
                                {
                                    $totalC[$id]=true;
                                }
                            }

                            if($cedula=='')
                            {
                                $alert='class="danger" title="Existen Campos Vacios"'; 
                            }
                            else
                            {
                                $personas= new Consulta_Personas();
                                $personas->Consulta_Cedula_Rol_Participante($cedula);
                                $personas->Consulta_General();
                                $filapersona=$personas->Devuelve_Consulta();
                                $personas->Consulta_Paginador();
                                $filapersonas=$personas->Devuelve_Contador();

                                if($filapersonas>=1)
                                {
                                    $id_per=$filapersona[0]['id_per'];

                                    $canchas= new Consulta_Canchas();
                                    $canchas->Consulta_Nombre_Cancha($idcancha);
                                    $canchas->Consulta_General();
                                    $filacancha=$canchas->Devuelve_Consulta();
                                    $canchas->Consulta_Paginador();
                                    $filacanchas=$canchas->Devuelve_Contador();

                                    if($filacanchas>=1)
                                    {
                                        $ecancha==1;
                                        $v_cancha=$filacancha[0]['val_can']; 
                                        $porcentaje=$filacancha[0]['por_can'];
                                        $n_cancha=$filacancha[0]['nom_can'];

                                        $evaluacion= new Consulta_Evaluaciones();
                                        $evaluacion->Consulta_Evaluacion_Cancha($id_per, $idcancha);
                                        $evaluacion->Consulta_General();
                                        $evaluacion->Consulta_Paginador();
                                        $filaevaluacion=$evaluacion->Devuelve_Contador();

                                        if($filaevaluacion>=1)
                                        {
                                            $alert='class="danger" title="Ya ha sido Evaluado para esta Cancha" style="font-weight:700"';
                                            $error=$error."
                                                <tr title='Ya ha sido Evaluado para esta Cancha' class='danger' style='font-weight:700'>
                                                    <td style='vertical-align: middle;'>".$i."</td>
                                                    <td style='vertical-align: middle;'>".$cedula."</td>
                                                    <td style='vertical-align: middle;'>".$n_cancha."</td>
                                                    <td style='vertical-align: middle;'>".$nota."</td>
                                                    <td style='vertical-align: middle;'>Ya ha sido Evaluado para esta Cancha</td>
                                                </tr>
                                            ";
                                        }
                                        else
                                        {
                                            if($nota>20)
                                            {
                                                $alert='class="danger" title="Excede el Maximo de Notas" style="font-weight:700"';
                                                $error=$error."
                                                    <tr title='Excede el Maximo de Notas' class='danger' style='font-weight:700'>
                                                        <td style='vertical-align: middle;'>".$i."</td>
                                                        <td style='vertical-align: middle;'>".$cedula."</td>
                                                        <td style='vertical-align: middle;'>".$n_cancha."</td>
                                                        <td style='vertical-align: middle;'>".$nota."</td>
                                                        <td style='vertical-align: middle;'>Excede el Maximo de Notas</td>
                                                    </tr>
                                                ";
                                            }
                                            else
                                            {
                                                if($nota<0)
                                                {
                                                    $alert='class="danger" title="La nota minima es 0" style="font-weight:700"';
                                                    $error=$error."
                                                        <tr title='La nota minima es 0' class='danger' style='font-weight:700'>
                                                            <td style='vertical-align: middle;'>".$i."</td>
                                                            <td style='vertical-align: middle;'>".$cedula."</td>
                                                            <td style='vertical-align: middle;'>".$n_cancha."</td>
                                                            <td style='vertical-align: middle;'>".$nota."</td>
                                                            <td style='vertical-align: middle;'>La nota minima es 0</td>
                                                        </tr>
                                                    "; 
                                                }
                                                else
                                                {
                                                    $cancha=$filacancha[0]['nom_can'];
                                                    $revalua= new Registro_Evaluacion();
                                                    $revalua->Registro_De_Evaluacion($id_per, $idcancha, $nota);
                                                    $revalua->Registro_General();
                                                    $alert='title="Carga Exitosa" class="success"';
                                                    
                                                    $fechanew=date('Y-m-d');
                                                    $horanew=date('H:i:s');
                                                    session_start();
                                                    $ced=$_SESSION['ced']; 

                                                    $conced= new Consulta_Personas();
                                                    $conced->Consulta_Acceso_Cedula($ced);
                                                    $conced->Consulta_General();
                                                    $filaconced=$conced->Devuelve_Consulta();
                                                    $id_acc=$filaconced[0]['id_acc'];

                                                    $proceso= new Registro_Auditorias(); 
                                                    $proceso->Registro_Proceso2(3 , $id_acc, $id_per, $fechanew, $horanew);
                                                    $proceso->Registro_General();

                                                    $conproce= new Consulta_Auditorias();
                                                    $conproce->Consulta_Auditoria_Proceso($id_per);
                                                    $conproce->Consulta_General();
                                                    $filaconproce=$conproce->Devuelve_Consulta();
                                                    $id_pro=$filaconproce[0]['id_pro'];

                                                    $modulo="Carga/Nota/".$cancha."";
                                                    $auditoria= new Registro_Auditorias();
                                                    $auditoria->Registro_Auditoria($id_pro, 2, $modulo);
                                                    $auditoria->Registro_General();
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $alert='class="danger" title="Cancha No Existe"';
                                        $fix2='style="font-weight:700" class="text-danger"'; $n_cancha='Cancha Desconocida';
                                        $error=$error."
                                            <tr title='Cancha No Existe' class='danger' style='font-weight:700'>
                                                <td style='vertical-align: middle;'>".$i."</td>
                                                <td style='vertical-align: middle;'>".$cedula."</td>
                                                <td style='vertical-align: middle;'>".$n_cancha."</td>
                                                <td style='vertical-align: middle;'>".$nota."</td>
                                                <td style='vertical-align: middle;'>Cancha No Existe</td>
                                            </tr>
                                        ";
                                    }
                                }
                                else
                                {
                                    $alert = 'class="danger" title="Cédula o Matrícula No Existe"';
                                    $fix1 =  'style="font-weight:700" class="text-danger"';
                                    $alert='class="danger" title="Ya ha sido Evaluado para esta Cancha" style="font-weight:700"';
                                    $error=$error."
                                        <tr title='Cédula No Existe' class='danger' style='font-weight:700'>
                                            <td style='vertical-align: middle;'>".$i."</td>
                                            <td style='vertical-align: middle;'>".$cedula."</td>
                                            <td style='vertical-align: middle;'>".$n_cancha."</td>
                                            <td style='vertical-align: middle;'>".$nota."</td>
                                            <td style='vertical-align: middle;'>Cédula o Matrícula No Existe</td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                            <tr <?= $alert?>>
                                <td><?=$i?></td>
                                <td <?=$fix1?>><?=$cedula?></td>
                                <td <?=$fix2?>><?=strtoupper($n_cancha);?></td>
                                <td><?=$nota?></td>
                            </tr>
                            <?php
                        }
                        echo "</tbody></table>";
                        fclose($handle);
                        echo "<br/><h2>Leido Exitosamente</h2>";
                    ?>
                                        </div>
                                    </div>
                                    <center>
                                    <table>
                                        <tr>
                                            <td align='center'>
                                                <br>
                                                <form data-ajax='false' id='forimprimirparte' name='forimprimirparte' method='post' action='imprimirerrorcsv.php'>
                                                    <input type='hidden' name='error' id='error' autocomplete='off' value="<?php echo $error;?>" />
                                                    <input type='hidden' name='ecsv' id='ecsv' autocomplete='off' value="2" />
                                                    <button class="btn btn-lg btn-primary btn-block" type='submit' name='Submit' value='Imprimir'><span class="glyphicon glyphicon-print"></span> Imprimir</button>
                                                </form>
                                            </td>
                                            <td align='center'>
                                                <br>
                                                <form data-ajax='false' id='forvolver' name='forvolver' method='post' action="carga_notas.php?registro=2">
                                                        <input class="btn btn-lg btn-primary btn-block" type='submit' name='Submit' value='Atr&aacute;s'/>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                    </center>
                                </div>
                            </body>
											<?php
					include("../config/footer.php");
				?>
								<script src="../../js/jquery-3.1.1.min.js"></script>
				<script src="../../js/bootstrap.js"></script>
				<script src="../../js/jquery-backstretch.js"></script>
				<script src="../../js/backstretch.js"></script>
                        </body>
                    </html>

                    <?php
                }
            }
        }
        else
        {
            header($fallo);
            exit();
        }
    }
    else
    {
        header($fallo);
        exit();
    }
}
?>
