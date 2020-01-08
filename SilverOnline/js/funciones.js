
function agregarUsuarios(email, pass){

  cadena = "EMAIL=" + email + "&PASS=" + pass;

  $.ajax({
    type:"POST",
    url: "php/agregarUsuarios.php",
    data:cadena,
    success:function(result){

      if(result==1){

        alert("Se registro el usuario de forma correcta...");
        $('#txtEmail').val('');
        $('#txtPass').val('');
        $('#ModalRegistroUsuarios').hide();
      }
      else{
        alert("Error...");
      }

    }

  });
}

function login(email, pass){

  cadena = "EMAIL=" + email + "&PASS=" + pass;

  $.ajax({
    type:"POST",
    url: "php/valUser.php",
    data:cadena,
    success:function(result){
      if(result==1){

        alert("Inicio de sesión correcto, ya puede continuar coprando...");
        $('#txt_Email').val('');
        $('#txt_Pass').val('');
        $('#ModalLogin').hide();

        if($("#customRadio1").is(':checked') || $("#customRadio2").is(':checked')) {

          precioEnvio = $('input:radio[name=rbDelivery]:checked').val();

          if (precioEnvio == 'express') {
            x = 700;
          }
          else{
            x = 250;
          }
          pruebas(x);
        }else{
          alert('Debe seleccionar un metodo de envío.');
        }
        location.reload();
      }
      else{
        alert("Usuario o contraseña incorrectos...");
      }

    }

  });
}

function AddCart(id, nombre, precio, url, cantidad){

  cadena = "ID=" + id + "&NOMBRE=" + nombre + "&PRECIO=" + precio + "&URL=" + url + "&CANTIDAD=" + cantidad;

  $.ajax({
    type:"POST",
    url: "joyas-h.php",
    data:cadena,
    success:function(result){

      $('#quickview' + id ).hide();
      location.reload();
    }

  });
}

function logOut(vaciar){

  cadena = "VACIAR=" + vaciar;

  $.ajax({

    type:"POST",
    url: "checkout.php",
    data: cadena,
    success: function(result){
      location.reload();
    }
  });
}

function cartModPrice(id, nombre, precio, url, cantidad, posicion){

  cadena = "ID=" + id + "&NOMBRE=" + nombre + "&PRECIO=" + precio + "&URL=" + url + "&CANTIDAD=" + cantidad + "&Posicion=" + posicion;

  $.ajax({
    type:"POST",
    url: "cart.php",
    data:cadena,
    success:function(result){

      location.reload();
    }

  });

}

function eliminarArticulo(id, posicion, valida){

  cadena = "ID=" + id + "&Posicion=" + posicion + "&DelArt=" + valida;

  $.ajax({
    type:"POST",
    url: "cart.php",
    data:cadena,
    success:function(result){
      // location.href="cart.php";
      location.reload();
    }
  });
}

function getPriceDeli(precioEnvio, total){

  cadena = "MONTO=" + precioEnvio + "&finalTotal=" + total;

  $.ajax({
    type:"POST",
    url: "cart.php",
    data:cadena,
    success:function(result){
      var ventaTotal = total;
      var montoEnvio = precioEnvio;
      const formatterDolar = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
      })
      $('#txtcost').val(formatterDolar.format(montoEnvio));
      $('#txtcostT').val(formatterDolar.format(ventaTotal));
    }

  });

}

function pruebas(envio, vtaTotal){
  cadena = "MONTO=" + envio + "&VTATOTAL=" + vtaTotal;

  $.ajax({
    type:"POST",
    url: "checkout.php",
    data:cadena,
    success:function(result){
      location.href ="checkout.php";
    }
  });
}

function guardarArt(nomArt,  descArt, barCode, modelArt, marcaArt, precioArt, categoria, subCatego, statusArt, nameArticulo){
  cadena = "NomArt=" + nomArt +
  "&DescArt=" + descArt +
  "&BarCode=" + barCode +
  "&ModelArt=" + modelArt +
  "&MarcaArt=" + marcaArt +
  "&PrecioArt=" + precioArt +
  "&Categoria=" + categoria +
  "&SubCatego=" + subCatego +
  "&StatusArt=" + statusArt +
  "&NombreImg=" + nameArticulo;

  $.ajax({
    type:"POST",
    url: "php/agregarArticulos.php",
    data:cadena,
    success:function(result){

      if(result==1){

        alert("Se registro el artículo de forma correcta...");
        $('#txtNameArt').val('');
        $('#txtDescArt').val('');
        $('#txtBarCode').val('');
        $('#txtModelo').val('');
        $("#cbmMarca option[value=0]").attr("selected",true);
        $('#txtPrecio').val(0);
        $("#cbmCategoria option[value=0]").attr("selected",true);
        $("#cbmSubcategoria option[value=0]").attr("selected",true);
        $("#cbmStatus option[value=2]").attr("selected",true);

      }
      else{
        alert("Error...");
      }
    }

  });
}

function buscarArticulos(buscador){
  cadena = "BarCode=" + buscador;

  $.ajax({
    type:"POST",
    url: "index.php",
    data:cadena,
    success:function(result){

      x=result;

    }
  });
}
