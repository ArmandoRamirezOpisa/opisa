<?php
	session_start();
	class ini
	{
		static function main()
		{
			date_default_timezone_set('America/Tegucigalpa'); 
            require "libs/config.php";
			require "models/modelo.php"; //Contiene las consultas a bases de datos.
			require "views/vista.php"; //Contiene la interfaz de usuario.
              
            echo "<div id='principal'>";
			if ($_SESSION['login'])
			{
				echo inicio();
			}else{
				echo acceso();
			}
            echo "</div>";

		}
	}
?>