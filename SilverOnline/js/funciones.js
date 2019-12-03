
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
      }
      else{
        alert("Error...");
      }

    }

  });

}
