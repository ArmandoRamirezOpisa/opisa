<?php
	//Cabeceras para liberar cache
	   
	header("Expires: Sun, 19 Nov 1978 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

	//Archivos de conexión a base de datos
	include ('../include/local_dsn.php');
	include ('../include/dsn.php');

	$sql="SELECT id,usuario,pwd,nombre,saldo FROM t8IpartWeb WHERE codPrograma = 30";
	$res=mysql_query($sql);

	echo "<?xml version='1.0' encoding='ISO-8859-1'?>";
    echo "<participantes>";
	while ($row=mysql_fetch_array($res)){
		echo "<part>";
			echo "<id>".$row['id']."</id>";
			echo "<usr>".$row['usuario']."</usr>";
			echo "<pwd>".$row['pwd']."</pwd>";
			echo "<nom>".$row['nombre']."</nom>";
			echo "<saldo>".$row['saldo']."</saldo>";
		echo "</part>";
	}
	echo "</participantes>";
?>