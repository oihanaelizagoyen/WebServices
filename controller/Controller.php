<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', error_reporting(E_ALL));
session_start();


include __DIR__ . "/../model/Model.php";
include __DIR__ . "/../view/View.php";
$logedin = false;

if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
} elseif (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
} else {
    $accion = 'home';
}

if (isset($_SESSION['id_usuario']) && isset($_SESSION['contrasena']) && isset($_SESSION['tiempo'])) {
    $user = $_SESSION['id_usuario'];
    $passwd = $_SESSION['contrasena'];
    $tiempo = $_SESSION['tiempo'];
    $logedin = true;

    /*
if ((time() - $tiempo) > 600) {
    $accion = "abrirIniciarSesion";
    session_unset();
} else {
    $_SESSION['tiempo'] = time();
}
*/
}

switch ($accion) {
    case 'home':
        if ($logedin == true) {
            vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosEmpleadoDb($_SESSION['id_usuario']));
        } else {
            vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias());
        }
        break;
    case 'abrirCategoria':
        if (isset($_GET['id'])) {
            $id_categoria = $_GET['id'];
            $datosServiciosArray = obtenerDatosServiciosArray($id_categoria, null);

            if (!$datosServiciosArray[count($datosServiciosArray)-1]) {
                if ($logedin == true) {
                    vMostrarCategoria($logedin, obtenerDatosPagina(), obtenerCategorias(), $datosServiciosArray, $id_categoria, obtenerDatosEmpleadoDb($_SESSION['id_usuario']));
                } else {
                    vMostrarCategoria($logedin, obtenerDatosPagina(), obtenerCategorias(), $datosServiciosArray, $id_categoria);
                }
            } else {
                if ($logedin == true) {
                    vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosEmpleadoDb($_SESSION['id_usuario']), "error_api_categoria");
                } else {
                    vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_api_categoria");
                }
            }
        } else {
            if ($logedin == true) {
                vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosEmpleadoDb($_SESSION['id_usuario']), "error_generico");
            } else {
                vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_generico");
            }
        }
        break;
    case 'ordenarServicios':
        if (isset($_GET['id'])) {
            $id_categoria = $_GET['id'];
            if (isset($_GET['valorOrdenacion'])) {
                $valorOrdenacion = $_GET['valorOrdenacion'];
                $datosServiciosArray = obtenerDatosServiciosArray($id_categoria, $valorOrdenacion);
                if (!$datosServiciosArray[count($datosServiciosArray) - 1]) {
                    vMostrarServiciosCategoriaOrdenados($datosServiciosArray);
                } else {
                    echo "";
                }
            } else {
                $datosServiciosArray = obtenerDatosServiciosArray($id_categoria, null);
                if (!$datosServiciosArray[3]) {
                    vMostrarServiciosCategoriaOrdenados($datosServiciosArray);
                } else {
                    echo "";
                }
            }
        } else {
            echo "";
        }
        break;
    case 'abrirServicio':
        if (isset($_GET['id'])) {
            $id_servicio = $_GET['id'];
            $datosServicioArray = obtenerDatosServicioArray($id_servicio);
            if (!$datosServicioArray[count($datosServicioArray) - 1]) {
                if ($logedin == true) {
                    vMostrarServicio($logedin, obtenerDatosPagina(), obtenerCategorias(), $datosServicioArray, obtenerDatosEmpleadoDb($_SESSION['id_usuario']));
                } else {
                    vMostrarServicio($logedin, obtenerDatosPagina(), obtenerCategorias(), $datosServicioArray);
                }
            } else {
                if ($logedin == true) {
                    vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosEmpleadoDb($_SESSION['id_usuario']), "error_api_servicio");
                } else {
                    vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_api_servicio");
                }
            }
        } else {
            if ($logedin == true) {
                vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosEmpleadoDb($_SESSION['id_usuario']), "error_generico");
            } else {
                vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_generico");
            }
        }
        break;
    case 'obtenerProvincias':
        if (isset($_GET['id'])) {
            $id_comunidad_autonoma = $_GET['id'];
        } else {
            $id_comunidad_autonoma = 1;
        }
        vMostrarProvincias(obtenerProvinciasComunidadAutonoma($id_comunidad_autonoma));
        break;
    case 'obtenerPoblaciones':
        if (isset($_GET['id'])) {
            $id_provincia = $_GET['id'];
        } else {
            $id_provincia = 1;
        }
        vMostrarPoblaciones(obtenerPoblacionesProvincia($id_provincia));
        break;
    case 'realizarReserva':
        if (isset($_POST['idServicio'])) {
            $id_servicio = $_POST['idServicio'];
            if ($logedin == true) {
                vMostrarServicio($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosServicioArray($id_servicio), obtenerDatosEmpleadoDb($_SESSION['id_usuario']), validarReserva());
            } else {
                vMostrarServicio($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosServicioArray($id_servicio), null, validarReserva());
            }
        } else {
            if ($logedin == true) {
                vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosEmpleadoDb($_SESSION['id_usuario']), "error_formulario_reserva");
            } else {
                vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_formulario_reserva");
            }
        }
        break;
    case 'abrirPerfil':
        if (isset($_GET['id'])) {
            $id_usuario = $_GET['id'];
            $datosPerfilArray = obtenerDatosPerfilArray($id_usuario);
            if (!$datosPerfilArray[count($datosPerfilArray) - 1]) {
                if ($logedin == true) {
                    vMostrarPerfil($logedin, obtenerDatosPagina(), obtenerCategorias(), $datosPerfilArray, obtenerDatosEmpleadoDb($_SESSION['id_usuario']));
                } else {
                    vMostrarPerfil($logedin, obtenerDatosPagina(), obtenerCategorias(), $datosPerfilArray);
                }
            } else {
                if ($logedin == true) {
                    vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosEmpleadoDb($_SESSION['id_usuario']), "error_api_perfil");
                } else {
                    vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_api_perfil");
                }
            }
        } elseif (isset($_SESSION['id_usuario'])) {
            $id_usuario = $_SESSION['id_usuario'];
            $datosPerfilArray = obtenerDatosPerfilArray($id_usuario);
            if (!$datosPerfilArray[count($datosPerfilArray) - 1]) {
                vMostrarPerfil($logedin, obtenerDatosPagina(), obtenerCategorias(), $datosPerfilArray, obtenerDatosEmpleadoDb($_SESSION['id_usuario']));
            } else {
                vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosEmpleadoDb($_SESSION['id_usuario']), "error_api_perfil");
            }
        } else {
            vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_generico");
        }
        break;
    case 'cancelarCita':
        if (isset($_GET['idUsuario'])) {
            $id_usuario = $_GET['idUsuario'];
            if ($logedin == true) {
                vMostrarPerfil($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosPerfilArray($id_usuario), obtenerDatosEmpleadoDb($_SESSION['id_usuario']), validarCancelarCita());
            } else {
                vMostrarPerfil($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosPerfilArray($id_usuario), null, validarCancelarCita());
            }
        } else {
            if ($logedin == true) {
                vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosEmpleadoDb($_SESSION['id_usuario']), "error_generico");
            } else {
                vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_generico");
            }
        }
        break;
    case 'abrirRegistrar':
        if ($logedin == false) {
            vMostrarRegistrar(obtenerDatosPagina(), obtenerComunidadesAutonomas(), obtenerProvincias(), obtenerPoblaciones());
        } else {
            vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_generico");
        }
        break;
    case 'abrirIniciarSesion':
        if ($logedin == false) {
            vMostrarIniciarSesion(obtenerDatosPagina());
        } else {
            vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_generico");
        }
        break;
    case 'abrirNuevoServicio':
        if ($logedin == true) {
            vMostrarNuevoServicio(obtenerDatosPagina(), obtenerCategorias(), obtenerDatosEmpleadoDb($_SESSION['id_usuario']));
        } else {
            vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_generico");
        }
        break;
    case 'abrirEditarPerfil':
        if ($logedin == true) {
            //Me faltaría obtener los datos de la base y del api -->Modificar Empresa, Empleado API Y BBDD
            vMostrarEditarPerfil(obtenerDatosPagina(), obtenerComunidadesAutonomas(), obtenerProvincias(), obtenerPoblaciones());
        } else {
            vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_generico");
        }
        break;
    case 'nuevoServicio':
        if ($logedin == true) {
            if (isset($_SESSION['id_usuario'])) {
                $respuesta = crearServicio($_SESSION['id_usuario']);
                if ($respuesta == 'ok') {
                    vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosEmpleadoDb($_SESSION['id_usuario']), "servicio_ok");
                } else {
                    vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosEmpleadoDb($_SESSION['id_usuario']), "error_nuevo_servicio");
                }
            } else {
                vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosEmpleadoDb($_SESSION['id_usuario']), "error_generico");
            }
        } else {
            vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosEmpleadoDb($_SESSION['id_usuario']), "error_generico");
        }
        break;
    case 'iniciarSesion':
        if ($logedin == false) {
            $erroresinicio = iniciarSesion();
            if ($erroresinicio == "sesion_iniciada") {
                $logedin = true;
                vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), obtenerDatosEmpleadoDb($_SESSION['id_usuario']), "inicio_ok");
            } else {
                vMostrarIniciarSesion(obtenerDatosPagina(), "error");
            }
        } else {
            vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_generico");
        }
        break;
    case 'registrar':
        if ($logedin == false) {
            echo "hola";
            $empresa = crearEmpresaApi();
            if (isset($empresa['id'])) {

                $id_empresa = $empresa['id'];
                $empleado = crearEmpleadoApi($id_empresa);

                if (isset($empleado['id'])) {
                    $id_empleado = $empleado['id'];

                    $comprobacion = crearEmpleadoDb($id_empleado, $id_empresa);

                    if ($comprobacion = "ok") {
                        //iniciar sesion
                        vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "registro_ok");
                    } else {
                        //Error al crear el empleado en la base de datos
                        vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_empleado_db");
                    }

                } else {
                    //Error al crear el empleado
                    vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_empleado_api");
                }

            } else {
                //Error al crear la empresa
                vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_empresa_api");
            }
        } else {
            vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "error_generico");
        }
        break;
    case 'token':
        if (isset($_POST['ftoken'])) {
            $token = $_POST['ftoken'];
            setcookie("graph_token", $token, time() + (1800));
            echo "Token guardado";
        } else {
            echo "falta token";
        }
        break;
    case 'cerrarSesion':
        if ($logedin == true) {
            $logedin = false;
            session_unset();
        }
        vMostrarHome($logedin, obtenerDatosPagina(), obtenerCategorias(), null, "ok_cerrarsesion");
        break;
}