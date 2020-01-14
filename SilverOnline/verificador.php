<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/vendor/autoload.php';


$nombre = $_GET['NOMBRE'];
$apellidoP = $_GET['apellidoP'];
$apellidoM = $_GET['apellidoM'];
$calle = $_GET['CALLE'];
$numCalle = $_GET['numCalle'];
$cp = $_GET['CP'];
$ciudad = $_GET['CIUDAD'];
$estado = $_GET['ESTADO'];
$cel = $_GET['CEL'];
$emailUser = $_GET['EMAIL'];
$paymentToken = $_GET['paymentToken'];
$paymentID = $_GET['paymentID'];

//print_r($_GET);

// ----------------------------------------------------------------------------------------------------------------
//PRUEBAS.......
$ClientID = "AQfqqbzkFvxShrOBEbcFqOB6uDjVlaFgIwpW2JEErSGMSQe1cCzMMHdhA6jYXqhnYGVzSsmI3BGYQF9G";
$Secret = "EIRbeX9Yv6ze9ozLPagaHsMvOmvdw_MWK2kPH-CYmcGnov-RssU2sEh4KFHd2DZfpQQ28d1s-rd5TydZ";

// PRODUCCION
// $ClientID = "AWkFACdq0h4aeDpN-yfYhlk4FxnpGYbLmX6rcVA5qo3N2ErxCp3GrPyQ1sWIwCR2EH6UubCHJfNnH84I";
// $Secret = "EDiXuARlbHy0D8LdGLpOTOFO7YLdrqk9oapqR2mmQxJfq9DIYESd84N7DyZq6LVr2Wnz-yRJVbXcmtsb";
// ----------------------------------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------------------------------
//PRUEBAS.......
$login = curl_init("https://api.sandbox.paypal.com/v1/oauth2/token");

//PRODUCCION
// $login = curl_init("https://api.paypal.com/v1/oauth2/token");
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
$venta = curl_init("https://api.sandbox.paypal.com/v1/payments/payment/".$_GET['paymentID']);

//PRODUCCION
// $venta = curl_init("https://api.paypal.com/v1/payments/payment/".$_GET['paymentID']);
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

  // instanci de pdf
  $mpdf = new \Mpdf\Mpdf();

  // almacenara todo el cuerpo html
  $dataHTML = '';

  $dataHTML .= '<h1>Comprobante de Pedido</h1>';

  $dataHTML .= '<strong>Vendedor</strong>' . $nombre .' '. $apellidoP .' '. $apellidoM . '<br/>';

  $dataHTML .= '<br/>'.'<strong>Mensaje</strong>' . 'Su pedido: <strong>' . $idventa . '</strong> ha sido confirmado.' ;

  $mpdf -> WriteHTML($dataHTML);

  //output
  $pdf = $mpdf -> Output('','S');

  //obtener informacion
  $sendData = [
    'NOMBRE' => $nombre,
    'apellidoP' => $apellidoP,
    'apellidoM' => $apellidoM,
    'CALLE' => $calle,
    'numCalle' => $numCalle,
    'CP' => $cp,
    'CIUDAD' => $ciudad,
    'ESTADO' => $estado,
    'CEL' => $cel,
    'EMAIL' => $emailUser,
    'idVenta' => $idventa
  ];

  sendEmail($pdf, $sendData);



  echo "

  <script type='text/javascript'>
  // window.location= 'index.php?vaciar=1';
  alert('Pago aprobado');


  </script>";

}
else{
  echo "<script>
  // window.location= 'index.php';
  alert('Ocurrio un error con el pago');
  </script>";
}
function sendEmail($pdf, $sendData){

  // Instantiation and passing `true` enables exceptions
  $mail = new PHPMailer(true);

  try {
    //Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'gerenciageneral@evolutionsilver.com';                     // SMTP username
    $mail->Password   = 'Balbucerito2016';                               // SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->SMTPSecure = 'tls';
    $mail->Port  = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('gerenciageneral@evolutionsilver.com');
    // $mail->addAddress('gerenciageneral@evolutionsilver.com');     // Add a recipient
    $mail->addAddress('fer18092105@icloud.com');               // Name is optional
    // $mail->addReplyTo('gerenciageneral@evolutionsilver.com', 'Information');
    // $mail->addCC('vgeneral736@gmail.com');
    // $mail->addBCC('bcc@example.com');

    // Attachments
    $mail->addStringAttachment($pdf, $sendData['idVenta'].'.pdf');

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: ', $mail->ErrorInfo";
  }
}
?>
