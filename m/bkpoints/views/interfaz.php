<?php
    $_SESSION['dirProd']="http://www.opisa.com/incentivos/";

	
	function muestra_ini()
	{
		$salida=v_ini();
		$respuesta = new xajaxResponse();
		$respuesta->addAssign("principal","innerHTML",$salida);
		return $respuesta;
	}
	
	function infoPart()
	{
		if ($_SESSION['id']=='demo')//Si inicia sesión la cuenta demo
		{
			$saldo=0;
		}else{
			$saldo=calculaSaldo();			
		}
		
		$salida="<table>
								<tr><td>NOMBRE:</td><td><b>".$_SESSION['nom']."</b></td></tr>
								<tr><td>C&Oacute;DIGO:</td><td><b>".$_SESSION['clave']."</b></td></tr>
								<tr><td>PUNTOS:</td><td><b>".number_format($saldo)."</b></td></tr>
						 </table>";
		return $salida;
	}

	function v_ini()
	{
        $salida=inicio();
		return $salida;
	}

	function v_premio()
	{
        $salida.="<div id='infoDerC'>
                    <center>
                        <a href='javascript:void(xajax_muestra_ini())'>
                            <table>
                                <tr>
                                    <td><img src='views/img/back.png'></td>
                                    <td class='mvfontWa'>Regresar</td>
                                </tr>
                            </table>
                        </a>
                    </center><br>";
            $salida.="<center>".infoPart()."</center>";        
      		$resu=catePremio();
            while($row=mysql_fetch_array($resu))
    		{
    			$salida.="<table>
                            <tr>
                                <td><img src='views/img/bg.gif'></td>
                                <td><a class='mvBtnMenu2' href='javascript:void(xajax_muestraProd(".$row['CodCategoria']."))'>".$row['nbCategoria']."</a></td>
                            </tr>
                          </table>";
    		}
            $salida.="</div>";

		$respuesta = new xajaxResponse();
		$respuesta->addAssign("principal","innerHTML",$salida);
		return $respuesta;
	}
    
    function productos($idCat)
    {
        $dir=$_SESSION['dirProd'];
        $_SESSION['cat']=$idCat;

        $resu=premios($idCat);
        
        
        $salida="<center>
                     <a href='javascript:void(xajax_v_premio())'>
                         <table>
                             <tr>
                                 <td><img src='views/img/back.png'></td>
                                 <td class='mvfontWa'>Regresar</td>
                             </tr>
                         </table>
                     </a><br>
                     <label class='txtbl'>Click sobre la imagen para agregar al canje.</label>
                </center><br>";
                
        while($row=mysql_fetch_array($resu))
        {
		  $codPremio=$row['codPremio'];

		  while(!(strlen($codPremio)>4))
		      $codPremio='0'.$codPremio;
              $Img="t".$codPremio.".jpg";

              $pts=$row['ValorPuntos'];
              $nom=$row['Nombre_Esp'];

              $salida.="
                    <div class='mvContProd'>
                        <div class='mvImgp'>";
                        if ($_SESSION['actCanjes']==1)
                        {
                            $salida.="<a href='javascript:void(xajax_agregaCarrito(\"".$codPremio."\",".$pts.",\"".$nom."\",\"".$Img."\"))'>
                                        <img src='".$dir.$Img."' width='95px' height='95px'></div>
                                      </a>";
                        }else{
                            $salida.="<img src='".$dir.$Img."' width='95px' height='95px'></div>";
                        }
                        $salida.="<div class='mvCod'>C&oacute;digo:".$codPremio."</div>
                        <div class='mvDesc'>".utf8_decode(ucwords(strtolower($nom)))."</div>
                        <div class='mvPuntos'>".number_format($pts)." puntos</div>
                        <div></div>
                    </div>";
        }
        return $salida;

    }

    function muestraProd($idCat)
    {
        $salida=productos($idCat);
        $respuesta = new xajaxResponse();
		$respuesta->addAssign("principal","innerHTML",$salida);
		return $respuesta;
    }

    function v_carrito()
    {
        $dir=$_SESSION['dirProd'];

                            $total=0;
                            $noArt=0;
                            $salida="<center>
                                        <table>
                                            <tr>
                                                <td><a class='mvBtnC' href='javascript:void(xajax_v_premio())'>Agregar</a></td>
                                                <td><a class='mvBtnC' href='javascript:void(xajax_confirmaCanje())'>Canjear</a></td>
                                            </tr>
                                        </table>
                                     </center><br>";
                            $salida.="<center><form id='frmCar' name='frmCar'><table>
                                        <tr>
                                            <td class='enc1 tdEnc'>Eliminar</td>
                                            <td class='enc1 tdEnc'>C&oacute;digo</td>
                                            <td class='enc1 tdEnc'>Imagen</td>
                                            <td class='enc4 tdEnc'>Cantidad</td>
                                            <td class='enc4 tdEnc'>Total</td>
                                        </tr>";

                            foreach($_SESSION["act_car"] as $key)
                            {
                                $salida.="<tr>
                                            <td class='enc1 tdCue'><center><a href='javascript:void(xajax_borraArt(\"".$key[0]."\"))'><img src='views/img/trashC.gif'></a></center></td>
                                            <td class='txtbl'><center>".$key[0]."</center></td>
                                            <td class='enc2 tdCue'><center><img src='".$dir.$key[4]."' width='60px' height='60px'></center></td>
                                            <td class='enc4 tdCue'><center><input class='inpCCAR' type='text id='".$key[0]."' name='".$key[0]."' value=".$key[1]." maxlength='2' onKeyPress=\"return numero(event)\"></center></td>
                                            <td class='txtbl'><center>".numero($key[2]*$key[1])." pts</center></td>
                                          </tr>";
                                $total+=$key[2]*$key[1];
                                $noArt+=$key[1];
                            }

                            $salida.="</table></form></center>";
           /*$salida.="
                    <div id='dvBt'>
                        <center>
                            <table>
                                <tr>
                                    <td><a class='botonCar' href='javascript:void(xajax_v_premio())'>Agregar Art&iacute;culo</a></td>
                                    <td><a class='botonCar' href='javascript:void(xajax_borraArt(0))'>Eliminar Carrito</td>
                                    <td><a class='botonCar' href='javascript:void(xajax_actualizaCarr(xajax.getFormValues(\"frmCar\")))'>Actualiza Carrito</td>
                                </tr>
                            </table>
                        </center>
                    </div>

                    <div id='dvcTot'>
                        <center>
                            <table>
                                <tr>
                                    <td class='tit'>N&uacute;mero de Artículos: <label class='titB'>".numero($noArt)."</label></td>
                                    <td class='tit'>Puntos Totales: <label class='titB'>".numero($total)." pts</label></td>";
                        if (count($_SESSION["act_car"])>0)
                        {
                          $salida.="<td class='tit'><center><a class='btnECar' href='javascript:void(xajax_confirmaCanje())'>Canjear</a></center></td>";
                        }
                      $salida.="</tr>
                            </table>
                        </center>
                    </div>

                  <div>";*/
        return $salida;
    }

    function agregaCarrito($id,$pts,$nom,$img)
    {
        if (!$_SESSION["act_car"])
        {
            $_SESSION["act_car"]=array();
        }

        $cantidad=1;
    	foreach($_SESSION["act_car"] as $key)
    	{
    		if ($id==$key[0])
    		{
    			$cantidad=$key[1]+1;
    		}
    	}
    	$_SESSION["act_car"][$id][0]=$id;
    	$_SESSION["act_car"][$id][1]=$cantidad;
    	$_SESSION["act_car"][$id][2]=$pts;
    	$_SESSION["act_car"][$id][3]=$nom;
    	$_SESSION["act_car"][$id][4]=$img;

        $salida=v_carrito();
        $respuesta = new xajaxResponse();
		$respuesta->addAssign("principal","innerHTML",$salida);
		return $respuesta;
    }

    function borraArt($id)
    {
       if ($id!=0)
       {
    		unset($_SESSION["act_car"][$id]);
       }else{
    		unset($_SESSION["act_car"]);
            $_SESSION["act_car"]=array();
       }
       $salida=v_carrito();
       $respuesta = new xajaxResponse();
	   $respuesta->addAssign("principal","innerHTML",$salida);
	   return $respuesta;
    }

    function actualizaCarr($form)
    {
      foreach($_SESSION["act_car"] as $key)
	   	{
				$_SESSION["act_car"][$key[0]][1]=$form[$key[0]];
	   	}

      $salida=v_carrito();
      $respuesta = new xajaxResponse();
	   	$respuesta->addAssign("info","innerHTML",$salida);
	   	return $respuesta;
    }

    function muestraCarrito()
    {
       $salida=v_carrito();
       $respuesta = new xajaxResponse();
	   	 $respuesta->addAssign("info","innerHTML",$salida);
	     return $respuesta;
    }

    function confirmaCanje()
    {
    	$salida="<div id='infoDer'>
                    <div id='infContCar'>
                            <center><table>
                                <tr>
                                    <td colspan='3' class='titN'>Contenido del Canje</td>
                                </tr>
                                <tr>
                                    <td>Artículo</td>
                                    <td>Cantidad</td>
                                    <td>Puntos</td>
                                </tr>";
                      foreach($_SESSION["act_car"] as $key)
                      {
                        $salida.="<tr>
                                    <td><center>".$key[0]."</center></td>
                                    <td><center>".$key[1]."</center></td>
                                    <td class='derecha'>".numero($key[2]*$key[1])."</td>
                                   </tr>";
																		$ptsTot+=$key[2]*$key[1];
                      }
                      $salida.="<tr>
                      						<td colspan=2><b>TOTAL:</b></td><td class='derecha'><b>".numero($ptsTot)."</b></td>";
                      $salida.="</tr>";

                  $salida.="</table></center>
                  </div>
                </div>";

        $salida.="</div>

				  <div id='infoIzq'>
          	<div id='infoDircan'>
	          	<span class='titN'>
								<center>Los premios serán enviados a la siguiente dirección, la cual corresponde a tu restaurante.</center>
							</span><br><br>
							<center>";
							
				$rowEmp=datos_empresa();
							
				$salida.="<center><table>
									<tr><td class='tdTtitulo'>Nombre:</td><td class='tdDatos'>".$rowEmp['NombreOficial']."</td></tr>
									<tr><td class='tdTtitulo'>Calle:</td><td class='tdDatos'>".$rowEmp['CalleNumero']."</td></tr>
									<tr><td class='tdTtitulo'>Colonia:</td><td class='tdDatos'>".$rowEmp['Colonia']."</td></tr>
									<tr><td class='tdTtitulo'>C.P.:</td><td class='tdDatos'>".$rowEmp['CP']."</td></tr>
									<tr><td class='tdTtitulo'>Ciudad:</td><td class='tdDatos'>".$rowEmp['Ciudad']."</td></tr>
									<tr><td class='tdTtitulo'>Estado:</td><td class='tdDatos'>".$rowEmp['Estado']."</td></tr>
									<tr><td class='tdTtitulo'>Pais:</td><td class='tdDatos'>".$rowEmp['Pais']."</td></tr>
								</table>								
							</center>
							
							<br><br>
							
							<center><table>
								<tr>
									<td><a class='btnECar' href='javascript:void(xajax_muestraCarrito())'>Regresar</a></td>
									<td><a class='btnECar' href='javascript:void(xajax_procesaCanje(".$ptsTot."))'>Enviar</a></td>
								</tr>
							</table></center>

				  	</div>
         <div>";

       $respuesta = new xajaxResponse();
	   $respuesta->addAssign("info","innerHTML",$salida);
	   return $respuesta;
    }

		function form_envio()
		{
			$s="<center>
						<span class='titN'>
							Ingrese correctamente los datos solicitados, ya que serán usados para el envío de sus productos.
						</span><br><br>
						<form id='dirCar' name='dirCar'><table>
							<tr>
								<td class='etq'>Tel&eacute;fono:</td><td><input class='inpDir' type='text' id='tel' name='tel'></td>
							</tr>
							<tr>
								<td class='etq'>Calle y Número:</td><td><input class='inpDir' type='text' id='ca' name='ca'></td>
							</tr>
							<tr>
								<td class='etq'>Colonia:</td><td><input class='inpDir' type='text' id='col' name='col'></td>
							</tr>
							<tr>
								<td class='etq'>Ciudad:</td><td><input class='inpDir' type='text' id='cd' name='cd'></td>
							</tr>
							<tr>
								<td class='etq'>Estado:</td><td><input class='inpDir' type='text' id='edo' name='edo'></td>
							</tr>
							<tr>
								<td class='etq'>C.P.</td><td><input class='inpDir' type='text' id='cp' name='cp'></td>
							</tr>
						</table></form>
					</center>";
			return $s;
		}

    function validaForm($form)
    {
       $res = new xajaxResponse();
       if ($form['tel']==""){
            $res->addAlert("Debe llenar el campo Teléfono");
            $res->addScript("document.getElementById('tel').focus()");
       }else if ($form['ca']==""){
            $res->addAlert("Debe llenar el campo Calle y Número");
            $res->addScript("document.getElementById('ca').focus()");
       }else if ($form['col']==""){
            $res->addAlert("Debe llenar el campo Colonia");
            $res->addScript("document.getElementById('col').focus()");
       }else if ($form['cd']==""){
            $res->addAlert("Debe llenar el campo Ciudad");
            $res->addScript("document.getElementById('cd').focus()");
       }else if ($form['edo']==""){
            $res->addAlert("Debe llenar el campo Estado");
            $res->addScript("document.getElementById('edo').focus()");
       }else if ($form['cp']==""){
            $res->addAlert("Debe llenar el campo C.P.");
            $res->addScript("document.getElementById('cp').focus()");
       }else{
            procesaCanje();
       }
	   return $res;
    }
  
  function procesaCanje($ptsTot)
  {
  	$res = new xajaxResponse();
  	
  	//if ($ptsTot > $_SESSION['saldo']);
  	if ($ptsTot > calculaSaldo())
  	{
  		$res->addAlert("El saldo actual es insuficiente para realizar este canje");
  	}else{
  		$rowEmp=datos_empresa();
	  	if($folC=insertaCanje($rowEmp))
	  	{
	  		if($ptsTot=insertaDetalle($folC))
	  		{
	  			actualizaSaldo($ptsTot);
			  	$salida=folio($folC);
			  	borraArt(0);  			
	  		}
	  	}
	  	$res->addAssign("info","innerHTML",$salida);
	  	$res->addAssign("infoPS","innerHTML",infoPart());
	  }
  	return $res;
  }
  
  function folio($folC)
  {
  	$s="<div class='dvComp'>
                        <br>
                        <br>
                        <br>
                        <br>
                        <center>
                            <span class='titN'>El Canje ha sido enviado.<br>
                            Conserve este n&uacute;mero de folio para posibles aclaraciones</span>
                            <br>
                            <br>
                            <span class='folio'>".$folC."</span><br><br>
                            <center><a class='btnECar' href='javascript:void(xajax_muestra_ini())'>Aceptar</a></center>
                        </center>
                      </div>";
  	return $s;
  }

	function menuReglas($opc)
	{
	    $salida="<div id='infoDer'>
                    ".reglas()."
				  </div>

				  <div id='infoIzq'>";
                    $salida.= desc_reglas(0);
        $salida.="</div>";
		//$salida1=desc_reglas(0);

        if ($opc==0){
            $dvReglas="dvLeeReglas";
        }else{
            $dvReglas="info";
        }

		$respuesta = new xajaxResponse();
		$respuesta->addAssign($dvReglas,"innerHTML",$salida);
		//$respuesta->addAssign("info","innerHTML",$salida1);
		return $respuesta;
	}

    function reglas()
	{
		$salida.="<div id='dReg'>
                    <br>
                    <center><table>
    					<tr><td><img src='views/img/bg.gif'></td><td class='tdPreg'><a class='btnReg' href='javascript:void(xajax_muestraReglas(0))'>¿QUIÉN PARTICIPA?</a></td></tr>
    					<tr><td><img src='views/img/bg.gif'></td><td class='tdPreg'><a class='btnReg' href='javascript:void(xajax_muestraReglas(1))'>PERIODO DE VIGENCIA</a></td></tr>
    					<tr><td><img src='views/img/bg.gif'></td><td class='tdPreg'><a class='btnReg' href='javascript:void(xajax_muestraReglas(2))'>MECÁNICA</a></td></tr>
    					<tr><td><img src='views/img/bg.gif'></td><td class='tdPreg'><a class='btnReg' href='javascript:void(xajax_muestraReglas(3))'>CONSULTA VÍA INTERNET</a></td></tr>
    					<tr><td><img src='views/img/bg.gif'></td><td class='tdPreg'><a class='btnReg' href='javascript:void(xajax_muestraReglas(4))'>ESTADO DE CUENTA</a></td></tr>
    					<tr><td><img src='views/img/bg.gif'></td><td class='tdPreg'><a class='btnReg' href='javascript:void(xajax_muestraReglas(5))'>RELACIONES COMERCIALES</a></td></tr>
    					<tr><td><img src='views/img/bg.gif'></td><td class='tdPreg'><a class='btnReg' href='javascript:void(xajax_muestraReglas(6))'>CANJE DE INCENTIVOS</a></td></tr>
    					<tr><td><img src='views/img/bg.gif'></td><td class='tdPreg'><a class='btnReg' href='javascript:void(xajax_muestraReglas(7))'>OTROS</a></td></tr>
                    </table></center>
				</div>";
		return $salida;
	}

    function muestraReglas($id)
    {
		$salida=desc_reglas($id);
		$respuesta = new xajaxResponse();
		$respuesta->addAssign("infoIzq","innerHTML",$salida);
		return $respuesta;
	}

	function desc_reglas($id)
	{
		$salida="<div id='contRegla'>
					<div id='titRegla'>";
					switch($id)
					{
						case 0:
							$salida.="¿QUIÉN PARTICIPA?";
						break;
						case 1:
							$salida.="PERIODO DE VIGENCIA";
						break;
						case 2:
							$salida.="MECÁNICA";
						break;
						case 3:
							$salida.="CONSULTA VÍA INTERNET";
						break;
						case 4:
							$salida.="ESTADOS DE CUENTA Y RESULTADOS";
						break;
						case 5:
							$salida.="RELACIONES COMERCIALES SOLIDAS";
						break;
						case 6:
							$salida.="REGLAMENTO PARA EL CANJE DE INCENTIVOS";
						break;
						case 7:
							$salida.="OTROS";
						break;
					}
		  $salida.="</div>
					<div id='infoRegla'>";
						$salida.=selectRegla($id);
		  $salida.="</div>
				 </div>
					";
		return $salida;
	}

    function menuConsultas()
    {
	    $salida="<div id='infoDer'>
                    ".consultas()."
				  </div>

				  <div id='infoIzq'>";
                    $salida.= saldo();
        $salida.="</div>";

        $respuesta = new xajaxResponse();
		$respuesta->addAssign("info","innerHTML",$salida);
		//$respuesta->addAssign("info","innerHTML",$salida1);
		return $respuesta;
    }

    function consultas()
    {
		$salida.="<div id='dReg'>
                    <br>
                    <center><table>
    					<tr><td><img src='views/img/bg.gif'></td><td class='tdPreg'><a class='btnReg' href='javascript:void(xajax_muestraConsulta(0))'>SALDOS</a></td></tr>
    					<tr><td><img src='views/img/bg.gif'></td><td class='tdPreg'><a class='btnReg' href='javascript:void(xajax_muestraConsulta(1))'>MOVIMIENTOS DESPUES DEL CORTE</a></td></tr>
    					<tr><td><img src='views/img/bg.gif'></td><td class='tdPreg'><a class='btnReg' href='javascript:void(xajax_muestraConsulta(2))'>ESTATUS DE CANJE</a></td></tr>
    					<tr><td><img src='views/img/bg.gif'></td><td class='tdPreg'><a class='btnReg' href='javascript:void(xajax_muestraConsulta(3))'>ESTADO DE CUENTA</a></td></tr>
                    </table></center>
				</div>";
		return $salida;
    }

    function muestraConsulta($id)
    {
		$salida=descConsulta($id);
		$respuesta = new xajaxResponse();
		$respuesta->addAssign("infoIzq","innerHTML",$salida);
		return $respuesta;
	}

    function descConsulta($id)
    {
        if ($id==0)
        {
            $salida=saldo();
        }else if($id==1){
            $salida=movimientos();
        }else if($id==2){
            $salida=sinf();
        }else if($id==3){
            $salida.=edoCuenta();
        }
        return $salida;

    }

	function saldo()
	{
	//INICIA FUNSION

		 $idPart=$_SESSION['id'];
	   	 $codPrograma=$_SESSION['programa'];
		 $codEmpresa=$_SESSION['emp'];
		 $codParticipante=$_SESSION['part'];
		 /////////////CONSULTAS//////////////
		 //OBTIENE PUNTOS DEPOSITADOS
		 $sSql="SELECT SUM(m.noPuntos) AS Puntos ";
		 $sSql.="FROM PartMovsRealizados m INNER JOIN Participante p ON p.idParticipante = m.idParticipante ";
		 $sSql.="WHERE p.idParticipante=".$_SESSION['id']." AND m.dsMov NOT LIKE 'CANJ%'";
         //echo $sSql;
		 $res = mysql_query($sSql) or die ('La consulta fallo-PO;: ' .mysql_error());
		 $puntos_dep = mysql_fetch_array($res);

		 //OBTIENE CANJES DEL MES
		 $sSql="SELECT SUM(m.noPuntos) AS Puntos ";
		 $sSql.="FROM PartMovsRealizados m INNER JOIN Participante p ON p.idParticipante = m.idParticipante ";
		 $sSql.="WHERE p.idParticipante = $idPart AND m.dsMov LIKE 'CANJ%'";
		 $res = mysql_query($sSql) or die ('La consulta fallo-CM;: ' .mysql_error());
		 $canjes = mysql_fetch_array($res);
		 //OBTIENE SALDOS
		 $sSql="SELECT SaldoActual,PuntosEspera,FechaLiberacion,feActual,SaldoMesAnterior,feAnterior ";
		 $sSql.="FROM Participante ";
		 $sSql.="WHERE idParticipante = $idPart";
		 $res = mysql_query($sSql) or die ('La consulta fallo-SO;: ' .mysql_error());
		 $saldos = mysql_fetch_array($res);
		 //OBTIENE SALDO AL CIERRE ANTERIOR
		 $sSql="SELECT Ant_MesDeposito,Ant_Canjeados,Ant_Ajustados,Ant_SaldoFinal,Ant_SaldoAnt ";
		 $sSql.="FROM PartMovimientos ";
		 $sSql.="WHERE codPrograma = $codPrograma AND codEmpresa = $codEmpresa AND codParticipante= $codParticipante";
		 $res = mysql_query($sSql) or die ('La consulta fallo-CA;: ' .mysql_error());
		 $CAnterior = mysql_fetch_array($res);
		 //OBTIENE CUOTAS
		 //Obiene mes cuotas de mes anterior
		 $mesAnt=substr($saldos['feAnterior'],5,2);
		 $mesAct=substr($saldos['feActual'],5,2);


		 //////////////TABLAS/////////////
		 //TABLA DE SALDO ACTUAL

			//formatea fecha
			$fechaAct=$saldos['feActual'];
			setlocale(LC_TIME, 'es_ES.UTF-8');
			$fechaAct=strftime('%d/%B/%Y', strtotime($fechaAct));
			$fechaAct=ucfirst($fechaAct);

		 $salida .= "<br><br><center><table align='center'>";
		 $salida .= "<tr><td class='titulo_tab' colspan=6>Saldo al d&iacute;a :".$fechaAct."</td></tr>";
		 $salida .= "<tr>";
		 $salida .= "<td class='tdborder'>";
		 $salida .= "Saldo al Corte";
		 $salida .= "</td>";
		 $salida .= "<td class='tdborder'>";
		 $salida .= "+Puntos Depositados";
		 $salida .= "</td>";
		 $salida .= "<td class='tdborder'>";
		 $salida .= "-Puntos Canjeados";
		 $salida .= "</td>";
		 $salida .= "<td class='tdborder'>";
		 $salida .= "Saldo a la Fecha";
		 $salida .= "</td>";
		 $salida .= "</tr>";

		 $salida .= "<tr>";
		 $salida .= "<td class='tdborderI'>";
		 $salida .= number_format($saldos['SaldoMesAnterior'],0);
		 $salida .= "</td>";
		 $salida .= "<td class='tdborderI'>";
		 $salida .= number_format($puntos_dep['Puntos'],0);
		 $salida .= "</td>";
		 $salida .= "<td class='tdborderI'>";
		 $salida .= number_format($canjes['Puntos'],0);
		 $salida .= "</td>";
		 $salida .= "<td class='tdborderI'>";
		 $salida .= number_format($saldos['SaldoActual'],0);
		 $salida .= "</td>";
		 $salida .= "</tr>";
		 $salida .= "</table></center>";

			$fechaAnt=$saldos['feAnterior'];
			setlocale(LC_TIME, 'es_ES.UTF-8');
			$fechaAnt=strftime('%B/%Y', strtotime($fechaAnt));
			$fechaAnt=ucfirst($fechaAnt);

		 $salida.="<br><br><br>
				  <center><label class='titB'>¡Burger King reconoce tu esfuerzo y te invita a seguir cumpliendo tus metas!</label> <br><br><br>
                   <label class='txtN'>Al cierre de cada mes Alsea , podrás encontrar en éste apartado tu resúmen mensual con los puntos y los factores por lo que los has acumulado, conócelos  y asegúrarte de que todos los puntos ganados aparezcan.</label></center>";

        return $salida;
	//FIN FUNSION
	}

	function movimientos()
	{
	//INICIA FUNSION
	$idPart=$_SESSION['id'];
	 $sSql = "SELECT feMov,noFolio,dsMov,noPuntos FROM PartMovsRealizados WHERE idParticipante = $idPart ";
	 $sSql .="ORDER BY feMov DESC";
	 $res = mysql_query($sSql) or die ('La consulta fallo-MOV;: ' .mysql_error());

	 if (mysql_num_rows($res)==0)
	 {
	   $salida.=sinf();
	 }else{
	   $salida .= "<br><br><table align=center>";
	   $salida.="<tr><td class='titulo_tab' colspan=4>Movimientos</td></tr>";
	   $salida .= "<tr>";
	   $salida .= "<td class='tdborder1'>Fecha</td>";
	   $salida .= "<td class='tdborder2'>Folio</td>";
	   $salida .= "<td class='tdborder3'>Descripci&oacute;n</td>";
	   $salida .= "<td class='tdborder2'>Puntos</td>";
	   $salida .= "</tr>";
	   while($movs=mysql_fetch_array($res))
	   {
		  $folio = $movs['noFolio'];
		  $fecha = $movs['feMov'];
		  $fecha=strftime('%d/%m/%Y', strtotime($fecha));
		  $desc = $movs['dsMov'];

		  $puntos = number_format($movs['noPuntos']);
		  $salida .= "<tr>";
		  $salida .= "<td class='tdborderI'>";
		  $salida .= "$fecha";
		  $salida .= "</td>";
		  $salida .= "<td class='tdborderI'>";
		  $salida .= "$folio";
		  $salida .= "</td>";
		  $salida .= "<td class='tdborderI'>";
		  $salida .= "$desc";
		  $salida .= "</td>";
		  $salida .= "<td class='tdborderI'>";
		  $salida .= "$puntos";
		  $salida .= "</td>";
		  $salida .= "</tr>";
	   }
	   $salida .= "</table>";
	 }

	  return $salida;
	//FIN FUNSION
	}

 	function edoCuenta()
	{
		//INICIA FUNSION
		$idPart=$_SESSION['id'];
		$codEmpresa=$_SESSION['emp'];
		$codPart=$_SESSION['part'];
		$programa=$_SESSION['programa'];

		$sSql="SELECT Mes,Comentario,SaldoAnterior,PuntosAjustados,MovsDiversos,SaldoNuevo,PuntosGanados,FactorAjuste,NumVendedores,FechaDeposito ";
		$sSql.="FROM PartEdoCta WHERE codPrograma = $programa AND codEmpresa = $codEmpresa AND codParticipante = $codPart";
		$res = mysql_query($sSql) or die ('La consulta fallo-ECTA;: ' .mysql_error());

		if (mysql_num_rows($res)==0)
		{
			$salida.=sinf();
		}else{
		     $edocta=mysql_fetch_array($res);

			 $mes=$edocta['Mes'];
			 setlocale(LC_TIME, 'es_ES.UTF-8');
			 $mes=strftime('%B/%Y', strtotime($mes));
			 $mes=ucfirst($mes);

					 $sdoAnt=number_format($edocta['SaldoAnterior'],0);
		   $ptsAju=number_format($edocta['PuntosAjustados'],0);
		   $movDiv=number_format($edocta['MovsDiversos'],0);
		   $sdoNvo=number_format($edocta['SaldoNuevo'],0);
		   $com=$edocta['Comentario'];

		   $salida.="<div id='infoIzqPS'><center><table width=100% align=center>";
		   $salida.="<tr><td style = 'width:60%;'>";
		   $salida.="<table class='tableborder'>";
		   $salida.="<tr><td class='titulo_tab'>ESTADO DE CUENTA DEL MES DE:</td>";
		   $salida.="<td class='tdborder'>$mes</td></tr>";
		   $salida.="<tr><td class='titulo_tab'>SALDO ANTERIOR:</td>";
		   $salida.="<td class='tdborder'>$sdoAnt</td></tr>";
		   $salida.="<tr><td class='titulo_tab'>M&Aacute;S PUNTOS DEL MES AJUSTADOS:</td>";
		   $salida.="<td class='tdborder'>$ptsAju</td></tr>";
		   $salida.="<tr><td class='titulo_tab'>M&AacuteS/MENOS MOVIMIENTOS DIVERSOS:</td>";
		   $salida.="<td class='tdborder'>$movDiv</td></tr>";
		   $salida.="<tr><td class='titulo_tab'>IGUAL A SALDO NUEVO:</td>";
		   $salida.="<td class='tdborder'>$sdoNvo</td></tr>";
		   $salida.="</table><br>";
		   $salida.="</td><td style = 'width:40%;'>";
		   $salida.="<center><table>";
		   $salida.="<tr><td width=100% style='text-align:justify;font-size:12px;'>".utf8_decode($com)."</td></tr>";
		   $salida.="</table></center>";
		   $salida.="</td></tr></table></center>";

		   $sSql ="SELECT FechaFactura,NumFactura,Marca,codProducto,UnidDefinidas,Puntos ";
		   $sSql.="FROM PartEdoCtaDet WHERE codPrograma = $programa AND codEmpresa=$codEmpresa AND codParticipante = $codPart ";
		   $sSql.="ORDER BY idDetalle";
		   $res = mysql_query($sSql) or die ('La consulta fallo-ECTAD;: ' .mysql_error());

		   $salida.="<center><table class='tableborder'>";
		   $salida.="<tr><td class='titulo_tab'>Periodo</td><td class='titulo_tab'># de Control</td><td class='titulo_tab'>Descripci&oacute;n</td><td class='titulo_tab'>Puntos del Mes</td></tr>";
		   while ($ctadet=mysql_fetch_array($res))
		   {
			  $peri=$ctadet['FechaFactura'];
			  setlocale(LC_TIME, 'es_ES.UTF-8');
			  $peri=strftime('%d/%m/%Y', strtotime($peri));
			  $peri=ucfirst($peri);
			  $ncontrol=$ctadet['NumFactura'];
			  $desc=$ctadet['Marca'];
			  $puntos=number_format($ctadet['Puntos'],0);
			  $salida.="<tr><td class='tdborderI1'>$peri</td><td class='tdborderI1'>$ncontrol</td><td class='tdborderI1'>".utf8_decode($desc)."</td><td class='tdborderI1'>$puntos</td></tr>";
		   }
			   $salida.="</table>";
			   $salida.="</td>";
			   $salida.="</table></center></div>";
		}
		return $salida;
	}

 	function sinf()
	{
		$salida="<div id='sinInfo'>
					No hay información para mostrar
				 </div>";
		return $salida;
	}

    function muestraTrivias()
    {
    	  $noPreg=0;
        $sql="SELECT * FROM t4InTrivias WHERE activa=1 AND codPrograma =".$_SESSION['programa']." ORDER BY id";
        $res=mysql_query($sql);
        $salida="<div id='dvTri'><form id='frmTrivia' name='frmTrivia'>";
            if (mysql_num_rows($res)>0)
            {
            	if (verificaTrivia()==false)
            	{
	        				$noPreg=1;
	                while($row=mysql_fetch_array($res))
	                {
	                    if($row['tipo']==1)
	                    {
	                        $salida.="<div class='dvPreg'>
	                                    ".$noPreg.".- ".$row['pregunta']."
	                                  </div>";
	                        $salida.="<div class='dvResp'>
	                                  <textarea id='".$row['id']."' name='".$row['id']."' class='txtAresp'></textarea>
	                                  </div>";
	                    }else if ($row['tipo']==2){
	                        $salida.="<div class='dvPreg'>
	                                    ".$row['pregunta']."
	                                  </div>";
	                        $salida.="<div class='dvResp'>
	                                    <input type='radio' value='1'><label class='respN'>".$row['r1']."</label><br>
	                                    <input type='radio' value='2'><label class='respN'>".$row['r2']."</label><br>
	                                    <input type='radio' value='3'><label class='respN'>".$row['r3']."</label>
	                                </div>";
	                    }
	                    $salida.="<div class='dvEspacio'></div>";
	                    $noPreg+=1;
	                }
              }else{
              	$salida.="<br><br><br><br><br><br><center><span class='msgTr'>No hay trivias activas</span></center>";
              }
            }else{
                $salida.="<br><br><br><br><br><br><center><span class='msgTr'>No hay trivias activas</span></center>";
            }
        $salida.="</form></div>";

        $salida.="<div id='dvQue'>
                    <br>
                    <center>
                    	<img src='views/img/que.jpg'><br>";
              if ($noPreg > 0)
              {
            		$salida.="<a class='botonCar' href='javascript:void(xajax_guardaTrivia(xajax.getFormValues(\"frmTrivia\"),document.frmTrivia.length))' onClick=\"return confirm('La trivia será enviada. ¿Desea continuar?')\">Enviar Trivia</a>";
            	}
          $salida.="</center>
                  </div>";

			$respuesta = new xajaxResponse();
			$respuesta->addAssign("info","innerHTML",$salida);
			return $respuesta;
    }

    function validaLogin($form)
    {
        $resp = new xajaxResponse();
        if ($form['cve']=="" || $form['pwd']=="")
        {
            $resp->addAlert("Los datos ingresados son incorrectos. \n Intente nuevamente");
            $resp->addScript("document.getElementById('cve').focus();");
        }else if($form['cve']=="demo" && $form['pwd']=="bkpoints"){
        		$_SESSION['login']=1;
        		$_SESSION['id']='demo';
            $salida=inicio();
            $resp->addAssign("principal","innerHTML",$salida);
        }else if(($row=login($form))==false){
            $resp->addAlert("Los datos ingresados son incorrectos. \n Intente nuevamente");
            $resp->addScript("document.getElementById('cve').focus();");
        }else if(verificaPassword($row['idParticipante'])==2 && $_SESSION['chPass']==0){
            $resp->addAlert("Los datos ingresados son incorrectos. \n Intente nuevamente");
            $resp->addScript("document.getElementById('cve').focus();");
        }else if(verificaPassword($row['idParticipante'])==1){
            $salida=actualizaPassword();
            $resp->addAssign("dvmLogin","innerHTML",$salida);
        }else{
            $_SESSION['clave']=$form['cve'];
            $_SESSION['id']=$row['idParticipante'];
            $_SESSION['cargo']=strtolower($row['Cargo']);
            $_SESSION['emp']=$row['codEmpresa'];
        		$_SESSION['part']=$row['codParticipante'];;
        		$_SESSION['nom']=$row['PrimerNombre']." ".$row['ApellidoPaterno'];
        		if ($_SESSION['sant']==0)
                {
                    $_SESSION['saldo']=$row['saldoActual'];
                }else{
                    $_SESSION['saldo']=saldoAnoPass();
                }
        		$_SESSION['login']=1;
            $salida=inicio();
            $resp->addAssign("principal","innerHTML",$salida);
        }
		return $resp;
    }

    function actualizaPassword()
    {
        $salida="<div id='logoLogin'><img src='views/img/bkT.png'></div>";
        $salida.="<div id='dvChP'>
                    <br><br><br><br>
                    <center>
                        Debe actualizar su contraseña.
                    </center><br>
                    <center><form id='frmAct' name='frmAct' method='post'><table>
                        <tr>
                            <td class='txtB'>Nueva Contraseña</td><td><input id='pwd' name='pwd' class='inp' type='password' maxlength=8></td>
                        </tr>
                        <tr>
                            <td class='txtB'>Confirmar:</td><td><input id='cpwd' name='cpwd' class='inp' type='password' maxlength=8></td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                <center>
                                    <input type='checkbox' id='chkRl' name='chkRl' value='1'>He leído y estoy de acuerdo con el <a href='javascript:void(xajax_leeReglas(0))'>Reglamento</a>
                                </center>
                            </td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td colspan=2><center><a class='btnECar' href='javascript:void(xajax_validaAct(xajax.getFormValues(\"frmAct\")))'>Aceptar</a></center></td>
                        </tr>

                    </table></form></center>
                </div>";
        return $salida;
    }

    function leeReglas()
    {
        $salida.="<div id='dvLreglas'>
                    <div id='infoDer'>
                       ".reglas();
              $salida.="<div id='vbBtnC'><center><a class='btnECar' href='javascript:void(cierraMensaje())'>Cerrar</a></center></div>";
          $salida.="</div>";

          $salida.="<div id='infoIzq'>";
                    $salida.= desc_reglas(0);
          $salida.="</div>
                  <div>";

        $resp = new xajaxResponse();
		$resp->addAssign("dvSolid","innerHTML",$salida);
        $resp->addScript("Mensaje(1);");
		return $resp;
    }

    function validaAct($form)
    {
        $resp = new xajaxResponse();
        if ($form['pwd']=="")
        {
            $resp->addAlert("Debe ingresar una contraseña");
            $resp->addScript("document.getElementById('pwd').focus();");
        }else if($form['pwd']!=$form['cpwd']){
            $resp->addAlert("Los campos no coinciden. \n Confirme nuevamente");
            $resp->addScript("document.getElementById('cpwd').focus();");
        }else if(!isset($form['chkRl'])){
            $resp->addAlert("Debe aceptar las reglas, de no hacerlo, el acceso al sitio le será denegado.");
        }else{
            if (gPass($form)==true){
                $salida.=acceso();
                $resp->addAssign("principal","innerHTML",$salida);
            }else{
                $resp->addAlert("Ha ocurrido un error al actualizar el password");
            }
        }
        return $resp;
    }

    function stCanjes()
    {
        
        $s.="<div id='infoDerC'>
                    <center>
                        <a href='javascript:void(xajax_muestra_ini())'>
                            <table>
                                <tr>
                                    <td><img src='views/img/back.png'></td>
                                    <td class='mvfontWa'>Regresar</td>
                                </tr>
                            </table>
                        </a>
                    </center>";
        $s.="<center>
                <table>
                    <tr><td colspan='6' align='center' class='mvtdC'>Pendientes</td></tr>
                    <tr>
                        <td class='mvtdC'>Folio</td>
                        <td class='mvtdC'>Premio</td>
                        <td class='mvtdC'>Cantidad</td>
                        <td class='mvtdC'>Puntos</td>
                        <td class='mvtdC'>Status</td>
                        <td class='mvtdC'>No.Rastreo</td>
                    </tr>
                </table>
             <center>";
        $s.="<br><br>";     
        $s.="<center>
                <table>
                    <tr><td colspan='6' align='center' class='mvtdC'>Procesados</td></tr>
                    <tr>
                        <td class='mvtdC'>Folio</td>
                        <td class='mvtdC'>Premio</td>
                        <td class='mvtdC'>Cantidad</td>
                        <td class='mvtdC'>Puntos</td>
                        <td class='mvtdC'>Status</td>
                        <td class='mvtdC'>No.Rastreo</td>
                    </tr>
                </table>
             <center>";
        return $s;
    }

    function muestra_canjes()
    {
        $salida=stCanjes();
    	$respuesta = new xajaxResponse();
    	$respuesta->addAssign("principal","innerHTML",$salida);
    	return $respuesta;
    }

    function salir()
    {
        unset($_SESSION['clave']);
        unset($_SESSION['id']);
        unset($_SESSION['cargo']);
        unset($_SESSION['emp']);
        unset($_SESSION['part']);
        unset($_SESSION['nom']);
        unset($_SESSION['saldo']);
        unset($_SESSION['login']);
        unset($_SESSION['chPass']);
		$salida=acceso();

		$respuesta = new xajaxResponse();
		$respuesta->addAssign("principal","innerHTML",$salida);
		return $respuesta;
    }
?>