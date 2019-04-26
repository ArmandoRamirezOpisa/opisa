<?php
	
	include ('../../include/local_dsn.php');
	include ('../../include/dsn.php');
	
	$folioCarga=0;

	if($_GET['opc']==1)
	{
		//CANJES/////////////////////////////
		$sql="SELECT c.idCanje AS FolioCanjeWeb, c.idParticipante,p.codEmpresa,p.codParticipante,cd.codPremio,pp.Nombre_Esp,cd.Cantidad, p.eMail, 
				p.Telefono, CONCAT(p.PrimerNombre,' ',p.SegundoNombre,' ',p.ApellidoPaterno,' ',p.ApellidoMaterno) as PrimerNombre, p.CalleNumero, p.Colonia, p.Ciudad, p.CP, p.Estado
				FROM PreCanje c
				INNER JOIN PreCanjeDet cd ON cd.noFolio = c.idCanje and cd.idParticipante = c.idParticipante
				INNER JOIN Participante p ON p.idParticipante = c.idParticipante
                INNER JOIN Premio pp ON pp.codPremio = cd.codPremio
				WHERE c.codPrograma = 40 AND c.esExportado = 0
		        ORDER BY c.idCanje ";
		$res=mysql_query($sql);

		if (mysql_num_rows($res)<1)
		{
			echo "<script>alert(\"No se encontraron canjes pendientes\")</script>";
			echo "<script>window.location='../index.php'</script>";
		}else{
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition:attachment; filename=CanjesHeinz.xls");
			
			$sql ="SELECT max(folioExp)+1 as Folio FROM PreCanje WHERE codPrograma =40";
			$re=mysql_query($sql);
			$ro=mysql_fetch_array($re);

			$folioCarga=$ro['Folio'];

			//Creamos tabla
			echo "<table style='border:solid 1 red;'>";
				echo "<tr>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>FolioCanjeWeb</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>idParticipante</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>codEmpresa</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>codParticipante</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>codPremio</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Desc_Premio</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Cantidad</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>E-Mail</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Tel&eacute;fono</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Nombre</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Calle</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Colonia</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Ciudad</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>C.P.</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Estado</td>
					  </tr>";
				while ($row=mysql_fetch_array($res))
				{	
					echo "<tr>
							<td style='border:solid 1px'>".$row['FolioCanjeWeb']."</td>
							<td style='border:solid 1px'>".$row['idParticipante']."</td>
							<td style='border:solid 1px'>".$row['codEmpresa']."</td>
							<td style='border:solid 1px'>".$row['codParticipante']."</td>
							<td style='border:solid 1px'>".$row['codPremio']."</td>
							<td style='border:solid 1px'>".utf8_decode($row['Nombre_Esp'])."</td>
							<td style='border:solid 1px'>".$row['Cantidad']."</td>
							<td style='border:solid 1px'>".$row['eMail']."</td>
							<td style='border:solid 1px'>".$row['Telefono']."</td>
							<td style='border:solid 1px'>".$row['PrimerNombre']."</td>
							<td style='border:solid 1px'>".$row['CalleNumero']."</td>
							<td style='border:solid 1px'>".$row['Colonia']."</td>
							<td style='border:solid 1px'>".$row['Ciudad']."</td>
							<td style='border:solid 1px'>".$row['CP']."</td>
							<td style='border:solid 1px'>".$row['Estado']."</td>
						  </tr>";
					
					//Actualiza el estatus del campo esExportado = 1 para indicar que el registro ya fue exportado con anterioridad
					$sql_up="UPDATE PreCanje SET esExportado = 1,fhExp=CURDATE(),folioExp=".$folioCarga."
					      WHERE idCanje=".$row['FolioCanjeWeb']." AND idParticipante=".$row['idParticipante']." AND codPrograma = 40";
					@mysql_query($sql_up);
				}
				
			echo "</table>";
		}
	}else if($_GET['opc']==2){
		//PARTICIPANTES///////////////////////////////
		$sql="SELECT id,usuario,pwd,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhAlta,Saldo,codPrograma 
			  FROM t8IpartWeb
			  ORDER BY id";
		$res=mysql_query($sql);

		if (mysql_num_rows($res)<1)
		{
			echo "<script>alert(\"No se encontraron participantes\")</script>";
			echo "<script>window.location='../index.php'</script>";
		}else{
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition:attachment; filename=ParticipantesPACCAR.xls");
			
			/*$sql ="SELECT max(folioExp)+1 as Folio FROM PreCanje";
			$re=mysql_query($sql);
			$ro=mysql_fetch_array($re);

			$folioCarga=$ro['Folio'];*/

			//Creamos tabla
			echo "<table style='border:solid 1'>";
				echo "<tr>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Id</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Usuario</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>PWD</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Mail</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Telefono</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>nombre</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>calle</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>colonia</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>ciudad</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>cp</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>estado</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>fhAlta</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>saldo</td>
						<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>codprograma</td>
					  </tr>";
				while ($row=mysql_fetch_array($res))
				{	
					echo "<tr>
							<td style='border:solid 1px'>".$row['id']."</td>
							<td style='border:solid 1px'>".$row['usuario']."</td>
							<td style='border:solid 1px'>".$row['pwd']."</td>
							<td style='border:solid 1px'>".$row['mail']."</td>
							<td style='border:solid 1px'>".$row['telefono']."</td>
							<td style='border:solid 1px'>".$row['nombre']."</td>
							<td style='border:solid 1px'>".$row['calle']."</td>
							<td style='border:solid 1px'>".$row['colonia']."</td>
							<td style='border:solid 1px'>".$row['ciudad']."</td>
							<td style='border:solid 1px'>".$row['cp']."</td>
							<td style='border:solid 1px'>".$row['estado']."</td>
							<td style='border:solid 1px'>".$row['fhAlta']."</td>
							<td style='border:solid 1px'>".$row['Saldo']."</td>
							<td style='border:solid 1px'>".$row['codPrograma']."</td>
						  </tr>";
					
					/*$sql="UPDATE PreCanje SET esExportado = 1,fhExp=CURDATE(),folioExp=".$folioCarga."
						   WHERE noFolio=".$row['FolioCanjeWeb']." AND idPartWeb=".$row['codParticipanteWeb']." AND codPrograma = 40";
					@mysql_query($sql);*/
				}
				
			echo "</table>";
		}
	}else if($_GET['opc']==3){
			////////////////////////TICKETS///////////////////////////////
			$sql="SELECT id,numero,valor,fhcarga,fhcambio,idpart_web,esCambiado 
				  FROM t9Itikets 
				  ORDER BY id";
			$res=mysql_query($sql);
			if (mysql_num_rows($res)<1)
			{
				echo "<script>alert(\"No se encontraron Tickets\")</script>";
				echo "<script>window.location='../index.php'</script>";
			}else{
				header("Content-type: application/vnd.ms-excel");
				header("Content-Disposition:attachment; filename=TicketsPACCAR.xls");
				///////////Creamos tabla//////////////////////////////////////////////////////////
				echo "<table style='border:solid 1'>";
					echo "<tr>
							<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Id</td>
							<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>N&uacute;mero</td>
							<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Valor</td>
							<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Fecha de Carga</td>
							<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Fecha de Cambio</td>
							<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Id de Participante</td>
							<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Estatus de Cambio</td>
						  </tr>";
					while ($row=mysql_fetch_array($res))
					{	
						echo "<tr>
								<td style='border:solid 1px'>".$row['id']."</td>
								<td style='border:solid 1px'>".$row['numero']."</td>
								<td style='border:solid 1px'>".$row['valor']."</td>
								<td style='border:solid 1px'>".$row['fhcarga']."</td>
								<td style='border:solid 1px'>".$row['fhcambio']."</td>
								<td style='border:solid 1px'>".$row['idpart_web']."</td>
								<td style='border:solid 1px'>".$row['esCambiado']."</td>
							  </tr>";
					}
			}
	}else if($_GET['opc']==4){
			////////////////////////TICKETS///////////////////////////////
			$sql="SELECT p.codEmpresa,p.codParticipante,p.PrimerNombre,p.ApellidoPaterno,p.ApellidoMaterno,
			             t.idPregunta as NoPregunta,t.rAbierta as Respuesta 
						FROM t5InRespTrivias t
						INNER JOIN Participante p ON p.idParticipante = t.idParticipante 
						INNER JOIN t4InTrivias r ON r.id=t.idPregunta 
						WHERE p.codPrograma = 32 and r.idBloque=2
						ORDER BY codEmpresa,codParticipante";
			$res=mysql_query($sql);
			if (mysql_num_rows($res)<1)
			{
				echo "<script>alert(\"No se encontraron Respuestas\")</script>";
				echo "<script>window.location='../index.php'</script>";
			}else{
				header("Content-type: application/vnd.ms-excel");
				header("Content-Disposition:attachment; filename=TriviaBKPOINTS.xls");
				///////////Creamos tabla//////////////////////////////////////////////////////////
				echo "<table style='border:solid 1'>";
					echo "<tr>
							<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>CodEmpresa</td>
							<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>CodParticipante</td>
							<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>PrimerNombre</td>
							<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>ApellidoPaterno</td>
							<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>ApellidoMaterno</td>
							<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>NoPregunta</td>
							<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Respuesta</td>
						  </tr>";
					while ($row=mysql_fetch_array($res))
					{	
						echo "<tr>
								<td style='border:solid 1px'>".$row['codEmpresa']."</td>
								<td style='border:solid 1px'>".$row['codParticipante']."</td>
								<td style='border:solid 1px'>".$row['PrimerNombre']."</td>
								<td style='border:solid 1px'>".$row['ApellidoPaterno']."</td>
								<td style='border:solid 1px'>".$row['ApellidoMaterno']."</td>
								<td style='border:solid 1px'>".$row['NoPregunta']."</td>
								<td style='border:solid 1px'>".strip_tags($row['Respuesta'])."</td>
							  </tr>";
					}
			}
		}
?>