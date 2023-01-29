<?php
error_reporting(0);
session_start();
if($_SESSION['rol'] != 1)
{
    header('Location: ../logeo/login.php');
    exit();
}
include_once("../../clases/registros.php");
include_once("../../clases/consultas.php");
include_once("../../clases/borrar.php");
if($_POST!=null)
{
    $envio=$_POST["registro"];
}
if($_GET!=null)
{
    $envio=$_GET["registro"];
}

/** Borrar academias**/
if($envio==1)
{
    if($_GET['afirmativo']==1)
    {
        $fallo="Location: consultas.php?registro=6";
        if($_GET!=null)
        {
            $academia=$_GET["academia"];
        }
        else
        {
            echo "
                <script language='javascript'>
                    alert ('No se produce ningun cambio');
                    window.location='consultas.php?registro=6';
                </script>
            ";
            exit();
        } 
        $dataest=new Consulta_academias();
        $dataest->Consulta_Nombre_Academia($academia);
        $dataest->Consulta_General();
        $filadataest=$dataest->Devuelve_Consulta();
        $id_academia=$filadataest[0]['id_aca'];
        $nombre_academia=$filadataest[0]['nom_aca'];
        $estatus_academia=$filadataest[0]['id_est'];
        $dataest= new Consulta_Estatus();
        $dataest->Consulta_Nombre_Estatus($estatus_academia);
        $dataest->Consulta_General();
        $filadataest=$dataest->Devuelve_Consulta();
        $nombre_estatus_academia=$filadataest[0]['nom_est'];
        $habia=$id_academia.", ".$nombre_academia.", ".$nombre_estatus_academia;
        $personas=new Borrar_Academias();
        $personas->Borrar_Academia($id_academia);
        $personas->Borrar_General();
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
        $modulo="Elimino/Academia";
        $modifico="Eliminado";
        $auditoria= new Registro_Auditorias();
        $auditoria->Registro_Auditoria2($id_pro, 4, $modulo, $modifico, $habia);
        $auditoria->Registro_General();
        echo "
            <script language='javascript'>
                alert ('Proceso exitoso');
                window.location='consultas.php?registro=6';
            </script>
        ";
        exit();
    }
    else
    {
        echo "
            <script language='Javascript' type='text/javascript'>
                if (confirm('Seguro que deseas eliminar?'))
                {
                    if (confirm('Se debe tener en cuenta que eliminar un registro implica eliminar todo lo referente a el mismo, Seguro que deseas eliminar?'))
                    {
                        window.location='proborrar.php?registro=1&afirmativo=1&academia=".$_POST['academia']."';
                    }
                    else
                    {
                        alert ('Debe ser cuidadoso con sus decisiones');
                        window.location='consultas.php?registro=6';
                        exit();
                    }
                }
                else
                {
                    alert ('Debe ser cuidadoso con sus decisiones');
                    window.location='consultas.php?registro=6';
                    exit();
                }
            </script>
        ";
    }
}

/** Borrar canchas **/
if($envio==2)
{
    if($_GET['afirmativo']==1)
    {
        $fallo="Location: consultas.php?registro=7";
        //***Registro Persona***//
        if($_GET!=null)
        {
            $cancha=$_GET["cancha"];
        }
        else
        {
            echo "
                <script language='javascript'>
                    alert ('No se produce ningun cambio');
                    window.location='consultas.php?registro=7';
                </script>
            ";
            exit();
        }
        $dataest=new Consulta_Canchas();
        $dataest->Consulta_Nombre_Cancha($cancha);
        $dataest->Consulta_General();
        $filadataest=$dataest->Devuelve_Consulta();
        $id_cancha=$filadataest[0]['id_can'];
        $nombre_cancha=$filadataest[0]['nom_can'];
        $estatus_cancha=$filadataest[0]['id_est'];
        $dataest= new Consulta_Estatus();
        $dataest->Consulta_Nombre_Estatus($estatus_cancha);
        $dataest->Consulta_General();
        $filadataest=$dataest->Devuelve_Consulta();
        $nombre_estatus_cancha=$filadataest[0]['nom_est'];
        $habia=$id_cancha.", ".$nombre_cancha.", ".$nombre_estatus_cancha;
        $personas=new Borrar_Canchas();
        $personas->Borrar_Cancha($id_cancha);
        $personas->Borrar_General(); 
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
        $modulo="Elimino/Cancha";
        $modifico="Eliminado";
        $auditoria= new Registro_Auditorias();
        $auditoria->Registro_Auditoria2($id_pro, 4, $modulo, $modifico, $habia);
        $auditoria->Registro_General();
        echo "
            <script language='javascript'>
                alert ('Proceso exitoso');
                window.location='consultas.php?registro=7';
            </script>
        ";
        exit();
    }
    else
    {
        echo "
            <script language='Javascript' type='text/javascript'>
                if (confirm('Seguro que deseas eliminar?'))
                {
                    if (confirm('Se debe tener en cuenta que eliminar un registro implica eliminar todo lo referente a el mismo, Seguro que deseas eliminar?'))
                    {
                        window.location='proborrar.php?registro=2&afirmativo=1&cancha=".$_POST['cancha']."';
                    }
                    else
                    {
                        alert ('Debe ser cuidadoso con sus decisiones');
                        window.location='consultas.php?registro=7';
                        exit();
                    }
                }
                else
                {
                    alert ('Debe ser cuidadoso con sus decisiones');
                    window.location='consultas.php?registro=7';
                    exit();
                }
            </script>
        ";
    }
}

/** Borrar compañias **/
if($envio==3)
{
    if($_GET['afirmativo']==1)
    {
        $fallo="Location: consultas.php?registro=8";
        //***Registro Persona***//
        if($_GET!=null)
        {
            $compania=$_GET["compania"];
        }
        else
        {
            echo "
                <script language='javascript'>
                    alert ('No se produce ningun cambio');
                    window.location='consultas.php?registro=8';
                </script>
            ";
            exit();
        }
        $dataest=new Consulta_companias();
        $dataest->Consulta_Nombre_Compania($compania);
        $dataest->Consulta_General();
        $filadataest=$dataest->Devuelve_Consulta();
        $id_compania=$filadataest[0]['id_com'];
        $nombre_compania=$filadataest[0]['nom_com'];
        $estatus_compania=$filadataest[0]['id_est'];
        $dataest= new Consulta_Estatus();
        $dataest->Consulta_Nombre_Estatus($estatus_compania);
        $dataest->Consulta_General();
        $filadataest=$dataest->Devuelve_Consulta();
        $nombre_estatus_compania=$filadataest[0]['nom_est'];
        $habia=$id_compania.", ".$nombre_compania.", ".$nombre_estatus_compania;
        $personas=new Borrar_Companias();
        $personas->Borrar_Compania($id_compania);
        $personas->Borrar_General();
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
        $modulo="Elimino/Compania";
        $modifico="Eliminado";
        $auditoria= new Registro_Auditorias();
        $auditoria->Registro_Auditoria2($id_pro, 4, $modulo, $modifico, $habia);
        $auditoria->Registro_General();
        echo "
            <script language='javascript'>
                alert ('Proceso exitoso');
                window.location='consultas.php?registro=8';
            </script>
        ";
        exit();
    }
    else
    {
        echo "
            <script language='Javascript' type='text/javascript'>
                if (confirm('Seguro que deseas eliminar?'))
                {
                    if (confirm('Se debe tener en cuenta que eliminar un registro implica eliminar todo lo referente a el mismo, Seguro que deseas eliminar?'))
                    {
                        window.location='proborrar.php?registro=3&afirmativo=1&compania=".$_POST['compania']."';
                    }
                    else
                    {
                        alert ('Debe ser cuidadoso con sus decisiones');
                        window.location='consultas.php?registro=8';
                        exit();
                    }
                }
                else
                {
                    alert ('Debe ser cuidadoso con sus decisiones');
                    window.location='consultas.php?registro=8';
                    exit();
                }
            </script>
        ";
    }
}

/** Borrar jerarquias **/
if($envio==4)
{
    if($_GET['afirmativo']==1)
    {
        $fallo="Location: consultas.php?registro=9";
        //***Registro Persona***//
        if($_GET!=null)
        {
            $jerarquia=$_GET["jerarquia"];
        }
        else
        {
            echo "
                <script language='javascript'>
                    alert ('No se produce ningun cambio');
                    window.location='consultas.php?registro=9';
                </script>
            ";
            exit();
        }
        $dataest=new Consulta_jerarquias();
        $dataest->Consulta_Nombre_Jerarquia($jerarquia);
        $dataest->Consulta_General();
        $filadataest=$dataest->Devuelve_Consulta();
        $id_jerarquia=$filadataest[0]['id_jer'];
        $nombre_jerarquia=$filadataest[0]['nom_jer'];
        $estatus_jerarquia=$filadataest[0]['id_est'];
        $dataest= new Consulta_Estatus();
        $dataest->Consulta_Nombre_Estatus($estatus_jerarquia);
        $dataest->Consulta_General();
        $filadataest=$dataest->Devuelve_Consulta();
        $nombre_estatus_jerarquia=$filadataest[0]['nom_est'];
        $habia=$id_jerarquia.", ".$nombre_jerarquia.", ".$nombre_estatus_jerarquia;
        $personas=new Borrar_Jerarquias();
        $personas->Borrar_Jerarquia($id_jerarquia);
        $personas->Borrar_General(); 
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
        $modulo="Elimino/Jerarquia";
        $modifico="Eliminado";
        $auditoria= new Registro_Auditorias();
        $auditoria->Registro_Auditoria2($id_pro, 4, $modulo, $modifico, $habia);
        $auditoria->Registro_General();
        echo "
            <script language='javascript'>
                alert ('Proceso exitoso');
                window.location='consultas.php?registro=9';
            </script>
        ";
        exit();
    }
    else
    {
        echo "
            <script language='Javascript' type='text/javascript'>
                if (confirm('Seguro que deseas eliminar?'))
                {
                    if (confirm('Se debe tener en cuenta que eliminar un registro implica eliminar todo lo referente a el mismo, Seguro que deseas eliminar?'))
                    {
                        window.location='proborrar.php?registro=4&afirmativo=1&jerarquia=".$_POST['jerarquia']."';
                    }
                    else
                    {
                        alert ('Debe ser cuidadoso con sus decisiones');
                        window.location='consultas.php?registro=9';
                        exit();
                    }
                }
                else
                {
                    alert ('Debe ser cuidadoso con sus decisiones');
                    window.location='consultas.php?registro=9';
                    exit();
                }
            </script>
        ";
    }
}
/** Borrar jefe **/
if($envio==5)
{
    if($_GET['afirmativo']==1)
    {
        $fallo="Location: consultas.php?registro=12";
        //***Registro Persona***//
        if($_GET!=null)
        {
        }
        else
        {
            echo "
                <script language='javascript'>
                    alert ('No se produce ningun cambio');
                    window.location='consultas.php?registro=12';
                </script>
            ";
            exit();
        }
        $dataest=new Consulta_personas();
        $dataest->Consulta_Jefe_Departamento();
        $dataest->Consulta_General();
        $filadataest=$dataest->Devuelve_Consulta();
        $habia=$filadataest[0]['nom_jer'].", ".$filadataest[0]['ape_per']." ".$filadataest[0]['nom_per'].", ".$filadataest[0]['car_jef'];
        $personas=new Borrar_Jefes();
        $personas->Borrar_Jefe();
        $personas->Borrar_General(); 
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
        $modulo="Elimino/Jefe";
        $modifico="Eliminado";
        $auditoria= new Registro_Auditorias();
        $auditoria->Registro_Auditoria2($id_pro, 4, $modulo, $modifico, $habia);
        $auditoria->Registro_General();
        echo "
            <script language='javascript'>
                alert ('Proceso exitoso');
                window.location='consultas.php?registro=12';
            </script>
        ";
        exit();
    }
    else
    {
        echo "
            <script language='Javascript' type='text/javascript'>
                if (confirm('Seguro que deseas eliminar?'))
                {
                    if (confirm('Se debe tener en cuenta que eliminar un registro implica eliminar todo lo referente a el mismo, Seguro que deseas eliminar?'))
                    {
                        window.location='proborrar.php?registro=5&afirmativo=1';
                    }
                    else
                    {
                        alert ('Debe ser cuidadoso con sus decisiones');
                        window.location='consultas.php?registro=12';
                        exit();
                    }
                }
                else
                {
                    alert ('Debe ser cuidadoso con sus decisiones');
                    window.location='consultas.php?registro=12';
                    exit();
                }
            </script>
        ";
    }
}
/** Borrar aadministrador**/
if($envio==6)
{
    if($_GET['afirmativo']==1)
    {
        $fallo="Location: consultas.php?registro=1";
        if($_GET!=null)
        {
            $cedula=$_GET["cedula"];
            session_start();
            $ced=$_SESSION['ced'];
            if($cedula==$ced)
            {
                echo "
                    <script language='javascript'>
                        alert ('No se puede eliminar un usuario en sesion activa, No se produce ningun cambio');
                        window.location='consultas.php?registro=1';
                    </script>
                ";
                exit();
            }
        }
        else
        {
            echo "
                <script language='javascript'>
                    alert ('No se produce ningun cambio');
                    window.location='consultas.php?registro=1';
                </script>
            ";
            exit();
        } 
        $personas= new Consulta_Personas();
        $personas->Consulta_Cedula_Persona($cedula);
        $personas->Consulta_General();
        $filaconpersonas=$personas->Devuelve_Consulta();
        $personas->Consulta_Paginador();
        $filapersonas=$personas->Devuelve_Contador();
        if($filapersonas>=1)
        {
            $id_rol=$filaconpersonas[0]['id_rol'];
            $datarol= new Consulta_roles();
            $datarol->Consulta_Nombre_rol($id_rol);
            $datarol->Consulta_General();
            $filadatarol=$datarol->Devuelve_Consulta();
            $nombre_rol=$filadatarol[0]['nom_rol'];
            $id_academia=$filaconpersonas[0]['id_aca'];
            $dataacademia= new Consulta_academias();
            $dataacademia->Consulta_Nombre_Academia($id_academia);
            $dataacademia->Consulta_General();
            $filadataacademia=$dataacademia->Devuelve_Consulta();
            $nombre_academia=$filadataacademia[0]['nom_aca'];
            $id_jerarquia=$filaconpersonas[0]['id_jer'];
            $datajerarquia= new Consulta_jerarquias();
            $datajerarquia->Consulta_Nombre_Jerarquia($id_jerarquia);
            $datajerarquia->Consulta_General();
            $filadatajerarquia=$datajerarquia->Devuelve_Consulta();
            $nombre_jerarquia=$filadatajerarquia[0]['nom_jer'];
            $id_sexo=$filaconpersonas[0]['id_sex'];
            $datasexo= new Consulta_sexos();
            $datasexo->Consulta_Nombre_Sexo($id_sexo);
            $datasexo->Consulta_General();
            $filadatasexo=$datasexo->Devuelve_Consulta();
            $nombre_sexo=$filadatasexo[0]['nom_sex'];
            $nombre=$filaconpersonas[0]['nom_per'];
            $apellido=$filaconpersonas[0]['ape_per'];
            $habia=$nombre_rol.", ".$nombre_academia.", ".$nombre_jerarquia.", ".$nombre_sexo.", ".$cedula.", ".$apellido." ".$nombre;
            $personas=new Borrar_Personas();
            $personas->Borrar_persona($cedula);
            $personas->Borrar_General();  
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
            $modulo="Elimino/Administrador";
            $modifico="Eliminado";
            $auditoria= new Registro_Auditorias();
            $auditoria->Registro_Auditoria2($id_pro, 4, $modulo, $modifico, $habia);
            $auditoria->Registro_General();
            echo "
                <script language='javascript'>
                    alert ('Proceso exitoso');
                    window.location='consultas.php?registro=1';
                </script>
            ";
            exit();
        }
        else
        {
            echo "
                <script language='javascript'>
                    alert ('No se produce ningun cambio');
                    window.location='consultas.php?registro=1';
                </script>
            ";
            exit();
        }
    }
    else
    {
        echo "
            <script language='Javascript' type='text/javascript'>
                if (confirm('Seguro que deseas eliminar?'))
                {
                    if (confirm('Se debe tener en cuenta que eliminar un registro implica eliminar todo lo referente a el mismo, Seguro que deseas eliminar?'))
                    {
                        window.location='proborrar.php?registro=6&afirmativo=1&cedula=".$_POST['cedula']."';
                    }
                    else
                    {
                        alert ('Debe ser cuidadoso con sus decisiones');
                        window.location='consultas.php?registro=1';
                        exit();
                    }
                }
                else
                {
                    alert ('Debe ser cuidadoso con sus decisiones');
                    window.location='consultas.php?registro=1';
                    exit();
                }
            </script>
        ";
    }
}
/** Borrar operador**/
if($envio==7)
{
    if($_GET['afirmativo']==1)
    {
        $fallo="Location: consultas.php?registro=2";
        if($_GET!=null)
        {
            $cedula=$_GET["cedula"];
            session_start();
            $ced=$_SESSION['ced'];
            if($cedula==$ced)
            {
                echo "
                    <script language='javascript'>
                        alert ('No se puede eliminar un usuario en sesion activa, No se produce ningun cambio');
                        window.location='consultas.php?registro=1';
                    </script>
                ";
                exit();
            }
        }
        else
        {
            echo "
                <script language='javascript'>
                    alert ('No se produce ningun cambio');
                    window.location='consultas.php?registro=2';
                </script>
            ";
            exit();
        } 
        $personas= new Consulta_Personas();
        $personas->Consulta_Cedula_Persona($cedula);
        $personas->Consulta_General();
        $filaconpersonas=$personas->Devuelve_Consulta();
        $personas->Consulta_Paginador();
        $filapersonas=$personas->Devuelve_Contador();
        if($filapersonas>=1)
        {
            $id_rol=$filaconpersonas[0]['id_rol'];
            $datarol= new Consulta_roles();
            $datarol->Consulta_Nombre_rol($id_rol);
            $datarol->Consulta_General();
            $filadatarol=$datarol->Devuelve_Consulta();
            $nombre_rol=$filadatarol[0]['nom_rol'];
            $id_academia=$filaconpersonas[0]['id_aca'];
            $dataacademia= new Consulta_academias();
            $dataacademia->Consulta_Nombre_Academia($id_academia);
            $dataacademia->Consulta_General();
            $filadataacademia=$dataacademia->Devuelve_Consulta();
            $nombre_academia=$filadataacademia[0]['nom_aca'];
            $id_jerarquia=$filaconpersonas[0]['id_jer'];
            $datajerarquia= new Consulta_jerarquias();
            $datajerarquia->Consulta_Nombre_Jerarquia($id_jerarquia);
            $datajerarquia->Consulta_General();
            $filadatajerarquia=$datajerarquia->Devuelve_Consulta();
            $nombre_jerarquia=$filadatajerarquia[0]['nom_jer'];
            $id_sexo=$filaconpersonas[0]['id_sex'];
            $datasexo= new Consulta_sexos();
            $datasexo->Consulta_Nombre_Sexo($id_sexo);
            $datasexo->Consulta_General();
            $filadatasexo=$datasexo->Devuelve_Consulta();
            $nombre_sexo=$filadatasexo[0]['nom_sex'];
            $nombre=$filaconpersonas[0]['nom_per'];
            $apellido=$filaconpersonas[0]['ape_per'];
            $habia=$nombre_rol.", ".$nombre_academia.", ".$nombre_jerarquia.", ".$nombre_sexo.", ".$cedula.", ".$apellido." ".$nombre;
            $personas=new Borrar_Personas();
            $personas->Borrar_persona($cedula);
            $personas->Borrar_General();  
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
            $modulo="Elimino/Operador";
            $modifico="Eliminado";
            $auditoria= new Registro_Auditorias();
            $auditoria->Registro_Auditoria2($id_pro, 4, $modulo, $modifico, $habia);
            $auditoria->Registro_General();
            echo "
                <script language='javascript'>
                    alert ('Proceso exitoso');
                    window.location='consultas.php?registro=2';
                </script>
            ";
            exit();
        }
        else
        {
            echo "
                <script language='javascript'>
                    alert ('No se produce ningun cambio');
                    window.location='consultas.php?registro=2';
                </script>
            ";
            exit();
        }
    }
    else
    {
        echo "
            <script language='Javascript' type='text/javascript'>
                if (confirm('Seguro que deseas eliminar?'))
                {
                    if (confirm('Se debe tener en cuenta que eliminar un registro implica eliminar todo lo referente a el mismo, Seguro que deseas eliminar?'))
                    {
                        window.location='proborrar.php?registro=7&afirmativo=1&cedula=".$_POST['cedula']."';
                    }
                    else
                    {
                        alert ('Debe ser cuidadoso con sus decisiones');
                        window.location='consultas.php?registro=2';
                        exit();
                    }
                }
                else
                {
                    alert ('Debe ser cuidadoso con sus decisiones');
                    window.location='consultas.php?registro=2';
                    exit();
                }
            </script>
        ";
    }
}
/** Borrar cadete**/
if($envio==8)
{
    if($_GET['afirmativo']==1)
    {
        $fallo="Location: consultas.php?registro=3";
        if($_GET!=null)
        {
            $cedula=$_GET["cedula"];
        }
        else
        {
            echo "
                <script language='javascript'>
                    alert ('No se produce ningun cambio');
                    window.location='consultas.php?registro=3';
                </script>
            ";
            exit();
        } 
        $personas= new Consulta_Personas();
        $personas->Consulta_Cedula_Persona($cedula);
        $personas->Consulta_General();
        $filaconpersonas=$personas->Devuelve_Consulta();
        $personas->Consulta_Paginador();
        $filapersonas=$personas->Devuelve_Contador();
        if($filapersonas>=1)
        {
            $id_rol=$filaconpersonas[0]['id_rol'];
            $datarol= new Consulta_roles();
            $datarol->Consulta_Nombre_rol($id_rol);
            $datarol->Consulta_General();
            $filadatarol=$datarol->Devuelve_Consulta();
            $nombre_rol=$filadatarol[0]['nom_rol'];
            $id_academia=$filaconpersonas[0]['id_aca'];
            $dataacademia= new Consulta_academias();
            $dataacademia->Consulta_Nombre_Academia($id_academia);
            $dataacademia->Consulta_General();
            $filadataacademia=$dataacademia->Devuelve_Consulta();
            $nombre_academia=$filadataacademia[0]['nom_aca'];
            $id_compania=$filaconpersonas[0]['id_com'];
            $datacompania= new Consulta_companias();
            $datacompania->Consulta_Nombre_Compania($id_compania);
            $datacompania->Consulta_General();
            $filadatacompania=$datacompania->Devuelve_Consulta();
            $nombre_compania=$filadatacompania[0]['nom_com'];
            $id_jerarquia=$filaconpersonas[0]['id_jer'];
            $datajerarquia= new Consulta_jerarquias();
            $datajerarquia->Consulta_Nombre_Jerarquia($id_jerarquia);
            $datajerarquia->Consulta_General();
            $filadatajerarquia=$datajerarquia->Devuelve_Consulta();
            $nombre_jerarquia=$filadatajerarquia[0]['nom_jer'];
            $id_sexo=$filaconpersonas[0]['id_sex'];
            $datasexo= new Consulta_sexos();
            $datasexo->Consulta_Nombre_Sexo($id_sexo);
            $datasexo->Consulta_General();
            $filadatasexo=$datasexo->Devuelve_Consulta();
            $nombre_sexo=$filadatasexo[0]['nom_sex'];
            $matricula=$filaconpersonas[0]['mat_per'];
            $nombre=$filaconpersonas[0]['nom_per'];
            $apellido=$filaconpersonas[0]['ape_per'];
            $habia=$nombre_rol.", ".$nombre_academia.", ".$nombre_compania.", ".$nombre_jerarquia.", ".$nombre_sexo.", ".$cedula.", ".$matricula.", ".$apellido." ".$nombre;
            $personas=new Borrar_Personas();
            $personas->Borrar_persona($cedula);
            $personas->Borrar_General();  
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
            $modulo="Elimino/Cadete";
            $modifico="Eliminado";
            $auditoria= new Registro_Auditorias();
            $auditoria->Registro_Auditoria2($id_pro, 4, $modulo, $modifico, $habia);
            $auditoria->Registro_General();
            echo "
                <script language='javascript'>
                    alert ('Proceso exitoso');
                    window.location='consultas.php?registro=3';
                </script>
            ";
            exit();
        }
        else
        {
            echo "
                <script language='javascript'>
                    alert ('No se produce ningun cambio');
                    window.location='consultas.php?registro=3';
                </script>
            ";
            exit();
        }
    }
    else
    {
        echo "
            <script language='Javascript' type='text/javascript'>
                if (confirm('Seguro que deseas eliminar?'))
                {
                    if (confirm('Se debe tener en cuenta que eliminar un registro implica eliminar todo lo referente a el mismo, Seguro que deseas eliminar?'))
                    {
                        window.location='proborrar.php?registro=8&afirmativo=1&cedula=".$_POST['cedula']."';
                    }
                    else
                    {
                        alert ('Debe ser cuidadoso con sus decisiones');
                        window.location='consultas.php?registro=3';
                        exit();
                    }
                }
                else
                {
                    alert ('Debe ser cuidadoso con sus decisiones');
                    window.location='consultas.php?registro=3';
                    exit();
                }
            </script>
        ";
    }
}
?>
