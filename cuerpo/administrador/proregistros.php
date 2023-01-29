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
if($_POST!=null)
{
    $envio=$_POST["registro"];
}
if($_GET!=null)
{
    $envio=$_GET["registro"];
}

/** Registro administrador **/
if($envio==1)
{
    $fallo="Location: registros.php?registro=1";
    if($_POST!=null)
    {
        $academia=$_POST["Academia"];
        $jerarquia=$_POST["Jerarquia"];
        $sexo=$_POST["Sexo"];
        $cedula=$_POST["Cedula"];
        $apellido=$_POST["Apellido"];
        $nombre=$_POST["Nombre"];
        $usuario=$_POST["Usuario"];
        $contrasena=sha1($_POST["Contrasena"]);
    }
    else
    {
        header($fallo);
        exit();
    }
    
        $personas= new Consulta_Personas();
        $personas->Consulta_Cedula_Persona($cedula);
        $personas->Consulta_General();
        $personas->Consulta_Paginador();
        $filapersonas=$personas->Devuelve_Contador();

        if($filapersonas>=1)
        {
            echo "
                <script language='javascript'>
                    alert ('Usuario ya existe');
                    window.location='registros.php?registro=1';
                </script>
            ";
            exit();
        }
        else
        {
            $personas=new Registro_Persona();
            $personas->Registro_De_Persona(1, $academia, $jerarquia, $sexo, $cedula, $apellido, $nombre);
            $personas->Registro_General();

            $accesos= new Consulta_Personas();
            $accesos->Consulta_Cedula_Persona($cedula);
            $accesos->Consulta_General();
            $filaaccesos=$accesos->Devuelve_Consulta();

            $id_per=$filaaccesos[0]['id_per'];
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

            $modulo="Registro/Administrador";
            $auditoria= new Registro_Auditorias();
            $auditoria->Registro_Auditoria($id_pro, 2, $modulo);
            $auditoria->Registro_General();

            $conacc= new Consulta_Personas();
            $conacc->Consulta_Acceso_Cedula($cedula);
            $conacc->Consulta_General();
            $conacc->Consulta_Paginador();
            $filaconacc=$conacc->Devuelve_Contador();
            
            if($filaconacc>=1)
            {
                ?>
                <script language='Javascript'> 
                function confirmar()
                {
                    confirmar=confirm("Registro exitoso, Para realizar otro registro presione Aceptar"); 
                    if (confirmar) 
                    {
                        window.location='registros.php?registro=1';
                    }
                    else
                    {   
                        window.location='consultas.php?registro=1';
                    }
                } 
                </script>
                <?php
                echo "
                    <script>
                        javascript:confirmar();
                    </script>
                ";
            }
            else
            {
               $accesos= new Registro_Persona();
               $accesos->Registro_De_Acceso(1, $id_per, $usuario, $contrasena);
               $accesos->Registro_General();
               ?>
                <script language='Javascript'> 
                function confirmar()
                {
                    confirmar=confirm("Registro exitoso, Para realizar otro registro presione Aceptar"); 
                    if (confirmar) 
                    {
                        window.location='registros.php?registro=1';
                    }
                    else
                    {   
                        window.location='consultas.php?registro=1';
                    }
                } 
                </script>
                <?php
                echo "
                    <script>
                        javascript:confirmar();
                    </script>
                ";
            }
        }

}

/** Registro operador **/
if($envio==2)
{
    $fallo="Location: registros.php?registro=2";
    //***Registro Persona***//
    if($_POST!=null)
    {
        $academia=$_POST["Academia"];
        $jerarquia=$_POST["Jerarquia"];
        $sexo=$_POST["Sexo"];
        $cedula=$_POST["Cedula"];
        $apellido=$_POST["Apellido"];
        $nombre=$_POST["Nombre"];
        $usuario=$_POST["Usuario"];
        $contrasena=sha1($_POST["Contrasena"]);
    }
    else
    {
        header($fallo);
        exit();
    }
    
        $personas= new Consulta_Personas();
        $personas->Consulta_Cedula_Persona($cedula);
        $personas->Consulta_General();
        $personas->Consulta_Paginador();
        $filapersonas=$personas->Devuelve_Contador();

        if($filapersonas>=1)
        {
            echo "
                <script language='javascript'>
                    alert ('Usuario ya existe');
                    window.location='registros.php?registro=2';
                </script>
            ";
            exit();
        }
        else
        {
            $personas=new Registro_Persona();
            $personas->Registro_De_Persona(2, $academia, $jerarquia, $sexo, $cedula, $apellido, $nombre);
            $personas->Registro_General();

            $accesos= new Consulta_Personas();
            $accesos->Consulta_Cedula_Persona($cedula);
            $accesos->Consulta_General();
            $filaaccesos=$accesos->Devuelve_Consulta();

            $id_per=$filaaccesos[0]['id_per'];
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

            $modulo="Registro/Asistente";
            $auditoria= new Registro_Auditorias();
            $auditoria->Registro_Auditoria($id_pro, 2, $modulo);
            $auditoria->Registro_General();

            $conacc= new Consulta_Personas();
            $conacc->Consulta_Acceso_Cedula($cedula);
            $conacc->Consulta_General();
            $conacc->Consulta_Paginador();
            $filaconacc=$conacc->Devuelve_Contador();
            
            if($filaconacc>=1)
            {
                ?>
                <script language='Javascript'> 
                function confirmar()
                {
                    confirmar=confirm("Registro exitoso, Para realizar otro registro presione Aceptar"); 
                    if (confirmar) 
                    {
                        window.location='registros.php?registro=2';
                    }
                    else
                    {   
                        window.location='consultas.php?registro=2';
                    }
                } 
                </script>
                <?php
                echo "
                    <script>
                        javascript:confirmar();
                    </script>
                ";
            }
            else
            {
               $accesos= new Registro_Persona();
               $accesos->Registro_De_Acceso(1, $id_per, $usuario, $contrasena);
               $accesos->Registro_General();
               ?>
                <script language='Javascript'> 
                function confirmar()
                {
                    confirmar=confirm("Registro exitoso, Para realizar otro registro presione Aceptar"); 
                    if (confirmar) 
                    {
                        window.location='registros.php?registro=2';
                    }
                    else
                    {   
                        window.location='consultas.php?registro=2';
                    }
                } 
                </script>
                <?php
                echo "
                    <script>
                        javascript:confirmar();
                    </script>
                ";
            }
        }
        //***Registro Persona***//

}

/** Registro cadetes **/
if($envio==3)
{
    $fallo="Location: registros.php?registro=3";
    //***Registro Persona***//
    if($_POST!=null)
    {
        $academia=$_POST["Academia"];
        $compania=$_POST["Compania"];
        $jerarquia=$_POST["Jerarquia"];
        $sexo=$_POST["Sexo"];
        $cedula=$_POST["Cedula"];
        $contrasena=sha1($cedula);
        $matricula=$_POST["Matricula"];
        $apellido=$_POST["Apellido"];
        $nombre=$_POST["Nombre"];
    }
    else
    {
        header($fallo);
        exit();
    }
    
        $personas= new Consulta_Personas();
        $personas->Consulta_Cedula_Persona($cedula);
        $personas->Consulta_General();
        $personas->Consulta_Paginador();
        $filapersonas=$personas->Devuelve_Contador();

        if($filapersonas>=1)
        {
            echo "
                <script language='javascript'>
                    alert ('Usuario ya existe');
                    window.location='registros.php?registro=3';
                </script>
            ";
            exit();
        }
        else
        {
            $personasmatricula= new Consulta_Personas();
            $personasmatricula->Consulta_Matricula_Cadete($matricula);
            $personasmatricula->Consulta_General();
            $personasmatricula->Consulta_Paginador();
            $filapersonasmatricula=$personasmatricula->Devuelve_Contador();
            if($filapersonasmatricula>=1)
            {
                header($fallo);
                exit();
            }
            else
            {
                $personas=new Registro_Persona();
                $personas->Registro_De_Persona2(3, $academia, $compania, $jerarquia, $sexo, $cedula, $matricula, $apellido, $nombre);
                $personas->Registro_General();

                $accesos= new Consulta_Personas();
                $accesos->Consulta_Cedula_Persona($cedula);
                $accesos->Consulta_General();
                $filaaccesos=$accesos->Devuelve_Consulta();

                $id_per=$filaaccesos[0]['id_per'];
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

                $modulo="Registro/Participante";
                $auditoria= new Registro_Auditorias();
                $auditoria->Registro_Auditoria($id_pro, 2, $modulo);
                $auditoria->Registro_General();

                $conacc= new Consulta_Personas();
                $conacc->Consulta_Acceso_Cedula($cedula);
                $conacc->Consulta_General();
                $conacc->Consulta_Paginador();
                $filaconacc=$conacc->Devuelve_Contador();
            
                if($filaconacc>=1)
                {
                    ?>
                    <script language='Javascript'> 
                        function confirmar()
                        {
                            confirmar=confirm("Registro exitoso, Para realizar otro registro presione Aceptar"); 
                            if (confirmar) 
                            {
                                window.location='registros.php?registro=3';
                            }
                            else
                            {   
                                window.location='consultas.php?registro=3';
                            }
                        } 
                    </script>
                    <?php
                    echo "
                        <script>
                            javascript:confirmar();
                        </script>
                    ";
                }
                else
                {
                    $accesos= new Registro_Persona();
                    $accesos->Registro_De_Acceso(1, $id_per, $cedula, $contrasena);
                    $accesos->Registro_General();
                    ?>
                    <script language='Javascript'> 
                        function confirmar()
                        {
                            confirmar=confirm("Registro exitoso, Para realizar otro registro presione Aceptar"); 
                            if (confirmar) 
                            {
                                window.location='registros.php?registro=3';
                            }
                            else
                            {   
                                window.location='consultas.php?registro=3';
                            }
                        } 
                    </script>
                    <?php
                        echo "
                            <script>
                                javascript:confirmar();
                            </script>
                        ";
                }
            }
        }
        //***Registro Persona***//
}

//Registro por lista de cadetes
if($envio==4)
{
    $fallo="Location: registros.php?registro=4";
    //***Registro Persona***//
    if($_POST!=null)
    {
        if (isset($_POST['submit']))
        {
            $tmpcadetescsv = $_FILES['cadetescsv']['tmp_name']; 
            $namecadetescsv = $_FILES['cadetescsv']['name'];
            $ext=explode(".",$namecadetescsv);
            $ext2 = strtolower($ext[1]);
            if($ext2 != "csv")
            {
                echo "<script language='javascript'>
                    alert ('Archivo invalido');
                    window.location='registros.php?registro=4';
                </script>";     
            }
            else
            {
                if (is_uploaded_file($tmpcadetescsv))
                {
                    $handle=fopen($tmpcadetescsv, "r");
                    $totalC=array();
                    $limite=0;
                    while (($data=fgetcsv($handle, 1000, ","))!== FALSE)
                    {
                        $limite=$limite++;
                        $rjer=trim($data[4]);
                        $raca=trim($data[5]);
                        $rcom=trim($data[6]);
                        $rsex=trim($data[7]);
                        if(is_numeric($raca))
                        {
                            $nraca=1;
                        }
                        else
                        {
                            $nraca=2;
                        }
                        if(is_numeric($rcom))
                        {
                            $nrcom=1;
                        }
                        else
                        {
                            $nrcom=2;
                        }
                        if(is_numeric($rjer))
                        {
                            $nrjer=1;
                        }
                        else
                        {
                            $nrjer=2;
                        }
                        if(is_numeric($rsex))
                        {
                            $nrsex=1;
                        }
                        else
                        {
                            $nrsex=2;
                        }
                        if($nraca==2 || $nrcom==2 || $nrjer==2 || $nrsex==2)
                        {
                            echo "<script language='javascript'>
                                alert ('Los campos Academia, Compañia, Jerarquia y Sexo solo deben contener los Id correspondientes');
                                window.location='registros.php?registro=4';
                                </script>";
                            exit();
                        }
                        if($limite==201)
                        {
                            echo "<script language='javascript'>
                                alert ('El documento supera el máximo de registros permitidos');
                                window.location='registros.php?registro=4';
                                </script>";
                            exit();
                        }
                    }
                    fclose($handle);
                    ?>
                    <!DOCTYPE html>
                        <head>
                            <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>registros</title>
                            <link href="../../css/bootstrap.css" rel="stylesheet" type="text/css"/>
                            <link href="../../css/sb-admin.css" rel="stylesheet" type="text/css"/>
                            <link rel="shortcut icon" type="image/png" href="../../img/icon/helmet.png"/>
                        </head>
                        <body>
                            <?php
                                include("../config/navbar.php");
                            ?>
                            <br><br>
                            <div class="col-md-10 col-md-offset-1">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title" align="center"><strong>Registro de Cadetes</strong></h3>
                                    </div>
                                    <div class="panel-body">
                    <?php
                            $handle=fopen($tmpcadetescsv, "r");
                            $totalC=array();
                            echo "<table class='table'>";
                            echo "<thead>";
                            echo "<tr><th>N°</th><th>Cédula</th><th>Matrícula</th><th>Nombre</th></th><th>Apellido</th><th>Jerarquía</th><th>Academia</th><th>Compañia</th><th>Sexo</th></tr>";
                            echo "</thead><tbody>";
                            $error=null;
                            while (($data=fgetcsv($handle, 1000, ","))!== FALSE)
                            {
                                $i++;
                                $cedula=trim($data[0]);
                                $matricula=trim($data[1]);
                                $nombre=strtolower(rtrim(ltrim($data[2])));
                                $apellido=strtolower(rtrim(ltrim($data[3])));
                                $jerarquia=trim($data[4]);
                                $academia=trim($data[5]);
                                $compania=trim($data[6]);
                                $sexo=trim($data[7]);

                                $cedula=str_replace('.','',$cedula);
                                $contrasena=sha1($cedula);
                                $matricula=str_replace('.','',$matricula);
                                $nombre=str_replace('"',' ',$nombre);
                                $apellido=str_replace('"',' ',$apellido);
                                $jerarquia=str_replace('"',' ',$jerarquia);
                                $academia=str_replace('"',' ',$academia);
                                $compania=str_replace('"',' ',$compania);
                                $sexo=str_replace('"',' ',$sexo);

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
                                
                                $existcedula= new Consulta_Personas();
                                $existcedula->Consulta_Cedula_Persona($cedula);
                                $existcedula->Consulta_General();
                                $existcedula->Consulta_Paginador();
                                $ecedula=$existcedula->Devuelve_Contador();

                                $existmatricula= new Consulta_Personas();
                                $existmatricula->Consulta_Matricula_Cadete($matricula);
                                $existmatricula->Consulta_General();
                                $existmatricula->Consulta_Paginador();
                                $ematricula=$existmatricula->Devuelve_Contador();

                                $existeaca= new Consulta_academias();
                                $existeaca->Consulta_Nombre_Academia($academia);
                                $existeaca->Consulta_General();
                                $filaexisteaca=$existeaca->Devuelve_Consulta();
                                $nacademia=$filaexisteaca[0]['nom_aca'];

                                $existcia= new Consulta_companias();
                                $existcia->Consulta_Nombre_Compania($compania);
                                $existcia->Consulta_General();
                                $existcia->Consulta_Paginador();
                                $ecia=$existcia->Devuelve_Contador();
                                $filaexistcia=$existcia->Devuelve_Consulta();
                                $ncompania=$filaexistcia[0]['nom_com'];

                                $existejerar= new Consulta_jerarquias();
                                $existejerar->Consulta_Nombre_Jerarquia($jerarquia);
                                $existejerar->Consulta_General();
                                $filaexistejerar=$existejerar->Devuelve_Consulta();
                                $njerarquia=$filaexistejerar[0]['nom_jer'];

                                $existesex= new Consulta_sexos();
                                $existesex->Consulta_Nombre_Sexo($sexo);
                                $existesex->Consulta_General();
                                $filaexistesex=$existesex->Devuelve_Consulta();
                                $nsexo=$filaexistesex[0]['nom_sex'];
                                //Verficia existencia del cadete
                                if($academia=="" || $compania=="" || $jerarquia=="" || $sexo=="" || $cedula=="" || $matricula=="" || $nombre=="" || $apellido=="")
                                {
                                    header($fallo);
                                    exit();
                                }
                                else
                                {
                                    if($ecedula>=1)
                                    {
                                        ?>
                                        <tr title="Registro Duplicado" class="danger" style="font-weight:700">
                                            <td style="vertical-align: middle;"><?= $i ?></td>
                                            <td style="vertical-align: middle;"><?= $cedula ?></td>
                                            <td style="vertical-align: middle;"><?= $matricula ?></td>
                                            <td style="vertical-align: middle;"><?= $nombre ?></td>
                                            <td style="vertical-align: middle;"><?= $apellido ?></td>
                                            <td style="vertical-align: middle;"><?= $njerarquia ?></td>
                                            <td style="vertical-align: middle;"><?= $nacademia ?></td>
                                            <td style="vertical-align: middle;"><?= $ncompania ?></td>
                                            <td style="vertical-align: middle;"><?= $nsexo ?></td>
                                        </tr>
                                        <?php
                                        $error=$error."
                                            <tr title='Registro Duplicado' class='danger' style='font-weight:700'>
                                                <td style='vertical-align: middle;'>".$i."</td>
                                                <td style='vertical-align: middle;'>".$cedula."</td>
                                                <td style='vertical-align: middle;'>".$matricula."</td>
                                                <td style='vertical-align: middle;'>".$nombre."</td>
                                                <td style='vertical-align: middle;'>".$apellido."</td>
                                                <td style='vertical-align: middle;'>".$njerarquia."</td>
                                                <td style='vertical-align: middle;'>".$nacademia."</td>
                                                <td style='vertical-align: middle;'>".$ncompania."</td>
                                                <td style='vertical-align: middle;'>".$nsexo."</td>
                                                <td style='vertical-align: middle;'>Registro Duplicado</td>
                                            </tr>
                                        ";
                                    }
                                    else
                                    {
                                        //Verifica existencia de la matricula
                                        if($ematricula>=1)
                                        {
                                            ?>
                                            <tr title="Matrícula Duplicada" class="danger" style="font-weight:700">
                                                <td style="vertical-align: middle;"><?= $i ?></td>
                                                <td style="vertical-align: middle;"><?= $cedula ?></td>
                                                <td style="vertical-align: middle;"><?= $matricula ?></td>
                                                <td style="vertical-align: middle;"><?= $nombre ?></td>
                                                <td style="vertical-align: middle;"><?= $apellido ?></td>
                                                <td style="vertical-align: middle;"><?= $njerarquia ?></td>
                                                <td style="vertical-align: middle;"><?= $nacademia ?></td>
                                                <td style="vertical-align: middle;"><?= $ncompania ?></td>
                                                <td style="vertical-align: middle;"><?= $nsexo ?></td>
                                            </tr>
                                            <?php
                                            $error=$error."
                                                <tr title='Matrícula Duplicada' class='danger' style='font-weight:700'>
                                                    <td style='vertical-align: middle;'>".$i."</td>
                                                    <td style='vertical-align: middle;'>".$cedula."</td>
                                                    <td style='vertical-align: middle;'>".$matricula."</td>
                                                    <td style='vertical-align: middle;'>".$nombre."</td>
                                                    <td style='vertical-align: middle;'>".$apellido."</td>
                                                    <td style='vertical-align: middle;'>".$njerarquia."</td>
                                                    <td style='vertical-align: middle;'>".$nacademia."</td>
                                                    <td style='vertical-align: middle;'>".$ncompania."</td>
                                                    <td style='vertical-align: middle;'>".$nsexo."</td>
                                                    <td style='vertical-align: middle;'>Matrícula Duplicada</td>
                                                </tr>
                                            ";
                                        }
                                        else
                                        {
                                            //Verifica existencia de la jerarquía
                                            if($njerarquia!=null)
                                            {
                                                if($nacademia!=null)
                                                {
                                                    if($ncompania!=null)
                                                    {
                                                        if($nsexo!=null)
                                                        {
                                                            $personas=new Registro_Persona();
                                                            $personas->Registro_De_Persona2(3, $academia, $compania, $jerarquia, $sexo, $cedula, $matricula, $apellido, $nombre);
                                                            $personas->Registro_General();

                                                            $accesos= new Consulta_Personas();
                                                            $accesos->Consulta_Cedula_Persona($cedula);
                                                            $accesos->Consulta_General();
                                                            $filaaccesos=$accesos->Devuelve_Consulta();

                                                            $id_per=$filaaccesos[0]['id_per'];
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

                                                            $modulo="Registro/Participante";
                                                            $auditoria= new Registro_Auditorias();
                                                            $auditoria->Registro_Auditoria($id_pro, 2, $modulo);
                                                            $auditoria->Registro_General();

                                                            $conacc= new Consulta_Personas();
                                                            $conacc->Consulta_Acceso_Cedula($cedula);
                                                            $conacc->Consulta_General();
                                                            $conacc->Consulta_Paginador();
                                                            $filaconacc=$conacc->Devuelve_Contador();
                                                            if($filaconacc>=1)
                                                            {
                                                            }
                                                            else
                                                            {
                                                                $accesos= new Registro_Persona();
                                                                $accesos->Registro_De_Acceso(1, $id_per, $cedula, $contrasena);
                                                                $accesos->Registro_General();
                                                                ?>
                                                                <tr title="Carga Exitosa" class="success">
                                                                    <td style="vertical-align: middle;"><?= $i ?></td>
                                                                    <td style="vertical-align: middle;"><?= $cedula ?></td>
                                                                    <td style="vertical-align: middle;"><?= $matricula ?></td>
                                                                    <td style="vertical-align: middle;"><?= $nombre ?></td>
                                                                    <td style="vertical-align: middle;"><?= $apellido ?></td>
                                                                    <td style="vertical-align: middle;"><?= $njerarquia ?></td>
                                                                    <td style="vertical-align: middle;"><?= $nacademia ?></td>
                                                                    <td style="vertical-align: middle;"><?= $ncompania ?></td>
                                                                    <td style="vertical-align: middle;"><?= $nsexo ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        //Deniega Registro por Sexo inexistente
                                                        else
                                                        {
                                                            ?>
                                                            <tr title="Sexo no existe" class="danger" style="font-weight:700">
                                                                <td style="vertical-align: middle;"><?= $i ?></td>
                                                                <td style="vertical-align: middle;"><?= $cedula ?></td>
                                                                <td style="vertical-align: middle;"><?= $matricula ?></td>
                                                                <td style="vertical-align: middle;"><?= $nombre ?></td>
                                                                <td style="vertical-align: middle;"><?= $apellido ?></td>
                                                                <td style="vertical-align: middle;"><?= $njerarquia ?></td>
                                                                <td style="vertical-align: middle;"><?= $nacademia ?></td>
                                                                <td style="vertical-align: middle;"><?= $ncompania ?></td>
                                                                <td style="vertical-align: middle;"><?= $nsexo ?></td>
                                                            </tr>
                                                            <?php
                                                                $error=$error."
                                                                    <tr title='Sexo no existe' class='danger' style='font-weight:700'>
                                                                        <td style='vertical-align: middle;'>".$i."</td>
                                                                        <td style='vertical-align: middle;'>".$cedula."</td>
                                                                        <td style='vertical-align: middle;'>".$matricula."</td>
                                                                        <td style='vertical-align: middle;'>".$nombre."</td>
                                                                        <td style='vertical-align: middle;'>".$apellido."</td>
                                                                        <td style='vertical-align: middle;'>".$njerarquia."</td>
                                                                        <td style='vertical-align: middle;'>".$nacademia."</td>
                                                                        <td style='vertical-align: middle;'>".$ncompania."</td>
                                                                        <td style='vertical-align: middle;'>".$nsexo."</td>
                                                                        <td style='vertical-align: middle;'>Sexo no existe</td>
                                                                    </tr>
                                                                ";
                                                        }
                                                    }
                                                    //Deniega Registro por Compañía inexistente
                                                    else
                                                    {
                                                        ?>
                                                        <tr title="Compañia no existe" class="danger" style="font-weight:700">
                                                            <td style="vertical-align: middle;"><?= $i ?></td>
                                                            <td style="vertical-align: middle;"><?= $cedula ?></td>
                                                            <td style="vertical-align: middle;"><?= $matricula ?></td>
                                                            <td style="vertical-align: middle;"><?= $nombre ?></td>
                                                            <td style="vertical-align: middle;"><?= $apellido ?></td>
                                                            <td style="vertical-align: middle;"><?= $njerarquia ?></td>
                                                            <td style="vertical-align: middle;"><?= $nacademia ?></td>
                                                            <td style="vertical-align: middle;"><?= $ncompania ?></td>
                                                            <td style="vertical-align: middle;"><?= $nsexo ?></td>
                                                        </tr>
                                                        <?php
                                                            $error=$error."
                                                                <tr title='Compañia no existe' class='danger' style='font-weight:700'>
                                                                    <td style='vertical-align: middle;'>".$i."</td>
                                                                    <td style='vertical-align: middle;'>".$cedula."</td>
                                                                    <td style='vertical-align: middle;'>".$matricula."</td>
                                                                    <td style='vertical-align: middle;'>".$nombre."</td>
                                                                    <td style='vertical-align: middle;'>".$apellido."</td>
                                                                    <td style='vertical-align: middle;'>".$njerarquia."</td>
                                                                    <td style='vertical-align: middle;'>".$nacademia."</td>
                                                                    <td style='vertical-align: middle;'>".$ncompania."</td>
                                                                    <td style='vertical-align: middle;'>".$nsexo."</td>
                                                                    <td style='vertical-align: middle;'>Compañia no existe</td>
                                                                </tr>
                                                            ";
                                                    }
                                                }
                                                //Deniega Registro por Academia inexistente
                                                else
                                                {
                                                    ?>
                                                    <tr title="Academia no existe" class="danger" style="font-weight:700">
                                                        <td style="vertical-align: middle;"><?= $i ?></td>
                                                        <td style="vertical-align: middle;"><?= $cedula ?></td>
                                                        <td style="vertical-align: middle;"><?= $matricula ?></td>
                                                        <td style="vertical-align: middle;"><?= $nombre ?></td>
                                                        <td style="vertical-align: middle;"><?= $apellido ?></td>
                                                        <td style="vertical-align: middle;"><?= $njerarquia ?></td>
                                                        <td style="vertical-align: middle;"><?= $nacademia ?></td>
                                                        <td style="vertical-align: middle;"><?= $ncompania ?></td>
                                                        <td style="vertical-align: middle;"><?= $nsexo ?></td>
                                                    </tr>
                                                    <?php
                                                        $error=$error."
                                                            <tr title='Academia no existe' class='danger' style='font-weight:700'>
                                                                <td style='vertical-align: middle;'>".$i."</td>
                                                                <td style='vertical-align: middle;'>".$cedula."</td>
                                                                <td style='vertical-align: middle;'>".$matricula."</td>
                                                                <td style='vertical-align: middle;'>".$nombre."</td>
                                                                <td style='vertical-align: middle;'>".$apellido."</td>
                                                                <td style='vertical-align: middle;'>".$njerarquia."</td>
                                                                <td style='vertical-align: middle;'>".$nacademia."</td>
                                                                <td style='vertical-align: middle;'>".$ncompania."</td>
                                                                <td style='vertical-align: middle;'>".$nsexo."</td>
                                                                <td style='vertical-align: middle;'>Academia no existe</td>
                                                            </tr>
                                                        ";
                                                }     
                                            }
                                            //Deniega Registro por jerarquía inexistente            
                                            else
                                            { 
                                                ?>
                                                <tr title="Jerarquía no existe" class="danger" style="font-weight:700">
                                                    <td style="vertical-align: middle;"><?= $i ?></td>
                                                    <td style="vertical-align: middle;"><?= $cedula ?></td>
                                                    <td style="vertical-align: middle;"><?= $matricula ?></td>
                                                    <td style="vertical-align: middle;"><?= $nombre ?></td>
                                                    <td style="vertical-align: middle;"><?= $apellido ?></td>
                                                    <td style="vertical-align: middle;"><?= $njerarquia ?></td>
                                                    <td style="vertical-align: middle;"><?= $nacademia ?></td>
                                                    <td style="vertical-align: middle;"><?= $ncompania ?></td>
                                                    <td style="vertical-align: middle;"><?= $nsexo ?></td>
                                                </tr>
                                                <?php
                                                    $error=$error."
                                                        <tr title='Jerarquía no existe' class='danger' style='font-weight:700'>
                                                            <td style='vertical-align: middle;'>".$i."</td>
                                                            <td style='vertical-align: middle;'>".$cedula."</td>
                                                            <td style='vertical-align: middle;'>".$matricula."</td>
                                                            <td style='vertical-align: middle;'>".$nombre."</td>
                                                            <td style='vertical-align: middle;'>".$apellido."</td>
                                                            <td style='vertical-align: middle;'>".$njerarquia."</td>
                                                            <td style='vertical-align: middle;'>".$nacademia."</td>
                                                            <td style='vertical-align: middle;'>".$ncompania."</td>
                                                            <td style='vertical-align: middle;'>".$nsexo."</td>
                                                            <td style='vertical-align: middle;'>Jerarquía no existe</td>
                                                        </tr>
                                                    ";
                                            }   
                                        }
                                    }
                                }
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
                                            <td align='center' colspan='7'>
                                                <br>
                                                <form data-ajax='false' id='forimprimirparte' name='forimprimirparte' method='post' action='imprimirerrorcsv.php'>
                                                    <input type='hidden' name='error' id='error' autocomplete='off' value="<?php echo $error;?>" />
                                                    <input type='hidden' name='ecsv' id='ecsv' autocomplete='off' value='1'/>
                                                    <button class="btn btn-lg btn-primary btn-block" type='submit' name='Submit' value='Imprimir'><span class="glyphicon glyphicon-print"></span> Imprimir</button>
                                                </form>
                                            </td>
                                            <td>
                                                <br>
                                                <form data-ajax='false' id='forvolver' name='forvolver' method='post' action="registros.php?registro=4">
                                                    <button class="btn btn-lg btn-primary btn-block" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-circle-arrow-left"></span> Atrás</button>
                                                </form>
                                            </td>
                                            <td>
                                                <br>
                                                <form data-ajax='false' id='ForConCad' name='ForConCad' method='post' action="consultas.php?registro=3">
                                                    <button class="btn btn-lg btn-primary btn-block" type='submit' name='Submit' value='Atr&aacute;s'><span class="glyphicon glyphicon-search"></span> Consultar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                    </center>
                                </div>
                            </body>
                        </body>
                        <script src="../../js/jquery-3.1.1.min.js"></script>
                        <script src="../../js/bootstrap.js"></script>
                        <script src="../../js/jquery-backstretch.js"></script>
                        <script src="../../js/backstretch.js"></script>
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

/** Registro academias **/
if($envio==5)
{
    $fallo="Location: registros.php?registro=5";
    if($_POST!=null)
    {
        $academia=strtoupper($_POST["Academia"]);
    }
    else
    {
        header($fallo);
        exit();
    }
    
        $busacademia= new Consulta_academias();
        $busacademia->Consulta_Academia_Especifica($academia);
        $busacademia->Consulta_General();
        $busacademia->Consulta_Paginador();
        $filabusacademia=$busacademia->Devuelve_Contador();

        if($filabusacademia>=1)
        {
            echo "
                <script language='javascript'>
                    alert ('Academia ya existe');
                    window.location='registros.php?registro=5';
                </script>
            ";
            exit();
        }
        else
        {
            $regacademia=new Registro_Academia();
            $regacademia->Registro_De_Academia($academia, 1);
            $regacademia->Registro_General();

            $fechanew=date('Y-m-d');
            $horanew=date('H:i:s');
            session_start();
            $ced=$_SESSION['ced']; 

            $conced= new Consulta_Personas();
            $conced->Consulta_Acceso_Cedula($ced);
            $conced->Consulta_General();
            $filaconced=$conced->Devuelve_Consulta();

            $id_per=$filaconced[0]['id_per'];

            $proceso= new Registro_Auditorias(); 
            $proceso->Registro_Proceso(3, $id_per, $fechanew, $horanew);
            $proceso->Registro_General();

            $conproce= new Consulta_Auditorias();
            $conproce->Consulta_Auditoria_Proceso($id_per);
            $conproce->Consulta_General();
            $filaconproce=$conproce->Devuelve_Consulta();
            $id_pro=$filaconproce[0]['id_pro'];

            $modulo="Registro/Academia";
            $auditoria= new Registro_Auditorias();
            $auditoria->Registro_Auditoria($id_pro, 2, $modulo);
            $auditoria->Registro_General();
            ?>
            <script language='Javascript'> 
                function confirmar()
                {
                    confirmar=confirm("Registro exitoso, Para realizar otro registro presione Aceptar"); 
                    if (confirmar) 
                    {
                        window.location='registros.php?registro=5';
                    }
                    else
                    {   
                        window.location='consultas.php?registro=6';
                    }
                } 
            </script>
            <?php
                echo "
                    <script>
                        javascript:confirmar();
                    </script>
                ";
        }

}

/** Registro canchas **/
if($envio==6)
{
    $fallo="Location: registros.php?registro=6";
    if($_POST!=null)
    {
        $cancha=strtolower($_POST["Cancha"]);
    }
    else
    {
        header($fallo);
        exit();
    }
    
        $buscancha= new Consulta_Canchas();
        $buscancha->Consulta_Cancha_Especifica($cancha);
        $buscancha->Consulta_General();
        $buscancha->Consulta_Paginador();
        $filabuscancha=$buscancha->Devuelve_Contador();

        if($filabuscancha>=1)
        {
            echo "
                <script language='javascript'>
                    alert ('Cancha ya existe');
                    window.location='registros.php?registro=6';
                </script>
            ";
            exit();
        }
        else
        {
            $regcancha=new Registro_Canchas();
            $regcancha->Registro_De_Cancha($cancha, 1);
            $regcancha->Registro_General();

            $fechanew=date('Y-m-d');
            $horanew=date('H:i:s');
            session_start();
            $ced=$_SESSION['ced']; 

            $conced= new Consulta_Personas();
            $conced->Consulta_Acceso_Cedula($ced);
            $conced->Consulta_General();
            $filaconced=$conced->Devuelve_Consulta();

            $id_per=$filaconced[0]['id_per'];

            $proceso= new Registro_Auditorias(); 
            $proceso->Registro_Proceso(3, $id_per, $fechanew, $horanew);
            $proceso->Registro_General();

            $conproce= new Consulta_Auditorias();
            $conproce->Consulta_Auditoria_Proceso($id_per);
            $conproce->Consulta_General();
            $filaconproce=$conproce->Devuelve_Consulta();
            $id_pro=$filaconproce[0]['id_pro'];

            $modulo="Registro/Cancha";
            $auditoria= new Registro_Auditorias();
            $auditoria->Registro_Auditoria($id_pro, 2, $modulo);
            $auditoria->Registro_General();
            ?>
            <script language='Javascript'> 
                function confirmar()
                {
                    confirmar=confirm("Registro exitoso, Para realizar otro registro presione Aceptar"); 
                    if (confirmar) 
                    {
                        window.location='registros.php?registro=6';
                    }
                    else
                    {   
                        window.location='consultas.php?registro=7';
                    }
                } 
            </script>
            <?php
                echo "
                    <script>
                        javascript:confirmar();
                    </script>
                ";
        }

}

/** Registro compañias **/
if($envio==7)
{
    $fallo="Location: registros.php?registro=7";
    if($_POST!=null)
    {
        $compania=ucfirst($_POST["Compania"]);
    }
    else
    {
        header($fallo);
        exit();
    }
    
        $buscompania= new Consulta_companias();
        $buscompania->Consulta_Compania_Especifica($compania);
        $buscompania->Consulta_General();
        $buscompania->Consulta_Paginador();
        $filabuscompania=$buscompania->Devuelve_Contador();

        if($filabuscompania>=1)
        {
            echo "
                <script language='javascript'>
                    alert ('Compañia ya existe');
                    window.location='registros.php?registro=7';
                </script>
            ";
            exit();
        }
        else
        {
            $regcompania=new Registro_Companias();
            $regcompania->Registro_De_Compania($compania, 1);
            $regcompania->Registro_General();

            $fechanew=date('Y-m-d');
            $horanew=date('H:i:s');
            session_start();
            $ced=$_SESSION['ced']; 

            $conced= new Consulta_Personas();
            $conced->Consulta_Acceso_Cedula($ced);
            $conced->Consulta_General();
            $filaconced=$conced->Devuelve_Consulta();

            $id_per=$filaconced[0]['id_per'];

            $proceso= new Registro_Auditorias(); 
            $proceso->Registro_Proceso(3, $id_per, $fechanew, $horanew);
            $proceso->Registro_General();

            $conproce= new Consulta_Auditorias();
            $conproce->Consulta_Auditoria_Proceso($id_per);
            $conproce->Consulta_General();
            $filaconproce=$conproce->Devuelve_Consulta();
            $id_pro=$filaconproce[0]['id_pro'];

            $modulo="Registro/Compania";
            $auditoria= new Registro_Auditorias();
            $auditoria->Registro_Auditoria($id_pro, 2, $modulo);
            $auditoria->Registro_General();
            ?>
            <script language='Javascript'> 
                function confirmar()
                {
                    confirmar=confirm("Registro exitoso, Para realizar otro registro presione Aceptar"); 
                    if (confirmar) 
                    {
                        window.location='registros.php?registro=7';
                    }
                    else
                    {   
                        window.location='consultas.php?registro=8';
                    }
                } 
            </script>
            <?php
                echo "
                    <script>
                        javascript:confirmar();
                    </script>
                ";
        }
}

/** Registro jerarquias **/
if($envio==8)
{
    $fallo="Location: registros.php?registro=8";
    if($_POST!=null)
    {
        $jerarquia=strtoupper($_POST["Jerarquia"]);
    }
    else
    {
        header($fallo);
        exit();
    }
    
        $busjerarquia= new Consulta_jerarquias();
        $busjerarquia->Consulta_Jerarquia_Especifica($jerarquia);
        $busjerarquia->Consulta_General();
        $busjerarquia->Consulta_Paginador();
        $filabusjerarquia=$busjerarquia->Devuelve_Contador();

        if($filabusjerarquia>=1)
        {
            echo "
                <script language='javascript'>
                    alert ('Jerarquía ya existe');
                    window.location='registros.php?registro=8';
                </script>
            ";
            exit();
        }
        else
        {
            $regjerarquia=new Registro_Jerarquias();
            $regjerarquia->Registro_De_Jerarquia($jerarquia, 1);
            $regjerarquia->Registro_General();

            $fechanew=date('Y-m-d');
            $horanew=date('H:i:s');
            session_start();
            $ced=$_SESSION['ced']; 

            $conced= new Consulta_Personas();
            $conced->Consulta_Acceso_Cedula($ced);
            $conced->Consulta_General();
            $filaconced=$conced->Devuelve_Consulta();

            $id_per=$filaconced[0]['id_per'];

            $proceso= new Registro_Auditorias(); 
            $proceso->Registro_Proceso(3, $id_per, $fechanew, $horanew);
            $proceso->Registro_General();

            $conproce= new Consulta_Auditorias();
            $conproce->Consulta_Auditoria_Proceso($id_per);
            $conproce->Consulta_General();
            $filaconproce=$conproce->Devuelve_Consulta();
            $id_pro=$filaconproce[0]['id_pro'];

            $modulo="Registro/Jerarquia";
            $auditoria= new Registro_Auditorias();
            $auditoria->Registro_Auditoria($id_pro, 2, $modulo);
            $auditoria->Registro_General();
            ?>
            <script language='Javascript'> 
                function confirmar()
                {
                    confirmar=confirm("Registro exitoso, Para realizar otro registro presione Aceptar"); 
                    if (confirmar) 
                    {
                        window.location='registros.php?registro=8';
                    }
                    else
                    {   
                        window.location='consultas.php?registro=9';
                    }
                } 
            </script>
            <?php
                echo "
                    <script>
                        javascript:confirmar();
                    </script>
                ";
        }

}

/** Registro Jefe **/
if($envio==9)
{
    $fallo="Location: registros.php?registro=9";
    if($_POST!=null)
    {
        $administrador=$_POST["Administrador"];
        $cargo=$_POST["Cargo"];
    }
    else
    {
        header($fallo);
        exit();
    }
    
        $data=new Consulta_personas();
        $data->Consulta_Jefe_Departamento();
        $data->Consulta_General();
        $filadata=$data->Devuelve_Consulta();
        $data->Consulta_Paginador();
        $num_total_registros = $data->Devuelve_Contador();

        if($num_total_registros>=1)
        {
            echo "
                <script language='javascript'>
                    alert ('Ya se encuentra asignado un jefe');
                    window.location='registros.php?registro=9';
                </script>
            ";
            exit();
        }
        else
        {
            $regjefe=new Registro_Persona();
            $regjefe->Registro_De_Jefe($administrador, $cargo);
            $regjefe->Registro_General();

            $fechanew=date('Y-m-d');
            $horanew=date('H:i:s');
            session_start();
            $ced=$_SESSION['ced']; 

            $conced= new Consulta_Personas();
            $conced->Consulta_Acceso_Cedula($ced);
            $conced->Consulta_General();
            $filaconced=$conced->Devuelve_Consulta();

            $id_per=$filaconced[0]['id_per'];

            $proceso= new Registro_Auditorias(); 
            $proceso->Registro_Proceso(3, $id_per, $fechanew, $horanew);
            $proceso->Registro_General();

            $conproce= new Consulta_Auditorias();
            $conproce->Consulta_Auditoria_Proceso($id_per);
            $conproce->Consulta_General();
            $filaconproce=$conproce->Devuelve_Consulta();
            $id_pro=$filaconproce[0]['id_pro'];

            $modulo="Registro/Jefe";
            $auditoria= new Registro_Auditorias();
            $auditoria->Registro_Auditoria($id_pro, 2, $modulo);
            $auditoria->Registro_General();
            ?>
            <script language='Javascript'> 
                function confirmar()
                {
                    confirmar=confirm("Registro exitoso, Para realizar otro registro presione Aceptar"); 
                    if (confirmar) 
                    {
                        window.location='registros.php?registro=9';
                    }
                    else
                    {   
                        window.location='consultas.php?registro=12';
                    }
                } 
            </script>
            <?php
                echo "
                    <script>
                        javascript:confirmar();
                    </script>
                ";
        }

}
?>
