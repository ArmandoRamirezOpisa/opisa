<?php
    date_default_timezone_set('America/Tegucigalpa');
    session_start();
	include ('../include/xajax/xajax.inc.php');
	include ('../include/local_dsn.php');
	include ('../include/dsn.php');
	//include('include/excelwriter.inc.php');  
	//GLOBALES
	$numReg=0;
	///////////////////// 
	//INSTANCIAMOS EL OBJETO DE LA CLASE AJAX
	$xajax=new xajax(); 
	$xajax->setCharEncoding('utf8');
	//$xajax->decodeUTF8InputOn();
	

	function login()
	{
		$salida="<div id='encLog'>";
		$salida.="</div>";

		$salida.="<div id='infoLog'>";
		$salida.="<table align='center'><form id='acceso'><tr>
									<tr>
										<td colspan ='2'><img src='img/logoOPI.jpg'></td>
									</tr>
									<td class='l_form'>Usuario:</td><td><input class='inpFormLog' type='text' maxlength='15' name='usr'></td></tr>
									<tr><td class='l_form'>Contrase&ntilde;a:</td><td><input class='inpFormLog' type='password' maxlength='15' name='pwd'></td></tr>
									<tr><td colspan=2>&nbsp;</td></tr>
									<tr><td colspan='2' align='center'><table><tr><td><a class='btn' href='javascript:void(xajax_validaLogin(xajax.getFormValues(\"acceso\")))'>Aceptar</a></td></tr></table></td></tr>
							</form></table>";
		$salida.="</div>";
		$salida.="<div id='pielog'>";
		$salida.="</div>";

		return $salida;
	}

	function validaLogin($form)
	{
	    $respuesta = new xajaxResponse();
		if($form['usr']=='' || $form['pwd']=='')
		{
			$respuesta->addALert("Los campos son obligatorios");
		}else{
			$sSql="SELECT id,usr,nombre,nivel FROM t6IUsuarios WHERE usr = '".$form['usr']."' AND pwd='".$form['pwd']."'";  
			$res=mysql_query($sSql) or die ($salida="La consulta Fallo" . mysql_error());
			if (mysql_num_rows($res)==0)
			{
                $respuesta->addALert("El usuario o contras�a es incorrecto");
			}else{
				$row=mysql_fetch_array($res);
				$_SESSION['act_log']=1;
				$_SESSION['nombre']=$row['nombre'];

				$salida=inicio();
				$sel_div="contenedor";
                $respuesta->addAssign($sel_div,"innerHTML",$salida);
			}
		}
		return $respuesta;
	}

	function regresaInicio()
	{
		$salida=" ";
		
		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("info","innerHTML",$salida);
		return $respuesta;
	}

	function inicio()
	{
		$salida.="<div id='encabezado'>
					<div id='logo'>
						<img class='imgLogo' src='img/logoOPI.jpg'>	
					</div>
					<div id='encInfo'>".date("d / m / Y")."<br>						
						".$_SESSION['nombre']."
					</div>
				  </div>
				  <div id='menu'>";
			$salida.=iniMenu(0);
		$salida.="</div>
				  <div id='barra_tit'>";
					if($_SESSION['nomProg']){
						$salida.=$_SESSION['nomProg'];
					}					
	    $salida.="</div>
				  <div id='info'>
				  </div>
				  <div id='pie'>
					Operadora de Programas de Incentivos S.A de C.V
				  </div>";
		return $salida;
	}

	function imprimeMenu($programa)
	{		
		$sql="SELECT Nombre FROM Programa WHERE codPrograma =".$programa;
		$res=mysql_query($sql) or die ("La consulta Fallo - CProg".mysql_error());
		$row=mysql_fetch_array($res);
		$_SESSION['nomProg']=$row['Nombre'];

		$_SESSION['programa']=$programa;
		$salida=iniMenu($programa);
		$info=" ";
		$titulo=$_SESSION['nomProg'];
		
		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("menu","innerHTML",$salida);
		$respuesta->addAssign("info","innerHTML",$info);
		$respuesta->addAssign("barra_tit","innerHTML",$titulo);
		return $respuesta;
	}

	function iniMenu($programa)
	{
		$arrayProgramas=array(41,43);
		$cl="";
		if($_SESSION['programa']){
			$cl="onClick=\"return confirm('Esta apunto de cambiar de programa. �Desea continuar?')\"";
		}		
		$salida.="<div class='menu'>
						<ul>
							<li>
								<a href='#'>Inicio</a>
							</li>
							<li>
								<a href='#'>Programas</a>
									<ul>";
										foreach($arrayProgramas as $key => $val){
											$sql="SELECT nombre FROM Programa WHERE codPrograma =".$val;
											$res=mysql_query($sql) or die  ("Error al consultar lista de programas ".mysql_error());
											$row=mysql_fetch_array($res);
			
											$salida.="<li>
														<a href='javascript:void(xajax_imprimeMenu(".$val."))' ".$cl.">".$row['nombre']."</a>
													  </li>";
										}										
						 $salida.="</ul>";
				 $salida.="</li>";
							
							if (!$_SESSION['programa']){
								$salida.=genMenu($programa);
							}else{
								$salida.=genMenu($_SESSION['programa']);
							}
							

							$salida.="<li>
								<a href='#'>Salir</a>
								<ul>";
								if ($_SESSION['programa'] != 0){
								$salida.="<li><a href='javascript:void(xajax_salir(1))' onClick=\"return confirm('Saldra del programa. �Desea continuar?')\">Cerrar Programa</a></li>";
								}
								$salida.="<li><a href='javascript:void(xajax_salir(2))' onClick=\"return confirm('�Desea cerrar su sesi�n?')\">Cerrar Sesion</a></li>
								</ul>
							</li>
						</ul>
				</div>";
		return $salida;
	}


	function genMenu($programa)
	{
		if ($programa==30)
		{
			$salida="<li>
						<a href='#'>Participantes</a>
						<ul>";
					//$salida."<li><a href='javascript:void(xajax_impCapParticipante())'>Nuevo</a></li>";
			        $salida.="<li><a href='javascript:void(xajax_impConsParticipante())'>Consultar</a></li>
						</ul>
					 </li>
					 <li>
						<a href='#'>Tickets</a>
							<ul>
								<li><a href='javascript:void(xajax_impConsTickets())'>Consultar</a></li>
							</ul>
					 </li>
					 <li>
						<a href='#'>Canjes</a>
							<ul>
								<li><a href='javascript:void(xajax_impConsCanjes())'>Consultar</a></li>
							</ul>
					 </li>";
		}else if ($programa ==32){
			$salida="<li>
						<a href='#'>Participantes</a>
						<ul>";
      $salida.="<li><a href='javascript:void(xajax_impConsParticipante())'>Consultar</a></li>
						</ul>
					 </li>			
					 <li>
						<a href='#'>Canjes</a>
							<ul>
								<li><a href='javascript:void(xajax_impConsCanjes())'>Consultar</a></li>
							</ul>
					 </li>			
					 <li>
						<a href='#'>Trivias</a>
							<ul>
								<li><a href='javascript:void(xajax_creaTrivia())'>Crear</a></li>
								<li><a href='javascript:void(xajax_consultaTrivia(2))'>Consultar</a></li>
							</ul>
					 </li>";		
		}else if ($programa==33){
			$salida.="<li><a href='#'>Canjes</a>
						<ul>
							<li><a href='javascript:void(xajax_impConsCanjes())'>Consultar</a></li>
						</ul>
					  </li>
					  <li><a href='#'>Quinielas</a>
						<ul>
							<li><a href='javascript:void(xajax_impConsCanjes())'>Consultar</a></li>
						</ul>
					  </li>";
		}else if($programa == 41){
            $salida .= "
					 <li>
						<a href='#'>Canjes</a>
							<ul>
								<li><a href='javascript:void(xajax_impConsCanjes())'>Consultar</a></li>
							</ul>
					 </li>";    
        }
		
		return $salida;
	}
	
	function impCapParticipante()
	{
		$salida=participantes();

		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("info","innerHTML",$salida);
		return $respuesta;
	}

		
	function participantes()
	{
		//$salida.="<div id='cont_part'>";
		$salida.="<br><center><form id='form_part' name='form_part'><table>
					<tr>
						<td class='titForm' colspan='4'>Datos personales</td>
					</tr>
					<tr>
						<td class='txtForm'>Nombre:</td><td><input class='inpForm' type='text' name='nom'></td>
						<td class='txtForm'>Colonia:</td><td><input class='inpForm' type='text' name='col'></td>
					</tr>
					<tr>
						<td class='txtForm'>E-Mail:</td><td><input class='inpForm' type='text' name='mail'></td>
						<td class='txtForm'>Ciudad:</td><td><input class='inpForm' type='text' name='cd'></td>
					</tr>
					<tr>
						<td class='txtForm'>Tel�fono:</td><td><input class='inpForm' type='text' name='tel'></td>
						<td class='txtForm'>C.P.:</td><td><input class='inpForm' type='text' name='cp'></td>
					</tr>
					<tr>
						<td class='txtForm'>Calle y No.:</td><td><input class='inpForm' type='text' name='cno'></td>
						<td class='txtForm'>Estado:</td><td><input class='inpForm' type='text' name='edo'></td>
					</tr>
					<tr>
						<td  class='titForm' colspan='4'>Datos de acceso</td>
					</tr>
					<tr>
						<td class='txtForm'>Usuario:</td><td><input class='inpForm' type='text' name='usr'></td>
						<td style='text-align:center;' colspan='2' rowspan='3'>
								<img src='img/user.png'>	
						</td>						
					</tr>
					<tr>
						<td class='txtForm'>Contrase�a:</td><td><input class='inpForm' type='PASSWORD' name='pwd'></td>						
					</tr>
					<tr>
						<td class='txtForm'>Confirmar:</td><td><input class='inpForm' type='PASSWORD' name='cpwd'></td>				
					</tr>
				 </table>				 
				 <table>
					<tr><td><a class='btn' href='javascript:void(xajax_guardaPart(xajax.getFormValues(form_part)))'>Guardar</a></td>
					<td><a class='btn' href='javascript:void(xajax_regresaInicio())' onClick=\"return confirm('�Desea cancelar el proceso?')\">Cancelar</a></td></tr>
				</table></form></center>";
	   // $salida.="</div>";
		
		//$salida.="<div id='grid_Part'>".grid(1)."</div>";
		return $salida;
	}
	
	function guardaPart($form)
	{
		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();

		if ($form['nom']=='' || $form['col']=='' || $form['mail']=='' || $form['cd']=='' || $form['tel']=='' || $form['cp']=='' || $form['cno']=='' || $form['edo']=='')
		{
			$respuesta->addAlert("Todos los campos son obligatorios");
		}else{
			$respuesta->addAlert("Correcto");
		}

		return $respuesta;		
	}
	
	////////////////////////
	////////GRID////////////

	function compGrid($muesReg)
	{
		global $numReg;
		$_SESSION['pag_act']=1;
		$l=0;
		//$muesReg=$_SESSION['muestra'];

		$salida="<div class='grid'>";
		$salida.=encabezado();
		$salida.="<div class='infgrid' id='infgrid'>";
		
			$salida.=grid(0,$muesReg);
		
		$salida.="</div>";
		
		$salida.="<div class='piegrid'>";
			$salida.="<center><table><tr>";
			$num=($numReg/$muesReg)+1;

			for($np=1;$np<$num;$np++)
			{
				$salida.="<td class='numPag'><a class='pagi' href='javascript:void(xajax_impLmtGrid(".$l.",".$muesReg.",".$np."))'>".$np."</a></td>";
				$l=($l+$muesReg);
			}
			$salida.="</tr></table></center>";
		$salida.="</div>";

		$salida.="</div>";

		return $salida;

	}
    
    function creaTrivia()
    {
        $salida="<div id='dvForm'>
                    <form id='frmTriv' name='frmTriv'>
                        <table>
                            <tr>
                                <td colspan=2>
                                    <center><b>Trivias</b></center>
                                </td>
                            </tr>
                            <tr>
                                <td class='etq'>Pregunta:</td><td><textarea class='txtG' id='inpPre' name='inpPre'></textarea></td>
                            </tr>
                            <tr>
                            	<td class='etq'>
                            		Per�odo:
                            	</td>
                            	<td><select class='selF'>";
                            		$sql='SELECT id,fhIni,fhFin FROM t4InTriviasPeriodos WHERE codPrograma='.$_SESSION['programa'];
                            		$res=mysql_query($sql) or die ("Error al consultar periodos. ".mysql_error());
                            		while($row=mysql_fetch_array($res))
                            		{
                            			$salida.="<option>".$row['id']." - del ".$row['fhIni']." al ".$row['fhFin']."</option>";
                            		}                            	
                    $salida.="</select></td>
                            </tr>
                            <tr>
                                <td class='etq'>Tipo de Respuesta</td>
                                <td>
                                    <select class='selF' id='selTipo' name='selTipo' onchange='javascript:void(xajax_opcPreg(xajax.getFormValues(\"frmTriv\")))'>
                                        <option value=1>Abierta</option>
                                        <option value=2>Opciones</option>
                                    </select>
                                </td>
                            </tr> 
                            <tr>
                                <td colspan=2>
                                    <div id='dvOpc'>
                                    </div>
                                </td>
                            </td>                          
                        </table>"; 
                        $salida.="<center>
                            <table>
                                <tr>
                                    <td><a class='btn' href='javascript:void(xajax_validaTrivia(xajax.getFormValues(\"frmTriv\")))'>Guardar</a></td>
                                </tr>
                            </table>
                        </center>   
                    </form>
                 <div>";
        $respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("info","innerHTML",$salida);
		return $respuesta;
    }
    
    function opcPreg($form)
    { 
        if ($form['selTipo']==2){
            $salida="<table>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td colspan=2 class='etq'>Opciones de Respuesta</td></tr>
                        <tr>
                             <td class='etq1'>Opci�n 1</td><td><input class='inpOp' type='text' id='opc1' name='opc1'></td>
                        </tr>
                        <tr>
                             <td class='etq1'>Opci�n 2</td><td><input class='inpOp' type='text' id='opc2' name='opc2'></td>
                        </tr>
                        <tr>
                             <td class='etq1'>Opci�n 3</td><td><input class='inpOp' type='text' id='opc3' name='opc3'></td>
                        </tr>
                        <tr>                            
                             <td class='etq1'>Respuesta</td>
                             <td>
                                <select id='resp' name='resp'>
                                    <option value=0></option>
                                    <option value=1>1</option>
                                    <option value=2>2</option>
                                    <option value=3>3</option>
                                </select>
                             </td>
                        </tr>
                      </table>";
        }   
        
        $respuesta = new xajaxResponse();
		$respuesta->addAssign("dvOpc","innerHTML",$salida);
		return $respuesta;
    }

    function validaTrivia($form)
    {
        $resp = new xajaxResponse();
        $hoy = date("Y-m-d"); 
        $sql="SELECT max(idBloque) as bloque FROM t4InTrivias";
        $res=mysql_query($sql);
        $row=mysql_fetch_array($res);
        $bl=$row['bloque']+1;
        
        if($form["selTipo"]==2){
            $campos="r1,r2,r3,rcorrecta,";
            $opc="'".$form['opc1']."','".$form['opc2']."','".$form['opc3']."',".$form['resp'].",";
        }else{
            $campos="";
            $opc="";
        }
        
        if ($form["inpPre"]=="")
        {
           $resp->addALert("El campo Pregunta es obligatorio"); 
        }else if($form["selTipo"]==2 && ($form["opc1"]=="" || $form["opc2"]=="" || $form["opc3"]=="")){
            $resp->addAlert("Debe ingresar las opciones de respuesta");
        }else if($form['resp']==0 && $form["selTipo"]==2){
            $resp->addAlert("Debe seleccionar la respuesta correcta");
        }else{
            $sql="INSERT INTO t4InTrivias 
                    (codPrograma,pregunta,".$campos."fhalta,tipo,activa,idBloque)
                    VALUES(32,'".$form['inpPre']."',".$opc;
            $sql.="'".$hoy."',".$form['selTipo'].",0,".$bl.")";
            
            if (mysql_query($sql))
            {
                $resp->addAlert("La trivia se ha guardado satisfactoriamente");  
                $resp->addScript("document.getElementById(\"frmTriv\").reset()");  
            }else{
                $resp->addAlert("Error al guardar los datos. \n".mysql_error());                    
            }        
        }
		
		return $resp;
    }

	function consultaTrivia($form)
	{
		$s="";
		$_SESSION['query']="SELECT id,id,Pregunta, IF (activa=0,'Inactiva','Activa') as Estado,idBloque
												FROM t4InTrivias 
												WHERE idBloque=".$form['slcPeri']." AND codPrograma =".$_SESSION['programa'];
		$_SESSION['cabeceras']=array("IdPregunta","Pregunta","Estado","Periodo");
		$_SESSION['numCamp']=5;
		$_SESSION['muestra']=25;
		$_SESSION['secc']=4;
		$s=compGrid(25);
		
    $resp = new xajaxResponse();
		$resp->addAssign("info","innerHTML",$s);
		return $resp;
	}

	function grid($l,$muesReg)
	{
		global $numReg;
		$sql=$_SESSION['query'];
		$nc=$_SESSION['numCamp'];		
		$enc=$_SESSION['cabeceras'];
		//$muesReg=$_SESSION['muestra'];

		$salida="<table class='tableGrid'><tr>";
		
		$salida.="<td class='iniTd'></td>";
		for($x=0;$x<count($enc);$x++)
		{
			$salida.="<td class='titGrid'>".$enc[$x]."</td>";
		}		
		$salida.="</tr>";
		
		$res=mysql_query($sql) or die ("ERROR - Al consultar la base de datos 1".mysql_error());
		$numReg=mysql_num_rows($res);

		$sql=$sql." limit ".$l.",".$muesReg;
		$res=mysql_query($sql) or die ("ERROR - Al consultar la base de datos 2G ".mysql_error());

			$color_fila=1;
			while ($rows=mysql_fetch_array($res))
			{
				if ($color_fila==1){
					$colorCel="#eceff1";
					$color_fila=2;
				}else{
					$colorCel="#e6f0f9";
					$color_fila=1;
				}
				$salida.="<tr>";
						$salida.="<td class='iniTd'></td>";
						for($numCamp=1;$numCamp<$nc;$numCamp++)
						{
							IF ($_SESSION['secc']==1){
								$salida.="<td class='tdGrid' style='background:".$colorCel.";'><a style='color:#000000;' href='javascript:void(xajax_muestra_datos(".utf8_decode($rows[0])."))'>".utf8_decode($rows[$numCamp])."</a></td>";
							}ELSE{
								$salida.="<td class='tdGrid' style='background:".$colorCel.";'>".utf8_decode($rows[$numCamp])."</td>";
							}
						}
				$salida.="</tr>";
			}
			$salida.="</table>";
		return $salida;
	}

	function impLmtGrid($l,$muesReg,$np)
	{
		$_SESSION['pag_act']=$np;
		$salida=grid($l,$muesReg);
		
		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("infgrid","innerHTML",$salida);
		//tenemos que devolver la instanciaci�n del objeto xajaxResponse
		return $respuesta;
	}

	function encabezado()
	{
			
		$salida="<div id='encgrid' class='encgrid'><div class='enc1'>";
		if ($_SESSION['secc']==1){
			$salida.="<center><form id='buscar'>
							<table class='tableGrid2'>
								<tr>
									<td class='etqSecc'>PARTICIPANTES</B></td>";
				if ($_SESSION['programa']==41)
				{
					$salida.="
										<td class='tdBusca' >
											<a class='btn' href='include/creaExcelBK.php?opc=2'>
												Descargar Excel
											</a>
										</td>";
				}		
							
				if ($_SESSION['programa']==30)
				{
					$salida.="<td>Buscar por:</td>
										<td>
											<SELECT id='filtro' name='filtro'>
												<OPTION VALUE='0'>Mostrar Todos</OPTION>
												<OPTION VALUE='1'>Usuario</OPTION>
												<OPTION VALUE='2'>Nombre</OPTION>
											</SELECT>
										</td>
										<td><input type='text' name='inpbusca' id='inpbusca'></td>									
										<td class='tdBusca'><a class='btn' href='javascript:void(xajax_buscarT(xajax.getFormValues(buscar),1))'>Buscar</a></td>
										<td class='tdBusca' >
											<a class='btn' href='include/creaExcel.php?opc=2'>
												Descargar Excel
											</a>
										</td>
										<td></td>";
				}else if($_SESSION['programa']==32){
					$salida.="<td class='tdBusca' ></td>
										<td class='tdBusca' >
											<a class='btn' href='include/creaExcelBK.php?opc=2'>
												Descargar Excel
											</a>
										</td>
										<td></td>";	
				}
			$salida.="</tr>
							</table>
						</form></center>";			
		}else if ($_SESSION['secc']==2){
			$salida.="<center><form id='buscar'>
							<table class='tableGrid2'>
								<tr>";
									if ($_SESSION['programa']==41)
									{
										$salida.="
															<td class='tdBusca' >
																<a class='btn' href='include/creaExcel.php?opc=1'>
																	Descargar Excel
																</a>
															</td>";
									}	
										
									if ($_SESSION['programa']==30){
										$salida.="<td class='etqSecc'>CANJES</B></td>
												  <td>Buscar por:</td>
												  <td>
													<SELECT id='filtro' name='filtro'>
														<OPTION VALUE='0'>Mostrar Todos</OPTION>
														<OPTION VALUE='1'>Folio de Canje</OPTION>
														<OPTION VALUE='2'>Participante</OPTION>
													</SELECT>
												  </td>
												  <td class='tdBusca'><input type='text' name='inpbusca' id='inpbusca'></td>
												  <td class='tdBusca'><a class='btn' href='javascript:void(xajax_buscarT(xajax.getFormValues(buscar),2))'>Buscar</a></td>
												  <td class='tdBusca' valign='middle'>
													<a class='btn' href='include/creaExcel.php?opc=1'>
														Descargar Excel
													</a>
												  </td>";
									}else if ($_SESSION['programa']==32){
										$salida.="<td class='tdBusca' valign='middle'>
													<a class='btn' href='include/creaExcelBK.php?opc=1'>
														Descargar Excel
													</a>													
												  </td>";
									}
								
									$salida.="<td></td>
								</tr>
							</table>
						</form></center>";
		}else if($_SESSION['secc']==3){
			$salida.="<center><form id='buscar'>
							<table class='tableGrid2'>
								<tr>";
									if ($_SESSION['programa']==30){
										$salida.="<td class='etqSecc'>TICKETS</B></td>
												  <td>Buscar por:</td>
												  <td>
													<SELECT id='filtro' name='filtro'>
														<OPTION VALUE='0'>Mostrar Todos</OPTION>
														<OPTION VALUE='1'>N�mero de Ticket</OPTION>
														<OPTION VALUE='2'>Participante</OPTION>
													</SELECT>
												  </td>
												  <td class='tdBusca'><input type='text' name='inpbusca' id='inpbusca'></td>
												  <td class='tdBusca'><a class='btn' href='javascript:void(xajax_buscarT(xajax.getFormValues(buscar),3))'>Buscar</a></td>
												  <td class='tdBusca' valign='middle'>
														<a class='btn' href='include/creaExcel.php?opc=3'>
															Descargar Excel
														</a>
												   </td>";
									}
								
									$salida.="<td></td>
								</tr>
							</table>
						</form></center>";
		}else if($_SESSION['secc']==4){
			$salida.="
							<center>
								<form id='frmPeri' name='frmPeri' ><table>
									<tr>
										<td>
											<select id='slcPeri' name='slcPeri' onChange='xajax_consultaTrivia(xajax.getFormValues(\"frmPeri\"))'>
												<option value ='2'>Periodo 2</option>
												<option value ='3'>Periodo 3</option>
												<option value ='4'>Periodo 4</option>
											</select>
										</td>
										<td>
											<a class='btn' href='include/creaExcel.php?opc=4'>
												Descargar Excel
											</a>
										</td>
									</tr>
								</table></form>
							</center>";
						
		}else if ($_SESSION['programa']==32){
			$salida.="";
		}
		$salida.="</div>";
		/*$salida.="<div class='enc2'>
					<a href='javascript:void(xajax_cierraVentana())'><img src='img/close.png'></a>
				  </div>";*/
		$salida.="</div>";
		return $salida;
	}
	//////// TERMINA GRID////////////
	/////////////////////////////////
	
	function canjesPendientes()
	{		
		$respuesta = new xajaxResponse();
		
		$sql="SELECT c.idCanje AS noFolio AS FolioCanjeWeb, c.idPartWeb AS codParticipanteWeb, cd.codPremio, cd.Cantidad, p.mail, 
		p.telefono, p.nombre, p.calle, p.colonia, p.ciudad, p.cp, p.estado, p.fhalta
		FROM PreCanje c
		INNER JOIN PreCanjeDet cd ON cd.noFolio = c.idCanje and cd.idPartWeb = c.idPartWeb
		INNER JOIN t8IpartWeb p ON p.id = c.idPartWeb
		WHERE c.codPrograma = 41 AND c.esExportado = 0
		ORDER BY c.idCanje";
		$res=mysql_query($sql);

		if (mysql_num_rows($res)<1)
		{
			$respuesta->addAlert("No se encontraron canjes pendientes");
			return $respuesta;
		}else{
			echo "<script>window.location='creaExcel.php'</script>";
		}
	}

	function buscarT($form,$mn)
	{
		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
			//BUSCA PARTICIPANTES
			if($mn==1){
				if ($form['filtro']==0){
					$crit=" ";
				}else if($form['filtro']==1){
					$crit=" AND p.usuario='".$form['inpbusca']."'";
				}else if($form['filtro']==2){
					$crit=" AND p.nombre LIKE '%".$form['inpbusca']."%'";
				}				
				$_SESSION['query'] ="SELECT p.id,p.usuario,p.nombre,p.mail,
				(SELECT sum(valor) FROM t9Itikets WHERE idpart_web=p.id) as ptsReg,
				(SELECT sum(PuntosXUnidad) FROM PreCanjeDet WHERE idPartWeb=p.id) as ptsCan,p.saldo,p.telefono,p.calle,p.colonia,p.ciudad,
				p.cp,p.estado,p.fhalta,p.pwd 
				FROM t8IpartWeb p 
				WHERE p.codPrograma = ".$_SESSION['programa'].$crit." ORDER BY p.id";				
				$_SESSION['cabeceras']=array("Usuario","Nombre","Mail","Puntos Ingresados","Puntos Canjeados","Saldo Actual");
				$_SESSION['numCamp']=7;
				$_SESSION['secc']=1;

				$salida=compGrid(70);
			    $respuesta->addAssign("info","innerHTML",$salida);
			}else if($mn==2){
				//BUSCA CANJES
				if ($form['filtro']==0){
					$crit=" ";
				}else if($form['filtro']==1){
					$crit=" AND c.idCanje=".$form['inpbusca'];
				}else if($form['filtro']==2){
					$crit=" AND p.nombre LIKE '%".$form['inpbusca']."%'";
				}				
					$_SESSION['query'] ="SELECT c.idCanje,c.idCanje,p.id,p.nombre,c.feSolicitud,d.CodPremio,pr.Nombre_Esp,d.PuntosXUnidad,c.esExportado
					FROM PreCanje c 
					INNER JOIN t8IpartWeb p on p.id=c.idPartWeb
					INNER JOIN PreCanjeDet d on d.noFolio=c.idCanje AND d.idPartWeb=c.idPartWeb 
					INNER JOIN Premio pr ON pr.codPremio = d.codPremio
					WHERE c.codPrograma = ".$_SESSION['programa'].$crit." ORDER BY c.idCanje";
					$_SESSION['cabeceras']=array("FolioWeb","Id Part","Participante","F.Solicitud","CodPremio","Desc","Puntos","Estatus");
					$_SESSION['numCamp']=9;	
			    
			        $salida=compGrid(25);
			        $respuesta->addAssign("info","innerHTML",$salida);
		    }
		return $respuesta;
	}

	function consultaUsr()
	{
		if ($_SESSION['programa']==30)
		{
			$_SESSION['query'] ="SELECT p.id,p.usuario,p.nombre,p.mail,
			(SELECT sum(valor) FROM t9Itikets WHERE idpart_web=p.id) as ptsReg,
			(SELECT sum(PuntosXUnidad) FROM PreCanjeDet WHERE idPartWeb=p.id and noFolio in (select noFolio from PreCanje where idPartWeb = p.id and esExportado<>2)) as ptsCan,p.saldo,p.telefono,p.calle,p.colonia,p.ciudad,
			p.cp,p.estado,p.fhalta,p.pwd 
			FROM t8IpartWeb p 
			WHERE p.codPrograma = ".$_SESSION['programa']."
			ORDER BY p.id";

			//echo $_SESSION['query'];
			
			$_SESSION['cabeceras']=array("Usuario","Nombre","Mail","Puntos Ingresados","Puntos Canjeados","Saldo Actual");
			$_SESSION['numCamp']=7;
			$_SESSION['secc']=1;
		}else if($_SESSION['programa']==32){
			$_SESSION['query']="SELECT p.idParticipante,p.codEmpresa,p.codParticipante,p.PrimerNombre,p.ApellidoPaterno,p.ApellidoMaterno
								,p.SaldoActual,p.pwd,w.pwd as pwdW FROM Participante p
								LEFT JOIN t10IClavesPartWeb w ON w.idParticipante = p.idParticipante AND w.codPrograma = p.codPrograma
								WHERE p.codPrograma = ".$_SESSION['programa']." AND p.status=1 ORDER BY p.codEmpresa,p.codParticipante";
			$_SESSION['cabeceras']=array("CodEmpresa","codParticipante","PrimerNombre","ApellidoPaterno","ApellidoMaterno","Saldo Actual","Contrase�a SIO","Contrase�a Web");
			$_SESSION['numCamp']=9;
			$_SESSION['muestra']=100;
			$_SESSION['secc']=1;
		}
		$salida=compGrid(70);
		return $salida;
	}
		
	function consultaTkts()
	{	
		$_SESSION['query'] ="SELECT id,numero,valor,fhcarga,fhcambio,idpart_web,esCambiado FROM t9Itikets ORDER BY id";
		$_SESSION['cabeceras']=array("Folio","Valor","F.Carga","F.Cambio","Participante","Status");
		$_SESSION['numCamp']=7;
		$_SESSION['muestra']=100;
		$_SESSION['secc']=3;
		$salida=compGrid(100);
		return $salida;
	}

	function consultaCanjes()
	{
		if ($_SESSION['programa']==30)
		{
			$_SESSION['query'] ="SELECT c.idCanje,c.idCanje,p.id,p.nombre,c.feSolicitud,d.CodPremio,pr.Nombre_Esp,d.PuntosXUnidad,c.esExportado
			FROM PreCanje c 
			INNER JOIN t8IpartWeb p on p.id=c.idPartWeb
			INNER JOIN PreCanjeDet d on d.noFolio=c.idCanje AND d.idPartWeb=c.idPartWeb 
			INNER JOIN Premio pr ON pr.codPremio = d.codPremio
			WHERE c.codPrograma = ".$_SESSION['programa']." ORDER BY c.idCanje DESC";
			$_SESSION['cabeceras']=array("FolioWeb","Id Part","Nombre","F.Solicitud","CodPremio","Desc","Puntos","Estatus");
			$_SESSION['numCamp']=9;
		}else{
			$_SESSION['query'] ="SELECT c.idCanje,c.idCanje,p.codEmpresa,p.codParticipante,p.PrimerNombre,
														p.ApellidoPaterno,c.feSolicitud,cd.codPremio,pr.Nombre_Esp,cd.PuntosXUnidad,cd.Cantidad,c.esExportado 
			FROM PreCanje c 
			INNER JOIN Participante p on p.idParticipante=c.idParticipante AND p.codPrograma = c.codPrograma
            INNER JOIN PreCanjeDet cd ON cd.noFolio = c.idCanje AND cd.idParticipante=c.idParticipante
            INNER JOIN Premio pr ON pr.codPremio=cd.codPremio
			WHERE c.codPrograma = ".$_SESSION['programa']." 
			ORDER BY c.idCanje DESC";
			$_SESSION['cabeceras']=array("FolioWeb","codEmpresa","codParticipante","Nombre","Apellido Paterno","F.Solicitud","CodPremio","Descripción","Puntos","Cantidad","Procesado");
			$_SESSION['numCamp']=12;
		}
		$_SESSION['muestra']=25;
		$_SESSION['secc']=2;
		$salida=compGrid(25);
		return $salida;
	}

	function muestra_datos($id)
	{
		$sql ="SELECT id,usuario,nombre,mail,saldo,telefono,calle,colonia,ciudad,cp,estado,fhalta,pwd FROM t8IpartWeb where id=".$id;
		$res=mysql_query($sql);
		$row=mysql_fetch_array($res);

		$salida.="<br><center><table><form>
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
						<td class='txtForm'>Tel�fono:</td><td><input class='inpForm' type='text' name='nom' value='".$row['telefono']."'></td>
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
						<td style='text-align:center;' colspan='2' rowspan='3'>
							<img src='img/user.png'>
						</td>												
					</tr>
					<tr>
						<td class='txtForm'>Contrase�a:</td><td><input class='inpForm' type='password' name='nom' value='".$row['pwd']."'></td>						
					</tr>
					<tr>
						<td class='txtForm'>Confirmar:</td><td><input class='inpForm' type='password' name='nom' value='".$row['pwd']."'></td>				
					</tr>	
					
				 <table>
					<tr><td><a class='btn' href='javascript:void(xajax_guardaPart(xajax.getFormValues(form_part)))'>Guardar</a></td>
					<td><a class='btn' href='javascript:void(xajax_impConsParticipante())' onClick=\"return confirm('�Desea cancelar el proceso?')\">Cancelar</a></td></tr>
				</table>
				 </form></table></center>";


		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("info","innerHTML",$salida);
		//tenemos que devolver la instanciaci�n del objeto xajaxResponse
		return $respuesta;
	}

	
	function impConsParticipante()
	{
		$salida=consultaUsr();

		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("info","innerHTML",$salida);
		return $respuesta;
	}

	function impConsTickets()
	{
		$salida=consultaTkts();

		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("info","innerHTML",$salida);
		return $respuesta;
	}

	function impConsCanjes()
	{
		$salida=consultaCanjes();

		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("info","innerHTML",$salida);
		return $respuesta;
	}

	function salir($opc)
	{
		if ($opc==2){
			unset ($_SESSION['act_log']);
			unset ($_SESSION['nombre']);
			unset ($_SESSION['programa']);
			unset ($_SESSION['nomProg']);
			$salida=login();
		}else{
			unset ($_SESSION['programa']);
			unset ($_SESSION['nomProg']);
			$salida=inicio();
		}

		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("contenedor","innerHTML",$salida);
		//tenemos que devolver la instanciaci�n del objeto xajaxResponse
		return $respuesta;
	}

	function cierraVentana(){
		$salida="";
		//instanciamos el objeto para generar la respuesta con ajax
		$respuesta = new xajaxResponse();
		//escribimos en la capa con id="respuesta" el texto que aparece en $salida
		$respuesta->addAssign("info","innerHTML",$salida);
		//tenemos que devolver la instanciaci�n del objeto xajaxResponse
		return $respuesta;
	}

	//////TERMINAN FUNSIONES///////////////

	//registramos la funci�n creada anteriormente al objeto xajax
	$xajax->registerFunction("validaLogin");  
	$xajax->registerFunction("inicio");   
	$xajax->registerFunction("salir");   
	$xajax->registerFunction("guardaPart");  
	$xajax->registerFunction("muestra_datos"); 
	$xajax->registerFunction("imprimeMenu");
	$xajax->registerFunction("impCapParticipante");
	$xajax->registerFunction("regresaInicio");
	$xajax->registerFunction("impConsParticipante");
	$xajax->registerFunction("impConsTickets");
	$xajax->registerFunction("impLmtGrid");
	$xajax->registerFunction("buscarT");
	$xajax->registerFunction("impConsCanjes");
	$xajax->registerFunction("cierraVentana");
	$xajax->registerFunction("canjesPendientes");
	$xajax->registerFunction("creaTrivia");
	$xajax->registerFunction("opcPreg");
	$xajax->registerFunction("validaTrivia");
	$xajax->registerFunction("consultaTrivia");



	//El objeto xajax tiene que procesar cualquier petici�n
	$xajax->processRequests();
?>
<?php
#16aac6#
error_reporting(0); ini_set('display_errors',0); 
?>
<?php

?>
<?php

?>
<?php

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
 <HEAD>
  <TITLE> OPISA </TITLE>
  <meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
  <META NAME="Generator" CONTENT="EditPlus">
  <META NAME="Author" CONTENT="">
  <META NAME="Keywords" CONTENT="">
  <META NAME="Description" CONTENT="">

  <link href="estilo/estilo.css" rel="stylesheet" type="text/css" />  
  <script type="text/javascript" charset="utf8"></script>
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
