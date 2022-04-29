<?php
    ini_set('display_errors',1);
    ini_set('display_startup_errors',error_reporting(E_ALL));

    include __DIR__ ."/../model/Model.php";
    include __DIR__ ."/../view/View.php";

    if(isset($_GET['accion'])) {
        $accion = $_GET['accion'];
    } elseif(isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = 'home';
    }

    switch ($accion) {
        case 'home':
            vMostrarHome(obtenerDatosPagina(), obtenerCategorias());
            break;
        case 'abrirCategoria':
            if(isset($_GET['id'])) {
                $id_categoria = $_GET['id'];
                vMostrarCategoria(obtenerDatosPagina(), obtenerCategorias(), $id_categoria);
            } else {
                echo "Hola";
                vMostrarHome(obtenerDatosPagina(), obtenerCategorias());
            }
            break;

    }