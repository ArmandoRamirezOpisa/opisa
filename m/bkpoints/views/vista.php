<?php
	//Creado por: SIDEM Enero 2011
	include("../include/xajax/xajax.inc.php");
	require "interfaz.php";
	require "reglas.php";
	$xajax=new xajax(); 
	$xajax->setCharEncoding('ISO-8859-1');
	$xajax->decodeUTF8InputOn();
	    
function inicio()
	{
		$salida.= "<center>
                        <img src='views/img/bkT.gif'><br>
                        <label class='mvMsg1'>¡Burger King reconoce tu esfuerzo<br> 
                                              y te invita a seguir cumpliendo tus metas!
                        </label><br><br>
                        <CENTER>".infoPart()."</CENTER><br>
                        <table>
                            <tr>
                                <td>
                                    <a class='mvBtnMenu' href='javascript:void(xajax_muestra_canjes())'>
                                        <center><table class='mvtbl'><tr><td class='mvTd1'>Mis Canjes</td><td class='mvTd2'><img src='views/img/ca.png'></td></tr></table></center>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a class='mvBtnMenu' href='javascript:void(xajax_v_premio())'>
                                        <center><table class='mvtbl'><tr><td class='mvTd1'>Premios</td><td class='mvTd2'><img src='views/img/sc.png'></td></tr></table></center>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a class='mvBtnMenu' href='#'>
                                        <center><table class='mvtbl'><tr><td class='mvTd1'>Trivias</td><td class='mvTd2'><img src='views/img/tr.png'></td></tr></table></center>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a class='mvBtnMenu' href='javascript:void(xajax_salir())' onClick=\"return confirm('Abandonara el sitio. ¿Desea continuar?')\"'>
                                        <center><table class='mvtbl'><tr><td class='mvTd1'>Salir</td><td class='mvTd2'><img src='views/img/sa.png'></td></tr></table></center>
                                    </a>
                                </td>
                            </tr>
                        </table>
                   </center>";
        return $salida;

	}

	function acceso()
	{
	   $salida.="
                        <div id='logoLogin'><img src='views/img/bkT.gif'></div>
                        <div id='dviLogin'><br><br><br><br>
                            <center><form id='frmLogin' name='frmLogin' method='post'><table>
                                <tr>
                                    <td class='txtB'>Clave:</td><td><input id='cve' name='cve' class='inp' type='text' maxlength=8></td>
                                </tr>    
                                <tr>
                                    <td class='txtB'>Contrase&ntilde;a:</td><td><input id='pwd' name='pwd' class='inp' type='password' maxlength=8></td>
                                </tr> 
                                <tr><td>&nbsp;</td></tr>  
                                <tr>
                                    <td colspan=2><center><a class='btnECar' href='javascript:void(xajax_validaLogin(xajax.getFormValues(\"frmLogin\")))'>Aceptar</a></center></td>
                                </tr> 
                            </table></form></center>
                        </div>
                         

                 ";
       return $salida;
	}
	
	//REGISTRA FUNSIONES
	$xajax->registerFunction("muestra_ini");
	$xajax->registerFunction("v_premio");
	$xajax->registerFunction("muestraProd");
	$xajax->registerFunction("v_carrito");
	$xajax->registerFunction("agregaCarrito");
	$xajax->registerFunction("borraArt");
	$xajax->registerFunction("actualizaCarr");
	$xajax->registerFunction("muestraCarrito");
	$xajax->registerFunction("confirmaCanje");
	$xajax->registerFunction("validaForm");
	$xajax->registerFunction("menuReglas");
	$xajax->registerFunction("muestraReglas");
	$xajax->registerFunction("menuConsultas");
	$xajax->registerFunction("muestraConsulta");
	$xajax->registerFunction("muestraTrivias");
  $xajax->registerFunction("validaLogin");
  $xajax->registerFunction("leeReglas");
  $xajax->registerFunction("validaAct");
  $xajax->registerFunction("salir");
  $xajax->registerFunction("procesaCanje");
  $xajax->registerFunction("guardaTrivia");
  $xajax->registerFunction("muestra_canjes");

	//El objeto xajax tiene que procesar cualquier petición
	$xajax->processRequests();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
 <HEAD>
  <TITLE> BK POINTS </TITLE>
  <META NAME="Generator" CONTENT="EditPlus">
  <META NAME="Author" CONTENT="">
  <META NAME="Keywords" CONTENT="">
  <META NAME="Description" CONTENT="">
  <link rel="stylesheet" type="text/css" href="views/estilo/estilo.css" />
   <?
  //ABRE PHP
    //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
    //$xajax->printJavascript("../include/xajax/");
    $xajax->printJavascript("../include/xajax/")
  ?>
  
  <script language="javascript">
  		function Mensaje(acc){
			var div;
            var divS;
			div=document.getElementById('dvTrans');
			divS=document.getElementById('dvSolid');
            if (acc==1)
            {
			     div.style.display="block";
			     divS.style.display="block";
            }else{
			     div.style.display="none";
			     divS.style.display="none";	                
            }		
		}

		function cierraMensaje(){
			var div;
            var divS;
			div=document.getElementById('dvTrans');
			divS=document.getElementById('dvSolid');
            
			div.style.display="none";
            divS.style.display="none";	
		}
		
		function numero(evt)
		{
			//asignamos el valor de la tecla a keynum
			if(window.event){// IE
			keynum = evt.keyCode;
			}else{
			keynum = evt.which;
			}
			//comprobamos si se encuentra en el rango
			if(keynum>47 && keynum<58 || keynum==8){
			return true;
			}else{
			return false;
			}
		}
  </script>
 </HEAD>

	 <BODY>   
        <div id='dvTrans'></div> 
        <div id='dvSolid'></div>  
	 </BODY>

 </HTML>