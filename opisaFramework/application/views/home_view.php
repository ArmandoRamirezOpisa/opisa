    <!-- Cuerpo de la pagina de OPISA -->
    <div class="main">
        <div class="nosotros-data">
            <img src="assets/img/nosotros.jpg" alt="Nosotros" class="img-responsive nosotros-img">
            <p class="text-info-img">
                Hacemos que las cosas sucedan, somos líderes y pioneros en el negocio de la motivación en México.
            </p>
        </div>
        <div class="nosotros-info">
            <div class="nosotros-info-text">
                <h2 class="text-color-title">Nosotros</h2>
                <p class="text-info">Somos una empresa 100% mexicana, líderes y pioneros en el negocio de la motivación y de la fidelidad en nuestro país desde 1990.</p>
            </div>
            <div class="nosotros-opciones">
                <div class="nosotros-quienes nosotros-menu">
                    <a href="<?php echo site_url('Welcome/nosotros');?>">
                        <i class="fas fa-user-tie"></i> <span>¿Quiénes Somos?</span>
                    </a>
                </div>
                <div class="nosotros-hacemos nosotros-menu">
                    <a href="<?php echo site_url('Welcome/nosotros');?>">
                        <i class="fas fa-lightbulb"></i> <span>¿Qué Hacemos?</span>
                    </a>
                </div>
                <div class="nosotros-mision nosotros-menu">
                    <a href="<?php echo site_url('Welcome/nosotros');?>">
                        <i class="fas fa-flag"></i> <span>Misión</span>
                    </a>
                </div>
                <div class="nosotros-vision nosotros-menu">
                    <a href="<?php echo site_url('Welcome/nosotros');?>">
                        <i class="fas fa-eye"></i> <span>Visión</span>
                    </a>
                </div>
                <div class="nosotros-organizacion nosotros-menu">
                    <a href="<?php echo site_url('Welcome/nosotros');?>">
                        <i class="fas fa-sitemap"></i> <span>Nuestra Organización</span>
                    </a>
                </div>
                <div class="nosotros-valores nosotros-menu">
                    <a href="<?php echo site_url('Welcome/nosotros');?>">
                        <i class="fas fa-scroll"></i> <span>Valores</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="servicios-data">
            <img src="assets/img/servicios.png" class="img-responsive">
            <p class="text-info-img">La mejor decisión para su negocio.</p>
        </div>

        <div class="serivicios-info">
            <div class="nosotros-info-text">
                <h2 class="text-color-title">Servicios</h2>
                <p class="text-info">Contamos con la experiencia en administración, diseño y fullfilment en programas de incentivos, procesamiento de órdenes y comunicación con nuestros participantes</p>
            </div>
            <div class="servicios-opciones">
                <div class="servicios-administracion servicios-menu">
                    <a href="<?php echo site_url('Welcome/servicios');?>">
                        <i class="fas fa-toolbox"></i> <span>Administración</span>
                    </a>
                </div>
                <div class="servicios-fulfillment servicios-menu">
                    <a href="<?php echo site_url('Welcome/servicios');?>">
                        <i class="fas fa-list-alt"></i> <span>Fulfillment</span>
                    </a>
                </div>
                <div class="servicios-comunicaciones servicios-menu">
                    <a href="<?php echo site_url('Welcome/servicios');?>">
                        <i class="fas fa-comments"></i> <span>Comuncaciones</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="programas-data">
            <img src="assets/img/programas.png " class="img-responsive ">
            <p class="text-info-img">Queremos que su negocio llegue más lejos.</p>
        </div>

        <div class="programas-info">
            <div class="nosotros-info-text">
                <h2 class="text-color-title">Programas</h2>
                <p class="text-info">Nuestros programas están orientados a estimular las ventas, mejorar el desempeño del capital humano y aumentar la lealtad del consumidor</p>
            </div>
            <div class="programas-opciones">
                <div class="programas-mercado programas-menu">
                    <a href="<?php echo site_url('Welcome/programas');?>">
                        <i class="fas fa-shopping-cart"></i> <span>Mercado Intermedio</span>
                    </a>
                </div>
                <div class="programas-consumidor programas-menu">
                    <a href="<?php echo site_url('Welcome/programas');?>">
                        <i class="fas fa-shopping-bag"></i> <span>Consumidor</span>
                    </a>
                </div>
                <div class="programas-productividad programas-menu">
                    <a href="<?php echo site_url('Welcome/programas');?>">
                        <i class="fas fa-user-md"></i> <span>Productividad de Empleados</span>
                    </a>
                </div>
                <div class="programas-fuerza programas-menu">
                    <a href="<?php echo site_url('Welcome/programas');?>">
                        <i class="fas fa-chart-bar"></i> <span>Fuerza de Venta</span>
                    </a>
                </div>
            </div>
        </div>
        <div id="contactOPI" class="contacto">
            <h2>Contacto</h2>
            <div class="contacto-info">
                <div class="contacto-location">
                    <div class="direccion">
                        <i class="fas fa-map-marker"></i> <span>Vicente Segura No. 10 int. 4, Col. Lomas de Sotelo
                                    C.P. 53390, Naucalpan, Estado de México.</span>
                    </div>
                    <div class="telefono">
                        <i class="fas fa-phone-alt"></i> <span>55 5359 3000</span>
                    </div>
                    <div class="correo">
                        <i class="fas fa-envelope"></i> <span>info@opisa.com</span>
                    </div>
                </div>
                <div class="contacto-form">
                    <small id="alert" class="alert-primary">Algo campo que escribiste esta vacio</small>
                    <form>
                        <input type="text" name="nombrePersona" id="nombrePersona" class="input-text" placeholder="Escribe tu nombre">
                        <input type="email" name="correoPersona" id="correoPersona" class="input-text" placeholder="Escribe tu correo">
                        <input type="tel" name="telefonoPersona" id="telefonoPersona" class="input-text" placeholder="Escribe tu telefono">
                        <input type="text" name="empresaPersona" id="empresaPersona" class="input-text" placeholder="Escribe tu empresa (Opcional)">
                        <textarea name="mensajePersona" id="mensajePersona" class="input-text" cols="30" rows="10" placeholder="Escribe tu mensaje"></textarea>
                        <button id="btnEnviarCorreo" type="button" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- fin del Cuerpo de la pagina de OPISA -->