<?php    
    $_SESSION['programa']=32;
    $_SESSION['actCanjes']=1;
    $_SESSION['sant']=1;
    $_SESSION['trivia']=2;
    
    function numero($num)
    {
        $salida="<span>".number_format($num)."</span>";
        return $salida;
    }
    
    function ip_vis()
    {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } else {
            $ip = getenv("REMOTE_ADDR");
        }
        return $ip;
    }

	  function acento($palabra)
	  {
	    $letras = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú","ñ","Ñ","\"");
	    $cutes = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;","&ntilde;","&Ntilde;","");
	    $result = str_replace($letras, $cutes, $palabra);
	    return nl2br($result);
	  }
	  
	  function quitaAcento($palabra)
	  {
	    $letras = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú","ñ","Ñ","\"");
	    $cutes = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U","n","N","");
	    $result = str_replace($letras, $cutes, $palabra);
	    return nl2br($result);
	  }
?>