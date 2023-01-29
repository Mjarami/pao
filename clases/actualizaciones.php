<?php
   require_once "conexion.php";

   /** Procesa las ediciones **/
   class Editar extends Conexion
   {
      protected $sql;
      protected $editar;
      public function __construct()
      {
         parent::__construct();
      }

      function Editar_General()
      {
         $this->editar=$this->con->query($this->sql);
      }
   }   
   
   /** Clases para la generacion del sql el cual edita la tabla correspondiente **/
   
   class Editar_Persona extends Editar
   {  
      protected $id;
      protected $id2;
      protected $estatus;
      protected $rol;
      protected $academia;
      protected $jerarquia;
      protected $categoria;
      protected $sexo;
      protected $cedula;
      protected $matricula;
      protected $nombres;
      protected $apellidos;
      protected $usuario;
      protected $contrasena;
      protected $titulo1;
      protected $titulo2;
      protected $autor1;
      protected $autor2;
      protected $tono1;
      protected $tono2;
      protected $representa1;
      protected $representa2;
      protected $cargo;

      function Edito_Estatus_Persona($id, $est)
      {
         $this->id=$id;
         $this->estatus=$est;

         $this->sql="update accesos set id_est='$this->estatus' where id_per='$this->id'";
      }

      function Edito_Jefe($id, $id2, $car)
      {
         $this->id=$id;
         $this->id2=$id2;
         $this->cargo=$car;
         $this->sql="update jefe set id_per='$this->id2', car_jef='$this->cargo' where id_jef='$this->id'";
      }

      function Edito_Datos_Administrador($id, $aca, $jer, $sex, $ced, $nom, $ape, $usu)
      {
         $this->id=$id;
         $this->academia=$aca;
         $this->jerarquia=$jer;
         $this->sexo=$sex;
         $this->cedula=$ced;
         $this->nombres=$nom;
         $this->apellidos=$ape;
         $this->usuario=$usu;

         $this->sql="update personas, accesos set personas.id_aca='$this->academia', personas.id_jer='$this->jerarquia', personas.id_sex='$this->sexo', personas.ced_per='$this->cedula', personas.nom_per='$this->nombres', personas.ape_per='$this->apellidos', accesos.usu_acc='$this->usuario' where personas.id_per='$this->id' and personas.id_per=accesos.id_per";
      }

      function Edito_Datos_Administrador2($id, $aca, $jer, $sex, $ced, $nom, $ape, $usu, $con)
      {
         $this->id=$id;
         $this->academia=$aca;
         $this->jerarquia=$jer;
         $this->sexo=$sex;
         $this->cedula=$ced;
         $this->nombres=$nom;
         $this->apellidos=$ape;
         $this->usuario=$usu;
         $this->contrasena=$con;

         $this->sql="update personas, accesos set personas.id_aca='$this->academia', personas.id_jer='$this->jerarquia', personas.id_sex='$this->sexo', personas.ced_per='$this->cedula', personas.nom_per='$this->nombres', personas.ape_per='$this->apellidos', accesos.usu_acc='$this->usuario', accesos.cla_acc=sha1('$this->contrasena') where personas.id_per='$this->id' and personas.id_per=accesos.id_per";
      }

      function Edito_Datos_Asistente($id, $aca, $jer, $sex, $ced, $nom, $ape, $usu)
      {
         $this->id=$id;
         $this->academia=$aca;
         $this->jerarquia=$jer;
         $this->sexo=$sex;
         $this->cedula=$ced;
         $this->nombres=$nom;
         $this->apellidos=$ape;
         $this->usuario=$usu;

         $this->sql="update personas, accesos set personas.id_aca='$this->academia', personas.id_jer='$this->jerarquia', personas.id_sex='$this->sexo', personas.ced_per='$this->cedula', personas.nom_per='$this->nombres', personas.ape_per='$this->apellidos', accesos.usu_acc='$this->usuario' where personas.id_per='$this->id' and personas.id_per=accesos.id_per";
      }

      function Edito_Datos_Asistente2($id, $aca, $jer, $sex, $ced, $nom, $ape, $usu, $con)
      {
         $this->id=$id;
         $this->academia=$aca;
         $this->jerarquia=$jer;
         $this->sexo=$sex;
         $this->cedula=$ced;
         $this->nombres=$nom;
         $this->apellidos=$ape;
         $this->usuario=$usu;
         $this->contrasena=$con;

         $this->sql="update personas, accesos set personas.id_aca='$this->academia', personas.id_jer='$this->jerarquia', personas.id_sex='$this->sexo', personas.ced_per='$this->cedula', personas.nom_per='$this->nombres', personas.ape_per='$this->apellidos', accesos.usu_acc='$this->usuario', accesos.cla_acc=sha1('$this->contrasena') where personas.id_per='$this->id' and personas.id_per=accesos.id_per";
      }

      function Edito_Datos_Cadete($id, $aca, $com, $jer, $sex, $ced, $mat, $nom, $ape)
      {
         $this->id=$id;
         $this->academia=$aca;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->sexo=$sex;
         $this->cedula=$ced;
         $this->matricula=$mat;
         $this->nombres=$nom;
         $this->apellidos=$ape;

         $this->sql="update personas, accesos set personas.id_aca='$this->academia', personas.id_com='$this->compania', personas.id_jer='$this->jerarquia', personas.id_sex='$this->sexo', personas.ced_per='$this->cedula', personas.mat_per='$this->matricula', personas.nom_per='$this->nombres', personas.ape_per='$this->apellidos' where personas.id_per='$this->id' and personas.id_per=accesos.id_per";
      }

      function Edito_Datos_Cadete2($id, $aca, $com, $jer, $sex, $ced, $nom, $ape)
      {
         $this->id=$id;
         $this->academia=$aca;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->sexo=$sex;
         $this->cedula=$ced;
         $this->nombres=$nom;
         $this->apellidos=$ape;

         $this->sql="update personas, accesos set personas.id_aca='$this->academia', personas.id_com='$this->compania', personas.id_jer='$this->jerarquia', personas.id_sex='$this->sexo', personas.ced_per='$this->cedula', personas.nom_per='$this->nombres', personas.ape_per='$this->apellidos' where personas.id_per='$this->id' and personas.id_per=accesos.id_per";
      }

      function Edito_Datos_Cadete3($com, $ced)
      {
         $this->compania=$com;
         $this->cedula=$ced;
         $this->sql="update personas set personas.id_com='$this->compania' where personas.ced_per='$this->cedula'";
      }

      function Edito_Datos_Cadete4($id, $rol)
      {
         $this->rol=$rol;
         $this->id=$id;
         $this->sql="update personas set personas.id_rol='$this->rol' where personas.id_per='$this->id'";
      }

      function Edito_Datos_Acceso_Asistente($id, $usu, $con)
      {
         $this->id=$id;
         $this->usuario=$usu;
         $this->contrasena=$con;

         $this->sql="update accesos set accesos.usu_acc='$this->usuario', accesos.cla_acc=sha1('$this->contrasena') where accesos.id_per='$this->id'";
      }
      
      function Edito_Datos_Participante($id, $aca, $jer, $sex, $gru, $cat, $ced, $nom, $ape, $usu, $ti1, $au1, $to1, $re1, $ti2, $au2, $to2, $re2)
      {
         $this->id=$id;
         $this->academia=$aca;
         $this->jerarquia=$jer;
         $this->sexo=$sex;
         $this->grupo=$gru;
         $this->categoria=$cat;
         $this->cedula=$ced;
         $this->nombres=$nom;
         $this->apellidos=$ape;
         $this->usuario=$usu;
         $this->titulo1=$ti1;
         $this->autor1=$au1;
         $this->tono1=$to1;
         $this->representa1=$re1;
         $this->titulo2=$ti2;
         $this->autor2=$au2;
         $this->tono2=$to2;
         $this->representa2=$re2;

         $this->sql="update personas, accesos set personas.id_aca='$this->academia', personas.id_jer='$this->jerarquia', personas.id_sex='$this->sexo', personas.idgru='$this->grupo', personas.idcat='$this->categoria', personas.ced_per='$this->cedula', personas.nom_per='$this->nombres', personas.ape_per='$this->apellidos', accesos.usu_acc='$this->usuario', personas.cancion1='$this->titulo1', personas.autor1='$this->autor1', personas.tono1='$this->tono1', personas.representa1='$this->representa1', personas.cancion2='$this->titulo2', personas.autor2='$this->autor2', personas.tono2='$this->tono2', personas.representa2='$this->representa2' where personas.id_per='$this->id' and personas.id_per=accesos.id_per";
      }

      function Edito_Datos_Participante2($id, $aca, $jer, $sex, $gru, $cat, $ced, $nom, $ape, $usu, $con, $ti1, $au1, $to1, $re1, $ti2, $au2, $to2, $re2)
      {
         $this->id=$id;
         $this->academia=$aca;
         $this->jerarquia=$jer;
         $this->sexo=$sex;
         $this->grupo=$gru;
         $this->categoria=$cat;
         $this->cedula=$ced;
         $this->nombres=$nom;
         $this->apellidos=$ape;
         $this->usuario=$usu;
         $this->contrasena=$con;
         $this->titulo1=$ti1;
         $this->autor1=$au1;
         $this->tono1=$to1;
         $this->representa1=$re1;
         $this->titulo2=$ti2;
         $this->autor2=$au2;
         $this->tono2=$to2;
         $this->representa2=$re2;

         $this->sql="update personas, accesos set personas.id_aca='$this->academia', personas.id_jer='$this->jerarquia', personas.id_sex='$this->sexo', personas.idgru='$this->grupo', personas.idcat='$this->categoria', personas.ced_per='$this->cedula', personas.nom_per='$this->nombres', personas.ape_per='$this->apellidos', accesos.usu_acc='$this->usuario', accesos.cla_acc=sha1('$this->contrasena'), personas.cancion1='$this->titulo1', personas.autor1='$this->autor1', personas.tono1='$this->tono1', personas.representa1='$this->representa1', personas.cancion2='$this->titulo2', personas.autor2='$this->autor2', personas.tono2='$this->tono2', personas.representa2='$this->representa2' where personas.id_per='$this->id' and personas.id_per=accesos.id_per";
      }
   }

   class Editar_Academias extends Editar
   {
      protected $id;
      protected $academia;
      protected $id_est;

      function Edito_Academia($id, $aca)
      {
         $this->id=$id;
         $this->academia=$aca;

         $this->sql="update academias set nom_aca='$this->academia' where id_aca='$this->id'";
      }

      function Edito_Academia_Estatus($id_est, $aca)
      {
         $this->id_est=$id_est;
         $this->academia=$aca;

         $this->sql="update academias set id_est='$this->id_est' where id_aca='$this->academia'";
      }
   }

   class Editar_Canchas extends Editar
   {
      protected $id;
      protected $cancha;
      protected $id_est;

      function Edito_Cancha($id, $can)
      {
         $this->id=$id;
         $this->cancha=$can;

         $this->sql="update canchas set nom_can='$this->cancha' where id_can='$this->id'";
      }

      function Edito_Cancha_Estatus($id_est, $can)
      {
         $this->id_est=$id_est;
         $this->cancha=$can;

         $this->sql="update canchas set id_est='$this->id_est' where id_can='$this->cancha'";
      }
   }

   class Editar_Companias extends Editar
   {
      protected $id;
      protected $compania;
      protected $id_est;

      function Edito_Compania($id, $com)
      {
         $this->id=$id;
         $this->compania=$com;

         $this->sql="update companias set nom_com='$this->compania' where id_com='$this->id'";
      }

      function Edito_Compania_Estatus($id_est, $com)
      {
         $this->id_est=$id_est;
         $this->compania=$com;

         $this->sql="update companias set id_est='$this->id_est' where id_com='$this->compania'";
      }
   }

   class Editar_Jerarquias extends Editar
   {
      protected $id;
      protected $jerarquia;
      protected $id_est;

      function Edito_Jerarquia($id, $jer)
      {
         $this->id=$id;
         $this->jerarquia=$jer;

         $this->sql="update jerarquias set nom_jer='$this->jerarquia' where id_jer='$this->id'";
      }

      function Edito_Jerarquia_Estatus($id_est, $jer)
      {
         $this->id_est=$id_est;
         $this->jerarquia=$jer;

         $this->sql="update jerarquias set id_est='$this->id_est' where id_jer='$this->jerarquia'";
      }
   }

   class Editar_Evaluaciones extends Editar
   {
      protected $id;
      protected $nota;

      function Edito_Evaluacion($id, $not)
      {
         $this->id=$id;
         $this->nota=$not;

         $this->sql="update evaluaciones set not_eva='$this->nota' where id_eva='$this->id'";
      }

      function Edito_Promedio($id, $not)
      {
         $this->id=$id;
         $this->nota=$not;

         $this->sql="update posicion set pro_pos='$this->nota' where id_per='$this->id'";
      }
   }
?>
