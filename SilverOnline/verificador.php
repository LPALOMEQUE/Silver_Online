<?php
print_r($_GET);

$ClientID = "AZouiQJ_ecOO2hGI0RYFOxJWCzA-4-xFIO8keTZA42Ss2DN2fXPHtAwKMItRHFJ9rP3JqtoHG1bJJDsy";
$Secret = "EAPCLNOyJznrllJ_Hei38HEkYmK5eku_-6BbeUXeo5v2X_UsHm0JhhrylloEiUx2rgAq-zp2QpEK7gVV";

$login = curl_init("https://api.sandbox.paypal.com/v1/oauth2/token");

curl_setopt($login,CURLOPT_RETURNTRANSFER,TRUE);

curl_setopt($login,CURLOPT_USERPWD,$ClientID.":".$Secret);

curl_setopt($login,CURLOPT_POSTFIELDS,"grant_type=client_credentials");

$respuesta = curl_exec($login);

// print_r($respuesta);

$objRespuesta = json_decode($respuesta);

$accessToken = $objRespuesta->access_token;

print_r($accessToken);

$venta = curl_init("https://api.sandbox.paypal.com/v1/payments/payment/".$_GET['paymentID']);

curl_setopt($venta,CURLOPT_HTTPHEADER,array("Content-Type: application/json","Authorization: Bearer ".$accessToken));

$respuestaVenta = curl_exec($venta);

print_r($respuestaVenta);












 ?>
