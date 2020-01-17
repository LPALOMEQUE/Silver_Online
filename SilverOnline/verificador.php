<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/vendor/autoload.php';

// region carrito_compra

session_start();
require_once "php/Conexion.php";
$con = conexion();
$aCarrito = array();
$sHTML = '';
$fPrecioTotal = 0;
$bagNumber = 0;
$TotalxArtGlobal = 0;
$costoEnvio = 0;
$totalP =0;
$prueba = 0;

if (isset($_POST['VACIAR'])) {
  unset($_SESSION['ID_USER']);
  unset($_SESSION['Email']);
  session_destroy();
}

//Vaciamos el carrito
if(isset($_GET['vaciar'])) {
  unset($_COOKIE['carrito']);
}

if (isset($_SESSION['ID_ARTICLES'])) {
  $bagNumber = count($_SESSION['ID_ARTICLES']);
  $ID_ARTICLES=$_SESSION['ID_ARTICLES'];
}
//Obtenemos los productos anteriores
// if(isset($_COOKIE['carrito'])) {
//   $aCarrito = unserialize($_COOKIE['carrito']);
// }

//Eliminamos articulos del carrito
// if(isset($_POST['ID']) && isset($_POST['DelArt']) && isset($_POST['Posicion'])) {
//
//   unset($aCarrito[$_POST['Posicion']]);
//   setcookie('carrito', serialize($aCarrito));
//   // echo ("posicion: ".$_POST['Posicion']);
//   // echo "   -----------------   ";
//   unserialize(urldecode($_COOKIE['carrito']));
//   // echo $_COOKIE['carrito'];
// }

//Anyado un nuevo articulo al carrito
// if(isset($_POST['ID']) && isset($_POST['NOMBRE']) && isset($_POST['PRECIO']) && isset($_POST['URL']) && isset($_POST['CANTIDAD']) && isset($_POST['Posicion'])) {
//   foreach ($aCarrito as $key => $value) {
//
//     if ($aCarrito[$_POST['Posicion']]['ID'] == $_POST['ID'])
//     {
//       $aCarrito[$_POST['Posicion']]['ID'] = $_POST['ID'];
//       $aCarrito[$_POST['Posicion']]['NOMBRE'] = $_POST['NOMBRE'];
//       $aCarrito[$_POST['Posicion']]['PRECIO'] = $_POST['PRECIO'];
//       $aCarrito[$_POST['Posicion']]['URL'] = $_POST['URL'];
//       $aCarrito[$_POST['Posicion']]['CANTIDAD'] = $_POST['CANTIDAD'];
//     }
//
//     else {
//       $iUltimaPos = count($aCarrito);
//       $aCarrito[$iUltimaPos]['ID'] = $_POST['ID'];
//       $aCarrito[$iUltimaPos]['NOMBRE'] = $_POST['NOMBRE'];
//       $aCarrito[$iUltimaPos]['PRECIO'] = $_POST['PRECIO'];
//       $aCarrito[$iUltimaPos]['URL'] = $_POST['URL'];
//       $aCarrito[$iUltimaPos]['CANTIDAD'] = $_POST['CANTIDAD'];
//     }
//
//   }
// }
if (isset($_SESSION['ID_ARTICLES'])) {

  foreach($ID_ARTICLES as $item){

    $sql = "SELECT PRICE FROM articles where ID_ARTICLES='$item[0]'";
    $result = mysqli_query($con,$sql);
    while($arti = mysqli_fetch_row($result)){
      $TotalxArtGlobal += $arti[0] * $item[1];
    }
  }
}

//Creamos la cookie (serializamos)
$iTemCad = time() + (60 * 60);
// setcookie('carrito', serialize($aCarrito), $iTemCad);

if (isset($_POST['MONTO'])) {
  setcookie('express',$_POST['MONTO'],$iTemCad);
  $costoEnvio = $_COOKIE['express'];
}

//Imprimimos el contenido del array
// foreach ($aCarrito as $key => $value) {
//   $sHTML .= '-> ' . $value['ID'] . ' ' . $value['NOMBRE'] . ' ' . $value['PRECIO'] . ' ' . $value['URL'] . ' ' . $value['CANTIDAD'] . ' <br>';
//   $fPrecioTotal += $value['PRECIO'];
//   $bagNumber = count($aCarrito);
//   $TotalxArtGlobal += $value['PRECIO'] * $value['CANTIDAD'];
// }


// endRegion carrito_compra


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
  $fecha = "  " .date("d") . "/" . date("m") . "/" . date("Y");

  //cabecera del pdf
  $mpdf->SetHTMLHeader('
  <div style="text-align: right; font-weight: bold;">
      ATREVETE A GANAR MAS...
  </div>');

  //pie del pdf
  $mpdf->SetHTMLFooter('
  <table width="100%">
      <tr>
          <td width="33%">{DATE j-m-Y}</td>
          <td width="33%" align="center">{PAGENO}/{nbpg}</td>
          <td width="33%" style="text-align: right;">'.$idventa.'</td>
      </tr>
  </table>');



  // almacenara todo el cuerpo html
  $dataHTML = '<link rel="stylesheet" href="style.css">';

  $dataHTML .= '<img src="img/core-img/silverEvolution.png"><br/><br/>';

  $dataHTML .= '<h1>Comprobante de Pedido</h1><br/><br/>';

  $dataHTML .= '<strong>Vendedor:</strong></center> <br/>';
  $dataHTML .= '' .$nombre .' '. $apellidoP .' '. $apellidoM . '<br/>';

  $dataHTML .= '<br/>'.'<strong>Información:</strong> <br/>';
  $dataHTML .= '<P ALIGN="justify">Su pedido ha sido confirmado,';
  $dataHTML .= 'en breve nos pondremos en contacto con usted.<br/><br/>';

  $dataHTML .= '<strong>Folio de pedido: </strong>#' . $idventa . '<br/>' ;
  $dataHTML .= '<strong>Fecha del pedido:</strong> '. $fecha . '<br/><br/><br/>';

  $dataHTML .= '
  <input type="text" class="inputcentrado" color="red" value="Artículo" size="60">
  <input type="text" class="inputcentrado" color="red" value="Precio Unitario" size="30">
  <input type="text" class="inputcentrado" color="red" value="Cantidad" size="30">
  <input type="text" class="inputcentrado" color="red" value="Precio x artículo" size="30">
  <br/>
  ';

  foreach($ID_ARTICLES as $item){

    $sql = "SELECT NAME_ART,URL_IMAGE,PRICE FROM articles where ID_ARTICLES='$item[0]'";

    $result = mysqli_query($con,$sql);
    while($arti = mysqli_fetch_row($result)){
      $TotalxArt = $arti[2] * $item[1];
    $dataHTML .=
    '

    <input type="text" name="txtNombre" value=" '.$arti[0] .'" size="60">
    <input type="text" name="txtPRECIO" value=" $'. number_format($arti[2],2) .'" size="30">
    <input type="text" name="txtCANTIDAD" value=" '.$item[1] .'" size="30">
    <input type="text" name="txtTotalArt" value=" $'. number_format($TotalxArt,2) .'" size="30">
    <br/>
    ';
  }
}

  $dataHTML .= '
  <input type="text" value="----------------------------------------------------------------------" size="60">
  <input type="text" value="--------------------------------" size="30">
  <input type="text" value="TOTAL" size="30">
  <input type="text" name="txtTotalArt" value=" $'. number_format($TotalxArtGlobal,2) .'" size="30">
  ';


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
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->SMTPSecure = 'tls';
    $mail->Port  = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('gerenciageneral@evolutionsilver.com');
    // $mail->addAddress('gerenciageneral@evolutionsilver.com');     // Add a recipient
    $mail->addAddress($sendData['EMAIL']);               // Name is optional
    // $mail->addReplyTo('gerenciageneral@evolutionsilver.com', 'Information');
    $mail->addCC('vgeneral736@gmail.com');
    // $mail->addCC('sistemas@evolutionsilver.com');
    // $mail->addBCC('bcc@example.com');

    // Attachments
    $mail->addStringAttachment($pdf, $sendData['idVenta'].'.pdf');

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Pedido: '. $sendData['idVenta'];
    $mail->Body    = 'Su pedido ha sido recibio, en breve nos pondremos en contacto para la validación de existencia.';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: ', $mail->ErrorInfo";
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  <!-- Title  -->
  <title>Siler - Evolution | Email</title>

  <!-- Favicon  -->
  <link rel="icon" href="img/core-img/favicon.ico">


  <!-- scripts LFPO -->
  <script src="js/jquery/jquery-2.2.4.min.js"></script>
  <script src="js/funciones.js"></script>
  <script src="librerias/alertify/alertify.js"></script>
</head>
<body>
  <?php echo $dataHTML ?>

</body>
</html>
