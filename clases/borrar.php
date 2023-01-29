<?php
   require_once "conexion.php";

/** Procesa la eliminacion de registros **/
   class Borrar extends Conexion
   {
      protected $sql;
      protected $borrar;
      public function __construct()
      {
         parent::__construct();
      }

      function Borrar_General()
      {
         $this->borrar=$this->con->query($this->sql);
      }
   }

/** Clases para la eliminacion de datos**/

   class Borrar_Academias extends Borrar
   {
      protected $academia;
      function Borrar_Academia($aca)
      {
         $this->academia=$aca;
         $this->sql="delete from academias where id_aca='$this->academia'";
      }
   }

   class Borrar_Canchas extends Borrar
   {
      protected $cancha;
      function Borrar_Cancha($can)
      {
         $this->cancha=$can;
         $this->sql="delete from canchas where id_can='$this->cancha'";
      }
   }

   class Borrar_Companias extends Borrar
   {
      protected $compania;
      function Borrar_Compania($com)
      {
         $this->compania=$com;
         $this->sql="delete from companias where id_com='$this->compania'";
      }
   }

   class Borrar_Jerarquias extends Borrar
   {
      protected $jerarquia;
      function Borrar_Jerarquia($jer)
      {
         $this->jerarquia=$jer;
         $this->sql="delete from jerarquias where id_jer='$this->jerarquia'";
      }
   }

   class Borrar_Promedios extends Borrar
   {
      function Borrar_Promedio()
      {
         $this->sql="delete from posicion";
      }
   }

   class Borrar_Jefes extends Borrar
   {
      function Borrar_Jefe()
      {
         $this->sql="delete from jefe";
      }
   }

   class Borrar_Personas extends Borrar
   {
      protected $cedula;
      function Borrar_persona($ced)
      {
         $this->cedula=$ced;
         $this->sql="delete from personas where ced_per='$this->cedula'";
      }
   }

?>
