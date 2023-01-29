<!-- Validaciones que se realizan en los formularios antes de ser enviados, para evitar datos nulos -->

<script type="text/javascript">

	function valida_envia_forcon()
	{
    	if (document.forcon.codigo.value.length==0)
    	{
       		alert("Debe escribir su c\xF3digo asignado")
       		document.forcon.codigo.focus()
       		return 0;
    	}
    	//el formulario se envia
    	alert("Muchas gracias por enviar el formulario");
    	document.forcon.submit();
	}

	function valida_envia_forauxiliar()
	{
    	if (document.forauxiliar.cedula.value.length==0)
    	{
       		alert("Debe escribir su cedula")
       		document.forauxiliar.cedula.focus()
       		return 0;
    	}
    	//el formulario se envia
    	alert("Muchas gracias por enviar el formulario");
    	document.forauxiliar.submit();
	}

	function valida_envia_forlog()
	{
    	if (document.forlog.usuario.value.length==0)
    	{
       		alert("Debe escribir su usuario")
       		document.forlog.usuario.focus()
       		return 0;
    	}
    	if (document.forlog.contrasena.value.length==0)
    	{
       		alert("Debe escribir su contrase\xF1a")
       		document.forlog.contrasena.focus()
       		return 0;
    	}
    	//el formulario se envia
    	document.forlog.submit();
	}

  function valida_envia_forreg_admin()
  {
      if (document.FormRegAdmin.Academia.value.length==0)
      {
          alert("Debe indicar su academia")
          document.FormRegAdmin.Academia.focus()
          return 0;
      }
      if (document.FormRegAdmin.Jerarquia.value.length==0)
      {
          alert("Debe indicar su jerarquia")
          document.FormRegAdmin.Jerarquia.focus()
          return 0;
      }
      if (document.FormRegAdmin.Sexo.value.length==0)
      {
          alert("Debe indicar su sexo")
          document.FormRegAdmin.Sexo.focus()
          return 0;
      }
      if (document.FormRegAdmin.Cedula.value.length==0)
      {
          alert("Debe escribir su cedula")
          document.FormRegAdmin.Cedula.focus()
          return 0;
      }
      if (document.FormRegAdmin.Apellido.value.length==0)
      {
          alert("Debe escribir sus apellidos")
          document.FormRegAdmin.Apellido.focus()
          return 0;
      }
      if (document.FormRegAdmin.Nombre.value.length==0)
      {
          alert("Debe escribir sus Nombres")
          document.FormRegAdmin.Nombre.focus()
          return 0;
      }
      if (document.FormRegAdmin.Usuario.value.length==0)
      {
          alert("Debe escribir su usuario")
          document.FormRegAdmin.Usuario.focus()
          return 0;
      }
      if (document.FormRegAdmin.Contrasena.value.length==0)
      {
          alert("Debe escribir su clave")
          document.FormRegAdmin.Contrasena.focus()
          return 0;
      }
      //el formulario se envia
      document.FormRegAdmin.submit();
  }

  function valida_envia_forreg_Mesa()
  {
      if (document.FormRegMez.Academia.value.length==0)
      {
          alert("Debe indicar su academia")
          document.FormRegMez.Academia.focus()
          return 0;
      }
      if (document.FormRegMez.Jerarquia.value.length==0)
      {
          alert("Debe indicar su jerarquia")
          document.FormRegMez.Jerarquia.focus()
          return 0;
      }
      if (document.FormRegMez.Sexo.value.length==0)
      {
          alert("Debe indicar su sexo")
          document.FormRegMez.Sexo.focus()
          return 0;
      }
      if (document.FormRegMez.Cedula.value.length==0)
      {
          alert("Debe escribir su cedula")
          document.FormRegMez.Cedula.focus()
          return 0;
      }
      if (document.FormRegMez.Apellido.value.length==0)
      {
          alert("Debe escribir sus apellidos")
          document.FormRegMez.Apellido.focus()
          return 0;
      }
      if (document.FormRegMez.Nombre.value.length==0)
      {
          alert("Debe escribir sus Nombres")
          document.FormRegMez.Nombre.focus()
          return 0;
      }
      if (document.FormRegMez.Usuario.value.length==0)
      {
          alert("Debe escribir su usuario")
          document.FormRegMez.Usuario.focus()
          return 0;
      }
      if (document.FormRegMez.Contrasena.value.length==0)
      {
          alert("Debe escribir su clave")
          document.FormRegMez.Contrasena.focus()
          return 0;
      }
      //el formulario se envia
      document.FormRegMez.submit();
  }

  function valida_envia_forreg_participante()
  {
      if (document.FormRegPar.Academia.value.length==0)
      {
          alert("Debe indicar su academia")
          document.FormRegPar.Academia.focus()
          return 0;
      }
      if (document.FormRegPar.Compania.value.length==0)
      {
          alert("Debe indicar su compania")
          document.FormRegPar.Compania.focus()
          return 0;
      }
      if (document.FormRegPar.Jerarquia.value.length==0)
      {
          alert("Debe indicar su jerarquia")
          document.FormRegPar.Jerarquia.focus()
          return 0;
      }
      if (document.FormRegPar.Sexo.value.length==0)
      {
          alert("Debe indicar su sexo")
          document.FormRegPar.Sexo.focus()
          return 0;
      }
      if (document.FormRegPar.Cedula.value.length==0)
      {
          alert("Debe escribir su cedula")
          document.FormRegPar.Cedula.focus()
          return 0;
      }
      if (document.FormRegPar.Matricula.value.length==0)
      {
          alert("Debe escribir su Matrícula")
          document.FormRegPar.Matricula.focus()
          return 0;
      }
      if (document.FormRegPar.Apellido.value.length==0)
      {
          alert("Debe escribir sus apellidos")
          document.FormRegPar.Apellido.focus()
          return 0;
      }
      if (document.FormRegPar.Nombre.value.length==0)
      {
          alert("Debe escribir sus Nombres")
          document.FormRegPar.Nombre.focus()
          return 0;
      }
      //el formulario se envia
      document.FormRegPar.submit();
  }

  function valida_envia_forreg_academia()
  {
      if (document.FormRegAca.Academia.value.length==0)
      {
          alert("Debe indicar una academia")
          document.FormRegAca.Academia.focus()
          return 0;
      }
      //el formulario se envia
      document.FormRegAca.submit();
  }

  function valida_envia_forreg_cancha()
  {
      if (document.FormRegCan.Cancha.value.length==0)
      {
          alert("Debe indicar una cancha")
          document.FormRegCan.Cancha.focus()
          return 0;
      }
      //el formulario se envia
      document.FormRegCan.submit();
  }

  function valida_envia_forreg_companias()
  {
      if (document.FormRegCom.Compania.value.length==0)
      {
          alert("Debe indicar una compañia")
          document.FormRegCom.Compania.focus()
          return 0;
      }
      //el formulario se envia
      document.FormRegCom.submit();
  }

  function valida_envia_forreg_jerarquias()
  {
      if (document.FormRegJer.Jerarquia.value.length==0)
      {
          alert("Debe indicar una jerarquía")
          document.FormRegJer.Jerarquia.focus()
          return 0;
      }
      //el formulario se envia
      document.FormRegJer.submit();
  }

   function valida_envia_forreg_jefe()
  {
      if (document.FormRegJef.Administrador.value.length==0)
      {
          alert("Debe indicar un Administrador")
          document.FormRegJef.Administrador.focus()
          return 0;
      }
      if (document.FormRegJef.Cargo.value.length==0)
      {
          alert("Debe indicar un Cargo")
          document.FormRegJef.Cargo.focus()
          return 0;
      }
      //el formulario se envia
      document.FormRegJef.submit();
  }

  function valida_envia_foredi_admin()
  {
      if (document.FormEdiAdmin.Academia.value.length==0)
      {
          alert("Debe indicar su academia")
          document.FormEdiAdmin.Academia.focus()
          return 0;
      }
      if (document.FormEdiAdmin.Jerarquia.value.length==0)
      {
          alert("Debe indicar su jerarquia")
          document.FormEdiAdmin.Jerarquia.focus()
          return 0;
      }
      if (document.FormEdiAdmin.Sexo.value.length==0)
      {
          alert("Debe indicar su sexo")
          document.FormEdiAdmin.Sexo.focus()
          return 0;
      }
      if (document.FormEdiAdmin.Cedula.value.length==0)
      {
          alert("Debe escribir su cedula")
          document.FormEdiAdmin.Cedula.focus()
          return 0;
      }
      if (document.FormEdiAdmin.Apellidos.value.length==0)
      {
          alert("Debe escribir sus apellidos")
          document.FormEdiAdmin.Apellidos.focus()
          return 0;
      }
      if (document.FormEdiAdmin.Nombres.value.length==0)
      {
          alert("Debe escribir sus Nombres")
          document.FormEdiAdmin.Nombres.focus()
          return 0;
      }
      if (document.FormEdiAdmin.Usuario.value.length==0)
      {
          alert("Debe escribir su usuario")
          document.FormEdiAdmin.Usuario.focus()
          return 0;
      }
      if (document.FormEdiAdmin.Contrasena.value.length==0)
      {
          alert("Modificar contraseña")
          document.FormEdiAdmin.Contrasena.focus()
          return 0;
      }
  
      //el formulario se envia
      document.FormEdiAdmin.submit();
  }

  function valida_envia_foredi_Mesa()
  {
      if (document.FormEdiMesa.Academia.value.length==0)
      {
          alert("Debe indicar su academia")
          document.FormEdiMesa.Academia.focus()
          return 0;
      }
      if (document.FormEdiMesa.Jerarquia.value.length==0)
      {
          alert("Debe indicar su jerarquia")
          document.FormEdiMesa.Jerarquia.focus()
          return 0;
      }
      if (document.FormEdiMesa.Sexo.value.length==0)
      {
          alert("Debe indicar su sexo")
          document.FormEdiMesa.Sexo.focus()
          return 0;
      }
      if (document.FormEdiMesa.Cedula.value.length==0)
      {
          alert("Debe escribir su cedula")
          document.FormEdiMesa.Cedula.focus()
          return 0;
      }
      if (document.FormEdiMesa.Apellidos.value.length==0)
      {
          alert("Debe escribir sus apellidos")
          document.FormEdiMesa.Apellidos.focus()
          return 0;
      }
      if (document.FormEdiMesa.Nombres.value.length==0)
      {
          alert("Debe escribir sus nombres")
          document.FormEdiMesa.Nombres.focus()
          return 0;
      }
      if (document.FormEdiMesa.Usuario.value.length==0)
      {
          alert("Debe escribir su usuario")
          document.FormEdiMesa.Usuario.focus()
          return 0;
      }
      if (document.FormEdiMesa.Contrasena.value.length==0)
      {
          alert("Modificar contraseña")
          document.FormEdiMesa.Contrasena.focus()
          return 0;
      }
  
      //el formulario se envia
      document.FormEdiMesa.submit();
  }


  function valida_envia_foredi_participante()
  {
      if (document.FormEdiCadetes.Academia.value.length==0)
      {
          alert("Debe indicar su academia")
          document.FormEdiCadetes.Academia.focus()
          return 0;
      }
      if (document.FormEdiCadetes.Compania.value.length==0)
      {
          alert("Debe indicar su compañia")
          document.FormEdiCadetes.Compania.focus()
          return 0;
      }
      if (document.FormEdiCadetes.Jerarquia.value.length==0)
      {
          alert("Debe indicar su jerarquia")
          document.FormEdiCadetes.Jerarquia.focus()
          return 0;
      }
      if (document.FormEdiCadetes.Sexo.value.length==0)
      {
          alert("Debe indicar su sexo")
          document.FormEdiCadetes.Sexo.focus()
          return 0;
      }
      if (document.FormEdiCadetes.Cedula.value.length==0)
      {
          alert("Debe escribir su cedula")
          document.FormEdiCadetes.Cedula.focus()
          return 0;
      }
      if (document.FormEdiCadetes.Apellidos.value.length==0)
      {
          alert("Debe escribir sus apellidos")
          document.FormEdiCadetes.Apellidos.focus()
          return 0;
      }
      if (document.FormEdiCadetes.Nombres.value.length==0)
      {
          alert("Debe escribir sus Nombres")
          document.FormEdiCadetes.Nombres.focus()
          return 0;
      }
      if (document.FormEdiCadetes.Cambiomatri.value.length==0)
      {
          alert("Modificar matrícula")
          document.FormEdiCadetes.Cambiomatri.focus()
          return 0;
      }
  
      //el formulario se envia
      document.FormEdiCadetes.submit();
  }

  function valida_envia_foredi_academia()
  {
      if (document.FormEdiAca.Academia.value.length==0)
      {
          alert("Debe indicar una compañia")
          document.FormEdiAca.Academia.focus()
          return 0;
      }
      //el formulario se envia
      document.FormEdiAca.submit();
  }

  function valida_envia_foredi_cancha()
  {
      if (document.FormEdiCan.Cancha.value.length==0)
      {
          alert("Debe indicar una cancha")
          document.FormEdiCan.Cancha.focus()
          return 0;
      }
      //el formulario se envia
      document.FormEdiCan.submit();
  }

  function valida_envia_foredi_compania()
  {
      if (document.FormEdiCom.Compania.value.length==0)
      {
          alert("Debe indicar una compañia")
          document.FormEdiCom.Compania.focus()
          return 0;
      }
      //el formulario se envia
      document.FormEdiCom.submit();
  }

  function valida_envia_foredi_jerarquia()
  {
      if (document.FormEdiJer.Jerarquia.value.length==0)
      {
          alert("Debe indicar una jerarquía")
          document.FormEdiJer.Jerarquia.focus()
          return 0;
      }
      //el formulario se envia
      document.FormEdiJer.submit();
  }

  function valida_envia_foredi_jefe()
  {
      if (document.FormEdiJef.Administrador.value.length==0)
      {
          alert("Debe indicar un Administrador")
          document.FormEdiJef.Administrador.focus()
          return 0;
      }
      if (document.FormEdiJef.Cargo.value.length==0)
      {
          alert("Debe indicar un Cargo")
          document.FormEdiJef.Cargo.focus()
          return 0;
      }
      //el formulario se envia
      document.FormEdiJef.submit();
  }
</script>