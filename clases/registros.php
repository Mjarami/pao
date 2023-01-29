<?php
   require_once "conexion.php";

   /** Procesa los registros**/
   class Registros extends Conexion
   {
      protected $sql;
      protected $registro;
      public function __construct()
      {
         parent::__construct();
      }

      function Registro_General()
      {
         $this->registro=$this->con->query($this->sql);
      }
   }   
   
   /** Clases especificas para cada modulo **/

   /** La clase Registro_Persona refiere a todos los usuarios en el sistema **/

   class Registro_Persona extends Registros
   {  
      protected $rol;
      protected $academia;
      protected $compania;
      protected $jerarquia;
      protected $sexo;
      protected $grupo;
      protected $categoria;
      protected $texto_poetico;
      protected $cedula;
      protected $matricula;
      protected $nombre;
      protected $apellido;
      protected $estatus;
      protected $persona;
      protected $usuario;
      protected $contrasena;
      protected $titulo;
      protected $autor;
      protected $tono;
      protected $representa;
      protected $id;
      protected $cargo;

      /** Registro_De_Persona Procesa el registro de los usuarios menos el del rol de cadetes **/
      function Registro_De_Persona($rol, $aca, $jer, $sex, $ced, $ape, $nom)
      {
         $this->rol=$rol;
         $this->academia=$aca;
         $this->jerarquia=$jer;
         $this->sexo=$sex;
         $this->cedula=$ced;
         $this->nombre=$nom;
         $this->apellido=$ape;
         $this->sql="INSERT INTO personas (id_rol, id_aca, id_jer, id_sex, ced_per, nom_per, ape_per) VALUES ('".$this->rol."', '".$this->academia."', '".$this->jerarquia."', '".$this->sexo."', '".$this->cedula."', '".$this->nombre."', '".$this->apellido."')";
      }

      /** Registro_De_Persona Procesa el registro de los usuarios con el rol cadetes **/
      function Registro_De_Persona2($rol, $aca, $com, $jer, $sex, $ced, $mat, $ape, $nom)
      {
         $this->rol=$rol;
         $this->academia=$aca;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->sexo=$sex;
         $this->cedula=$ced;
         $this->matricula=$mat;
         $this->nombre=$nom;
         $this->apellido=$ape;
         $this->sql="INSERT INTO personas (id_rol, id_aca, id_com, id_jer, id_sex, ced_per, mat_per, nom_per, ape_per) VALUES ('".$this->rol."', '".$this->academia."', '".$this->compania."', '".$this->jerarquia."', '".$this->sexo."', '".$this->cedula."', '".$this->matricula."', '".$this->nombre."', '".$this->apellido."')";
      }

      function Registro_De_Acceso($est, $per, $usu, $con)
      {
         $this->estatus=$est;
         $this->persona=$per;
         $this->usuario=$usu;
         $this->contrasena=$con;
         $this->sql="INSERT INTO accesos (id_est, id_per, usu_acc, cla_acc) VALUES ('".$this->estatus."', '".$this->persona."', '".$this->usuario."', '".$this->contrasena."')";
      }

      function Registro_De_Jefe($id, $car)
      {
         $this->id=$id;
         $this->cargo=$car;
         $this->sql="INSERT INTO jefe (id_per, car_jef) VALUES ('".$this->id."', '".$this->cargo."')";
      }
   }

   /** La clase Registro_Academia se refiere a las academias o instituciones **/
   class Registro_Academia extends Registros
   {  
      protected $academia;
      protected $estatus;

      function Registro_De_Academia($aca, $id)
      {
         $this->academia=$aca;
         $this->estatus=$id;
         $this->sql="INSERT INTO academias (nom_aca, id_est) VALUES ('".$this->academia."', '".$this->estatus."')";
      }
   }

   /** Registro_Canchas hace referencia a las canchas, campos o clases en las cuales se evaluan los cadetes **/
   class Registro_Canchas extends Registros
   {  
      protected $cancha;
      protected $estatus;

      function Registro_De_Cancha($can, $est)
      {
         $this->cancha=$can;
         $this->estatus=$est;
         $this->sql="INSERT INTO canchas (nom_can, id_est) VALUES ('".$this->cancha."', '".$this->estatus."')";
      }
   }

   /** Registro_Companias hace referencia a las canchas, campos o clases en las cuales se evaluan los cadetes **/
   class Registro_Companias extends Registros
   {  
      protected $compania;
      protected $estatus;

      function Registro_De_Compania($com, $est)
      {
         $this->compania=$com;
         $this->estatus=$est;
         $this->sql="INSERT INTO companias (nom_com, id_est) VALUES ('".$this->compania."', '".$this->estatus."')";
      }
   }

   /** Registro_Jerarquias hace referencia a los grados que poseen los militares o civiles en el caso de grados academicos **/
   class Registro_Jerarquias extends Registros
   {  
      protected $jerarquia;
      protected $estatus;

      function Registro_De_Jerarquia($jer, $est)
      {
         $this->jerarquia=$jer;
         $this->estatus=$est;
         $this->sql="INSERT INTO jerarquias (nom_jer, id_est) VALUES ('".$this->jerarquia."', '".$this->estatus."')";
      }
   }

   /** Registro_Evaluacion hace referencia a las calificaciones de los cadetes **/
   class Registro_Evaluacion extends Registros
   {  
      protected $persona;
      protected $cancha;
      protected $nota;

      function Registro_De_Evaluacion($per, $can, $not)
      {
         $this->persona=$per;
         $this->cancha=$can;
         $this->nota=$not;
         $this->sql="INSERT INTO evaluaciones (id_per, id_can, not_eva) VALUES ('".$this->persona."', '".$this->cancha."', '".$this->nota."')";
      }

      function Registro_De_Promedio($per, $not)
      {
         $this->persona=$per;
         $this->nota=$not;
         $this->sql="INSERT INTO posicion (id_per, pro_pos) VALUES ('".$this->persona."', '".$this->nota."')";
      }      
   }

   /** Registro_auditorias hace referencia a el historial de los procesos o acciones que se ejecutan en el sistema por los usuarios**/
   class Registro_auditorias extends Registros
   {
      protected $accion;
      protected $acceso;
      protected $persona;
      protected $fecha;
      protected $hora;
      protected $proceso;
      protected $motivo;
      protected $lugar;
      protected $edi_aud;
      protected $hab_aud;

      function Registro_Proceso($aci, $per, $fec, $hor)
      {
         $this->accion=$aci;
         $this->persona=$per;
         $this->fecha=$fec;
         $this->hora=$hor;
         $this->sql="INSERT INTO procesos (id_aci, id_per, fec_pro, hor_pro) VALUES ('".$this->accion."', '".$this->persona."', '".$this->fecha."', '".$this->hora."')";
      }

      function Registro_Proceso2($aci, $acc, $per, $fec, $hor)
      {
         $this->accion=$aci;
         $this->acceso=$acc;
         $this->persona=$per;
         $this->fecha=$fec;
         $this->hora=$hor;
         $this->sql="INSERT INTO procesos (id_aci, id_acc, id_per, fec_pro, hor_pro) VALUES ('".$this->accion."', '".$this->acceso."', '".$this->persona."', '".$this->fecha."', '".$this->hora."')";
      }

      function Registro_Auditoria($pro, $id_mot, $lug)
      {
         $this->proceso=$pro;
         $this->motivo=$id_mot;
         $this->lugar=$lug;
         $this->sql="INSERT INTO auditorias (id_pro, id_mot, lug_aud) VALUES ('".$this->proceso."', '".$this->motivo."', '".$this->lugar."')";
      }

      function Registro_Auditoria2($pro, $id_mot, $lug, $edi, $hab)
      {
         $this->proceso=$pro;
         $this->motivo=$id_mot;
         $this->lugar=$lug;
         $this->edi_aud=$edi;
         $this->hab_aud=$hab;

         $this->sql="INSERT INTO auditorias (id_pro, id_mot, lug_aud, edi_aud, hab_aud) VALUES ('".$this->proceso."', '".$this->motivo."', '".$this->lugar."', '".$this->edi_aud."', '".$this->hab_aud."')";
      }

      function Registro_Auditoria3($pro, $id_mot, $lug, $edi, $hab, $obs)
      {
         $this->proceso=$pro;
         $this->motivo=$id_mot;
         $this->lugar=$lug;
         $this->edi_aud=$edi;
         $this->hab_aud=$hab;
         $this->observa=$obs;

         $this->sql="INSERT INTO auditorias (id_pro, id_mot, lug_aud, edi_aud, hab_aud, obs_aud) VALUES ('".$this->proceso."', '".$this->motivo."', '".$this->lugar."', '".$this->edi_aud."', '".$this->hab_aud."', '".$this->observa."')";
      }
   }


?>
