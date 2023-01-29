<?php
error_reporting(0);
session_start();
if($_SESSION['rol'] != 1)
{
    header('Location: ../logeo/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Panel de Auditorias</title>
    <link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
    <link href="../../img/icon/helmet.png" rel="shortcut icon" type="image/png"/>
</head>
<body>
<?php
    include("../config/navbar3.php");
    include("../config/navbar2.php");
    /** menu auditorias **/
?>
<br>
<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="panel-title" align="center"><strong><span class="glyphicon glyphicon-eye-open"></span> Auditorias</strong></h2><br>
                    <h3 class="panel-title" align="center">Selecciona la opci&oacute;n a ejecutar:</h3>
                </div>
                <div class="panel-body">
                    <form id='ForAudEnt' name='ForAudEnt' method='post' action='reportes.php'>
                        <fieldset>
                            <div class="form-group">
                                <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='1'/>
                                <button class="btn btn-primary btn-block" type='submit' name='Submit' value='Entradas'><span class="glyphicon glyphicon-send"></span> Entradas al Sistemas</button>
                            </div>
                        </fieldset>
					</form>
                    <form id='ForAudSal' name='ForAudSal' method='post' action='reportes.php'>
                        <fieldset>
                            <div class="form-group">
                                <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='2'/>
                                <button class="btn btn-primary btn-block" type='submit' name='Submit' value='Salidas'><span class="glyphicon glyphicon-off"></span> Salidas del Sistema</button>
                             </div>
                        </fieldset>
                    </form>
                    <form id='ForAudRep' name='ForAudRep' method='post' action='reportes.php'>
                        <fieldset>
                            <div class="form-group">                        
                                <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='3'/>
                                <button class="btn btn-primary btn-block" type='submit' name='Submit' value='Reportes'><span class="glyphicon glyphicon-list"></span> Reportes</button>
                            </div>
                        </fieldset>
                    </form>
                    <form id='ForAudRep' name='ForAudRep' method='post' action='reportes.php'>
                        <fieldset>
                            <div class="form-group">
                                <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='4'/>
                                <button class="btn btn-primary btn-block" type='submit' name='Submit' value='Registros'><span class="glyphicon glyphicon-user"></span> Registros</button>
                            </div>
                        </fieldset>
                    </form>
                    <form id='ForAudRep' name='ForAudRep' method='post' action='reportes.php'>
                        <fieldset>
                            <div class="form-group">
                                <input type='hidden' name='auditar' id='auditar' autocomplete='off' value='5'/>
                                <button class="btn btn-primary btn-block" type='submit' name='Submit' value='Ediciones'><span class="glyphicon glyphicon-edit"></span> Ediciones</button>
                            </div>
                        </fieldset>
                    </form>
					<form id='ForSalir' name='ForSalir' method='post' action='../administrador/menu.php'>
                        <fieldset>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atr&aacute;s</button>
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

