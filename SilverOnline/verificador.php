<?php
$calle = 'prueba';

//print_r($_GET);

// ----------------------------------------------------------------------------------------------------------------
//PRUEBAS.......
// $ClientID = "AQfqqbzkFvxShrOBEbcFqOB6uDjVlaFgIwpW2JEErSGMSQe1cCzMMHdhA6jYXqhnYGVzSsmI3BGYQF9G";
// $Secret = "EIRbeX9Yv6ze9ozLPagaHsMvOmvdw_MWK2kPH-CYmcGnov-RssU2sEh4KFHd2DZfpQQ28d1s-rd5TydZ";

// PRODUCCION
$ClientID = "AWkFACdq0h4aeDpN-yfYhlk4FxnpGYbLmX6rcVA5qo3N2ErxCp3GrPyQ1sWIwCR2EH6UubCHJfNnH84I";
$Secret = "EDiXuARlbHy0D8LdGLpOTOFO7YLdrqk9oapqR2mmQxJfq9DIYESd84N7DyZq6LVr2Wnz-yRJVbXcmtsb";
// ----------------------------------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------------------------------
//PRUEBAS.......
// $login = curl_init("https://api.sandbox.paypal.com/v1/oauth2/token");

//PRODUCCION
$login = curl_init("https://api.paypal.com/v1/oauth2/token");
// ----------------------------------------------------------------------------------------------------------------

curl_setopt($login,CURLOPT_RETURNTRANSFER,TRUE);

curl_setopt($login,CURLOPT_USERPWD,$ClientID.":".$Secret);

curl_setopt($login,CURLOPT_POSTFIELDS,"grant_type=client_credentials");

$respuesta = curl_exec($login);

// print_r($respuesta);

$objRespuesta = json_decode($respuesta);

$accessToken = $objRespuesta->access_token;

// print_r($accessToken);

// ----------------------------------------------------------------------------------------------------------------
//PRUEBAS.......
// $venta = curl_init("https://api.sandbox.paypal.com/v1/payments/payment/".$_GET['paymentID']);

//PRODUCCION
$venta = curl_init("https://api.paypal.com/v1/payments/payment/".$_GET['paymentID']);
// ----------------------------------------------------------------------------------------------------------------

curl_setopt($venta,CURLOPT_HTTPHEADER,array("Content-Type: application/json","Authorization: Bearer ".$accessToken));

curl_setopt($venta,CURLOPT_RETURNTRANSFER,TRUE);

$respuestaVenta = curl_exec($venta);

 // print_r($respuestaVenta);

$objDatosTransaccion = json_decode($respuestaVenta);

$state = $objDatosTransaccion->state;
$email = $objDatosTransaccion->payer->payer_info->email;
$total = $objDatosTransaccion->transactions[0]->amount->total;
$currrency = $objDatosTransaccion->transactions[0]->amount->currency;
$idventa = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->id;

// $custom = $objDatosTransaccion->transactions[0]->custom;

// echo $total;
// echo " , ";
// echo $state;
 // echo $idventa;

curl_close($venta);
curl_close($login);

if ($state == 'approved') {
  echo "
  <script src='js/jquery/jquery-2.2.4.min.js'></script>
  <!-- Popper js -->
  <script src='js/popper.min.js'></script>
  <!-- Bootstrap js -->
  <script src='js/bootstrap.min.js'></script>
  <!-- Plugins js -->
  <script src='js/plugins.js'></script>
  <!-- Active js -->
  <script src='js/active.js'></script>

  <script src='https://smtpjs.com/v3/smtp.js'></script>
  <script type='text/javascript'>

  $(document).ready(function(){

    Email.send({
      Host : 'smtp.elasticemail.com',
      Username : 'fernando18092105@gmail.com',
      Password : 'C8C00D5D9EEF4F923A4B7190F4F83F9D4E5B',
      To : 'fer18092105@icloud.com',
      From : 'fernando18092105@gmail.com',
      Subject : 'Pedido #$idventa',
      Body : '$calle'
    }).then(
      // message => alert(message)
    );
    window.location= 'index.php?vaciar=1';
    alert('Pago aprobado');
  });

  </script>";

}
else{
  echo "<script>
  window.location= 'index.php';
  alert('Ocurrio un error con el pago');
  </script>";
}

?>
