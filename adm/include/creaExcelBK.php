<?php
	
	include ('../../include/local_dsn.php');
	include ('../../include/dsn.php');
	
	$folioCarga=0;
	//session_start();
		if ($_GET['opc']==1)
		{

				$sql="SELECT c.noFolio AS FolioCanjeWeb, c.idParticipante,c.Telefono,
					cd.codPremio,cd.Cantidad, c.CalleNumero, c.Colonia, c.Ciudad, c.CP, c.Estado,c.feSolicitud 
					FROM PreCanje c
					INNER JOIN PreCanjeDet cd ON cd.noFolio = c.noFolio and cd.idParticipante = c.idParticipante
					WHERE c.codPrograma = 40 AND c.esExportado = 0 ORDER BY c.noFolio";
				$res=mysql_query($sql);

				if (mysql_num_rows($res)<1)
				{
					echo "<script>alert(\"No se encontraron canjes pendientes\")</script>";
					echo "<script>window.location='../index.php'</script>";
				}else{
				header("Content-type: application/vnd.ms-excel");
				header("Content-Disposition:attachment; filename=CanjesBKPOINTS.xls");
					
					$sql ="SELECT max(folioExp)+1 as Folio FROM PreCanje WHERE codPrograma = 40";
					$re=mysql_query($sql);
					$ro=mysql_fetch_array($re);

					$folioCarga=$ro['Folio'];
					
					//Creamos tabla			
					echo "<table style='border:solid 1 red;'>";
						echo "<tr>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>FolioCanjeWeb</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>idParticipante</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Telefono</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>codPremio</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Cantidad</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Calle</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Colonia</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Ciudad</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>C.P.</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Estado</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>FechaCanje</td>
							  </tr>";
						while ($row=mysql_fetch_array($res))
						{	
							echo "<tr>
									<td style='border:solid 1px'>".$row['FolioCanjeWeb']."</td>
									<td style='border:solid 1px'>".$row['idParticipante']."</td>
									<td style='border:solid 1px'>".$row['Telefono']."</td>
									<td style='border:solid 1px'>".$row['codPremio']."</td>
									<td style='border:solid 1px'>".$row['Cantidad']."</td>
									<td style='border:solid 1px'>".$row['CalleNumero']."</td>
									<td style='border:solid 1px'>".$row['Colonia']."</td>
									<td style='border:solid 1px'>".$row['Ciudad']."</td>
									<td style='border:solid 1px'>".$row['CP']."</td>
									<td style='border:solid 1px'>".$row['Estado']."</td>
									<td style='border:solid 1px'>".$row['feSolicitud']."</td>
								  </tr>";
							
							$sql="UPDATE PreCanje SET esExportado = 1,fhExp=CURDATE(),folioExp=".$folioCarga."
								   WHERE noFolio=".$row['FolioCanjeWeb']." AND idParticipante=".$row['idParticipante']." AND codPrograma = 40";
							@mysql_query($sql);
						}
				}
			}else if($_GET['opc']==2){
				$sql="SELECT p.idParticipante,p.codEmpresa,e.NombreOficial,p.codParticipante,p.PrimerNombre,p.ApellidoPaterno,p.ApellidoMaterno
								,p.SaldoActual,p.pwd,w.pwd as pwdW FROM Participante p
								LEFT JOIN t10IClavesPartWeb w ON w.idParticipante = p.idParticipante AND w.codPrograma = p.codPrograma
								INNER JOIN Empresa e ON e.codPrograma = p.codPrograma AND e.codEmpresa = p.codEmpresa
								WHERE p.codPrograma = 40 AND p.status=1 ORDER BY p.codEmpresa,p.codParticipante";
				//echo $sql;				
				$res=mysql_query($sql);						

				if (mysql_num_rows($res)<1)
				{
						echo "<script>alert(\"No se encontraron Participantes\")</script>";
						echo "<script>window.location='../index.php'</script>";
				}else{
					header("Content-type: application/vnd.ms-excel");
					header("Content-Disposition:attachment; filename=ParticipantesBKPOINTS.xls");	
					//Creamos tabla			
					echo "<table style='border:solid 1 red;'>";
						echo "<tr>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>C�digo de Empresa</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Nombre de Empresa</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>C�digo de Participante</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Nombre(s)</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Apellido Paterno</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Apellido Materno</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Clave</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Contrase�a SIO</td>
								<td style='color:#fff;font-weight:bold;background:#123756;border:solid 1px'>Contrase�a Actual</td>
							  </tr>";
					while ($row=mysql_fetch_array($res))
					{
						$codEmpresa=$row['codEmpresa'];
						$codPart=$row['codParticipante'];
						
						while(!(strlen($codEmpresa)>4))
							$codEmpresa='0'.$codEmpresa;
							
						while(!(strlen($codPart)>2))
							$codPart='0'.$codPart;
							
						echo "<tr>
										<td style='border:solid 1px #000;'>".$row['codEmpresa']."</td>
										<td style='border:solid 1px #000;'>".$row['NombreOficial']."</td>
										<td style='border:solid 1px #000;'>".$row['codParticipante']."</td>
										<td style='border:solid 1px #000;'>".$row['PrimerNombre']."</td>
										<td style='border:solid 1px #000;'>".$row['ApellidoPaterno']."</td>
										<td style='border:solid 1px #000;'>".$row['ApellidoMaterno']."</td>
										<td style='border:solid 1px #000;'>'".$codEmpresa.$codPart."'</td>
										<td style='border:solid 1px #000;'>".$row['pwd']."</td>
										<td style='border:solid 1px #000;'>".$row['pwdW']."</td>
									</tr>";
					}
				  echo "</table>";	
				}				
			}
	
?>