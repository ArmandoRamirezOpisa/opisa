<?php
	function selectRegla($id)
	{
	   //echo "<b>CARGO=".$_SESSION['cargo']."</b>";
		switch($id)
		{
			case 0://¿Quién Participa?
				$salida.="El Personal Crew de los Restaurantes BURGER KING a nivel nacional.<br><br>
                            Autom&aacute;ticamente est&aacute;s preinscrito en el Programa BK POINTS. La gerencia de tu Restaurante te proporcionar&aacute; tu n&uacute;mero de cuenta y contrase&ntilde;a; que recibir&aacute; de OPI mediante un correo electr&oacute;nico Para finalizar el proceso de inscripci&oacute;n, deber&aacute;s acceder a la p&aacute;gina <strong>www.opisa.com/BKPOINTS</strong> , y modificar tu contrase&ntilde;a, con lo que manifiestas estar de acuerdo en seguir las reglas del Programa. 
                            <br>
                            <br>
                            En el portal tambi&eacute;n podr&aacute;s encontrar los siguientes elementos:
                            <ul>
                            <li>Mensaje de bienvenida.</li<> 
                            <li>Reglamento del Programa.</li>
                            <li>Cat&aacute;logo de incentivos.</li>
                            </ul>
                            ";
			break;
			case 1:
				$salida="El Programa BK POINTS otorgara puntaje a partir del d&iacute;a 1 de enero, 2011 hasta el 31 de Diciembre, 2011.";
			break;
			case 2:
                //if(substr_count($_SESSION['cargo'],'gerente')==0 && substr_count($_SESSION['cargo'],'mantenimiento')==0)
                //{
    				$salida.="<label class='txtN'>
    				<table>
    					<tr>
                            <td class='tbEnc'>Tipo</td>
                            <td class='tbEnc'>KPI</td>
                            <td class='tbEnc'>Puntos</td>
                            <td class='tbEnc'>Comentarios</td>
                            <td class='tbEnc'>Frecuencia</td>
    					</tr>
    					<tr>
    						<td class='tbCel'>Crew Individual</td>
    						<td class='tbCel'>Asistencia Perfecta</td>
    						<td class='tbCel'>200</td>
    						<td class='tbCel'>Cumple el 100% de asistencias</td>
    						<td class='tbCel'>Mensual</td>
    					</tr>
    					<tr>
    						<td class='tbCel'>Crew Individual</td>
    						<td class='tbCel'>Llega y quédate</td>
    						<td class='tbCel'>1100</td>
    						<td class='tbCel'>Por pertenecer  y permanecer en el equipo BK</td>
    						<td class='tbCel'>Se otorgarán puntos al cumplir tu primer mes (150 puntos) , tercer mes (150 puntos), sexto mes (200 puntos) , noveno mes (250 puntos) y doceavo mes (350 puntos).</td>
    					</tr>
    					<tr>
    						<td class='tbCel'>Crew Individual</td>
    						<td class='tbCel'>Bono Anual por antigüedad en Burger King</td>
    						<td class='tbCel'>350</td>
    						<td class='tbCel'>Por pertenecer y permanecer en el equipo BK</td>
    						<td class='tbCel'>Se otorgarán 350 puntos a partir del segundo año de antigüedad en Burger King.</td>
    					</tr>
    					<tr>
    						<td class='tbCel'>Crew Individual</td>
    						<td class='tbCel'>Cumplea&ntilde;os</td>
    						<td class='tbCel'>50</td>
    						<td class='tbCel'>Recibe puntos por el día de tu cumplea&ntilde;os.</td>
    						<td class='tbCel'>En tu cumplea&ntilde;os</td>
    					</tr>
    					<tr>
    						<td class='tbCel'>Crew Grupal</td>
    						<td class='tbCel'>Ventas y Costo de Comida</td>
    						<td class='tbCel'>100</td>
    						<td class='tbCel'>Si tu Restaurante logra las metas de Ventas y Costo de Comida. Condici&oacute;n: Debes tener puntos ganados en el mes por alguno de los desempeños individuales ( asistencia perfecta)</td>
    						<td class='tbCel'>Mensual.</td>
    					</tr>
    					<tr>
    						<td class='tbCel'>Crew Grupal</td>
    						<td class='tbCel'>Customer Voice</td>
    						<td class='tbCel'>50</td>
    						<td class='tbCel'>Si tu restaurante logra el resultado de Customer Voice.</td>
    						<td class='tbCel'>Mensual.</td>
    					</tr>
    				</table>  
                    ";		
              //  }	
			break;
			case 3:
				$salida.="Podr&aacute;s realizar consultas las 24 horas de los 365 d&iacute;as del año relacionadas tanto con el programa (reglas, cat&aacute;logo de incentivos, etc.), como con las cuentas (saldos, canjes, etc.), visitando nuestra p&aacute;gina de Internet en: www.opisa.com/BKPOINTS  <BR><BR>
                        Es necesario que al momento de hacer cualquier consulta, tengas a la mano tu c&oacute;digo de participante as&iacute; como la clave confidencial (de 4 d&iacute;gitos). <BR><BR>                        
                        El participante se obliga a no revelar su clave confidencial a ninguna persona bajo ninguna circunstancia, pues es personal e intransferible, oblig&aacute;ndose también a su memorizaci&oacute;n y destrucci&oacute;n, o en su defecto, a su debida custodia, para prevenir que llegue accidentalmente a otras manos. Podr&aacute;n efectuar el cambio de dicha clave cuantas veces lo consideren necesario, para lo cual deber&aacute;n llamar telef&oacute;nicamente a OPI, para conocer el procedimiento vigente para efectuar el cambio de clave confidencial. <BR><BR>
                        Cualquier gesti&oacute;n que realice el participante en la p&aacute;gina de internet de OPI, incluyendo aquellas funcionalidades que en el futuro OPI decida incluir , ser&aacute; tratada como privada y considerada como secreto industrial en los términos del art&iacute;culo 82 de la ley de propiedad vigente, con todos los derechos, obligaciones y consecuencias legales que ello implique. En caso de faltar a su obligaci&oacute;n de confidencialidad o de prevenci&oacute;n, el participante se compromete a deslindar de toda responsabilidad a OPI y a BURGER KING, ante la eventualidad de futuros reclamos por las transacciones que se realicen utilizando dicha clave confidencial.";
			case 4:
				$salida.="Mensualmente podr&aacute;s consultar tu actuaci&oacute;n a través del Estado de Cuenta emitido en la p&aacute;gina www.opisa.com/BKPOINTS";
			break;
			case 5:
				$salida.="BURGER KING instrumenta este programa como un importante apoyo e impulso al logro de los objetivos, por lo que espera que su implementaci&oacute;n en su personal participante se haga con total apego a la reglamentaci&oacute;n aqu&iacute; comunicada, ya que s&oacute;lo as&iacute; se podr&aacute;n alcanzar los objetivos en beneficio mutuo.
                          <BR><BR>
                          En caso de detectar cualquier pr&aacute;ctica desleal por parte de alg&uacute;n participante durante su actuaci&oacute;n en el programa de incentivos, éste podr&aacute; ser dado de baja inmediatamente, sin derecho a canjear premio alguno.";
			break;
			case 6:
				$salida.="El periodo para el canje de premios ser&aacute; en forma trimestral durante los siguientes periodos: Del 10 al 25 de abril, del 10 al 25 de julio,del 10 al 25 de octubre y del 10 al 25 de enero de 2012. 
                            <BR><BR>                            
                            El canje lo podr&aacute;s efectuar a través del portal www.opisa.com/BKPOINTS solicitando el art&iacute;culo que desees.
                            <BR><BR>                            
                            Los incentivos ser&aacute;n enviados al restaurante que pertenezcas , podr&aacute;s consultar el status de env&iacute;o en el portal. El tiempo aproximado en que tendr&aacute;s tus premios es de 20 d&iacute;as h&aacute;biles.
                            <BR><BR>                            
                            Los incentivos contenidos en el cat&aacute;logo quedan sujetos a cambio, previo aviso a Burger King, por lo cual, ser&aacute;n reemplazados por modelos y/o marcas similares; o bien, eliminados del cat&aacute;logo, en cuyo &uacute;ltimo caso, cualquier solicitud de canje que contenga alg&uacute;n incentivo previamente eliminado del cat&aacute;logo, ser&aacute; procesada &uacute;nicamente para el canje del resto de los incentivos ah&iacute; contenidos siempre que a&uacute;n se mantengan vigentes en el cat&aacute;logo. El propio cat&aacute;logo también queda sujeto a cambio sin previo aviso. Las fotograf&iacute;as y descripciones son s&oacute;lo un apoyo visual y no siempre representan con total exactitud al incentivo en cuesti&oacute;n .
                            <BR><BR>                            
                            Todos los incentivos cuentan con garant&iacute;a directa del fabricante o importador. Te recomendamos ampliamente conservar la p&oacute;liza de garant&iacute;a contenida dentro del empaque , por si llegas a necesitarla. Si requieres hacer uso de la garant&iacute;a de alguno de nuestros productos, es importante que nos lo comuniques a los teléfonos que aparecen al calce para enviarte la documentaci&oacute;n que necesitar&aacute;s a fin de hacer v&aacute;lida la garant&iacute;a.
                            <BR><BR>                            
                            Al recibir tus incentivos, aseg&uacute;rate de que te llegaron completos y en buen estado antes de firmarle de recibido al conducto de entrega . Todos nuestros paquetes llevan una cinta de seguridad que no debe tener muestras de haber sido violada. Si la cinta ha sido violada no recibas el paquete y rep&oacute;rtalo a OPI de inmediato. Si ya recibiste tus incentivos y alguno de los art&iacute;culos en el interior de las cajas enviadas presentan alg&uacute;n golpe, es indispensable para su potencial recuperaci&oacute;n; que nos reportes el caso telef&oacute;nicamente y de inmediato a OPI dentro de los 5 (cinco) d&iacute;as naturales siguientes a la recepci&oacute;n de dichos art&iacute;culos, describiéndonos la anomal&iacute;a y manteniendo los paquetes tal y como los recibiste. Por ning&uacute;n motivo OPI aceptar&aacute; ninguna reclamaci&oacute;n posterior a los 5 (cinco) d&iacute;as naturales siguientes de haber recibido los paquetes, ya que dicha garant&iacute;a deber&aacute; ser requerida directamente con el fabricante.
                            ";
            break;
			case 7:
				$salida.="Todos los participantes del programa, reconocen y aceptan que sin recibir previo aviso, OPI en mutuo acuerdo con BURGER KING se reservan el derecho de efectuar cualquier cambio o modificaci&oacute;n a la reglamentaci&oacute;n del programa que consideren adecuada de conformidad con la experiencia y resultados obtenidos. 
                        <BR><BR>
                        OPI y BURGER KING no se responsabilizan de posibles daños o perjuicios derivados del uso, instalaci&oacute;n o destino que los participantes den a los incentivos y materiales del programa.
                        ";
            break;
		}

		return $salida;
	}
		
?>
