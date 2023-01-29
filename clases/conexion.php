<?php
   require_once "config.php";
   /**Se crea la clase Conexion la cual efectua el proceso de enlace a la base de datos **/
   class Conexion
   {
      protected $con;
      public function __construct()
      {
         /** se crea el objeto con, enviando las constantes para ser procesadas por la clase mysqli**/
         $this->con=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
         /** Se verifica la existencia de algun error en la conexion efectuada **/
         if ($this->con->connect_errno)
         {
            echo "Fallo al conectar a MySQL: ".$this->con->connect_error;
            return;    
         }
         $this->con->set_charset(DB_CHARSET);
      }
   }
?> 