<script language="JavaScript" type="text/javascript">

   /** Solo admite letras **/
   function validar(e)
   {
      tecla=(document.all) ? e.keyCode : e.which;
      if (tecla==8) return true;
      patron=/[A-Za-z\s]/; 
      te= String.fromCharCode(tecla);
      return patron.test(te);
   }

   /** Solo admite numeros **/
   function validar2(e)
   {
      tecla=(document.all) ? e.keyCode : e.which;
      if (tecla==8) return true;
      patron=/\d/; 
      te= String.fromCharCode(tecla);
      return patron.test(te);
   }

   /** Impide la creacion de codigo php o html **/
   function validar4(e)
   {
      tecla=(document.all) ? e.keyCode : e.which;
      if (tecla==8) return true;
      patron=/[a-zA-Z0-9\-_ .,/|#%¡!¿?*+-=]/; 
      te= String.fromCharCode(tecla);
      return patron.test(te);
   }
   
   /** Permite letras y el punto **/
   function validar5(e)
   {
      tecla=(document.all) ? e.keyCode : e.which;
      if (tecla==8) return true;
      patron=/[a-zA-Z\.]/; 
      te= String.fromCharCode(tecla);
      return patron.test(te);
   }   

   /** Permite letras y espacio **/
   function validar6(e)
   {
      tecla=(document.all) ? e.keyCode : e.which;
      if (tecla==8) return true;
      patron=/[a-zA-Z\ ]/; 
      te= String.fromCharCode(tecla);
      return patron.test(te);
   }

   /** Permite letras, numeros y el guion **/
   function validar7(e)
   {
      tecla=(document.all) ? e.keyCode : e.which;
      if (tecla==8) return true;
      patron=/[a-zA-Z0-9\-]/; 
      te= String.fromCharCode(tecla);
      return patron.test(te);
   }

   /** Permite letras, nunmeros, espacio, punto y doble punto **/
   function validar8(e)
   {
      tecla=(document.all) ? e.keyCode : e.which;
      if (tecla==8) return true;
      patron=/[a-zA-Z0-9\ ,:]/; 
      te= String.fromCharCode(tecla);
      return patron.test(te);
   }

   /** Permite letras, numeros y barra inclinada **/
   function validar9(e)
   {
      tecla=(document.all) ? e.keyCode : e.which;
      if (tecla==8) return true;
      patron=/[a-zA-Z0-9\/]/; 
      te= String.fromCharCode(tecla);
      return patron.test(te);
   }

   /** Permite letras, numeros, guion y espacio **/
   function validar10(e)
   {
      tecla=(document.all) ? e.keyCode : e.which;
      if (tecla==8) return true;
      patron=/[a-zA-Z0-9\-/ ]/;
      te= String.fromCharCode(tecla);
      return patron.test(te);
   }

</script>
