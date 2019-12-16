
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

      location.reload();
    }

  });

}

function guardarArt(id, posicion, valida){

  cadena = "ID=" + id + "&Posicion=" + posicion + "&DelArt=" + valida;

  $.ajax({
    type:"POST",
    url: "cart.php",
    data:cadena,
    success:function(result){

      location.reload();
    }

  });

}
