<?php
error_reporting(0);
session_start();
if($_SESSION['rol'] != 1)
{
    header('Location: ../logeo/login.php');
    exit();
}
include_once("../../clases/consultas.php");
$a=$_POST["auditar"];
$anoa=date('Y');
$mesa=date('m');
$diaa=date('d');
$fecha=$anoa."-".$mesa."-".$diaa;
if($_POST['tamano']!=null)
{
    $TAMANO_PAGINA=$_POST["tamano"];
}
else
{
    $TAMANO_PAGINA=10;
}
/** consultas de las auditorias **/
if($a==1)
{
    ?>
    <!DOCTYPE html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>Accesos</title>
        <link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
        <link href="../../img/icon/helmet.png" rel="shortcut icon" type="image/png"/>
    </head>
    <body>
    <?php
        include("../config/navbar3.php");
    ?>
        <br><br>
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><strong>Accesos a al sistema</strong></h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered" align="center">
                        <tr align='center'>
                            <td><strong>Fecha</strong></td>
                            <td><strong>Hora</strong></td>
                            <td><strong>Motivo</strong></td>
                            <td><strong>Cédula</strong></td>
                            <td><strong>Usuario</strong></td>
                            <td><strong>Acción</strong></td>
                            <td><strong>Lugar</strong></td>
                        </tr>
            <?php
                $pagina = $_POST["pagina"];

                if (!$pagina)
                {
                    $inicio = 0;
                    $pagina=1;
                }
                else
                {
                    $inicio =($pagina - 1) * $TAMANO_PAGINA;
                }
                $data= new Consulta_Auditorias();
                $data->Consulta_Auditoria_Entradas();
                $data->Consulta_General();
                $data->Consulta_Paginador();
                $num_total_registros = $data->Devuelve_Contador();

                if($num_total_registros>=1)
                {
                    $data->Consulta_Auditoria_Entradas2($TAMANO_PAGINA, $inicio);
                    $data->Consulta_General();
                    $filadata=$data->Devuelve_Consulta();
                    $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
                    echo "<center>N&uacute;mero de registros encontrados: " . $num_total_registros . "<br>";
                    echo "Se muestran p&aacute;ginas de " . $TAMANO_PAGINA . " registros cada una<br>";
                    echo "Mostrando la p&aacute;gina " . $pagina . " de " . $total_paginas . "<p></center>";
            ?>
            <?php
                    foreach ($filadata as $row1):
            ?>
                        <tr align='center'>
                            <td><?php echo ucwords($row1['fec_pro']); ?></td>
                            <td><?php echo ucwords($row1['hor_pro']); ?></td>
                            <td><?php echo ucwords($row1['nom_mot']); ?></td>
                            <td><?php echo ucwords($row1['ced_per']); ?></td>
                            <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']);?></td>
                            <td><?php echo ucwords($row1['nom_aci']); ?></td>
                            <td><?php echo ucwords($row1['lug_aud']); ?></td>
                        </tr><!-- /TROW -->
            <?php
                    endforeach
            ?>
                    </table>
                    <table align='center'>
                        <?php
                            if ($total_paginas > 1)
                            {
                                ?>
                                <tr>
                                    <td align='center' colspan='5'>
                                        <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                            <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='1' />
                                            <input type='text' name='tamano' id='tamano' autocomplete='off' size='1' onkeypress="return validar2(event)" />
                                            <input class="btn btn-primary" type='submit' name='Submit' value="Registros por pagina" />
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                        if($pagina>1)
                                        {
                                            $pagina2=$pagina-1;
                                            ?>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='1' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="1"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Primera" />
                                                </form>
                                            </td>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='1' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="<?php echo $pagina2 ?>"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Anterior" />
                                                </form>
                                            </td>
                                            <?php
                                        }
                                    ?>
                                    <td align='center'>
                                        <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                            <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='1' />
                                            <select class="form-control" name='pagina' id='pagina' size='1' autocomplete='off'>
                                                <option value="<?php echo $pagina;?>"><?php echo $pagina;?></option>
                                                <?php
                                                    for ($i=1;$i<=$total_paginas;$i++)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                            <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                            <button class="btn btn-primary" type='submit' name='Submit' value='Buscar'><span class="glyphicon glyphicon-search"></span></button>
                                        </form>
                                    </td>
                                    <?php
                                        if($pagina<$total_paginas)
                                        {
                                            $pagina2=$pagina+1;
                                            ?>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='1' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="<?php echo $pagina2 ?>"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Siguiente" />
                                                </form>
                                            </td>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='1' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="<?php echo $total_paginas ?>"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Ultima" />
                                                </form>
                                            </td>
                                            <?php
                                        }
                            }
                        ?>
                        </tr>
                    </table>
                    <?php
                }
                else
                {
            ?>
                        <tr align='center'>
                            <td colspan='7'>No se encontraron registros</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

<?php
                    
            }
}
elseif($a==2)
{
?>
    <!DOCTYPE html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>Salidas</title>
        <link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
        <link href="../../img/icon/helmet.png" rel="shortcut icon" type="image/png"/>
    </head>
    <body>
    <?php
        include("../config/navbar3.php");
    ?>
    br><br><br>
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><strong>Salidas del sistema</strong></h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered" align="center">
                        <tr align='center'>
                            <td><strong>Fecha</strong></td>
                            <td><strong>Hora</strong></td>
                            <td><strong>Motivo</strong></td>
                            <td><strong>Cédula</strong></td>
                            <td><strong>Usuario</strong></td>
                            <td><strong>Acción</strong></td>
                            <td><strong>Lugar</strong></td>
                        </tr>

                        <?php
                            $pagina = $_POST["pagina"];
                            if (!$pagina)
                            {
                                $inicio = 0;
                                $pagina=1;
                            }
                            else
                            {
                                $inicio =($pagina - 1) * $TAMANO_PAGINA;
                            }

                            $data= new Consulta_Auditorias();
                            $data->Consulta_Auditoria_Salidas();
                            $data->Consulta_General();
                            $data->Consulta_Paginador();
                            $num_total_registros = $data->Devuelve_Contador();

                            if($num_total_registros>=1)
                            {
                            	$data->Consulta_Auditoria_Salidas2($TAMANO_PAGINA, $inicio);
                                $data->Consulta_General();
                                $filadata=$data->Devuelve_Consulta();

                                $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
                                echo "<center>N&uacute;mero de registros encontrados: " . $num_total_registros . "<br>";
                                echo "Se muestran p&aacute;ginas de " . $TAMANO_PAGINA . " registros cada una<br>";
                                echo "Mostrando la p&aacute;gina " . $pagina . " de " . $total_paginas . "<p></center>";
                            ?>
                            <?php
                                foreach ($filadata as $row1):
                            ?>
                                <tr align='center'>
                                    <td><?php echo ucwords($row1['fec_pro']); ?></td>
                                    <td><?php echo ucwords($row1['hor_pro']); ?></td>
                                    <td><?php echo ucwords($row1['nom_mot']); ?></td>
                                    <td><?php echo ucwords($row1['ced_per']); ?></td>
                                    <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']);?></td>
                                    <td><?php echo ucwords($row1['nom_aci']); ?></td>
                                    <td><?php echo ucwords($row1['lug_aud']); ?></td>
                                </tr><!-- /TROW -->
                            <?php
                                endforeach
                            ?>
                    </table>

                    <table align='center'>
                        <?php
                            if ($total_paginas > 1)
                            {
                                ?>
                                <tr>
                                    <td align='center' colspan='5'>
                                        <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                            <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='2' />
                                            <input type='text' name='tamano' id='tamano' autocomplete='off' size='1' onkeypress="return validar2(event)" />
                                            <input class="btn btn-primary" type='submit' name='Submit' value="Registros por pagina" />
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                        if($pagina>1)
                                        {
                                            $pagina2=$pagina-1;
                                            ?>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='2' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="1"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Primera" />
                                                </form>
                                            </td>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='2' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="<?php echo $pagina2 ?>"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Anterior" />
                                                </form>
                                            </td>
                                            <?php
                                        }
                                    ?>
                                    <td align='center'>
                                        <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                            <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='2' />
                                            <select class="form-control" name='pagina' id='pagina' size='1' autocomplete='off'>
                                                <option value="<?php echo $pagina;?>"><?php echo $pagina;?></option>
                                                <?php
                                                    for ($i=1;$i<=$total_paginas;$i++)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                            <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                            <button class="btn btn-primary" type='submit' name='Submit' value='Buscar'><span class="glyphicon glyphicon-search"></span></button>
                                        </form>
                                    </td>
                                    <?php
                                        if($pagina<$total_paginas)
                                        {
                                            $pagina2=$pagina+1;
                                            ?>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='2' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="<?php echo $pagina2 ?>"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Siguiente" />
                                                </form>
                                            </td>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='2' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="<?php echo $total_paginas ?>"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Ultima" />
                                                </form>
                                            </td>
                                            <?php
                                        }
                            }
                        ?>
                        </tr>
                    </table>
                    <?php
            }
            else
            {
            ?>
                        <tr align='center'>
                            <td colspan='7'> No se encontraron registros</td>
                        </tr>
                   </table>
                </div>
            </div>
        </div>
    </div>
    </body>


<?php
            }
}
elseif($a==3)
{
?>
    <!DOCTYPE html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>Reportes</title>
        <link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
        <link href="../../img/icon/helmet.png" rel="shortcut icon" type="image/png"/>
    </head>
    <body>
    <?php
        include("../config/navbar3.php");
    ?>
        <br><br><br>
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><strong>Reportes generados</strong></h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered" align="center">
                        <tr align='center'>
                            <td><strong>Fecha</strong></td>
                            <td><strong>Hora</strong></td>
                            <td><strong>Motivo</strong></td>
                            <td><strong>Cédula</strong></td>
                            <td><strong>Usuario</strong></td>
                            <td><strong>Acción</strong></td>
                            <td><strong>Lugar</strong></td>
                        </tr>

                <?php
                    $pagina = $_POST["pagina"];

                    if (!$pagina)
                    {
                        $inicio = 0;
                        $pagina=1;
                    }
                    else
                    {
                        $inicio =($pagina - 1) * $TAMANO_PAGINA;
                    }

                    $data= new Consulta_Auditorias();
                    $data->Consulta_Auditoria_Reportes();
                    $data->Consulta_General();
                    $data->Consulta_Paginador();
                    $num_total_registros = $data->Devuelve_Contador();

                    if($num_total_registros>=1)
                    {
                    	$data->Consulta_Auditoria_Reportes2($TAMANO_PAGINA, $inicio);
                        $data->Consulta_General();
                        $filadata=$data->Devuelve_Consulta();

                        $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
                        echo "<center>N&uacute;mero de registros encontrados: " . $num_total_registros . "<br>";
                        echo "Se muestran p&aacute;ginas de " . $TAMANO_PAGINA . " registros cada una<br>";
                        echo "Mostrando la p&aacute;gina " . $pagina . " de " . $total_paginas . "<p></center>";

                        foreach ($filadata as $row1):
                ?>
                        <tr align='center'>
                        	<td><?php echo ucwords($row1['fec_pro']); ?></td>
  							<td><?php echo ucwords($row1['hor_pro']); ?></td>
  							<td><?php echo ucwords($row1['nom_mot']); ?></td>
  							<td><?php echo ucwords($row1['ced_per']); ?></td>
  							<td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']);?></td>
  							<td><?php echo ucwords($row1['nom_aci']); ?></td>
  							<td><?php echo ucwords($row1['lug_aud']); ?></td>
                        </tr> <!-- /TROW -->
                <?php 
                        endforeach
                ?>

                                
                          
                    </table>

                    <table align='center'>
                        <?php
                            if ($total_paginas > 1)
                            {
                                ?>
                                <tr>
                                    <td align='center' colspan='5'>
                                        <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                            <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='3' />
                                            <input type='text' name='tamano' id='tamano' autocomplete='off' size='1' onkeypress="return validar2(event)" />
                                            <input class="btn btn-primary" type='submit' name='Submit' value="Registros por pagina" />
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                        if($pagina>1)
                                        {
                                            $pagina2=$pagina-1;
                                            ?>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='3' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="1"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Primera" />
                                                </form>
                                            </td>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='3' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="<?php echo $pagina2 ?>"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Anterior" />
                                                </form>
                                            </td>
                                            <?php
                                        }
                                    ?>
                                    <td align='center'>
                                        <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                            <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='3' />
                                            <select class="form-control" name='pagina' id='pagina' size='1' autocomplete='off'>
                                                <option value="<?php echo $pagina;?>"><?php echo $pagina;?></option>
                                                <?php
                                                    for ($i=1;$i<=$total_paginas;$i++)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                            <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                            <button class="btn btn-primary" type='submit' name='Submit' value='Buscar'><span class="glyphicon glyphicon-search"></span></button>
                                        </form>
                                    </td>
                                    <?php
                                        if($pagina<$total_paginas)
                                        {
                                            $pagina2=$pagina+1;
                                            ?>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='3' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="<?php echo $pagina2 ?>"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Siguiente" />
                                                </form>
                                            </td>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='3' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="<?php echo $total_paginas ?>"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Ultima" />
                                                </form>
                                            </td>
                                            <?php
                                        }
                            }
                        ?>
                        </tr>
                    </table>
                    <?php
                }
                else
                {
                ?>
                        <tr align='center'>
                            <td colspan='7'>No se encontraron registros</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </body>
                <?php
                }
}
elseif($a==4)
{
?>
    <!DOCTYPE html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>Registros realizados</title>
        <link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
        <link href="../../img/icon/helmet.png" rel="shortcut icon" type="image/png"/>
    </head>
    <body>
        <?php
            include("../config/navbar3.php");
        ?>
        <br><br>
         <div class="container">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><strong>Registros realizados</strong></h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered" align="center">
                            <tr align='center'>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan='2'><strong>Afectado</strong></td>
                                <td></td>
                                <td></td>
                                <td colspan='2'><strong>Autor</strong></td>
                            </tr>

                            <tr align='center'>
                                <td><strong>Fecha</strong></td>
                                <td><strong>Hora</strong></td>
                                <td><strong>Motivo</strong></td>
                                <td><strong>Cédula</strong></td>
                                <td><strong>Nombre</strong></td>
                                <td><strong>Acción</strong></td>
                                <td><strong>Lugar</strong></td>
                                <td><strong>Cédula</strong></td>
                                <td><strong>Usuario</strong></td>
                            </tr>
                <?php
                    $pagina = $_POST["pagina"];
                    if (!$pagina)
                    {
                        $inicio = 0;
                        $pagina=1;
                    }
                    else
                    {
                        $inicio =($pagina - 1) * $TAMANO_PAGINA;
                    }

                    $data= new Consulta_Auditorias();
                    $data->Consulta_Auditoria_Registros();
                    $data->Consulta_General();
                    $data->Consulta_Paginador();
                    $num_total_registros = $data->Devuelve_Contador();

                    if($num_total_registros>=1)
                    {
                        $data->Consulta_Auditoria_Registros2($TAMANO_PAGINA, $inicio);
                        $data->Consulta_General();
                        $filadata=$data->Devuelve_Consulta();

                        $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
                        echo "<center>N&uacute;mero de registros encontrados: " . $num_total_registros . "<br>";
                        echo "Se muestran p&aacute;ginas de " . $TAMANO_PAGINA . " registros cada una<br>";
                        echo "Mostrando la p&aacute;gina " . $pagina . " de " . $total_paginas . "<p></center>";
                        foreach ($filadata as $row1)
                        {
                ?>
                            <tr align='center'>
                                <td><?php echo ucwords($row1['fec_pro']);?></td>
                                <td><?php echo ucwords($row1['hor_pro']);?></td>
                                <td><?php echo ucwords($row1['nom_mot']);?></td>
                                <td><?php echo ucwords($row1['afectado']);?></td>
                                <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']);?></td>
                                <td><?php echo ucwords($row1['nom_aci']);?></td>
                                <td><?php echo ucwords($row1['lug_aud']);?></td>
                                <td><?php echo ucwords($row1['autor']);?></td>
                                <td><?php echo ucwords($row1['usu_acc']);?></td>
                            </tr>
                            <?php
                                }
                            ?>

                        </table>

                        <table align='center'>
                        <?php
                            if ($total_paginas > 1)
                            {
                                ?>
                                <tr>
                                    <td align='center' colspan='5'>
                                        <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                            <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='4' />
                                            <input type='text' name='tamano' id='tamano' autocomplete='off' size='1' onkeypress="return validar2(event)" />
                                            <input class="btn btn-primary" type='submit' name='Submit' value="Registros por pagina" />
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                        if($pagina>1)
                                        {
                                            $pagina2=$pagina-1;
                                            ?>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='4' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="1"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Primera" />
                                                </form>
                                            </td>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='4' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="<?php echo $pagina2 ?>"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Anterior" />
                                                </form>
                                            </td>
                                            <?php
                                        }
                                    ?>
                                    <td align='center'>
                                        <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                            <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='4' />
                                            <select class="form-control" name='pagina' id='pagina' size='1' autocomplete='off'>
                                                <option value="<?php echo $pagina;?>"><?php echo $pagina;?></option>
                                                <?php
                                                    for ($i=1;$i<=$total_paginas;$i++)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                            <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                            <button class="btn btn-primary" type='submit' name='Submit' value='Buscar'><span class="glyphicon glyphicon-search"></span></button>
                                        </form>
                                    </td>
                                    <?php
                                        if($pagina<$total_paginas)
                                        {
                                            $pagina2=$pagina+1;
                                            ?>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='4' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="<?php echo $pagina2 ?>"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Siguiente" />
                                                </form>
                                            </td>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='4' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="<?php echo $total_paginas ?>"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Ultima" />
                                                </form>
                                            </td>
                                            <?php
                                        }
                            }
                        ?>
                        </tr>
                    </table>
                    <?php
                    }
                    else
                    {
                    ?>

                            </tr>
                            <tr align='center'>
                                <td colspan='9'>No se encontraron registros</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
                    <?php
                    }
}


elseif($a==5)
{
    ?>
    <!DOCTYPE html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>Ediciones realizadas</title>
        <link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
        <link href="../../img/icon/helmet.png" rel="shortcut icon" type="image/png"/>
        </head>
    <body>
    <?php
        include("../config/navbar3.php");
    ?>
        <br><br><br>
    <div class="container">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><strong>Ediciones realizadas</strong></h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered" align="center">
                        <tr align='center'>
                            <td colspan='3'><strong> Fecha de la Modificacion</strong></td>
                            <td colspan='2'><strong> Persona a la cual se le realizo la modificación</strong></td>
                            <td colspan='2'><strong> Proceso ejecutado</strong></td>
                            <td colspan='2'><strong>Usuario que realiza la Modificación</strong></td>
                            <td colspan='3'><strong>Datos editados</strong></td>
                        </tr>
                        <tr align='center'>
                            <td><strong>Fecha</strong></td>
                            <td><strong>Hora</strong></td>
                            <td><strong>Motivo</strong></td>
                            <td><strong>Cédula</strong></td>
                            <td><strong>Nombre</strong></td>
                            <td><strong>Acción</strong></td>
                            <td><strong>Lugar</strong></td>
                            <td><strong>Cédula</strong></td>
                            <td><strong>Usuario</strong></td>
                            <td><strong>Había</strong> </td>
                            <td><strong>Editado</strong></td>
                            <td><strong>Observación</strong></td>
                        </tr>
            <?php
                $pagina = $_POST["pagina"];

                if (!$pagina)
                {
                    $inicio = 0;
                    $pagina=1;
                }
                else
                {
                    $inicio =($pagina - 1) * $TAMANO_PAGINA;
                }

                $data= new Consulta_Auditorias();
                $data->Consulta_Auditoria_Ediciones();
                $data->Consulta_General();
                $data->Consulta_Paginador();
                $num_total_registros = $data->Devuelve_Contador();

                if($num_total_registros>=1)
                {
                    $data->Consulta_Auditoria_Ediciones2($TAMANO_PAGINA, $inicio);
                    $data->Consulta_General();
                    $filadata=$data->Devuelve_Consulta();

                    $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
                    echo "<center>N&uacute;mero de registros encontrados: " . $num_total_registros . "<br>";
                    echo "Se muestran p&aacute;ginas de " . $TAMANO_PAGINA . " registros cada una<br>";
                    echo "Mostrando la p&aacute;gina " . $pagina . " de " . $total_paginas . "<p></center>";
                    foreach ($filadata as $row1)
                    {
                        ?>
                        <tr align='center'>
                            <td><?php echo ucwords($row1['fec_pro']);?></td>
                            <td><?php echo ucwords($row1['hor_pro']);?></td>
                            <td><?php echo ucwords($row1['nom_mot']);?></td>
                            <td><?php echo ucwords($row1['afectado']);?></td>
                            <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']);?></td>
                            <td><?php echo ucwords($row1['nom_aci']);?></td>
                            <td><?php echo ucwords($row1['lug_aud']);?></td>
                            <td><?php echo ucwords($row1['autor']);?></td>
                            <td><?php echo ($row1['usu_acc']);?></td>
                            <td><?php echo ucwords($row1['hab_aud']);?></td>
                            <td><?php echo ucwords($row1['edi_aud']);?></td>
                            <td><?php echo ucwords($row1['obs_aud']);?></td>
                        </tr>
                        <?php
                    }
            ?>
                    </table>
                    <table align='center'>
                        <?php
                            if ($total_paginas > 1)
                            {
                                ?>
                                <tr>
                                    <td align='center' colspan='5'>
                                        <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                            <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='5' />
                                            <input type='text' name='tamano' id='tamano' autocomplete='off' size='1' onkeypress="return validar2(event)" />
                                            <input class="btn btn-primary" type='submit' name='Submit' value="Registros por pagina" />
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                        if($pagina>1)
                                        {
                                            $pagina2=$pagina-1;
                                            ?>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='5' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="1"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Primera" />
                                                </form>
                                            </td>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='5' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="<?php echo $pagina2 ?>"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Anterior" />
                                                </form>
                                            </td>
                                            <?php
                                        }
                                    ?>
                                    <td align='center'>
                                        <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                            <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='5' />
                                            <select class="form-control" name='pagina' id='pagina' size='1' autocomplete='off'>
                                                <option value="<?php echo $pagina;?>"><?php echo $pagina;?></option>
                                                <?php
                                                    for ($i=1;$i<=$total_paginas;$i++)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                            <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                            <button class="btn btn-primary" type='submit' name='Submit' value='Buscar'><span class="glyphicon glyphicon-search"></span></button>
                                        </form>
                                    </td>
                                    <?php
                                        if($pagina<$total_paginas)
                                        {
                                            $pagina2=$pagina+1;
                                            ?>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='5' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="<?php echo $pagina2 ?>"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Siguiente" />
                                                </form>
                                            </td>
                                            <td align='center'>
                                                <form id='paginacion' name='paginacion' method='post' action='reportes.php'>
                                                    <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='5' />
                                                    <input type='hidden' name='pagina' id='pagina' autocomplete='off' value="<?php echo $total_paginas ?>"/>
                                                    <input type='hidden' name='tamano' id='tamano' autocomplete='off' value="<?php echo $TAMANO_PAGINA ?>"/>
                                                    <input class="btn btn-primary" type='submit' name='Submit' value="Ultima" />
                                                </form>
                                            </td>
                                            <?php
                                        }
                            }
                        ?>
                        </tr>
                    </table>
                    <?php
                }
                else
                {
            ?>
                        <tr align='center'>
                            <td colspan='12'>No se encontraron registros</td>
                        </tr>
                    </table>
            <?php
                }
}
else
{
?>
                        <tr align='center'>
                           <td colspan='9'>No se encontraron registros</td>
                        </tr>
                    </table>
    <?php
}
if($a==1)
{
    ?>
                    <table align='center' border='0' bgcolor='white'>
                        <!--</td>  -->
                        <!--</tr>-->
                    <tr>
                        <td align='center' colspan='7'>
                    <?php
                            if($_POST["new"]!=null)
                            {
                                include_once("../../clases/registros.php");
                                include_once("../../clases/consultas.php");
                                session_start();
                                $ced=$_SESSION['ced'];
                                $modulo="Acceso/Entrada";

                                $conadm= new Consulta_Personas();
                                $conadm->Consulta_Cedula_Persona($ced);
                                $conadm->Consulta_General();
                                $filaconadm=$conadm->Devuelve_Consulta();

                                $idper=$filaconadm[0]['idper'];
                                $nombre=$filaconadm[0]['nom_per']." ".$filaconadm[0]['ape_per'];
                                $fechanew=date('Y-m-d');
                                $horanew=date('h:i:s');
                                $conadm->Consulta_Paginador();
                                $num_total_registros2=$conadm->Devuelve_Contador();

                                if($num_total_registros2>=1)
                                {
                                    $proceso= new Registro_Auditorias();
                                    $proceso->Registro_Proceso(3 , $idper, $fechanew, $horanew);
                                    $proceso->Registro_General();

                                    $conproce= new Consulta_Auditorias();
                                    $conproce->Consulta_Auditoria_Proceso($idper);
                                    $conproce->Consulta_General();
                                    $filaconproce=$conproce->Devuelve_Consulta();
                                    $idpro=$filaconproce[0]['idpro'];

                                    $auditoria= new Registro_Auditorias();
                                    $auditoria->Registro_Auditoria($idpro, 5, $modulo);
                                    $auditoria->Registro_General();
                                }
                                echo("
                                    <script language='JavaScript'>
                                        var newWindow=window.open('imprimir.php?auditar=1', 'temp', 'left=150', 'top=200', 'height=1000', 'width=1000', 'scrollbar=no', 'location=no', 'resizable=no,menubar=no');
                                        window.close();
                                    </script>
                                ");
                            }
                    ?>
                            <form data-ajax='false' id='forimprimirparte' name='forimprimirparte' method='post' action='reportes.php'>
                                <input type='hidden' name='new' id='new' autocomplete='off' value="1" />
                                <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='1' />
                                <button class="btn btn-primary" type='submit' name='Submit' value='Imprimir'><span class="glyphicon glyphicon-print"></span> imprimir</button>
                            </form>
                        </td>
                        <td>
                            <form data-ajax='false' id='forvolver' name='forvolver' method='post' action='menu.php'>
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
elseif($a==2)
{
    ?>
                <table align='center' border='0' bgcolor='white'>
                    </td>
                    </tr>
                    <tr>
                        <td align='center' colspan='7'>
                            <?php
                                if($_POST["new"]!=null)
                                {
                                    include_once("../../clases/coneccion.php");
                                    include_once("../../clases/registros.php");
                                    include_once("../../clases/consultas.php");
                                    session_start();
                                    $ced=$_SESSION['ced'];
                                    $modulo="Acceso/Salida";

                                    $conadm= new Consulta_Personas();
                                    $conadm->Consulta_Cedula_Persona($ced);
                                    $conadm->Consulta_General();
                                    $filaconadm=$conadm->Devuelve_Consulta();

                                    $idper=$filaconadm[0]['idper'];
                                    $nombre=$filaconadm[0]['nom_per']." ".$filaconadm[0]['ape_per'];
                                    $fechanew=date('Y-m-d');
                                    $horanew=date('h:i:s');
                                    $conadm->Consulta_Paginador();
                                    $num_total_registros2=$conadm->Devuelve_Contador();

                                    if($num_total_registros2>=1)
                                    {
                                    	$proceso= new Registro_Auditorias(); 
                                        $proceso->Registro_Proceso(3 , $idper, $fechanew, $horanew);
                                        $proceso->Registro_General();

                                        $conproce= new Consulta_Auditorias();
                                        $conproce->Consulta_Auditoria_Proceso($idper);
                                        $conproce->Consulta_General();
                                        $filaconproce=$conproce->Devuelve_Consulta();
                                        $idpro=$filaconproce[0]['idpro'];

                                        $auditoria= new Registro_Auditorias();
                                        $auditoria->Registro_Auditoria($idpro, 5, $modulo);
                                        $auditoria->Registro_General();
                                    }
                                    echo("
                                        <script language='JavaScript'>
                                            var newWindow=window.open('imprimir.php?auditar=2', 'temp', 'left=150', 'top=200', 'height=1000', 'width=1000', 'scrollbar=no', 'location=no', 'resizable=no,menubar=no');
                                            window.close();
                                        </script>
                                    ");
                                }
                            ?>
                            <form data-ajax='false' id='forimprimirparte' name='forimprimirparte' method='post' action='reportes.php'>
                                <input type='hidden' name='new' id='new' autocomplete='off' value="2" />
                                <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='2' />
                                <button class="btn btn-primary" type='submit' name='Submit' value='Imprimir'><span class="glyphicon glyphicon-print"></span> imprimir</button>
                            </form>
                        </td>
                        <td>
                            <form data-ajax='false' id='forvolver' name='forvolver' method='post' action='menu.php'>
                                <button class="btn btn-primary"  type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php
}
elseif($a==3)
{
    ?>
                <table align='center' border='0' bgcolor='white'>
                    </td>
                    </tr>
                    <tr>
                        <td align='center' colspan='7'>
                            <?php
                                if($_POST["new"]!=null)
                                {
                                    include_once("../../clases/registros.php");
                                    include_once("../../clases/consultas.php");
                                    session_start();
                                    $ced=$_SESSION['ced'];
                                    $modulo="Reporte";

                                    $conadm= new Consulta_Personas();
                                    $conadm->Consulta_Cedula_Persona($ced);
                                    $conadm->Consulta_General();
                                    $filaconadm=$conadm->Devuelve_Consulta();

                                    $idper=$filaconadm[0]['idper'];
                                    $nombre=$filaconadm[0]['nom_per']." ".$filaconadm[0]['ape_per'];
                                    $fechanew=date('Y-m-d');
                                    $horanew=date('h:i:s');
                                    $conadm->Consulta_Paginador();
                                    $num_total_registros2=$conadm->Devuelve_Contador();

                                    if($num_total_registros2>=1)
                                    {
                                    	$proceso= new Registro_Auditorias(); 
                                        $proceso->Registro_Proceso(3 , $idper, $fechanew, $horanew);
                                        $proceso->Registro_General();

                                        $conproce= new Consulta_Auditorias();
                                        $conproce->Consulta_Auditoria_Proceso($idper);
                                        $conproce->Consulta_General();
                                        $filaconproce=$conproce->Devuelve_Consulta();
                                        $idpro=$filaconproce[0]['idpro'];

                                        $auditoria= new Registro_Auditorias();
                                        $auditoria->Registro_Auditoria($idpro, 5, $modulo);
                                        $auditoria->Registro_General();
                                    }
                                    echo("
                                        <script language='JavaScript'>
                                            var newWindow=window.open('imprimir.php?auditar=3', 'temp', 'left=150', 'top=200', 'height=1000', 'width=1000', 'scrollbar=no', 'location=no', 'resizable=no,menubar=no');
                                            window.close();
                                        </script>
                                    ");
                                }
                            ?>
                            <form data-ajax='false' id='forimprimirparte' name='forimprimirparte' method='post' action='reportes.php'>
                                <input type='hidden' name='new' id='new' autocomplete='off' value="3" />
                                <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='3' />
                                <button class="btn btn-primary" type='submit' name='Submit' value='Imprimir'><span class="glyphicon glyphicon-print"></span> imprimir</button>
                            </form>
                        </td>
                        <td>
                            <form data-ajax='false' id='forvolver' name='forvolver' method='post' action='menu.php'>
                                <button class="btn btn-primary"  type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php
}
elseif($a==4)
{
    ?>
                <table align='center' border='0' bgcolor='white'>
                    </td>
                    </tr>
                    <tr>
                        <td align='center' colspan='7'>
                            <?php
                                if($_POST["new"]!=null)
                                {
                                    include_once("../../clases/registros.php");
                                    include_once("../../clases/consultas.php");
                                    session_start();
                                    $ced=$_SESSION['ced'];
                                    $modulo="Registro";

                                    $conadm= new Consulta_Personas();
                                    $conadm->Consulta_Cedula_Persona($ced);
                                    $conadm->Consulta_General();
                                    $filaconadm=$conadm->Devuelve_Consulta();

                                    $idper=$filaconadm[0]['idper'];
                                    $nombre=$filaconadm[0]['nom_per']." ".$filaconadm[0]['ape_per'];
                                    $fechanew=date('Y-m-d');
                                    $horanew=date('h:i:s');
                                    $conadm->Consulta_Paginador();
                                    $num_total_registros2=$conadm->Devuelve_Contador();

                                    if($num_total_registros2>=1)
                                    {
                                        $proceso= new Registro_Auditorias(); 
                                        $proceso->Registro_Proceso(3 , $idper, $fechanew, $horanew);
                                        $proceso->Registro_General();

                                        $conproce= new Consulta_Auditorias();
                                        $conproce->Consulta_Auditoria_Proceso($idper);
                                        $conproce->Consulta_General();
                                        $filaconproce=$conproce->Devuelve_Consulta();
                                        $idpro=$filaconproce[0]['idpro'];

                                        $auditoria= new Registro_Auditorias();
                                        $auditoria->Registro_Auditoria($idpro, 5, $modulo);
                                        $auditoria->Registro_General();
                                    }
                                    echo("
                                        <script language='JavaScript'>
                                            var newWindow=window.open('imprimir.php?auditar=4', 'temp', 'left=150', 'top=200', 'height=1000', 'width=1000', 'scrollbar=no', 'location=no', 'resizable=no,menubar=no');
                                            window.close();
                                        </script>
                                    ");
                                }
                            ?>
                            <form data-ajax='false' id='forimprimirparte' name='forimprimirparte' method='post' action='reportes.php'>
                                <input type='hidden' name='new' id='new' autocomplete='off' value="4"/>
                                <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='4'/>
                                <button class="btn btn-primary" type='submit' name='Submit' value='Imprimir'><span class="glyphicon glyphicon-print"></span> imprimir</button>
                            </form>
                        </td>
                        <td>
                            <form data-ajax='false' id='forvolver' name='forvolver' method='post' action='menu.php'>
                                <button class="btn btn-primary" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php
}
elseif($a==5)
{
?>
                <table align='center' border='0' bgcolor='white'>
                    <!--</td>-->
                    <!-- </tr>-->
                    <tr>
                        <td align='center' colspan='7'>
                    <?php
                            if($_POST["new"]!=null)
                            {
                                include_once("../../clases/registros.php");
                                include_once("../../clases/consultas.php");
                                session_start();
                                $ced=$_SESSION['ced'];
                                $modulo="edi_audr";

                                $conadm= new Consulta_Personas();
                                $conadm->Consulta_Cedula_Persona($ced);
                                $conadm->Consulta_General();
                                $filaconadm=$conadm->Devuelve_Consulta();

                                $idper=$filaconadm[0]['idper'];
                                $nombre=$filaconadm[0]['nom_per']." ".$filaconadm[0]['ape_per'];
                                $fechanew=date('Y-m-d');
                                $horanew=date('h:i:s');
                                $conadm->Consulta_Paginador();
                                $num_total_registros2=$conadm->Devuelve_Contador();

                                if($num_total_registros2>=1)
                                {
                                    $proceso= new Registro_Auditorias();
                                    $proceso->Registro_Proceso(3 , $idper, $fechanew, $horanew);
                                    $proceso->Registro_General();

                                    $conproce= new Consulta_Auditorias();
                                    $conproce->Consulta_Auditoria_Proceso($idper);
                                    $conproce->Consulta_General();
                                    $filaconproce=$conproce->Devuelve_Consulta();
                                    $idpro=$filaconproce[0]['idpro'];

                                    $auditoria= new Registro_Auditorias();
                                    $auditoria->Registro_Auditoria($idpro, 5, $modulo);
                                    $auditoria->Registro_General();
                                }
                                echo("
                                    <script language='JavaScript'>
                                        var newWindow=window.open('imprimir.php?auditar=5', 'temp', 'left=150', 'top=200', 'height=1000', 'width=1000', 'scrollbar=no', 'location=no', 'resizable=no,menubar=no');
                                        window.close();
                                    </script>
                                ");
                            }
                    ?>
                            <form data-ajax='false' id='forimprimirparte' name='forimprimirparte' method='post' action='reportes.php'>
                                <input type='hidden' name='new' id='new' autocomplete='off' value="5" />
                                <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='5' />
                                <button class="btn btn-primary" type='submit' name='Submit' value='Imprimir'><span class="glyphicon glyphicon-print"></span> imprimir</button>
                            </form>
                        </td>
                        <td>
                            <form data-ajax='false' id='forvolver' name='forvolver' method='post' action='menu.php'>
                                <button class="btn btn-primary"  type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
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
include("config/footer.php");
?>
    <script src="../../js/jquery-3.1.1.min.js"></script>
    <script src="../../js/bootstrap.js"></script>
    <script src="../../js/jquery-backstretch.js"></script>
    <script src="../../js/backstretch.js"></script>
</body>
</body>
