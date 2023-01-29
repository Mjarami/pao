<?php 
   require_once "conexion.php";

   /** Consultas basicas **/
   class Consultas extends Conexion
   {
      protected $sql;
      protected $consulta;
      protected $resultado;
      protected $tabla;
      protected $row;
      protected $contador;
      protected $tamano;
      protected $inicio;
      protected $proceso;

      public function __construct()
      {
         parent::__construct();
      }

      public function Desactivar_Full_Group()
      {
         $this->sql="SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
      }

      public function Consulta_Tabla_General($tabla)
      {
         $this->tabla=$tabla;
         $this->sql="SELECT * FROM $this->tabla";
      }

      public function Consulta_Tabla_General2($tabla)
      {
         $this->tabla=$tabla;
         $this->sql="SELECT * FROM $this->tabla where id_est='1'";
      }

      public function Consulta_Tabla_General3($tabla, $tam, $ini)
      {
         $this->tabla=$tabla;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT * FROM $this->tabla where id_est='1' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Tabla_General4($tabla, $tam, $ini)
      {
         $this->tabla=$tabla;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT * FROM $this->tabla LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Procesar_Desactivar_Full_Group()
      {
         $this->proceso=$this->con->query($this->sql);
      }

      public function Consulta_General()
      {
         $this->consulta=$this->con->query($this->sql);
         $this->resultado=$this->consulta->fetch_all(MYSQLI_ASSOC);
      }

      public function Consulta_Paginador()
      {
         $this->contador=0;
         foreach ($this->resultado as $this->row)
         {
            $this->contador=$this->contador+1;
         }
      }      

      public function Devuelve_Consulta()
      {
         return $this->resultado;
      }

      public function Devuelve_Contador()
      {
         return $this->contador;
      }
   }

   /** Consultas especificas y multiconsultas **/
   class Consulta_personas extends Consultas
   {
      protected $cedula;
      protected $matricula;
      protected $usuario;
      protected $contrasena;
      protected $rol;
      protected $id_per;
      protected $buscando;
      protected $buscando2;
      protected $buscando3;
      protected $buscando4;
      protected $jerarquia1;
      protected $jerarquia2;
      protected $jerarquia3;
      protected $jerarquia4;

      public function Consulta_Jefe_Departamento()
      {
         $this->sql="SELECT j.id_jef, j.car_jef, j.id_per, p.nom_per, p.ape_per, je.nom_jer FROM jefe AS j, personas AS p, jerarquias AS je WHERE j.id_per=p.id_per AND p.id_jer=je.id_jer";
      }

      public function Consulta_Cedula_Persona($ced)
      {
         $this->cedula=$ced;
         $this->sql="SELECT * FROM personas WHERE ced_per='$this->cedula'";
      }

      public function Consulta_Id_Persona($id)
      {
         $this->id_per=$id;
         $this->sql="SELECT * FROM personas WHERE id_per='$this->id_per'";
      }

      public function Consulta_Matricula_Cadete($mat)
      {
         $this->matricula=$mat;
         $this->sql="SELECT * FROM personas WHERE mat_per='$this->matricula'";
      }

      public function Consulta_Acceso_Persona($usu, $con)
      {
         $this->usuario=$usu;
         $this->contrasena=$con;
         $this->sql="SELECT accesos.id_est, accesos.id_per, accesos.usu_acc, accesos.cla_acc, personas.id_rol, personas.id_per, personas.ced_per, estatus.id_est, estatus.nom_est, roles.id_rol, roles.nom_rol FROM accesos, personas, estatus, roles WHERE accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol=roles.id_rol AND accesos.usu_acc='$this->usuario' AND accesos.cla_acc='$this->contrasena' AND accesos.id_est='1'";
      }

      public function Consulta_Acceso_Cedula($ced)
      {
         $this->cedula=$ced;
         $this->sql="SELECT accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, personas.id_rol, personas.id_per, personas.ced_per, estatus.id_est, estatus.nom_est, roles.id_rol, roles.nom_rol FROM accesos, personas, estatus, roles WHERE accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol=roles.id_rol AND personas.ced_per='$this->cedula'";
      }

      public function Consulta_Cedula_Rol_Administrador($ced)
      {
         $this->cedula=$ced;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_jer, personas.id_sex, personas.ced_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='1' and personas.ced_per='$this->cedula'";
      }

      public function Consulta_Cedula_Rol_Asistente($ced)
      {
         $this->cedula=$ced;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_jer, personas.id_sex, personas.ced_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='2' and personas.ced_per='$this->cedula'";
      }

      public function Consulta_Cedula_Rol_Participante($ced)
      {
         $this->cedula=$ced;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' and personas.ced_per='$this->cedula' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' and personas.mat_per='$this->cedula'";
      }
      
      public function Consulta_Id_Rol_Participante($per)
      {
         $this->id_per=$per;
         $this->sql="SELECT ced_per FROM personas WHERE id_per='$this->id_per';";
      }

      public function Consulta_personas_Rol_Administrador()
      {
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_jer, personas.id_sex, personas.id_per, personas.ced_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='1' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Administrador2($tam, $ini)
      {
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_jer, personas.id_sex, personas.id_per, personas.ced_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='1' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Asistente()
      {
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_jer, personas.id_sex, personas.ced_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='2' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Asistente2($tam, $ini)
      {
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_jer, personas.id_sex, personas.ced_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante()
      {
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Transcriptor()
      {
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante2($tam, $ini)
      {
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante2_Transcriptor($tam, $ini)
      {
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador($bus)
      {
         $this->buscando=$bus;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.nom_jer='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND sexos.nom_sex='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND personas.ced_per='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND personas.mat_per='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND personas.ape_per like '%$this->buscando%' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND personas.nom_per like '%$this->buscando%' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.nom_jer='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND sexos.nom_sex='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND personas.ced_per='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND personas.mat_per='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND personas.ape_per like '%$this->buscando%' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND personas.nom_per like '%$this->buscando%' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador2($bus, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.nom_jer='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND sexos.nom_sex='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND personas.ced_per='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND personas.mat_per='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND personas.ape_per like '%$this->buscando%' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND personas.nom_per like '%$this->buscando%' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.nom_jer='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND sexos.nom_sex='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND personas.ced_per='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND personas.mat_per='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND personas.ape_per like '%$this->buscando%' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND personas.nom_per like '%$this->buscando%' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias($bus)
      {
         $this->buscando=$bus;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Transcriptor($bus)
      {
         $this->buscando=$bus;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias2($bus, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias2_Transcriptor($bus, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias($bus)
      {
         $this->buscando=$bus;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Transcriptor($bus)
      {
         $this->buscando=$bus;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias2($bus, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias2_Transcriptor($bus, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Jerarquias($bus)
      {
         $this->buscando=$bus;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.nom_jer='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.nom_jer='$this->buscando' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Jerarquias_Transcriptor($bus)
      {
         $this->buscando=$bus;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.nom_jer='$this->buscando' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Jerarquias2($bus, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.nom_jer='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.nom_jer='$this->buscando' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Jerarquias2_Transcriptor($bus, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.nom_jer='$this->buscando' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Anos($bus)
      {
         $this->buscando=$bus;
         if($this->buscando==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         
         if($this->buscando==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia5' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia4' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC";
         }
         
      }

      public function Consulta_personas_Rol_Participante_Buscador_Anos_Transcriptor($bus)
      {
         $this->buscando=$bus;
         if($this->buscando==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         
         if($this->buscando==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC";
         }
         
      }

      public function Consulta_personas_Rol_Participante_Buscador_Anos2($bus, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         
         if($this->buscando==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia5' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia4' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Anos2_Transcriptor($bus, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         
         if($this->buscando==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Sexos($bus)
      {
         $this->buscando=$bus;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND sexos.nom_sex='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND sexos.nom_sex='$this->buscando' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Sexos_Transcriptor($bus)
      {
         $this->buscando=$bus;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND sexos.nom_sex='$this->buscando' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Sexos2($bus, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND sexos.nom_sex='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND sexos.nom_sex='$this->buscando' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Sexos2_Transcriptor($bus, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND sexos.nom_sex='$this->buscando' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Estatus($bus)
      {
         $this->buscando=$bus;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND estatus.nom_est='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND estatus.nom_est='$this->buscando' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Estatus_Transcriptor($bus)
      {
         $this->buscando=$bus;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND estatus.nom_est='$this->buscando' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Estatus2($bus, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND estatus.nom_est='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND estatus.nom_est='$this->buscando' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Estatus2_Transcriptor($bus, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND estatus.nom_est='$this->buscando' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Transcriptor($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias2($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias2_Transcriptor($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Jerarquias($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Jerarquias_Transcriptor($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Jerarquias2($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Jerarquias2_Transcriptor($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Anos($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Anos_Transcriptor($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Anos2($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Anos2_Transcriptor($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Sexos($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND sexos.nom_sex='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Sexos_Transcriptor($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Sexos2($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND sexos.nom_sex='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Sexos2_Transcriptor($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Estatus($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND estatus.nom_est='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND estatus.nom_est='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Estatus_Transcriptor($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND estatus.nom_est='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Estatus2($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND estatus.nom_est='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND estatus.nom_est='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Estatus2_Transcriptor($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND estatus.nom_est='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Jerarquias($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
      }

       public function Consulta_personas_Rol_Participante_Buscador_Companias_Jerarquias_Transcriptor($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Jerarquias2($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Jerarquias2_Transcriptor($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Anos($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Anos_Transcriptor($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Anos2($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Anos2_Transcriptor($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Sexos($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND sexos.nom_sex='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Sexos_Transcriptor($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Sexos2($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND sexos.nom_sex='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Sexos2_Transcriptor($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Jerarquias_Sexos($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.nom_jer='$this->buscando' AND sexos.nom_sex='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.nom_jer='$this->buscando' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Jerarquias_Sexos_Transcriptor($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.nom_jer='$this->buscando' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Jerarquias_Sexos2($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.nom_jer='$this->buscando' AND sexos.nom_sex='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.nom_jer='$this->buscando' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Jerarquias_Sexos2_Transcriptor($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.nom_jer='$this->buscando' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Anos_Sexos($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         if($this->buscando==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Anos_Sexos_Transcriptor($bus, $bus2)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         if($this->buscando==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Anos_Sexos2($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando2' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Anos_Sexos2_Transcriptor($bus, $bus2, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando2' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Jerarquias($bus, $bus2, $bus3)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.nom_jer='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.nom_jer='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Jerarquias_Transcriptor($bus, $bus2, $bus3)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.nom_jer='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Jerarquias2($bus, $bus2, $bus3, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.nom_jer='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.nom_jer='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Jerarquias2_Transcriptor($bus, $bus2, $bus3, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.nom_jer='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Anos($bus, $bus2, $bus3)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         if($this->buscando3==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando3==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando3==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando3==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia5' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Anos_Transcriptor($bus, $bus2, $bus3)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         if($this->buscando3==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando3==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando3==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando3==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Anos2($bus, $bus2, $bus3, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando3==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando3==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando3==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando3==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia5' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Anos2_Transcriptor($bus, $bus2, $bus3, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando3==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando3==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando3==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando3==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia5' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Sexos($bus, $bus2, $bus3)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND sexos.nom_sex='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Sexos_Transcritor($bus, $bus2, $bus3)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Sexos2($bus, $bus2, $bus3, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND sexos.nom_sex='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Sexos2_Transcriptor($bus, $bus2, $bus3, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Jerarquias_Sexos($bus, $bus2, $bus3)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' AND sexos.nom_sex='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Jerarquias_Sexos_Transcriptor($bus, $bus2, $bus3)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Jerarquias_Sexos2($bus, $bus2, $bus3, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' AND sexos.nom_sex='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Jerarquias_Sexos2_Transcriptor($bus, $bus2, $bus3, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Anos_Sexos($bus, $bus2, $bus3)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Anos_Sexos_Transcriptor($bus, $bus2, $bus3)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Anos_Sexos2($bus, $bus2, $bus3, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Anos_Sexos2_Transcriptor($bus, $bus2, $bus3, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Jerarquias_Sexos($bus, $bus2, $bus3)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' AND sexos.nom_sex='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Jerarquias_Sexos_Transcriptor($bus, $bus2, $bus3)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Jerarquias_Sexos2($bus, $bus2, $bus3, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' AND sexos.nom_sex='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Jerarquias_Sexos2_Transcriptor($bus, $bus2, $bus3, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.nom_jer='$this->buscando2' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Anos_Sexos($bus, $bus2, $bus3)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Anos_Sexos_Transcriptor($bus, $bus2, $bus3)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Anos_Sexos2($bus, $bus2, $bus3, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Companias_Anos_Sexos2_Transcriptor($bus, $bus2, $bus3, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando2==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando2==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando2==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando2==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando3' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND companias.nom_com='$this->buscando' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando3' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Jerarquias_Sexos($bus, $bus2, $bus3, $bus4)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->buscando4=$bus4;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.nom_jer='$this->buscando3' AND sexos.nom_sex='$this->buscando4' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.nom_jer='$this->buscando3' AND sexos.nom_sex='$this->buscando4' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Jerarquias_Sexos_Transcriptor($bus, $bus2, $bus3, $bus4)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->buscando4=$bus4;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.nom_jer='$this->buscando3' AND sexos.nom_sex='$this->buscando4' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Jerarquias_Sexos2($bus, $bus2, $bus3, $bus4, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->buscando4=$bus4;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.nom_jer='$this->buscando3' AND sexos.nom_sex='$this->buscando4' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.nom_jer='$this->buscando3' AND sexos.nom_sex='$this->buscando4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Jerarquias_Sexos2_Transcriptor($bus, $bus2, $bus3, $bus4, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->buscando4=$bus4;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.nom_jer='$this->buscando3' AND sexos.nom_sex='$this->buscando4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Anos_Sexos($bus, $bus2, $bus3, $bus4)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->buscando4=$bus4;
         if($this->buscando3==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando3==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando3==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando3==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando4' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando4' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando4' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando4' ORDER BY jerarquias.id_jer ASC";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Anos_Sexos_Transcriptor($bus, $bus2, $bus3, $bus4)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->buscando4=$bus4;
         if($this->buscando3==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando3==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando3==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando3==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando4' ORDER BY jerarquias.id_jer ASC";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando4' ORDER BY jerarquias.id_jer ASC";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Anos_Sexos2($bus, $bus2, $bus3, $bus4, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->buscando4=$bus4;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando3==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando3==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando3==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando3==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando4' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='3' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando4' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Anos_Sexos2_Transcriptor($bus, $bus2, $bus3, $bus4, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->buscando2=$bus2;
         $this->buscando3=$bus3;
         $this->buscando4=$bus4;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->buscando3==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->buscando3==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->buscando3==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->buscando3==3)
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia5' AND sexos.nom_sex='$this->buscando4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_com, personas.id_jer, personas.id_sex, personas.ced_per, personas.mat_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, companias.id_com, companias.nom_com, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, companias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia1' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia2' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia3' AND sexos.nom_sex='$this->buscando4' OR personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_com=companias.id_com AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='4' AND academias.nom_aca='$this->buscando' AND companias.nom_com='$this->buscando2' AND jerarquias.id_jer='$this->jerarquia4' AND sexos.nom_sex='$this->buscando4' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_personas_Rol_Asistente_Buscador($bus)
      {
         $this->buscando=$bus;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_jer, personas.id_sex, personas.ced_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='2' AND academias.nom_aca='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='2' AND jerarquias.nom_jer='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='2' AND sexos.nom_sex='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='2' AND personas.ced_per='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='2' AND personas.ape_per like '%$this->buscando%' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='2' AND personas.nom_per like '%$this->buscando%' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Asistente_Buscador2($bus, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_jer, personas.id_sex, personas.ced_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='2' AND academias.nom_aca='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='2' AND jerarquias.nom_jer='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='2' AND sexos.nom_sex='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='2' AND personas.ced_per='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='2' AND personas.ape_per like '%$this->buscando%' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='2' AND personas.nom_per like '%$this->buscando%' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_personas_Rol_Administrador_Buscador($bus)
      {
         $this->buscando=$bus;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_jer, personas.id_sex, personas.ced_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='1' AND academias.nom_aca='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='1' AND jerarquias.nom_jer='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='1' AND sexos.nom_sex='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='1' AND personas.ced_per='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='1' AND personas.ape_per like '%$this->buscando%' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='1' AND personas.nom_per like '%$this->buscando%' ORDER BY jerarquias.id_jer ASC";
      }

      public function Consulta_personas_Rol_Administrador_Buscador2($bus, $tam, $ini)
      {
         $this->buscando=$bus;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT personas.id_rol, personas.id_aca, personas.id_jer, personas.id_sex, personas.ced_per, personas.ape_per, personas.nom_per, roles.id_rol, roles.nom_rol, academias.id_aca, academias.nom_aca, jerarquias.id_jer, jerarquias.nom_jer, sexos.id_sex, sexos.nom_sex, accesos.id_acc, accesos.id_est, accesos.id_per, accesos.usu_acc, estatus.id_est, estatus.nom_est FROM personas, roles, academias, sexos, jerarquias, accesos, estatus WHERE personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='1' AND academias.nom_aca='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='1' AND jerarquias.nom_jer='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='1' AND sexos.nom_sex='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='1' AND personas.ced_per='$this->buscando' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='1' AND personas.ape_per like '%$this->buscando%' or personas.id_rol=roles.id_rol AND personas.id_aca=academias.id_aca AND personas.id_jer=jerarquias.id_jer AND personas.id_sex=sexos.id_sex AND accesos.id_per=personas.id_per AND accesos.id_est=estatus.id_est AND personas.id_rol='1' AND personas.nom_per like '%$this->buscando%' ORDER BY jerarquias.id_jer ASC LIMIT $this->tamano OFFSET $this->inicio";
      }
   }

   class Consulta_roles extends Consultas
   {
      protected $rol;

      public function Consulta_Nombre_rol($rol)
      {
         $this->rol=$rol;
         $this->sql="SELECT * FROM roles WHERE id_rol='$this->rol'";
      }
   }

   class Consulta_estatus extends Consultas
   {
      protected $estatus;

      public function Consulta_Nombre_estatus($est)
      {
         $this->estatus=$est;
         $this->sql="SELECT * FROM estatus WHERE id_est='$this->estatus'";
      }
   }

   class Consulta_academias extends Consultas
   {
      protected $academia;

      public function Consulta_Nombre_Academia($aca)
      {
         $this->academia=$aca;
         $this->sql="SELECT * FROM academias WHERE id_aca='$this->academia'";
      }

      public function Consulta_Academia_Especifica($aca)
      {
         $this->academia=$aca;
         $this->sql="SELECT * FROM academias WHERE nom_aca='$this->academia'";
      }
   }

   class Consulta_jerarquias extends Consultas
   {
      protected $jerarquia;

      public function Consulta_Nombre_Jerarquia($jer)
      {
         $this->jerarquia=$jer;
         $this->sql="SELECT * FROM jerarquias WHERE id_jer='$this->jerarquia'";
      }

      public function Consulta_Jerarquia_Especifica($jer)
      {
         $this->jerarquia=$jer;
         $this->sql="SELECT * FROM jerarquias WHERE nom_jer='$this->jerarquia'";
      }
   }

   class Consulta_sexos extends Consultas
   {
      protected $sexo;

      public function Consulta_Nombre_Sexo($sex)
      {
         $this->sexo=$sex;
         $this->sql="SELECT * FROM sexos WHERE id_sex='$this->sexo'";
      }
   }

   class Consulta_companias extends Consultas
   {
      protected $compania;

      public function Consulta_Nombre_Compania($com)
      {
         $this->compania=$com;
         $this->sql="SELECT * FROM companias WHERE id_com='$this->compania'";
      }

      public function Consulta_Compania_Especifica($com)
      {
         $this->compania=$com;
         $this->sql="SELECT * FROM companias WHERE nom_com='$this->compania'";
      }
   }

   class Consulta_Canchas extends Consultas
   {
      protected $cancha;

      public function Consulta_Nombre_Cancha($can)
      {
         $this->cancha=$can;
         $this->sql="SELECT * FROM canchas WHERE id_can='$this->cancha'";
      }

      public function Consulta_Cancha_Especifica($can)
      {
         $this->cancha=$can;
         $this->sql="SELECT * FROM canchas WHERE nom_can='$this->cancha'";
      }
   }

   class Consulta_Evaluaciones extends Consultas
   {
      protected $persona;
      protected $cancha;
      protected $cedula;
      protected $academia;
      protected $sexo;
      protected $compania;
      protected $ano;
      protected $buscando;

      public function Consulta_Promedio($per)
      {
        $this->persona=$per;
        $this->sql="SELECT * FROM posicion WHERE id_per='$this->persona'";
      }

      public function Consulta_Evaluacion_Cancha($per, $can)
      {
        $this->persona=$per;
        $this->cancha=$can;
        $this->sql="SELECT * FROM evaluaciones WHERE id_can='$this->cancha' and id_per='$this->persona'";
      }

      public function Consulta_Evaluacion_General_Cedula($ced, $can)
      {
        $this->cedula=$ced;
        $this->cancha=$can;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, canchas As ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex and ca.id_can=e.id_can and p.ced_per='$this->cedula' AND e.id_can='$this->cancha'";
      }

      public function Consulta_Evaluacion_General($ncan)
      {
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.id_per, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_General2($ncan, $tam, $ini)
      {
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_General_Buscador($ncan, $bus)
      {
        $this->numero_canchas=$ncan;
        $this->buscando=$bus;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.id_per, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.ced_per='$this->buscando' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.mat_per='$this->buscando'  GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_General_Buscador2($ncan, $bus, $tam, $ini)
      {
        $this->numero_canchas=$ncan;
        $this->buscando=$bus;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.ced_per='$this->buscando' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.mat_per='$this->buscando' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia($aca, $ncan)
      {
        $this->academia=$aca;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia2($aca, $ncan, $tam, $ini)
      {
        $this->academia=$aca;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha($can, $ncan)
      {
        $this->cancha=$can;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Cancha2($can, $ncan, $tam, $ini)
      {
        $this->cancha=$can;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Sexo($sex, $ncan)
      {
        $this->sexo=$sex;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Sexo2($sex, $ncan, $tam, $ini)
      {
        $this->sexo=$sex;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Compania($com, $ncan)
      {
        $this->compania=$com;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Compania2($com, $ncan, $tam, $ini)
      {
        $this->compania=$com;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Jerarquia($jer, $ncan)
      {
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Jerarquia2($jer, $ncan, $tam, $ini)
      {
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Ano($ano, $ncan)
      {
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

      public function Consulta_Evaluacion_por_Ano2($ano, $ncan, $tam, $ini)
      {
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Cancha($aca, $can, $ncan)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha2($aca, $can, $ncan, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo($aca, $sex, $ncan)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo2($aca, $sex, $ncan, $tam, $ini)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Compania($aca, $com, $ncan)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia_Compania2($aca, $com, $ncan, $tam, $ini)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Jerarquia($aca, $jer, $ncan)
      {
        $this->academia=$aca;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia_Jerarquia2($aca, $jer, $ncan, $tam, $ini)
      {
        $this->academia=$aca;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Ano($aca, $ano, $ncan)
      {
         $this->academia=$aca;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Ano2($aca, $ano, $ncan, $tam, $ini)
      {
        $this->academia=$aca;
        $this->ano=$ano;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo($can, $sex, $ncan)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo2($can, $sex, $ncan, $tam, $ini)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha_Compania($can, $com, $ncan)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Cancha_Compania2($can, $com, $ncan, $tam, $ini)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha_Jerarquia($can, $jer, $ncan)
      {
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Cancha_Jerarquia2($can, $jer, $ncan, $tam, $ini)
      {
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha_Ano($can, $ano, $ncan)
      {
         $this->cancha=$can;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

      public function Consulta_Evaluacion_por_Cancha_Ano2($can, $ano, $ncan, $tam, $ini)
      {
         $this->cancha=$can;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_por_Sexo_Compania($sex, $com, $ncan)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Sexo_Compania2($sex, $com, $ncan, $tam, $ini)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Sexo_Jerarquia($sex, $jer, $ncan)
      {
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Sexo_Jerarquia2($sex, $jer, $ncan, $tam, $ini)
      {
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Sexo_Ano($sex, $ano, $ncan)
      {
         $this->sexo=$sex;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
             $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

      public function Consulta_Evaluacion_por_Sexo_Ano2($sex, $ano, $ncan, $tam, $ini)
      {
         $this->sexo=$sex;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
             $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_por_Compania_Jerarquia($com, $jer, $ncan)
      {
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Compania_Jerarquia2($com, $jer, $ncan, $tam, $ini)
      {
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Compania_Ano($com, $ano, $ncan)
      {
         $this->compania=$com;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

      public function Consulta_Evaluacion_por_Compania_Ano2($com, $ano, $ncan, $tam, $ini)
      {
         $this->compania=$com;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo($aca, $can, $sex, $ncan)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_sex='$this->sexo' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo2($aca, $can, $sex, $ncan, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_sex='$this->sexo' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Compania($aca, $can, $com, $ncan)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->compania=$com;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Compania2($aca, $can, $com, $ncan, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->compania=$com;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Jerarquia($aca, $can, $jer, $ncan)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Jerarquia2($aca, $can, $jer, $ncan, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Ano($aca, $can, $ano, $ncan)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Ano2($aca, $can, $ano, $ncan, $tam, $ini)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and e.id_can='$this->cancha' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Compania($aca, $sex, $com, $ncan)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Compania2($aca, $sex, $com, $ncan, $tam, $ini)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Jerarquia($aca, $sex, $jer, $ncan)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Jerarquia2($aca, $sex, $jer, $ncan, $tam, $ini)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Ano($aca, $sex, $ano, $ncan)
      {
         $this->academia=$aca;
         $this->sexo=$sex;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Ano2($aca, $sex, $ano, $ncan, $tam, $ini)
      {
         $this->academia=$aca;
         $this->sexo=$sex;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Compania_Jerarquia($aca, $com, $jer, $ncan)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia_Compania_Jerarquia2($aca, $com, $jer, $ncan, $tam, $ini)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Compania_Ano($aca, $com, $ano, $ncan)
      {
         $this->academia=$aca;
         $this->compania=$com;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Compania_Ano2($aca, $com, $ano, $ncan, $tam, $ini)
      {
         $this->academia=$aca;
         $this->compania=$com;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_Compania($can, $sex, $com, $ncan)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_Compania2($can, $sex, $com, $ncan, $tam, $ini)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_Jerarquia($can, $sex, $jer, $ncan)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_Jerarquia2($can, $sex, $jer, $ncan, $tam, $ini)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_Ano($can, $sex, $ano, $ncan)
      {
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_Ano2($can, $sex, $ano, $ncan, $tam, $ini)
      {
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_por_Cancha_Compania_Jerarquia($can, $com, $jer, $ncan)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Cancha_Compania_Jerarquia2($can, $com, $jer, $ncan, $tam, $ini)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha_Compania_Ano($can, $com, $jer, $ncan)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

      public function Consulta_Evaluacion_por_Cancha_Compania_Ano2($can, $com, $jer, $ncan, $tam, $ini)
      {
         $this->cancha=$can;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_por_Sexo_Compania_Jerarquia($sex, $com, $jer, $ncan)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Sexo_Compania_Jerarquia2($sex, $com, $jer, $ncan, $tam, $ini)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Sexo_Compania_Ano($sex, $com, $ano, $ncan)
      {
         $this->sexo=$sex;
         $this->compania=$com;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

      public function Consulta_Evaluacion_por_Sexo_Compania_Ano2($sex, $com, $ano, $ncan, $tam, $ini)
      {
         $this->sexo=$sex;
         $this->compania=$com;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Compania($aca, $can, $sex, $com, $ncan)
      {
      	$this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->numero_canchas=$ncan;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Compania2($aca, $can, $sex, $com, $ncan, $tam, $ini)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_com='$this->compania' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Jerarquia($aca, $can, $sex, $jer, $ncan)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->jerarquia=$jer;
         $this->numero_canchas=$ncan;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Jerarquia2($aca, $can, $sex, $jer, $ncan, $tam, $ini)
      {
         $this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->numero_canchas=$ncan;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Ano($aca, $can, $sex, $ano, $ncan)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Ano2($aca, $can, $sex, $ano, $ncan, $tam, $ini)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Compania_Jerarquia($aca, $sex, $com, $jer, $ncan)
      {
         $this->academia=$aca;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->numero_canchas=$ncan;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Compania_Jerarquia2($aca, $sex, $com, $jer, $ncan, $tam, $ini)
      {
         $this->academia=$aca;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Compania_Ano($aca, $sex, $com, $ano, $ncan)
      {
         $this->academia=$aca;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Compania_Ano2($aca, $sex, $com, $ano, $ncan, $tam, $ini)
      {
         $this->academia=$aca;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_Compania_Jerarquia($can, $sex, $com, $jer, $ncan)
      {
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->numero_canchas=$ncan;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_Compania_Jerarquia2($can, $sex, $com, $jer, $ncan, $tam, $ini)
      {
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_Compania_Ano($can, $sex, $com, $ano, $ncan)
      {
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

       public function Consulta_Evaluacion_por_Cancha_Sexo_Compania_Ano2($can, $sex, $com, $ano, $ncan, $tam, $ini)
      {
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Compania_Jerarquia($aca, $can, $com, $jer, $ncan)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->numero_canchas=$ncan;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Compania_Jerarquia2($aca, $can, $com, $jer, $ncan, $tam, $ini)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Compania_Ano($aca, $can, $com, $ano, $ncan)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->compania=$com;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Compania_Ano2($aca, $can, $com, $ano, $ncan, $tam, $ini)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->compania=$com;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' and p.id_com='$this->compania' and p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Compania_Jerarquia($aca, $can, $sex, $com, $jer, $ncan)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->numero_canchas=$ncan;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Compania_Jerarquia2($aca, $can, $sex, $com, $jer, $ncan, $tam, $ini)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Compania_Ano($aca, $can, $sex, $com, $ano, $ncan)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC";
         }
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Compania_Ano2($aca, $can, $sex, $com, $ano, $ncan, $tam, $ini)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->ano=$ano;
         $this->numero_canchas=$ncan;
         $this->tamano=$tam;
         $this->inicio=$ini;
         if($this->ano==1)
         {
            $this->jerarquia1=23;
            $this->jerarquia2=24;
         }
         elseif($this->ano==2)
         {
            $this->jerarquia1=25;
            $this->jerarquia2=26;
         }
         elseif($this->ano==3)
         {
            $this->jerarquia1=27;
            $this->jerarquia2=28;
            $this->jerarquia3=29;
            $this->jerarquia4=30;
            $this->jerarquia5=31;
         }
         else
         {
            $this->jerarquia1=32;
            $this->jerarquia2=33;
            $this->jerarquia3=34;
            $this->jerarquia4=35;
         }
         if($this->ano==3)
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia4' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia5' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
         else
         {
            $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, sum(e.not_eva)/$this->numero_canchas AS t_nota FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia1' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia2' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia3' OR p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia4' GROUP BY p.ced_per ORDER BY t_nota DESC LIMIT $this->tamano OFFSET $this->inicio";
         }
      }

      public function Consulta_Evaluacion_General_0()
      {
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND e.not_eva='0' AND ca.id_est='1' AND c.id_est='1'";
      }

      public function Consulta_Evaluacion_General_0_2($tam, $ini)
      {
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND e.not_eva='0' AND ca.id_est='1' AND c.id_est='1' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_0($aca)
      {
        $this->academia=$aca;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia'";
      }

      public function Consulta_Evaluacion_por_Academia_0_2($aca, $tam, $ini)
      {
        $this->academia=$aca;
		$this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha_0($can)
      {
        $this->cancha=$can;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_est='1' AND c.id_est='1' AND e.id_can='$this->cancha'";
      }

      public function Consulta_Evaluacion_por_Cancha_0_2($can, $tam, $ini)
      {
        $this->cancha;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_est='1' AND c.id_est='1' AND e.id_can='$this->cancha' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Sexo_0($sex)
      {
        $this->sexo=$sex;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_est='1' AND c.id_est='1' AND p.id_sex='$this->sexo'";
      }

      public function Consulta_Evaluacion_por_Sexo_0_2($sex, $tam, $ini)
      {
        $this->sexo=$sex;
		$this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_est='1' AND c.id_est='1' AND p.id_sex='$this->sexo' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Compania_0($com)
      {
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_est='1' AND c.id_est='1' AND p.id_com='$this->compania'";
      }

      public function Consulta_Evaluacion_por_Compania_0_2($com, $tam, $ini)
      {
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_est='1' AND c.id_est='1' AND p.id_com='$this->compania' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Jerarquia_0($jer)
      {
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_est='1' AND c.id_est='1' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Jerarquia_0_2($jer, $tam, $ini)
      {
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_est='1' AND c.id_est='1' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_0($aca, $can)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha'";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_0_2($aca, $can, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_0($aca, $sex)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo'";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_0_2($aca, $sex, $tam, $ini)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Compania_0($aca, $com)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_com='$this->compania'";
      }

      public function Consulta_Evaluacion_por_Academia_Compania_0_2($aca, $com, $tam, $ini)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_com='$this->compania' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Jerarquia_0($aca, $jer)
      {
        $this->academia=$aca;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Academia_Jerarquia_0_2($aca, $jer, $tam, $ini)
      {
        $this->academia=$aca;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_0($can, $sex)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo'";
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_0_2($can, $sex, $tam, $ini)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha_Compania_0($can, $com)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_com='$this->compania'";
      }

      public function Consulta_Evaluacion_por_Cancha_Compania_0_2($can, $com, $tam, $ini)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_com='$this->compania' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha_Jerarquia_0($can, $jer)
      {
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Cancha_Jerarquia_0_2($can, $jer, $tam, $ini)
      {
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Sexo_Compania_0($sex, $com)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania'";
      }

      public function Consulta_Evaluacion_por_Sexo_Compania_0_2($sex, $com, $tam, $ini)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Sexo_Jerarquia_0($sex, $jer)
      {
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Sexo_Jerarquia_0_2($sex, $jer, $tam, $ini)
      {
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Compania_Jerarquia_0($com, $jer)
      {
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Compania_Jerarquia_0_2($com, $jer, $tam, $ini)
      {
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_0($aca, $can, $sex)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo'";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_0_2($aca, $can, $sex, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Compania_0($aca, $can, $com)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_com='$this->compania'";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Compania_0_2($aca, $can, $com, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_com='$this->compania' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Jerarquia_0($aca, $can, $jer)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Jerarquia_0_2($aca, $can, $jer, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Compania_0($aca, $sex, $com)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania'";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Compania_0_2($aca, $sex, $com, $tam, $ini)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Jerarquia_0($aca, $sex, $jer)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Jerarquia_0_2($aca, $sex, $jer, $tam, $ini)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Compania_Jerarquia_0($aca, $com, $jer)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Academia_Compania_Jerarquia_0_2($aca, $com, $jer, $tam, $ini)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_Compania_0($can, $sex, $com)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania'";
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_Compania_0_2($can, $sex, $com, $tam, $ini)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_Jerarquia_0($can, $sex, $jer)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per and ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_Jerarquia_0_2($can, $sex, $jer, $tam, $ini)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha_Compania_Jerarquia_0($can, $com, $jer)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Cancha_Compania_Jerarquia_0_2($can, $com, $jer, $tam, $ini)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Sexo_Compania_Jerarquia_0($sex, $com, $jer)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Sexo_Compania_Jerarquia_0_2($sex, $com, $jer, $tam, $ini)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Compania_0($aca, $can, $sex, $com)
      {
      	$this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania'";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Compania_0_2($aca, $can, $sex, $com, $tam, $ini)
      {
      	$this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Jerarquia_0($aca, $can, $sex, $jer)
      {
         $this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Jerarquia_0_2($aca, $can, $sex, $jer, $tam, $ini)
      {
         $this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Compania_Jerarquia_0($aca, $sex, $com, $jer)
      {
         $this->academia=$aca;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Academia_Sexo_Compania_Jerarquia_0_2($aca, $sex, $com, $jer, $tam, $ini)
      {
         $this->academia=$aca;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

       public function Consulta_Evaluacion_por_Academia_Cancha_Compania_Jerarquia_0($aca, $can, $com, $jer)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Compania_Jerarquia_0_2($aca, $can, $com, $jer, $tam, $ini)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_Compania_Jerarquia_0($can, $sex, $com, $jer)
      {
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Cancha_Sexo_Compania_Jerarquia_0_2($can, $sex, $com, $jer, $tam, $ini)
      {
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Compania_Jerarquia_0($aca, $can, $sex, $com, $jer)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia'";
      }

      public function Consulta_Evaluacion_por_Academia_Cancha_Sexo_Compania_Jerarquia_0_2($aca, $can, $sex, $com, $jer, $tam, $ini)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND e.not_eva='0' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_com=p.id_com AND c.id_est='1' AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_General_Por_Canchas()
      {
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_General_Por_Canchas_2($tam, $ini)
      {
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_can=e.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias($aca)
      {
        $this->academia=$aca;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_2($aca, $tam, $ini)
      {
        $this->academia=$aca;
      $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas($can)
      {
        $this->cancha=$can;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_2($can, $tam, $ini)
      {
        $this->cancha=$can;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos($sex)
      {
        $this->sexo=$sex;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_sex='$this->sexo' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_2($sex, $tam, $ini)
      {
        $this->sexo=$sex;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_sex='$this->sexo' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Companias($com)
      {
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_com='$this->compania' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Companias_2($com, $tam, $ini)
      {
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_com='$this->compania' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Jerarquias($jer)
      {
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Jerarquias_2($jer, $tam, $ini)
      {
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas($aca, $can)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_2($aca, $can, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos($aca, $sex)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_2($aca, $sex, $tam, $ini)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Companias($aca, $com)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND p.id_com='$this->compania' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Companias_2($aca, $com, $tam, $ini)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND p.id_com='$this->compania' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Jerarquias($aca, $jer)
      {
        $this->academia=$aca;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Jerarquias_2($aca, $jer, $tam, $ini)
      {
        $this->academia=$aca;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos($can, $sex)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_2($can, $sex, $tam, $ini)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Companias($can, $com)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' and p.id_com='$this->compania' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Companias_2($can, $com, $tam, $ini)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' and p.id_com='$this->compania' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Jerarquias($can, $jer)
      {
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Jerarquias_2($can, $jer, $tam, $ini)
      {
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Companias($sex, $com)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Companias_2($sex, $com, $tam, $ini)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Jerarquias($sex, $jer)
      {
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Jerarquias_2($sex, $jer, $tam, $ini)
      {
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Companias_Jerarquias($com, $jer)
      {
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Companias_Jerarquias_2($com, $jer, $tam, $ini)
      {
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos($aca, $can, $sex)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_2($aca, $can, $sex, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Compania($aca, $can, $com)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_com='$this->compania' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Compania_2($aca, $can, $com, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_com='$this->compania' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Jerarquias($aca, $can, $jer)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Jerarquias_2($aca, $can, $jer, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Companias($aca, $sex, $com)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Companias_2($aca, $sex, $com, $tam, $ini)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Jerarquias($aca, $sex, $jer)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Jerarquias_2($aca, $sex, $jer, $tam, $ini)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Companias_Jerarquias($aca, $com, $jer)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Companias_Jerarquias_2($aca, $com, $jer, $tam, $ini)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Companias($can, $sex, $com)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_com='$this->compania' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Companias_2($can, $sex, $com, $tam, $ini)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_com='$this->compania' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Jerarquias($can, $sex, $jer)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Jerarquias_2($can, $sex, $jer, $tam, $ini)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Companias_Jerarquias($can, $com, $jer)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Companias_Jerarquias_2($can, $com, $jer, $tam, $ini)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Companias_Jerarquias($sex, $com, $jer)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Companias_Jerarquias_2($sex, $com, $jer, $tam, $ini)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Companias($aca, $can, $sex, $com)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Companias_2($aca, $can, $sex, $com, $tam, $ini)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Jerarquias($aca, $can, $sex, $jer)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->jerarquia=$jer;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Jerarquias_2($aca, $can, $sex, $jer, $tam, $ini)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->jerarquia=$jer;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Companias_Jerarquias($aca, $sex, $com, $jer)
      {
         $this->academia=$aca;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Companias_Jerarquias_2($aca, $sex, $com, $jer, $tam, $ini)
      {
         $this->academia=$aca;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Companias_Jerarquias($aca, $can, $com, $jer)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Companias_Jerarquias_2($aca, $can, $com, $jer, $tam, $ini)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Companias_Jerarquias($can, $sex, $com, $jer)
      {
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Companias_Jerarquias_2($can, $sex, $com, $jer, $tam, $ini)
      {
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Companias_Jerarquias($aca, $can, $sex, $com, $jer)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Companias_Jerarquias_2($aca, $can, $sex, $com, $jer, $tam, $ini)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.nom_can, e.not_eva, po.pro_pos FROM personas AS p, evaluaciones AS e, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca, posicion AS po WHERE p.id_per=e.id_per AND j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND e.id_can=ca.id_can AND ca.id_est='1' AND c.id_est='1' AND po.id_per=p.id_per AND p.id_aca='$this->academia' AND e.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY po.pro_pos DESC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Lista_Por_Canchas_Sin_Notas()
      {
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Lista_Por_Canchas_Sin_Notas_2($tam, $ini)
      {
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sin_Notas($aca)
      {
        $this->academia=$aca;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sin_Notas_2($aca, $tam, $ini)
      {
        $this->academia=$aca;
      $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sin_Notas($can)
      {
        $this->cancha=$can;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sin_Notas_2($can, $tam, $ini)
      {
        $this->cancha=$can;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Sin_Notas($sex)
      {
        $this->sexo=$sex;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_sex='$this->sexo' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Sin_Notas_2($sex, $tam, $ini)
      {
        $this->sexo=$sex;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_sex='$this->sexo' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Companias_Sin_Notas($com)
      {
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_com='$this->compania' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Companias_Sin_Notas_2($com, $tam, $ini)
      {
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_com='$this->compania' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Jerarquias_Sin_Notas($jer)
      {
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Jerarquias_Sin_Notas_2($jer, $tam, $ini)
      {
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sin_Notas($aca, $can)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sin_Notas_2($aca, $can, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Sin_Notas($aca, $sex)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Sin_Notas_2($aca, $sex, $tam, $ini)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Companias_Sin_Notas($aca, $com)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_com='$this->compania' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Companias_Sin_Notas_2($aca, $com, $tam, $ini)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_com='$this->compania' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Jerarquias_Sin_Notas($aca, $jer)
      {
        $this->academia=$aca;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Jerarquias_Sin_Notas_2($aca, $jer, $tam, $ini)
      {
        $this->academia=$aca;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Sin_Notas($can, $sex)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' AND p.id_sex='$this->sexo' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Sin_Notas_2($can, $sex, $tam, $ini)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' AND p.id_sex='$this->sexo' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Companias_Sin_Notas($can, $com)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' and p.id_com='$this->compania' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Companias_Sin_Notas_2($can, $com, $tam, $ini)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' and p.id_com='$this->compania' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Jerarquias_Sin_Notas($can, $jer)
      {
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Jerarquias_Sin_Notas_2($can, $jer, $tam, $ini)
      {
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Companias_Sin_Notas($sex, $com)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Companias_Sin_Notas_2($sex, $com, $tam, $ini)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Jerarquias_Sin_Notas($sex, $jer)
      {
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Jerarquias_Sin_Notas_2($sex, $jer, $tam, $ini)
      {
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Companias_Jerarquias_Sin_Notas($com, $jer)
      {
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Companias_Jerarquias_Sin_Notas_2($com, $jer, $tam, $ini)
      {
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Sin_Notas($aca, $can, $sex)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' AND p.id_sex='$this->sexo' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Sin_Notas_2($aca, $can, $sex, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' AND p.id_sex='$this->sexo' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Compania_Sin_Notas($aca, $can, $com)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' AND p.id_com='$this->compania' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Compania_Sin_Notas_2($aca, $can, $com, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' AND p.id_com='$this->compania' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Jerarquias_Sin_Notas($aca, $can, $jer)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Jerarquias_Sin_Notas_2($aca, $can, $jer, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Companias_Sin_Notas($aca, $sex, $com)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Companias_Sin_Notas_2($aca, $sex, $com, $tam, $ini)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Jerarquias_Sin_Notas($aca, $sex, $jer)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Jerarquias_Sin_Notas_2($aca, $sex, $jer, $tam, $ini)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Companias_Jerarquias_Sin_Notas($aca, $com, $jer)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Companias_Jerarquias_Sin_Notas_2($aca, $com, $jer, $tam, $ini)
      {
        $this->academia=$aca;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }
      //pausa
      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Companias_Sin_Notas($can, $sex, $com)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_com='$this->compania' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Companias_Sin_Notas_2($can, $sex, $com, $tam, $ini)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' and p.id_sex='$this->sexo' and p.id_com='$this->compania' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Jerarquias_Sin_Notas($can, $sex, $jer)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Jerarquias_Sin_Notas_2($can, $sex, $jer, $tam, $ini)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Companias_Jerarquias_Sin_Notas($can, $com, $jer)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Companias_Jerarquias_Sin_Notas_2($can, $com, $jer, $tam, $ini)
      {
        $this->cancha=$can;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Companias_Jerarquias_Sin_Notas($sex, $com, $jer)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Companias_Jerarquias_Sin_Notas_2($sex, $com, $jer, $tam, $ini)
      {
        $this->sexo=$sex;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Companias_Sin_Notas($aca, $can, $sex, $com)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Companias_Sin_Notas_2($aca, $can, $sex, $com, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Jerarquias_Sin_Notas($aca, $can, $sex, $jer)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Jerarquias_Sin_Notas_2($aca, $can, $sex, $jer, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Companias_Jerarquias_Sin_Notas($aca, $sex, $com, $jer)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Companias_Jerarquias_Sin_Notas_2($aca, $sex, $com, $jer, $tam, $ini)
      {
        $this->academia=$aca;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Companias_Jerarquias_Sin_Notas($aca, $can, $com, $jer)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Companias_Jerarquias_Sin_Notas_2($aca, $can, $com, $jer, $tam, $ini)
      {
        $this->academia=$aca;
        $this->cancha=$can;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Companias_Jerarquias_Sin_Notas($can, $sex, $com, $jer)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Companias_Jerarquias_Sin_Notas_2($can, $sex, $com, $jer, $tam, $ini)
      {
        $this->cancha=$can;
        $this->sexo=$sex;
        $this->compania=$com;
        $this->jerarquia=$jer;
        $this->tamano=$tam;
        $this->inicio=$ini;
        $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND ca.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Companias_Jerarquias_Sin_Notas($aca, $can, $sex, $com, $jer)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC";
      }

      public function Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Companias_Jerarquias_Sin_Notas_2($aca, $can, $sex, $com, $jer, $tam, $ini)
      {
         $this->academia=$aca;
         $this->cancha=$can;
         $this->sexo=$sex;
         $this->compania=$com;
         $this->jerarquia=$jer;
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT a.nom_aca, c.nom_com, j.nom_jer, s.nom_sex, p.ced_per, p.mat_per, p.nom_per, p.ape_per, ca.id_can, ca.nom_can FROM personas AS p, jerarquias AS j, academias AS a, companias AS c, sexos AS s, accesos AS ac, canchas AS ca WHERE j.id_jer=p.id_jer AND a.id_aca=p.id_aca AND c.id_com=p.id_com AND s.id_sex=p.id_sex AND ac.id_per=p.id_per AND ac.id_est='1' AND a.id_est='1' AND ca.id_est='1' AND c.id_est='1' AND p.id_aca='$this->academia' AND ca.id_can='$this->cancha' AND p.id_sex='$this->sexo' AND p.id_com='$this->compania' AND p.id_jer='$this->jerarquia' ORDER BY p.ced_per ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

   }

   class Consulta_auditorias extends Consultas
   {
      protected $persona;

      public function Consulta_Auditoria_Proceso($per)
      {
         $this->persona=$per;
         $this->sql="SELECT id_pro, id_per, id_aci, fec_pro, hor_pro FROM procesos WHERE id_per='$this->persona' ORDER BY id_pro DESC LIMIT 1";
      }

      public function Consulta_Auditoria_Entradas()
      {
         $this->sql="SELECT auditorias.id_pro, auditorias.id_mot, auditorias.lug_aud, procesos.id_pro, procesos.id_per, procesos.fec_pro, procesos.hor_pro, motivos.id_mot, motivos.nom_mot, personas.id_per, personas.nom_per, personas.ape_per, personas.ced_per, acciones.id_aci, acciones.nom_aci FROM auditorias, procesos, motivos, personas, acciones WHERE auditorias.id_pro=procesos.id_pro AND acciones.id_aci='1' AND motivos.id_mot=auditorias.id_mot AND personas.id_per=procesos.id_per AND acciones.id_aci=procesos.id_aci ORDER BY fec_pro ASC";
      }

      public function Consulta_Auditoria_Entradas2($tam, $ini)
      {
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT auditorias.id_pro, auditorias.id_mot, auditorias.lug_aud, procesos.id_pro, procesos.id_per, procesos.fec_pro, procesos.hor_pro, motivos.id_mot, motivos.nom_mot, personas.id_per, personas.nom_per, personas.ape_per, personas.ced_per, acciones.id_aci, acciones.nom_aci FROM auditorias, procesos, motivos, personas, acciones WHERE auditorias.id_pro=procesos.id_pro AND acciones.id_aci='1' AND motivos.id_mot=auditorias.id_mot AND personas.id_per=procesos.id_per AND acciones.id_aci=procesos.id_aci ORDER BY fec_pro ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Auditoria_Salidas()
      {
         $this->sql="SELECT auditorias.id_pro, auditorias.id_mot, auditorias.lug_aud, procesos.id_pro, procesos.id_per, procesos.fec_pro, procesos.hor_pro, motivos.id_mot, motivos.nom_mot, personas.id_per, personas.nom_per, personas.ape_per, personas.ced_per, acciones.id_aci, acciones.nom_aci FROM auditorias, procesos, motivos, personas, acciones WHERE auditorias.id_pro=procesos.id_pro AND acciones.id_aci='2' AND motivos.id_mot=auditorias.id_mot AND personas.id_per=procesos.id_per AND acciones.id_aci=procesos.id_aci ORDER BY fec_pro ASC";
      }

      public function Consulta_Auditoria_Salidas2($tam, $ini)
      {
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT auditorias.id_pro, auditorias.id_mot, auditorias.lug_aud, procesos.id_pro, procesos.id_per, procesos.fec_pro, procesos.hor_pro, motivos.id_mot, motivos.nom_mot, personas.id_per, personas.nom_per, personas.ape_per, personas.ced_per, acciones.id_aci, acciones.nom_aci FROM auditorias, procesos, motivos, personas, acciones WHERE auditorias.id_pro=procesos.id_pro AND acciones.id_aci='2' AND motivos.id_mot=auditorias.id_mot AND personas.id_per=procesos.id_per AND acciones.id_aci=procesos.id_aci ORDER BY fec_pro ASC LIMIT $this->tamano OFFSET $this->inicio";
      } 

      public function Consulta_Auditoria_Reportes()
      {
         $this->sql="SELECT auditorias.id_pro, auditorias.id_mot, auditorias.lug_aud, procesos.id_pro, procesos.id_per, procesos.fec_pro, procesos.hor_pro, motivos.id_mot, motivos.nom_mot, personas.id_per, personas.nom_per, personas.ape_per, personas.ced_per, acciones.id_aci, acciones.nom_aci FROM auditorias, procesos, motivos, personas, acciones WHERE auditorias.id_pro=procesos.id_pro AND acciones.id_aci='3' AND motivos.id_mot='5' AND motivos.id_mot=auditorias.id_mot AND personas.id_per=procesos.id_per AND acciones.id_aci=procesos.id_aci ORDER BY fec_pro ASC";
      }

      public function Consulta_Auditoria_Reportes2($tam, $ini)
      {
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT auditorias.id_pro, auditorias.id_mot, auditorias.lug_aud, procesos.id_pro, procesos.id_per, procesos.fec_pro, procesos.hor_pro, motivos.id_mot, motivos.nom_mot, personas.id_per, personas.nom_per, personas.ape_per, personas.ced_per, acciones.id_aci, acciones.nom_aci FROM auditorias, procesos, motivos, personas, acciones WHERE auditorias.id_pro=procesos.id_pro AND acciones.id_aci='3' AND motivos.id_mot='5' AND motivos.id_mot=auditorias.id_mot AND personas.id_per=procesos.id_per AND acciones.id_aci=procesos.id_aci ORDER BY fec_pro ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Auditoria_Registros()
      {
         $this->sql="SELECT A.id_pro, A.id_mot, A.lug_aud, P.id_pro, P.id_acc, P.id_per, P.fec_pro, P.hor_pro, M.id_mot, M.nom_mot, Pe.id_per, Pe.nom_per, Pe.ape_per, Pe.ced_per AS afectado, Ac.id_aci, Ac.nom_aci, Acc.id_acc, Acc.id_per, Acc.usu_acc, Per.id_per, Per.ced_per AS autor FROM auditorias A, procesos P, motivos M, personas Pe, acciones Ac, accesos Acc, personas Per WHERE A.id_pro=P.id_pro AND Ac.id_aci='3' AND M.id_mot='2' AND M.id_mot=A.id_mot AND Pe.id_per=P.id_per AND Ac.id_aci=P.id_aci AND Acc.id_acc=P.id_acc AND Acc.id_per=Per.id_per ORDER BY fec_pro ASC";
      }

      public function Consulta_Auditoria_Registros2($tam, $ini)
      {
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT A.id_pro, A.id_mot, A.lug_aud, P.id_pro, P.id_acc, P.id_per, P.fec_pro, P.hor_pro, M.id_mot, M.nom_mot, Pe.id_per, Pe.nom_per, Pe.ape_per, Pe.ced_per AS afectado, Ac.id_aci, Ac.nom_aci, Acc.id_acc, Acc.id_per, Acc.usu_acc, Per.id_per, Per.ced_per AS autor FROM auditorias A, procesos P, motivos M, personas Pe, acciones Ac, accesos Acc, personas Per WHERE A.id_pro=P.id_pro AND Ac.id_aci='3' AND M.id_mot='2' AND M.id_mot=A.id_mot AND Pe.id_per=P.id_per AND Ac.id_aci=P.id_aci AND Acc.id_acc=P.id_acc AND Acc.id_per=Per.id_per ORDER BY fec_pro ASC LIMIT $this->tamano OFFSET $this->inicio";
      }

      public function Consulta_Auditoria_Ediciones()
      {
         $this->sql="SELECT A.id_pro, A.id_mot, A.lug_aud, A.edi_aud, A.hab_aud, A.obs_aud, P.id_pro, P.id_acc, P.id_per, P.fec_pro, P.hor_pro, M.id_mot, M.nom_mot, Pe.id_per, Pe.nom_per, Pe.ape_per, Pe.ced_per AS afectado, Ac.id_aci, Ac.nom_aci, Acc.id_acc, Acc.id_per, Acc.usu_acc, Per.id_per, Per.ced_per AS autor FROM auditorias A, procesos P, motivos M, personas Pe, acciones Ac, accesos Acc, personas Per WHERE A.id_pro=P.id_pro AND Ac.id_aci='3' AND M.id_mot='3' AND M.id_mot=A.id_mot AND Pe.id_per=P.id_per AND Ac.id_aci=P.id_aci AND Acc.id_acc=P.id_acc AND Acc.id_per=Per.id_per ORDER BY fec_pro ASC";
      }

      public function Consulta_Auditoria_Ediciones2($tam, $ini)
      {
         $this->tamano=$tam;
         $this->inicio=$ini;
         $this->sql="SELECT A.id_pro, A.id_mot, A.lug_aud, A.edi_aud, A.hab_aud, A.obs_aud, P.id_pro, P.id_acc, P.id_per, P.fec_pro, P.hor_pro, M.id_mot, M.nom_mot, Pe.id_per, Pe.nom_per, Pe.ape_per, Pe.ced_per AS afectado, Ac.id_aci, Ac.nom_aci, Acc.id_acc, Acc.id_per, Acc.usu_acc, Per.id_per, Per.ced_per AS autor FROM auditorias A, procesos P, motivos M, personas Pe, acciones Ac, accesos Acc, personas Per WHERE A.id_pro=P.id_pro AND Ac.id_aci='3' AND M.id_mot='3' AND M.id_mot=A.id_mot AND Pe.id_per=P.id_per AND Ac.id_aci=P.id_aci AND Acc.id_acc=P.id_acc AND Acc.id_per=Per.id_per ORDER BY fec_pro ASC LIMIT $this->tamano OFFSET $this->inicio";
      }
   }
?>
