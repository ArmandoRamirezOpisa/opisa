<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Programas de incentivos">
    <meta name="keywords" content="incentivos,Premios,Programas">
    <meta name="author" content="Opisa 2019">
    <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../assets/lib/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/materialize.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-168470096-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-168470096-1');
    </script>
    <title>OPI</title>
</head>

<body>
    <header class="headerMenu">
        <a href="<?php echo site_url('Welcome');?>">
            <img src="../assets/img/logo.jpg" alt="OPISA" class="logo">
        </a>
        <nav>
            <a href="#" class="line-menu hide-desktop">
                <div class="menu-btn">
                    <div class="btn-line"></div>
                    <div class="btn-line"></div>
                    <div class="btn-line"></div>
                </div>
            </a>
            <ul class="show-desktop hide-mobile" id="nav">
            <li class="nav-item"><a href="<?php echo site_url('Welcome/nosotros');?>"><i class="far fa-id-card"></i> Nosotros</a></li>
                <li class="nav-item"><a href="<?php echo site_url('Welcome/servicios');?>"><i class="fas fa-book"></i> Servicios</a></li>
                <li class="nav-item"><a href="<?php echo site_url('Welcome/programas');?>"><i class="fas fa-info-circle"></i> Programas</a></li>
                <li class="nav-item"><a href="<?php echo site_url('Welcome/catalogo');?>"><i class="fas fa-newspaper"></i> Catálogo</a></li>
                <li class="nav-item"><a href="<?php echo site_url('Welcome#contactOPI');?>"><i class="fas fa-address-book"></i> Contacto</a></li>
            </ul>
        </nav>
    </header>
    <div class="main">
        <div class="catalogo">
            <h2>Catálogo</h2>
            <p>
                Contamos con un atractivo catálogo de premios en varias categorías. Solicite el catálogo vigente a <strong>info@opisa.com</strong>
            </p>
        </div>
        <div class="catalogo-img">
            <div class="col xl12 xl12">
                <div class="carousel">
                    <div class="carousel-item">
                        <img src="../assets/img/carrusel/01-reconocelo.PNG" alt="Catalogo 01" class="catalogo-imagen">
                    </div>
                    <div class="carousel-item">
                        <img src="../assets/img/carrusel/02-reconocelo.PNG" alt="Catalogo 02" class="catalogo-imagen">
                    </div>
                    <div class="carousel-item">
                        <img src="../assets/img/carrusel/03-reconocelo.PNG" alt="Catalogo 03" class="catalogo-imagen">
                    </div>
                    <div class="carousel-item">
                        <img src="../assets/img/carrusel/04-reconocelo.PNG" alt="Catalogo 04" class="catalogo-imagen">
                    </div>
                </div>
            </div>
            <!--<img src="../assets/img/catalogo-reconocelo.JPG" alt="" class="catalogo-imagen">-->
        </div>
    </div>
    <footer class="footer">
        <span>Copyright &copy; 2020 OPISA</span>
        <hr>
        <span>Todos los derechos reservados</span>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="../assets/js/materialize.js"></script>
    <script src="../assets/js/main.js "></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const elementosCarrusel = document.querySelectorAll('.carousel');
        M.Carousel.init(elementosCarrusel, {
            duration: 150
        });
});
    </script>
</body>

</html>