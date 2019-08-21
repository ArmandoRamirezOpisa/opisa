<?php

    $tpl = array(
         "titulo"    => "OPI"
        ,"contenido" => "_contenido/_".basename(__FILE__)
        ,"menu"      => "_tpl/menu.tpl.php"
        ,"activo"    => "inicio"
    );

    $_n = "";

    include "_tpl/base.tpl.php";
?>