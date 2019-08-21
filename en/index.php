<!DOCTYPE html>

<html lang="es">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>OPISA</title>

        <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon/>

        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/estilos.css" rel="stylesheet">
        <link href="../css/opisa.css" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">

    </head>

    <body>

        <?php include '_tpl/menu.tpl.php'; ?>

        <?php include '_contenido/_index.php';  ?>

        <footer class="piePagina">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <p>Copyright © 2017 OPISA</p>
                        <p>Todos los derechos reservados</p>
                    </div>
                </div>
            </div>
        </footer>

        <span id="top-contenedor">
            <a href="#" class="top-link" onclick="$('html,body').animate({scrollTop:0},'slow');return false;">
                <i class="glyphicon glyphicon-chevron-up"></i>
            </a>
        </span>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/index.onload.js"></script>

    </body>

</html>