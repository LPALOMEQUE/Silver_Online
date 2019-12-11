
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

function ModCart(totalNew, envioSiNo){

  cadena = "totalNew=" + totalNew + "&envioSiNo=" + envioSiNo;

  $.ajax({
    type:"POST",
    url: "cart.php",
    data:cadena,
    success:function(result){

      // $('#quickview' + id ).hide();
      location.reload();
    }

  });

}
