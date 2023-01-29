<?php

	require_once "conexion.php";

	class Procesos extends Conexion
	{
		protected $sql;
    protected $proceso;
    protected $resultado;
    protected $contador;
    protected $campos;
    protected $numero;
    protected $info;
    protected $nombre;
    protected $tipo;
    protected $fila;
    protected $rfila;

    public function __construct()
    {
      parent::__construct();
    }

    public function Proceso_General()
    {
      $this->proceso=$this->con->query($this->sql);
    }

    public function Guarda_Resultado()
    {
      $this->resultado=$this->proceso->fetch_all(MYSQLI_ASSOC);
    }

    public function Consulta_Paginador()
    {
      $this->contador=0;
      foreach ($this->resultado as $this->row)
      {
        $this->contador=$this->contador+1;
      }
    }

    public function Consulta_Campos()
    {
      $this->campos=$this->resultado->field_count;
    }

    public function Consulta_Nombre_Campo($num)
    {
      $this->numero=num;
      $this->info=$this->resultado->fetch_field_direct($this->numero);
      $this->nombre=$this->info->name;
    }

    public function Consulta_Tipo_Campo($num)
    {
      $this->numero=num;
      $this->info=$this->resultado->fetch_field_direct($this->numero);
      $this->tipo=$this->info->type;
    }

    public function Consulta_Fila($num)
    {
      $this->numero=num;
      $this->fila=$this->resultado->data_seek($this->numero);
      $this->rfila=$this->filafetch_row();
    }

    public function Devuelve_Resultado()
    {
      return $this->resultado;
    }

    public function Devuelve_Contador()
    {
      return $this->contador;
    }

    public function Devuelve_Campos()
    {
      return $this->campos;
    }

    public function Devuelve_Nombre()
    {
      return $this->nombre;
    }

    public function Devuelve_Tipo()
    {
      return $this->tipo;
    }

    public function Devuelve_Fila()
    {
      return $this->rfila;
    }
  }

  class BD extends Procesos
  {
    function Show_tables()
    {
      $this->sql="show tables";
    }

    function Show_Create_tables($tab)
    {
      $this->tabla=$tab;
      $this->sql="show create table npao.$this->tabla";
    }

    function Select($tab)
    {
      $this->tabla=$tab;
      $this->sql="select * from npao.$this->tabla";
    }
  }
   
  $texto.="create database if not exists npao;\n";
  $texto.="use npao;\n";

  $tablas= new BD();
  $tablas->Show_tables();
  $tablas->Proceso_General();
  $tablas->Guarda_resultado();
  $VerTablas=$tablas->Devuelve_Resultado();

  foreach ($VerTablas as $tabla)
  {
    $mitabla=$tabla[0];
    $tablas->Show_Create_tables($mitabla);
    $tablas->Proceso_General();
    $tablas->Guarda_resultado();
    $creates=$tablas->Devuelve_Resultado();
    foreach ($creates as $create)
    {
    	$texto.=$create[1].";\n";
    	$tablas->Select($mitabla);
    	$tablas->Proceso_General();
    	$tablas->Guarda_resultado();
    	$datos=$tablas->Devuelve_Resultado();
    	$tablas->Consulta_Paginador();
    	$regs=$tablas->Devuelve_Contador();
    	$tablas->Consulta_Campos();
    	$campos=$tablas->Devuelve_Campos();
    	for($i=0;$i<$regs;$i++)
      {
				$inserta="insert into $mitabla(";
    		for($j=0;$j<$campos;$j++)
        {
					$tablas->Consulta_Nombre_Campo($j);
          $nombre=$tablas->Devuelve_Nombre();
    			$inserta.="$nombre,";
    		}
    		$inserta=substr($inserta,0,strlen($inserta)-1).") values(";
    		for($j=0;$j<$campos;$j++)
				{
					$tablas->Consulta_Tipo_Campo($datos,$j);
    			$tipo=$tablas->Devuelve_Nombre();
    			$tablas->Consulta_Fila($i);
    			$fila=$tablas->Devuelve_Fila();
    			$valor=$fila[$j];
    			switch($tipo)
					{
            case "string":
            case "date":
            case "time":
            $valor="'$valor'";
            break;
					}
					$inserta.="$valor,";
				}
      }
      $inserta=substr($inserta,0,strlen($inserta)-1).");";
      $texto.=$inserta."\n";
    }
    $texto.="\n";
  }
  $archivo="SICI.sql";
  header("Content-disposition: attachment;filename=$archivo");
  header("Content-Type: text/plain");
  echo $texto;
/*

$con_base=mysql_connect("localhost","root","");
$base="npao";
$tablas=mysql_query("show tables from $base;",$con_base);
$texto.="create database if not exists $base;\n";
$texto.="use $base;\n";
while($tabla=mysql_fetch_array($tablas))
{
	$mitabla=$tabla[0];
	$creates=mysql_query("show create table $base.$mitabla;",$con_base);
	while($create=mysql_fetch_array($creates))
	{
		$texto.=$create[1].";\n";
		$datos=mysql_query("select * from $base.$mitabla;",$con_base);
		$campos=mysql_num_fields($datos);
		$regs=mysql_num_rows($datos);
		for($i=0;$i<$regs;$i++)
		{
			$inserta="insert into $mitabla(";
			for($j=0;$j<$campos;$j++)
			{
				$nombre=mysql_field_name($datos,$j);
				$inserta.="$nombre,";
			}
			$inserta=substr($inserta,0,strlen($inserta)-1).") values(";
			for($j=0;$j<$campos;$j++)
			{
				$tipo=mysql_field_type($datos,$j);
				$valor=mysql_result($datos,$i,$j);
				switch($tipo)
				{
					case "string":
					case "date":
					case "time":
					$valor="'$valor'";
					break;
				}
				$inserta.="$valor,";
			}
			$inserta=substr($inserta,0,strlen($inserta)-1).");";
			$texto.=$inserta."\n";
		}
	}
	$texto.="\n";
}
$archivo= "SICI.sql";
header("Content-disposition: attachment;filename=$archivo");
header("Content-Type: text/plain");
echo $texto;

*/
?>