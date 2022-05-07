<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', error_reporting(E_ALL));
session_start();

include __DIR__ . '/model/Model.php';
include __DIR__ . '/view/View.php';
$logedin = false;
$comentarios_login = "ok";

if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
} elseif (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
} else {
    $accion = 'mostrarIniciarSesion';
}

if($accion != 'iniciarSesion'){
    if (isset($_SESSION['id_admin']) && isset($_SESSION['contrasena']) && isset($_SESSION['tiempo'])){
        if($adminDb = obtenerAdminDb($_SESSION['id_admin'])->fetch_assoc()){
            if($_SESSION['contrasena'] == $adminDb['contrasena']) {
                if((time() - $_SESSION['tiempo']) > 600){
                    $comentarios_login = "tiempo_expirado";
                    $accion = 'mostrarIniciarSesion';
                    $logedin = false;
                    session_unset();
                }else{
                    $logedin = true;
                    $_SESSION['tiempo'] = time();
                }
            }else{
                $comentarios_login = "contrasena_incorrecta";
                $accion = 'mostrarIniciarSesion';
            }
        }else{
            $comentarios_login = "usuario_no_existe";
            $accion = 'mostrarIniciarSesion';
        }
    }else{
        $accion = 'mostrarIniciarSesion';
    }
}

switch ($accion) {
    case 'mostrarIniciarSesion':
        vMostrarIniciarSesion($comentarios_login);
        break;
    case 'iniciarSesion':
        $resultado_inicio_sesion = validarIniciarSesion();
        if($resultado_inicio_sesion == "sesion_iniciada"){
            vMostrarHome(obtenerDatosPagina());
        }else{
            vMostrarIniciarSesion($resultado_inicio_sesion);
        }
        break;
    case 'obtenerSeccionDatosPagina':
        vMostrarSeccionDatosPagina(obtenerDatosPagina());
        break;
    case 'obtenerSeccionCategoriasServicios':
        vMostrarSeccionCategoriasServicios(obtenerCategorias());
        break;
    case 'obtenerSeccionServicios':
        $datosServicios = obtenerDatosServicios();
        if(!$datosServicios[count($datosServicios)-1]){
            vMostrarSeccionServicios($datosServicios, obtenerCategorias());
        }else{
            vMostrarSeccionDatosPagina(obtenerDatosPagina(), "error_servicios_api");
        }
        break;
    case 'obtenerSeccionUsuarios':
        vMostrarSeccionUsuarios(obtenerUsuariosDb());
        break;
    case 'obtenerModificarDatos':
        vMostrarModificarDatos(obtenerDatosPagina());
        break;
    case 'guardarDatos':
        vMostrarHome(obtenerDatosPagina(), validarGuardarDatos());
        break;
    case 'eliminarCategoria':
        if (isset($_GET['id'])){
            $idCategoria = $_GET['id'];
            vMostrarHome(obtenerDatosPagina(), eliminarCategoria($idCategoria));
        }else{
            vMostrarHome(obtenerDatosPagina(), "error_id_eliminar_categoria");
        }
        break;
    case 'obtenerModificarCategoria':
        if (isset($_GET['id'])){
            $idCategoria = $_GET['id'];
            vMostrarModificarCategoria(obtenerCategoria($idCategoria));
        }else{
            vMostrarSeccionDatosPagina(obtenerDatosPagina(), "error_id_modificar_categoria");
        }
        break;
    case 'guardarDatosCategoria':
        vMostrarHome(obtenerDatosPagina(), validarGuardarDatosCategoria());
        break;
    case 'obtenerCrearNuevaCategoria':
        vMostrarCrearNuevaCategoria();
        break;
    case 'crearNuevaCategoria':
        vMostrarHome(obtenerDatosPagina(), anadirCategoria());
        break;
    case 'crearCsv':
        crearCsvUsuarios();
        break;
    case 'crearPdf':
        crearPdfServicios();
        break;
    case 'cerrarSesion':
        if($logedin == true){
            $logedin = false;
            session_unset();
        }
        vMostrarIniciarSesion();
        break;
}