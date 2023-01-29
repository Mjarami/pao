<?php
   error_reporting(0);
   include_once("../../clases/consultas.php");
   include_once("../../clases/javascript.php");
   $a=$_GET["auditar"];
   if($a==3)
   {
      $consurc=$_GET["consurc"];
      $academiac=$_GET["academiac"];
      $companiac=$_GET["companiac"];
      $jerarquiac=$_GET["jerarquiac"];
      $ano=$_GET["anoc"];
      $sexoc=$_GET["sexoc"];
      $estatusc=$_GET["estatusc"];
      $data=new Consulta_academias();
      $data->Consulta_Nombre_Academia($academiac);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $academia=$filadatabus[0]['nom_aca'];
      $data=new Consulta_companias();
      $data->Consulta_Nombre_Compania($companiac);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $compania=$filadatabus[0]['nom_com'];
      $data=new Consulta_jerarquias();
      $data->Consulta_Nombre_Jerarquia($jerarquiac);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $jerarquia=$filadatabus[0]['nom_jer'];
      $data=new Consulta_sexos();
      $data->Consulta_Nombre_Sexo($sexoc);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $sexo=$filadatabus[0]['nom_sex'];
      $data=new Consulta_estatus();
      $data->Consulta_Nombre_Estatus($estatusc);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $estatus=$filadatabus[0]['nom_est'];
      if($consurc==1)
      {
        $tituconsurc='Academia: '.$academia;
      }
      elseif($consurc==2)
      {
        $tituconsurc='Compa&ntilde;ia: '.$compania;
      }
      elseif($consurc==3)
      {
        $tituconsurc='Jerarqu&iacute;a: '.$jerarquia;
      }
      elseif($consurc==4)
      {
        $tituconsurc='A&ntilde;o: '.$ano;
      }
      elseif($consurc==5)
      {
        $tituconsurc='Sexo: '.$sexo;
      }
      elseif($consurc==6)
      {
        $tituconsurc='Estatus: '.$estatus;
      }
      elseif($consurc==7)
      {
        $tituconsurc='Academia: '.$academia.' y Compa&ntilde;ia: '.$compania;
      }
      elseif($consurc==8)
      {
        $tituconsurc='Academia: '.$academia.' y Jerarqu&iacute;a: '.$jerarquia;
      }
      elseif($consurc==9)
      {
        $tituconsurc='Academia: '.$academia.' y A&ntilde;o: '.$ano;
      }
      elseif($consurc==10)
      {
        $tituconsurc='Academia: '.$academia.' y Sexo: '.$sexo;
      }
      elseif($consurc==11)
      {
        $tituconsurc='Academia: '.$academia.' y Estatus: '.$estatus;
      }
      elseif($consurc==12)
      {
        $tituconsurc='Compa&ntilde;ia: '.$compania.' y Jerarqu&iacutea: '.$jerarquia;
      }
      elseif($consurc==13)
      {
        $tituconsurc='Compa&ntilde;ia: '.$compania.' y A&ntilde;o: '.$ano;
      }
      elseif($consurc==14)
      {
        $tituconsurc='Compa&ntilde;ia: '.$compania.' y Sexo: '.$sexo;
      }
      elseif($consurc==15)
      {
        $tituconsurc='Jerarqu&iacute;a: '.$jerarquia.' y Sexo: '.$sexo;
      }
      elseif($consurc==16)
      {
        $tituconsurc='A&ntilde;o: '.$ano.' y Sexo: '.$sexo;
      }
      elseif($consurc==17)
      {
        $tituconsurc='Academia: '.$academia.', Compa&ntilde;ia: '.$compania.' y Jerarqu&iacute;a: '.$jerarquia;
      }
      elseif($consurc==18)
      {
        $tituconsurc='Academia: '.$academia.', Compa&ntilde;ia: '.$compania.' y A&ntilde;o: '.$ano;
      }
      elseif($consurc==19)
      {
        $tituconsurc='Academia: '.$academia.', Compa&ntilde;ia: '.$compania.' y Sexo: '.$sexo;
      }
      elseif($consurc==20)
      {
        $tituconsurc='Academia: '.$academia.', Jerarqu&iacute;a: '.$jerarquia.' y Sexo: '.$sexo;
      }
      elseif($consurc==21)
      {
        $tituconsurc='Academia: '.$academia.', A&ntilde;o: '.$ano.' y Sexo: '.$sexo;
      }
      elseif($consurc==22)
      {
        $tituconsurc='Compa&ntilde;ia: '.$compania.', Jerarqu&iacute;a: '.$jerarquia.' y Sexo: '.$sexo;
      }
      elseif($consurc==23)
      {
        $tituconsurc='Compa&ntilde;ia: '.$compania.', A&ntilde;o: '.$ano.' y Sexo: '.$sexo;
      }
      elseif($consurc==24)
      {
        $tituconsurc='Academia: '.$academia.', Compa&ntilde;ia: '.$compania.', Jerarqu&iacute;a: '.$jerarquia.' y Sexo: '.$sexo;
      }
      elseif($consurc==25)
      {
        $tituconsurc='Academia: '.$academia.', Compa&ntilde;ia: '.$compania.', A&ntilde;o: '.$ano.' y Sexo: '.$sexo;
      }
      //establecemos el timezone para obtener la hora local
      date_default_timezone_set('America/Lima');
      //la fecha y hora de exportación sera parte del nombre del archivo Excel
      $fecha=date("d-m-Y H:i:s");
      //Inicio de exportación en Excel
      header('Content-type: application/vnd.ms-excel');
      header("Content-Disposition: attachment; filename=Lista_$fecha.xls"); //Indica el nombre del archivo resultante
      header("Pragma: no-cache");
      header("Expires: 0");
      ?>
      <div class="panel-heading">
        <h3 class="panel-title" align="center"><strong>Cadetes <?php echo $tituconsurc;?></strong></h3>
      </div>
      <table class="table table-bordered" align="center">
        <tr align='center'>
          <td>
            <strong>Rol</strong>
          </td>
          <td>
            <strong>C&eacute;dula</strong>
          </td>
          <td>
            <strong>Matr&iacute;cula</strong>
          </td>
          <td>
            <strong>Nombres</strong>
          </td>
          <td>
            <strong>Apellidos</strong>
          </td>
          <td>
            <strong>Jerarqu&iacute;a</strong>
          </td>
          <td>
            <strong>Academia</strong>
          </td>
          <td>
            <strong>Compa&ntilde;ia</strong>
          </td>
          <td>
            <strong>Sexo</strong>
          </td>
          <td>
            <strong>Estatus</strong>
          </td>  
        </tr>
         <?php
            if($_GET['buscando']!=null)
            {
               $buscando=$_GET['buscando'];
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador($buscando);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==1)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Academias($academia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==2)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Companias($compania);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==3)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Jerarquias($jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==4)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Anos($ano);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==5)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Sexos($sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==6)
            {
              $data= new Consulta_Personas();
              $data->Consulta_personas_Rol_Participante_Buscador_Estatus($estatus);
              $data->Consulta_General();
              $filadata=$data->Devuelve_Consulta();
              $data->Consulta_Paginador();
              $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==7)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias($academia, $compania);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==8)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Academias_Jerarquias($academia, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==9)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Academias_Anos($academia, $ano);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==10)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Academias_Sexos($academia, $sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==11)
            {
              $data= new Consulta_Personas();
              $data->Consulta_personas_Rol_Participante_Buscador_Academias_Estatus($academia, $estatus);
              $data->Consulta_General();
              $filadata=$data->Devuelve_Consulta();
              $data->Consulta_Paginador();
              $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==12)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Companias_Jerarquias($compania, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==13)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Companias_Anos($compania, $ano);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==14)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Companias_Sexos($compania, $sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==15)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Jerarquias_Sexos($jerarquia, $sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==16)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Anos_Sexos($ano, $sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==17)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Jerarquias($academia, $compania, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==18)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Anos($academia, $compania, $ano);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==19)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Sexos($academia, $compania, $sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==20)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Academias_Jerarquias_Sexos($academia, $jerarquia, $sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==21)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Academias_Anos_Sexos($academia, $ano, $sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==22)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Companias_Jerarquias_Sexos($compania, $jerarquia, $sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==23)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Companias_Anos_Sexos($compania, $ano, $sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==24)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Jerarquias_Sexos($academia, $compania, $jerarquia, $sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            elseif($consurc==25)
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante_Buscador_Academias_Companias_Anos_Sexos($academia, $compania, $ano, $sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else
            {
               $data= new Consulta_Personas();
               $data->Consulta_personas_Rol_Participante();
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            if($num_total_registros>=1)
            {
               foreach ($filadata as $row1)
               {
                  ?>
                  <tr align='center'>
                    <td><?php echo ucwords($row1['nom_rol']); ?></td>
                    <td><?php echo $row1['ced_per']; ?></td>
                    <td><?php echo $row1['mat_per']; ?></td>
                    <td><?php echo ucwords($row1['nom_per']); ?></td>
                    <td><?php echo ucwords($row1['ape_per']); ?></td>
                    <td><?php echo ucwords($row1['nom_jer']); ?></td>
                    <td><?php echo ucwords($row1['nom_aca']); ?></td>
                    <td><?php echo ucwords($row1['nom_com']); ?></td>
                    <td><?php echo ucwords($row1['nom_sex']); ?></td>
                    <td><?php echo ucwords($row1['nom_est']); ?></td>
                  </tr>
                  <?php
               }
               echo ("
                  </table>
                  <table align='center'>
                     <tr>
                        <td align='center'>

               ");
            }
            else
            {
               echo "<script language='javascript'>
                  alert ('No hay registros');
                  window.location='consultas.php?registro=$a';
               </script>";
            }
   }
   if($a==11)
   {
      $data=new Consulta_academias();
      $data->Consulta_Nombre_Academia($_GET['academias']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $busaca=$filadatabus[0]['nom_aca'];

      $data=new Consulta_Canchas();
      $data->Consulta_Nombre_Cancha($_GET['canchas']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $buscan=$filadatabus[0]['nom_can'];

      $data=new Consulta_sexos();
      $data->Consulta_Nombre_Sexo($_GET['sexos']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $bussex=$filadatabus[0]['nom_sex'];

      $data=new Consulta_companias();
      $data->Consulta_Nombre_Compania($_GET['companias']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $buscom=$filadatabus[0]['nom_com'];

      $data=new Consulta_jerarquias();
      $data->Consulta_Nombre_Jerarquia($_GET['jerarquias']);
      $data->Consulta_General();
      $filadatabus=$data->Devuelve_Consulta();
      $busjer=$filadatabus[0]['nom_jer'];

      $consur=$_GET["consur"];
      if($consur==0)
      {
          $titu="Por C&eacute;dula";
      }
      else if($consur==1)
      {
          $titu="Por Academia ".$busaca;
      }
      else if($consur==2)
      {
          $titu="Por Cancha ".$buscan;
      }
      else if($consur==3)
      {
          $titu="Por Sexo ".$bussex;
      }
      else if($consur==4)
      {
          $titu="Por Compa&ntilde;ia ".$buscom;
      }
      else if($consur==5)
      {
          $titu="Por Jerarqu&iacute;a ".$busjer;
      }
      else if($consur==6)
      {
          $titu="Por Academia ".$busaca." y Cancha ".$buscan;
      }
      else if($consur==7)
      {
          $titu="Por Academia ".$busaca." y Sexo ".$bussex;
      }
      else if($consur==8)
      {
          $titu="Por Academia ".$busaca." y Compa&ntilde;ia ".$buscom;
      }
      else if($consur==9)
      {
          $titu="Por Academia ".$busaca." y Jerarqu&iacute;a ".$busjer;
      }
      else if($consur==10)
      {
          $titu="Por Cancha ".$buscan." y Sexo ".$bussex;
      }
      else if($consur==11)
      {
          $titu="Por Cancha ".$buscan." y Compa&ntilde;ia ".$buscom;
      }
      else if($consur==12)
      {
          $titu="Por Cancha ".$buscan." y Jerarqu&iacute;a ".$busjer;
      }
      else if($consur==13)
      {
          $titu="Por Sexo ".$bussex." y Compa&ntilde;ia ".$buscom;
      }
      else if($consur==14)
      {
          $titu="Por Sexo ".$bussex." y Jerarqu&iacute;a ".$busjer;
      }
      else if($consur==15)
      {
          $titu="Por Compa&ntilde;ia ".$buscom." y Jerarqu&iacute;a ".$busjer;
      }
      else if($consur==16)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan." y Sexo ".$bussex;
      }
      else if($consur==17)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan." y Compa&ntilde;ia ".$buscom;
      }
      else if($consur==18)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan." y Jerarqu&iacute;a ".$busjer;
      }
      else if($consur==19)
      {
          $titu="Por Academia ".$busaca.", Sexo ".$bussex." y Compa&ntilde;ia ".$buscom;
      }
      else if($consur==20)
      {
          $titu="Por Academia ".$busaca.", Sexo ".$bussex." y Jerarqu&iacute;a ".$busjer;
      }
      else if($consur==21)
      {
          $titu="Por Academia ".$busaca.", Compa&ntilde;ia ".$buscom." y Jerarqu&iacute;a ".$busjer;
      }
      else if($consur==22)
      {
          $titu="Por Cancha ".$buscan.", Sexo ".$bussex." y Compa&ntilde;ia ".$buscom;
      }
      else if($consur==23)
      {
          $titu="Por Cancha ".$buscan.", Sexo ".$bussex." y Jerarqu&iacute;a ".$busjer;
      }
      else if($consur==24)
      {
          $titu="Por Cancha ".$buscan.", Compa&ntilde;ia ".$buscom." y Jerarqu&iacute;a ".$busjer;
      }
      else if($consur==25)
      {
          $titu="Por Sexo ".$bussex.", Compa&ntilde;ia ".$buscom." y Jerarqu&iacute;a ".$busjer;
      }
      else if($consur==26)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Sexo ".$bussex." y Compa&ntilde;ia ".$buscom;
      }
      else if($consur==27)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Sexo ".$bussex." y Jerarqu&iacute;a ".$busjer;
      }
      else if($consur==28)
      {
          $titu="Por Academia ".$busaca.", Sexo ".$bussex.", Compa&ntilde;ia ".$buscom." y Jerarqu&iacute;a ".$busjer;
      }
      else if($consur==29)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Compa&ntilde;ia ".$buscom." y Jerarqu&iacute;a ".$busjer;
      }
      else if($consur==30)
      {
          $titu="Por Cancha ".$buscan.", Sexo ".$bussex.", Compa&ntilde;ia ".$buscom." y Jerarqu&iacute;a ".$busjer;
      }
      else if($consur==31)
      {
          $titu="Por Academia ".$busaca.", Cancha ".$buscan.", Sexo ".$bussex.", Compa&ntilde;ia ".$buscom." y Jerarqu&iacute;a ".$busjer;
      }
      //establecemos el timezone para obtener la hora local
      date_default_timezone_set('America/Lima');
      //la fecha y hora de exportación sera parte del nombre del archivo Excel
      $fecha=date("d-m-Y H:i:s");
      //Inicio de exportación en Excel
      header('Content-type: application/vnd.ms-excel');
      header("Content-Disposition: attachment; filename=Lista_$fecha.xls"); //Indica el nombre del archivo resultante
      header("Pragma: no-cache");
      header("Expires: 0");
      ?>
      <table class="table table-bordered" align="center">
         <tr align='center'>
            <td colspan='9'>
               <strong><?php echo $titu; ?></strong>
            </td>
         </tr>   
         <tr align='center'>
            <td>
               <strong>Academia</strong>
            </td>
            <td>
               <strong>Compa&ntilde;ia</strong>
            </td>
            <td>
               <strong>Jerarqu&iacute;a</strong>
            </td>
            <td>
               <strong>Sexo</strong>
            </td>
            <td>
               <strong>C&eacute;dula</strong>
            </td>
            <td>
               <strong>Matr&iacute;cula</strong>
            </td>
            <td>
               <strong>Nombre</strong>
            </td>
            <td>
               <strong>ID Cancha</strong>
            </td>
            <td>
               <strong>Cancha</strong>
            </td>
            <td>
               <strong>Calificaci&oacute;n</strong>
            </td>
         </tr>
         <?php
            $academia=$_GET["academias"];
            $cancha=$_GET["canchas"];
            $sexo=$_GET["sexos"];
            $compania=$_GET["companias"];
            $jerarquia=$_GET["jerarquias"];

            if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sin_Notas($academia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sin_Notas($cancha);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Sin_Notas($sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Companias_Sin_Notas($compania);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Jerarquias_Sin_Notas($jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sin_Notas($academia, $cancha);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Sin_Notas($academia, $sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Companias_Sin_Notas($academia, $compania);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Jerarquias_Sin_Notas($academia, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Sin_Notas($cancha, $sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Companias_Sin_Notas($cancha, $compania);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Jerarquias_Sin_Notas($cancha, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Companias_Sin_Notas($sexo, $compania);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Jerarquias_Sin_Notas($sexo, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Companias_Jerarquias_Sin_Notas($compania, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]==null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Sin_Notas($academia, $cancha, $sexo);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Compania_Sin_Notas($academia, $cancha, $compania);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Jerarquias_Sin_Notas($academia, $cancha, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Companias_Sin_Notas($academia, $sexo, $compania);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Jerarquias_Sin_Notas($academia, $sexo, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Companias_Jerarquias_Sin_Notas($academia, $compania, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Companias_Sin_Notas($cancha, $sexo, $compania);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Jerarquias_Sin_Notas($cancha, $sexo, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Companias_Jerarquias_Sin_Notas($cancha, $compania, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]==null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Sexos_Companias_Jerarquias_Sin_Notas($sexo, $compania, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]==null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Companias_Sin_Notas($academia, $cancha, $sexo, $compania);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]==null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Jerarquias_Sin_Notas($academia, $cancha, $sexo, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]!=null and $_GET["canchas"]==null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Sexos_Companias_Jerarquias_Sin_Notas($academia, $sexo, $compania, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]==null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Companias_Jerarquias_Sin_Notas($academia, $cancha, $compania, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]==null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Canchas_Sexos_Companias_Jerarquias_Sin_Notas($cancha, $sexo, $compania, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else if($_GET["academias"]!=null and $_GET["canchas"]!=null and $_GET["sexos"]!=null and $_GET["companias"]!=null and $_GET["jerarquias"]!=null)
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Por_Canchas_Reporte_Academias_Canchas_Sexos_Companias_Jerarquias_Sin_Notas($academia, $cancha, $sexo, $compania, $jerarquia);
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            else
            {
               $data= new Consulta_Evaluaciones();
               $data->Consulta_Evaluacion_Lista_Por_Canchas_Sin_Notas();
               $data->Consulta_General();
               $filadata=$data->Devuelve_Consulta();
               $data->Consulta_Paginador();
               $num_total_registros = $data->Devuelve_Contador();
            }
            if($num_total_registros>=1)
            {
               foreach($filadata as $row1)
               {
                  ?>
                  <tr align='center'>
                     <td><?php echo ucwords($row1['nom_aca']); ?></td>
                     <td><?php echo ucwords($row1['nom_com']); ?></td>
                     <td><?php echo ucwords($row1['nom_jer']); ?></td>
                     <td><?php echo ucwords($row1['nom_sex']); ?></td>
                     <td><?php echo $row1['ced_per']; ?></td>
                     <td><?php echo $row1['mat_per']; ?></td>
                     <td><?php echo ucwords($row1['ape_per'])." ".ucwords($row1['nom_per']).""; ?></td>
                     <td><?php echo ucwords($row1['id_can']); ?></td>
                     <td><?php echo ucwords($row1['nom_can']); ?></td>
                     <td></td>
                  </tr>
                  <?php
               }
               echo ("
                  </table>
                  <table align='center'>
                     <tr>
                        <td align='center'>

               ");
            }
            else
            {
               echo "<script language='javascript'>
                  alert ('No hay registros');
                  window.location='consultas.php?registro=$a';
               </script>";
            }
   }
?>