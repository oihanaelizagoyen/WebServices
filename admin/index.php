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
            vMostrarHome(obtenerDatosPagina(), "error_servicios_api");
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
        break;
    case 'obtenerCambiarCategoria':
        break;
    case 'crearNuevaCategoria':
        break;
    case 'crearCategoria':
        break;
}