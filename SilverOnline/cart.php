<?php
$aCarrito = array();
$sHTML = '';
$fPrecioTotal = 0;
$bagNumber = 0;
$TotalxArtGlobal = 0;

//Vaciamos el carrito
if(isset($_GET['vaciar'])) {
  unset($_COOKIE['carrito']);
}

if (isset($_POST['DelArt'])) {

  // foreach ($aCarrito as $key => $value) {
  //
  // $aCarrito = unserialize($_COOKIE['carrito']);

  // if ($value['ID'] == $_POST['ID']) {
  // unset($aCarrito[$_POST['ID']-1]);
  unset($_COOKIE[$_POST['ID']-1]);
  // }
  //
  // }
}

//Obtenemos los productos anteriores

if(isset($_COOKIE['carrito'])) {
  $aCarrito = unserialize($_COOKIE['carrito']);
}

//Anyado un nuevo articulo al carrito

if(isset($_POST['ID']) && isset($_POST['NOMBRE']) && isset($_POST['PRECIO']) && isset($_POST['URL']) && isset($_POST['CANTIDAD']) && isset($_POST['Posicion'])) {
  foreach ($aCarrito as $key => $value) {

    // if ($aCarrito[$_POST['ID']-1]['ID'] == $_POST['ID'])
    //  {
    //   $aCarrito[$_POST['ID']-1]['ID'] = $_POST['ID'];
    //   $aCarrito[$_POST['ID']-1]['NOMBRE'] = $_POST['NOMBRE'];
    //   $aCarrito[$_POST['ID']-1]['PRECIO'] = $_POST['PRECIO'];
    //   $aCarrito[$_POST['ID']-1]['URL'] = $_POST['URL'];
    //   $aCarrito[$_POST['ID']-1]['CANTIDAD'] = $_POST['CANTIDAD'];
    // }
    if ($aCarrito[$_POST['Posicion']]['ID'] == $_POST['ID'])
    {
      $aCarrito[$_POST['Posicion']]['ID'] = $_POST['ID'];
      $aCarrito[$_POST['Posicion']]['NOMBRE'] = $_POST['NOMBRE'];
      $aCarrito[$_POST['Posicion']]['PRECIO'] = $_POST['PRECIO'];
      $aCarrito[$_POST['Posicion']]['URL'] = $_POST['URL'];
      $aCarrito[$_POST['Posicion']]['CANTIDAD'] = $_POST['CANTIDAD'];
    }

    else {
      $iUltimaPos = count($aCarrito);
      $aCarrito[$iUltimaPos]['ID'] = $_POST['ID'];
      $aCarrito[$iUltimaPos]['NOMBRE'] = $_POST['NOMBRE'];
      $aCarrito[$iUltimaPos]['PRECIO'] = $_POST['PRECIO'];
      $aCarrito[$iUltimaPos]['URL'] = $_POST['URL'];
      $aCarrito[$iUltimaPos]['CANTIDAD'] = $_POST['CANTIDAD'];
    }

  }
}

//Creamos la cookie (serializamos)

$iTemCad = time() + (60 * 60);
setcookie('carrito', serialize($aCarrito), $iTemCad);

//Imprimimos el contenido del array

foreach ($aCarrito as $key => $value) {
  $sHTML .= '-> ' . $value['ID'] . ' ' . $value['NOMBRE'] . ' ' . $value['PRECIO'] . ' ' . $value['URL'] . ' ' . $value['CANTIDAD'] . ' <br>';
  $fPrecioTotal += $value['PRECIO'];
  $bagNumber = count($aCarrito);
  $TotalxArtGlobal += $value['PRECIO'] * $value['CANTIDAD'];
}

//Imprimimos el precio total
$sHTML .= '<br>------------------<br>Precio total: ' . $fPrecioTotal;

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  <!-- Title  -->
  <title>Siler - Evolution | Carrito</title>

  <!-- Favicon  -->
  <link rel="icon" href="img/core-img/favicon.ico">

  <!-- Core Style CSS -->
  <link rel="stylesheet" href="css/core-style.css">
  <link rel="stylesheet" href="style.css">

  <!-- Responsive CSS -->
  <link href="css/responsive.css" rel="stylesheet">

  <!-- css LFPO -->
  <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" >
  <link rel="stylesheet" type="text/css" href="librerias/alertify/css/themes/default.css" >
  <!-- end -->

  <!-- scripts LFPO -->
  <script src="js/jquery/jquery-2.2.4.min.js"></script>
  <script src="js/funciones.js"></script>
  <script src="librerias/alertify/alertify.js"></script>
  <!-- end -->

</head>

<body>
  <div class="catagories-side-menu">
    <!-- Close Icon -->
    <div id="sideMenuClose">
      <i class="ti-close"></i>
    </div>
    <!--  Side Nav  -->
    <div class="nav-side-menu">
      <div class="menu-list">
        <h6>Categorías</h6>
        <ul id="menu-content" class="menu-content collapse out">

          <!-- Single Item -->
          <li data-toggle="collapse" data-target="#joyas" class="collapsed active">
            <a href="#">Joyas<span class="arrow"></span></a>
            <ul class="sub-menu collapse" id="joyas">
              <li><a href="joyas-h.php">Hombre</a></li>
              <li><a href="joyas-m.php">Mujer</a></li>
            </ul>
          </li>

          <!-- Single Item -->
          <li data-toggle="collapse" data-target="#bolsas" class="collapsed active">
            <a href="#">Bolsas<span class="arrow"></span></a>
            <ul class="sub-menu collapse" id="bolsas">
              <li><a href="#">Hombre</a></li>
              <li><a href="#">Mujer</a></li>
            </ul>
          </li>

          <!-- Single Item -->
          <li data-toggle="collapse" data-target="#perfumes" class="collapsed active">
            <a href="#">Perfumes<span class="arrow"></span></a>
            <ul class="sub-menu collapse" id="perfumes">
              <li><a href="#">Hombre</a></li>
              <li><a href="#">Mujer</a></li>
            </ul>
          </li>

          <!-- Single Item -->
          <li data-toggle="collapse" data-target="#ropa" class="collapsed active">
            <a href="#">Ropa<span class="arrow"></span></a>
            <ul class="sub-menu collapse" id="ropa">
              <li><a href="#">Hombre</a></li>
              <li><a href="#">Mujer</a></li>
              <li><a href="#">Niño</a></li>
              <li><a href="#">Niña</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div id="wrapper">

    <!-- ****** Header Area Start ****** -->
    <header class="header_area bg-img background-overlay-white" style="background-image: url(img/bg-img/bg-1.jpg);">
      <!-- Top Header Area Start -->
      <div class="top_header_area">
        <div class="container h-100">
          <div class="row h-100 align-items-center justify-content-end">

            <div class="col-12 col-lg-7">
              <div class="top_single_area d-flex align-items-center">
                <!-- Logo Area -->
                <div class="top_logo">
                  <a href="#"><img src="img/core-img/logo_Silver.png" alt=""></a>
                </div>
                <!-- Cart & Menu Area -->
                <div class="header-cart-menu d-flex align-items-center ml-auto">
                  <!-- Cart Area -->
                  <div class="cart">
                    <a href="#" id="header-cart-btn" target="_blank"><span class="cart_quantity"> <?php echo $bagNumber ?> </span> <i class="ti-bag"></i> Tu bolsa $ <?php echo $TotalxArtGlobal ?></a>
                    <!-- Cart List Area Start -->
                    <ul class="cart-list">
                      <?php foreach ($aCarrito as $key => $value) {
                        $TotalxArt = $value['PRECIO'] * $value['CANTIDAD'];
                        ?>
                        <li>
                          <a href="#" class="image"><img src="<?php echo $value['URL'] ?>" class="cart-thumb" alt=""></a>
                          <div class="cart-item-desc">
                            <h6><a href="#"><?php echo $value['NOMBRE'] ?></a></h6>
                            <p> <?php echo $value['CANTIDAD'] ?>x - <span class="price">$<?php echo $TotalxArt ?></span></p>
                          </div>
                          <span class="dropdown-product-remove"><i class="icon-cross"></i></span>
                        </li>
                      <?php } ?>
                      <li class="total">
                        <span class="pull-right">Total: $<?php echo $TotalxArtGlobal ?></span>
                        <a href="cart.php" class="btn btn-sm btn-cart">Carrito</a>
                        <a href="checkout-1.html" class="btn btn-sm btn-checkout">Checkout</a>
                      </li>
                    </ul>
                  </div>
                  <div class="header-right-side-menu ml-15">
                    <a href="#" id="sideMenuBtn"><i class="ti-menu" aria-hidden="true"></i></a>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- Top Header Area End -->
      <div class="main_header_area">
        <div class="container h-100">
          <div class="row h-100">
            <div class="col-12 d-md-flex justify-content-between">
              <!-- Header Social Area -->
              <div class="header-social-area">
                <a href="#"><span class="karl-level">Share</span> <i class="fa fa-pinterest" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
              </div>
              <!-- Menu Area -->
              <div class="main-menu-area">
                <nav class="navbar navbar-expand-lg align-items-start">

                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#karl-navbar" aria-controls="karl-navbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"><i class="ti-menu"></i></span></button>

                  <div class="collapse navbar-collapse align-items-start collapse" id="karl-navbar">
                    <ul class="navbar-nav animated" id="nav">
                      <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="karlDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                        <div class="dropdown-menu" aria-labelledby="karlDropdown">
                          <a class="dropdown-item" href="index.php">Home</a>
                          <a class="dropdown-item" href="shop.html">Shop</a>
                          <a class="dropdown-item" href="product-details.html">Product Details</a>
                          <a class="dropdown-item" href="cart.php">Carrito</a>
                          <a class="dropdown-item" href="checkout.html">Checkout</a>
                        </div>
                      </li>
                      <li class="nav-item"><a class="nav-link" href="#">Dresses</a></li>
                      <li class="nav-item"><a class="nav-link" href="#"><span class="karl-level">hot</span> Shoes</a></li>
                      <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                      <li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#ModalRegistroUsuarios">Sign In</a></li>
                    </ul>
                  </div>
                </nav>
              </div>

              <!-- Modal para registro de Usuarios -->
              <div class="modal fade" id="ModalRegistroUsuarios" tabindex="-1" role="dialog" aria-labelledby="ModalRegistroUsuarios" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="ModalRegistroUsuarios">Registro de Usuario...</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <label for="txtEmail">E-MaiL</label>
                          <input type="email" class="form-control" id="txtEmail" value="" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <label for="txtPass">Contraseña</label>
                          <input type="password" class="form-control" id="txtPass" value="" required>
                        </div>
                      </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <button type="button" class="btn btn-primary" id="btnGuardar">Registrarse</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Help Line -->
              <div class="help-line">
                <a href="tel:9221197785"><i class="ti-headphone-alt"></i> +52 922 1197 785</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- ****** Header Area End ****** -->

    <!-- ****** Top Discount Area Start ****** -->
    <section class="top-discount-area d-md-flex align-items-center">
      <!-- Single Discount Area -->
      <div class="single-discount-area">
        <h5>Free Shipping &amp; Returns</h5>
        <h6><a href="#">BUY NOW</a></h6>
      </div>
      <!-- Single Discount Area -->
      <div class="single-discount-area">
        <h5>20% Discount for all dresses</h5>
        <h6>USE CODE: Colorlib</h6>
      </div>
      <!-- Single Discount Area -->
      <div class="single-discount-area">
        <h5>20% Discount for students</h5>
        <h6>USE CODE: Colorlib</h6>
      </div>
    </section>
    <!-- ****** Top Discount Area End ****** -->

    <!-- ****** Cart Area Start ****** -->
    <div class="cart_area section_padding_100 clearfix">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="cart-table clearfix">
              <table class="table table-responsive">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th> </th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i=0;
                  foreach ($aCarrito as $key => $value) {

                    $TotalxArt = $value['PRECIO'] * $value['CANTIDAD'];

                    ?>
                    <tr>
                      <td class="cart_product_img d-flex align-items-center">
                        <a href="#"><img src="<?php echo $value['URL'] ?>" alt="Product"></a>
                        <h6 id="h6Nombre<?php echo $value['ID'] ?>"><?php echo $value['NOMBRE'] ?></h6>
                      </td>
                      <td class="price">$<?php echo $value['PRECIO'] ?></span></td>
                      <td class="qty">
                        <div class="quantity">
                          <button type="button" class="qty-minus" id="btnMenos<?php echo $value['ID'] ?>">-</button>
                          <input type="number" class="qty-text" id="qty<?php echo $value['ID'] ?>" name="CANTIDAD">
                          <button type="button" class="qty-minus" id="btnMas<?php echo $value['ID'] ?>">+</button>

                        </div>
                      </td>
                      <td>
                        <button type="button" class="btn btn-danger" id="btnDel<?php echo $value['ID'] ?>">X</button>

                        <!-- <a href="cart.php?DelArt=1" class="btn btn-danger">as<i class="glyphicon glyphicon-trash"></i></a> -->
                      </td>
                      <td >
                        <input type="text" class="sinborde" id="txtTotalxArt<?php echo $value['ID'] ?>" name="CANTIDAD" value="$<?php echo $TotalxArt ?>" readonly="readonly">
                      </td>
                    </tr>

                    <script type="text/javascript">
                    $(document).ready(function(){

                      $('#btnMenos<?php echo $value['ID'] ?>').click(function(){
                        valor = document.getElementById("qty<?php echo $value['ID'] ?>");
                        valor.value --;
                        id = <?php echo $value['ID'] ?>;
                        nombre = '<?php echo $value['NOMBRE'] ?>';
                        precio = <?php echo $value['PRECIO'] ?>;
                        url = '<?php echo $value['URL'] ?>';
                        cantidad=$('#qty<?php echo $value['ID'] ?>').val();
                        posicion = <?php echo $i ?>;
                        cartModPrice(id,
                          nombre,
                          precio,
                          url,
                          cantidad,
                          posicion);

                        });
                        $('#btnMas<?php echo $value['ID'] ?>').click(function(){
                          valor = document.getElementById("qty<?php echo $value['ID'] ?>");
                          valor.value ++;
                          id = <?php echo $value['ID'] ?>;
                          nombre = '<?php echo $value['NOMBRE'] ?>';
                          precio = <?php echo $value['PRECIO'] ?>;
                          url = '<?php echo $value['URL'] ?>';
                          cantidad=$('#qty<?php echo $value['ID'] ?>').val();
                          posicion = <?php echo $i ?>;
                          cartModPrice(id,
                            nombre,
                            precio,
                            url,
                            cantidad,
                            posicion);

                          });

                          $('#btnDel<?php echo $value['ID'] ?>').click(function(){
                            debugger;
                            id = <?php echo $value['ID'] ?>;
                            valida = 1;
                            eliminarArticulo(id, valida);

                          });
                        });
                        </script>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>
                  </table>
                </div>

                <div class="cart-footer d-flex mt-30">
                  <div class="back-to-shop w-50">
                    <a href="shop.html">Continue shooping</a>
                  </div>
                  <div class="update-checkout w-50 text-right">
                    <a href="cart.php?vaciar=1">Vaciar carrito</a>
                    <a href="#">Update cart</a>
                  </div>
                </div>

              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-6 col-lg-4">
                <div class="coupon-code-area mt-70">
                  <div class="cart-page-heading">
                    <h5>Cupon code</h5>
                    <p>Enter your cupone code</p>
                  </div>
                  <form action="#">
                    <input type="search" name="search" placeholder="#569ab15">
                    <button type="submit">Apply</button>
                  </form>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-4">
                <div class="shipping-method-area mt-70">
                  <div class="cart-page-heading">
                    <h5>Shipping method</h5>
                    <p>Select the one you want</p>
                  </div>

                  <div class="custom-control custom-radio mb-30">
                    <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                    <label class="custom-control-label d-flex align-items-center justify-content-between" for="customRadio1"><span>Next day delivery</span><span>$4.99</span></label>
                  </div>

                  <div class="custom-control custom-radio mb-30">
                    <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                    <label class="custom-control-label d-flex align-items-center justify-content-between" for="customRadio2"><span>Standard delivery</span><span>$1.99</span></label>
                  </div>

                  <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                    <label class="custom-control-label d-flex align-items-center justify-content-between" for="customRadio3"><span>Personal Pickup</span><span>Free</span></label>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-4">
                <div class="cart-total-area mt-70">
                  <div class="cart-page-heading">
                    <h5>Total del Carrito</h5>
                    <p>Información Final</p>
                  </div>

                  <ul class="cart-total-chart">
                    <li><span>Subtotal</span> <span>$<?php echo $TotalxArtGlobal ?></span></li>
                    <li><span>Envío</span> <span>$0.00 </span></li>
                    <li><span><strong>Total</strong></span> <span><strong>$<?php echo $TotalxArtGlobal ?></strong></span></li>
                  </ul>
                  <a href="checkout.html" class="btn karl-checkout-btn">Proceed to checkout</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- ****** Cart Area End ****** -->

        <!-- ****** Footer Area Start ****** -->
        <footer class="footer_area">
          <div class="container">
            <div class="row">
              <!-- Single Footer Area Start -->
              <div class="col-12 col-md-6 col-lg-3">
                <div class="single_footer_area">
                  <div class="footer-logo">
                    <img src="img/core-img/logo.png" alt="">
                  </div>
                  <div class="copywrite_text d-flex align-items-center">
                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                      Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a> &amp; distributed by <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                      <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    </div>
                  </div>
                </div>
                <!-- Single Footer Area Start -->
                <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                  <div class="single_footer_area">
                    <ul class="footer_widget_menu">
                      <li><a href="#">About</a></li>
                      <li><a href="#">Blog</a></li>
                      <li><a href="#">Faq</a></li>
                      <li><a href="#">Returns</a></li>
                      <li><a href="#">Contact</a></li>
                    </ul>
                  </div>
                </div>
                <!-- Single Footer Area Start -->
                <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                  <div class="single_footer_area">
                    <ul class="footer_widget_menu">
                      <li><a href="#">My Account</a></li>
                      <li><a href="#">Shipping</a></li>
                      <li><a href="#">Our Policies</a></li>
                      <li><a href="#">Afiliates</a></li>
                    </ul>
                  </div>
                </div>
                <!-- Single Footer Area Start -->
                <div class="col-12 col-lg-5">
                  <div class="single_footer_area">
                    <div class="footer_heading mb-30">
                      <h6>Subscribe to our newsletter</h6>
                    </div>
                    <div class="subscribtion_form">
                      <form action="#" method="post">
                        <input type="email" name="mail" class="mail" placeholder="Your email here">
                        <button type="submit" class="submit">Subscribe</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="line"></div>

              <!-- Footer Bottom Area Start -->
              <div class="footer_bottom_area">
                <div class="row">
                  <div class="col-12">
                    <div class="footer_social_area text-center">
                      <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                      <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                      <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                      <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </footer>
          <!-- ****** Footer Area End ****** -->
        </div>
        <!-- /.wrapper end -->

        <!-- jQuery (Necessary for All JavaScript Plugins) -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <!-- Popper js -->
        <script src="js/popper.min.js"></script>
        <!-- Bootstrap js -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Plugins js -->
        <script src="js/plugins.js"></script>
        <!-- Active js -->
        <script src="js/active.js"></script>

      </body>

      </html>

      <script type="text/javascript">

      $(document).ready(function(){
        $('#btnGuardar').click(function(){

          email= $('#txtEmail').val();
          pass= $('#txtPass').val();

          if($('#txtEmail').val() == ""){

            alert("Debe ingresar un E-mail...");
          }
          if($('#txtPass').val() == ""){

            alert("Debe ingresar una contraseña...");
          }
          if($('#txtEmail').val() != "" && $('#txtPass').val() != ""){
            agregarUsuarios(email, pass);
          }
        });

        <?php
        foreach ($aCarrito as $key => $value) {
          ?>
          $('#qty<?php echo $value['ID'] ?> ').val(<?php echo $value['CANTIDAD'] ?>);

          <?php } ?>
        });

        </script>
