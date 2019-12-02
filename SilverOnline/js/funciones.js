
function agregarUsuarios(email, pass){

cadena = "EMAIL=" + email + "&PASS=" + pass;

$.ajax({
    type:"POST",
    url: "php/agregarUsuarios.php",
    data:cadena,
    success:function(result){

      if(result==1){

        echo("Se registro el usuario de forma correcta...");
      }
      else{
        echo("Error...");
      }

    }

  });

}
