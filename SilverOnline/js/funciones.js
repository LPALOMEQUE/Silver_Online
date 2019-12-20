
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
debugger;
      x=result;
      location.reload();
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
      debugger;
x=result;

    }
  });
}
