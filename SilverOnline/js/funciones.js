
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

function AddCart(id, Name_art, Price_art, Url_art){

  cadena = "ID=" + id + "&NAME_ART=" + Name_art + "&PRICE_ART=" + Price_art + "&URL_ART=" + Url_art ;

  $.ajax({
    type:"POST",
    url: "php/cart.php",
    data:cadena,
    success:function(result){

      if(result==1){

        alert("proceso correct0...");
        // $('#txtEmail').val('');
        // $('#txtPass').val('');
        // $('#ModalRegistroUsuarios').hide();
      }
      else{
        alert("Error...");
      }

    }

  });

}
