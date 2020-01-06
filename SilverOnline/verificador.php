<?php
//print_r($_GET);

//PRUEBAS.......
// $ClientID = "AQfqqbzkFvxShrOBEbcFqOB6uDjVlaFgIwpW2JEErSGMSQe1cCzMMHdhA6jYXqhnYGVzSsmI3BGYQF9G";
// $Secret = "EIRbeX9Yv6ze9ozLPagaHsMvOmvdw_MWK2kPH-CYmcGnov-RssU2sEh4KFHd2DZfpQQ28d1s-rd5TydZ";

// PRODUCCION
$ClientID = "AT7sSm-M7LOWsHJwVSnCH5ZUJ6HtjSawkqZzNhHuR8h9SA9Aw4Qv3YcKDX-RM6bGRsdLKi1bUXhGse4d";
$Secret = "ELdce2O3fIYshzowJyIlLN2qRX3x06tJHqJRaLYQUTO0gPfhzf-ryfsOUQyLT3rNXuCSBSx8njhhwi9X";

$login = curl_init("https://api.sandbox.paypal.com/v1/oauth2/token");

curl_setopt($login,CURLOPT_RETURNTRANSFER,TRUE);

curl_setopt($login,CURLOPT_USERPWD,$ClientID.":".$Secret);

curl_setopt($login,CURLOPT_POSTFIELDS,"grant_type=client_credentials");

$respuesta = curl_exec($login);

// print_r($respuesta);

$objRespuesta = json_decode($respuesta);

$accessToken = $objRespuesta->access_token;

// print_r($accessToken);

$venta = curl_init("https://api.sandbox.paypal.com/v1/payments/payment/".$_GET['paymentID']);

curl_setopt($venta,CURLOPT_HTTPHEADER,array("Content-Type: application/json","Authorization: Bearer ".$accessToken));

curl_setopt($venta,CURLOPT_RETURNTRANSFER,TRUE);

$respuestaVenta = curl_exec($venta);

//print_r($respuestaVenta);

$objDatosTransaccion = json_decode($respuestaVenta);

$state = $objDatosTransaccion->state;
$email = $objDatosTransaccion->payer->payer_info->email;
$total = $objDatosTransaccion->transactions[0]->amount->total;
$currrency = $objDatosTransaccion->transactions[0]->amount->currency;
// $custom = $objDatosTransaccion->transactions[0]->custom;

// echo $total;
// echo " , ";
// echo $state;

curl_close($venta);
curl_close($login);

if ($state == 'approved') {
  echo "<script>
                alert('Pago aprobado');
                window.location = 'index.php?vaciar=1';
    </script>";

}
else{
  echo "<script>
                alert('Ocurrio un error con el pago');
                window.location= 'index.php';
    </script>";
}

 ?>
