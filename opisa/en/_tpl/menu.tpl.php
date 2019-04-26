<header id="menu-nav" class="navbar navbar-fixed-top" role="banner">

    <div class="container-fluid">

        <div class="container">

            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo $_n ?>index.html">
                    <img alt="Logotipo" src="<?php echo $_n ?>../img/logo.jpg" class="img-responsive">
                </a>

                <button class="navbar-toggle" data-target=".menu-collapse" data-toggle="collapse" type="button">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <nav class="navbar-collapse collapse menu-collapse">
                <ul class="nav navbar-nav navbar-right navbar-idiomas">
                    <li>
                        <a href="http://www.opisa.com/opisa/en/">
                            <img src="../img/flag-eua.png"> English
                        </a>
                    </li>
                    <li>
                        <a href="http://www.opisa.com/opisa/">
                            <img src="../img/flag-mex.png">Español
                        </a>
                    </li>
                </ul>

                <div class="clearfix"></div>

                <ul class="nav navbar-nav navbar-right">
                    <li <?php if ("nosotros" == $tpl["activo"]) echo "class = active"?>>
                        <a href="<?php echo "$_n"?>about-us.html">About us</a>
                    </li>
                    <li <?php if ("servicios" == $tpl["activo"]) echo "class = active"?>>
                        <a href="<?php echo "$_n"?>services.html">Services</a>
                    </li>
                    <li <?php if ("programas" == $tpl["activo"]) echo "class = active"?>>
                        <a href="<?php echo "$_n"?>programs.html">Programs</a>
                    </li>
                    <li <?php if ("catalogo" == $tpl["activo"]) echo "class = active"?>>
                        <a href="catalogue.html">Catalogue</a>
                    </li>
                    <li <?php if ("contacto" == $tpl["activo"]) echo "class = active"?>>
                        <a href="<?php echo "$_n"?>contact-us.html">Contact us</a>
                    </li>

                </ul>
            </nav>
        </div>

    </div>

</header>
<!--Final de Menu Principal responsivo-->