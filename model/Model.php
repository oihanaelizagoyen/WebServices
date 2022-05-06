<?php
require_once __DIR__ . '/DatabaseConnSingleton.php';
require_once __DIR__ . '/Curl.php';

function obtenerDatosPagina()
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaDatosPagina = "select nombre, logo, descripcion, imagen_descripcion from final_DatosPagina;";
    $resultadoDatosPagina = $conn->query($consultaDatosPagina);
    return $resultadoDatosPagina;
}

function obtenerCategorias()
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaCategorias = "select * from final_Categoria;";
    $resultadoCategorias = $conn->query($consultaCategorias);
    return $resultadoCategorias;
}

function obtenerServiciosCategoriaDb($id_categoria, $criterioOrdenacion)
{
    $conn = DatabaseConnSingleton::getConn();
    if ($criterioOrdenacion == 'precio_caros_primero') {
        $consultaServicios = "select * from final_Servicio where id_categoria = $id_categoria order by precio DESC;";
    } elseif ($criterioOrdenacion == 'precio_baratos_primero') {
        $consultaServicios = "select * from final_Servicio where id_categoria = $id_categoria order by precio ASC;";
    } elseif ($criterioOrdenacion == 'fecha_nuevos_primero') {
        $consultaServicios = "select * from final_Servicio where id_categoria = $id_categoria order by fecha_publicacion DESC;";
    } elseif ($criterioOrdenacion == 'fecha_antiguos_primero') {
        $consultaServicios = "select * from final_Servicio where id_categoria = $id_categoria order by fecha_publicacion ASC;";
    } else {
        $consultaServicios = "select * from final_Servicio where id_categoria = $id_categoria;";
    }
    $resultadoServicios = $conn->query($consultaServicios);
    return $resultadoServicios;
}

function obtenerDatosEmpleadoDb($id_usuario)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaEmpleado = "select id, nombre, imagen_perfil, id_empresa from final_Usuario where id = \"" . $id_usuario . "\";";
    $resultadoEmpleado = $conn->query($consultaEmpleado);
    return $resultadoEmpleado;
}

function crearEmpleadoDb($id_empleado, $id_empresa)
{
    if (isset($_POST['correo']) &&
        isset($_POST['contrasena']) &&
        isset($_POST['nombre']) &&
        isset($_POST['experiencia'])) {

        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];
        $experiencia = $_POST['experiencia'];
        $nombre = $_POST['nombre'];
        $vehiculo = 0;

        if (isset($_POST['vehiculo'])) {
            if ($_POST['vehiculo'] == 'on') {
                $vehiculo = 1;
            }
        } else {
            $vehiculo = 0;
        }

        $tipo = $_FILES['imgPerfil']['type'];

        if ($tipo == "image/jpg") {
            $nombrefichero = time() . "-" . uniqid() . ".jpg";
        } elseif ($tipo = "image/jpeg") {
            $nombrefichero = time() . "-" . uniqid() . ".jpeg";
        } elseif ($tipo = "image/png") {
            $nombrefichero = time() . "-" . uniqid() . ".png";
        } elseif ($tipo = "image/gif") {
            $nombrefichero = time() . "-" . uniqid() . ".gif";
        } else {
            return "error";
        }

        $temporal = $_FILES['imgPerfil']['tmp_name'];
        //chmod($temporal, 777);

        if (!move_uploaded_file($temporal, '../imagenes/fotosperfil/' . $nombrefichero)) {
            return "error";
        }

        $hashed_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        $conn = DatabaseConnSingleton::getConn();
        if ($conn->query("INSERT INTO final_Usuario (id, contrasena, vehiculo_propio, email, experiencia, id_empresa, imagen_perfil, nombre) VALUES ('" . $id_empleado . "','" . $hashed_contrasena . "','" . $vehiculo . "','" . $correo . "','" . $experiencia . "','" . $id_empresa . "','" . $nombrefichero . "','" . $nombre . "')") == TRUE) {
            return "ok";
        } else {
            DatabaseConnSingleton::closeConn();
            return "error";
        }
    } else {
        return "error_datos";
    }
}

function iniciarSesion()
{
    if (isset($_POST['correo']) &&
        isset($_POST['contrasena'])) {
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];

        $conn = DatabaseConnSingleton::getConn();
        $consultaInicioSesion = "select * from final_Usuario where email = \"" . $correo . "\";";
        if ($resultadoSesion = $conn->query($consultaInicioSesion)) {
            if ($resultadoSesionArray = $resultadoSesion->fetch_assoc()) {
                if (password_verify($contrasena, $resultadoSesionArray['contrasena'])) {
                    $_SESSION['id_usuario'] = $resultadoSesionArray['id'];
                    //Es la contraseña hashseada
                    $_SESSION['contrasena'] = $resultadoSesionArray['contrasena'];
                    $_SESSION['tiempo'] = time();

                    return "sesion_iniciada";
                }
            } else {
                return "error_consulta";
            }

        } else {
            //Ha ocurrido un error con la base de datos
            return "error_base";
        }

    } else {
        //Se an enviado los datos de forma incorrecta
        return "error_datos";
    }
}

function obtenerNombreComunidadAutonomaPorId($id)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaNombre = "select * from final_ComunidadAutonoma where id = " . $id . ";";
    $resultadoNombre = $conn->query($consultaNombre);
    $nombre_array = $resultadoNombre->fetch_assoc();
    $nombre = $nombre_array['nombre'];
    return $nombre;
}

function obtenerNombreProvinciaPorId($id)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaNombre = "select * from final_Provincia where id = " . $id . ";";
    $resultadoNombre = $conn->query($consultaNombre);
    $nombre_array = $resultadoNombre->fetch_assoc();
    $nombre = $nombre_array['nombre'];
    return $nombre;
}

function obtenerNombrePoblacionPorId($id)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaNombre = "select * from final_Poblacion where id = " . $id . ";";
    $resultadoNombre = $conn->query($consultaNombre);
    $nombre_array = $resultadoNombre->fetch_assoc();
    $nombre = $nombre_array['nombre'];
    return $nombre;
}

function obtenerServicioApi($id_empresa, $id_servicio)
{
    $curl = new Curl();
    $respuesta = $curl->getGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $id_empresa . '/services/' . $id_servicio);
    return $respuesta;
}
/*
function obtenerServiciosApi($id_empresa, $id_servicio)
{
    $curl = new Curl();
    $respuesta = $curl->getGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $id_empresa . '/services/' . $id_servicio);
    return $respuesta;
}
*/

/*
function obtenerEmpresaApi($id_empresa)
{
    $curl = new Curl();
    $respuesta = $curl->getGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $id_empresa);
    return $respuesta;
}
*/

function obtenerUsuarioApi($id_empresa, $id_usuario)
{
    $curl = new Curl();
    $respuesta = $curl->getGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $id_empresa . '/staffmembers/' . $id_usuario);
    return $respuesta;
}

function obtenerDatosServiciosArray($id_categoria, $valorOrdenacion)
{
    $datos = obtenerServiciosCategoriaDb($id_categoria, $valorOrdenacion);

    $serviciosDb = array();
    $serviciosApi = array();
    $usuariosApi = array();
    $errores = false;
    while ($datosServicioDb = $datos->fetch_assoc()) {
        $serviciosDb[] = $datosServicioDb;
        $serviciosApi[] = obtenerServicioApi($datosServicioDb['id_empresa'], $datosServicioDb['id']);
        if (!isset($serviciosApi[count($serviciosApi) - 1]["id"])) {
            $errores = true;
        }
        $usuariosApi[] = obtenerUsuarioApi($datosServicioDb['id_empresa'], $datosServicioDb['id_usuario']);
        if (!isset($usuariosApi[count($usuariosApi) - 1]["id"])) {
            $errores = true;
        }
    }

    $resultado = [$serviciosDb, $serviciosApi, $usuariosApi, $errores];

    return $resultado;
}

function obtenerServicioDb($id_servicio)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaServicio = "select * from final_Servicio where id = \"$id_servicio\";";
    $resultadoServicio = $conn->query($consultaServicio);
    return $resultadoServicio;
}

function obtenerUsuarioDb($id_usuario)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaUsuario = "select * from final_Usuario where id = \"$id_usuario\";";
    $resultadoUsuario = $conn->query($consultaUsuario);
    return $resultadoUsuario;
}

function obtenerComunidadesAutonomas()
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaComunidadesAutonomas = "select * from final_ComunidadAutonoma;";
    $resultadoComunidadesAutonomas = $conn->query($consultaComunidadesAutonomas);
    return $resultadoComunidadesAutonomas;
}

function obtenerProvincias()
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaProvincias = "select * from final_Provincia;";
    $resultadoProvincias = $conn->query($consultaProvincias);
    return $resultadoProvincias;
}

function obtenerPoblaciones()
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaPoblaciones = "select * from final_Poblacion;";
    $resultadoPoblaciones = $conn->query($consultaPoblaciones);
    return $resultadoPoblaciones;
}

function obtenerDatosServicioArray($id_servicio)
{
    $datosServicio = obtenerServicioDb($id_servicio);

    $errores = false;
    $servicioDb = $datosServicio->fetch_assoc();
    $servicioApi = obtenerServicioApi($servicioDb['id_empresa'], $servicioDb['id']);
    if (!isset($servicioApi["id"])) {
        $errores = true;
    }
    $usuarioApi = obtenerUsuarioApi($servicioDb['id_empresa'], $servicioDb['id_usuario']);
    if (!isset($usuarioApi["id"])) {
        $errores = true;
    }
    $usuarioDb = obtenerUsuarioDb($servicioDb['id_usuario'])->fetch_assoc();
    $comunidadesAutonomas = obtenerComunidadesAutonomas();
    $provincias = obtenerProvincias();
    $poblaciones = obtenerPoblaciones();

    $resultado = [$servicioDb, $servicioApi, $usuarioApi, $usuarioDb, $comunidadesAutonomas, $provincias, $poblaciones, $errores];

    return $resultado;
}

function obtenerProvinciasComunidadAutonoma($id_comunidad_autonoma)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaProvincias = "select * from final_Provincia where id_comunidad_autonoma = $id_comunidad_autonoma;";
    $resultadoProvincias = $conn->query($consultaProvincias);
    return $resultadoProvincias;
}

function obtenerPoblacionesProvincia($id_provincia)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaPoblaciones = "select * from final_Poblacion where id_provincia = $id_provincia;";
    $resultadoPoblaciones = $conn->query($consultaPoblaciones);
    return $resultadoPoblaciones;
}

function obtenerComunidadAutonoma($id_comunidad_autonoma)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaComunidadAutonoma = "select * from final_ComunidadAutonoma where id = $id_comunidad_autonoma;";
    $resultadoComunidadAutonoma = $conn->query($consultaComunidadAutonoma);
    return $resultadoComunidadAutonoma;
}

function obtenerProvincia($id_provincia)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaProvincia = "select * from final_Provincia where id = $id_provincia;";
    $resultadoProvincia = $conn->query($consultaProvincia);
    return $resultadoProvincia;
}

function obtenerPoblacion($id_poblacion)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaPoblacion = "select * from final_Poblacion where id = $id_poblacion;";
    $resultadoPoblacion = $conn->query($consultaPoblacion);
    return $resultadoPoblacion;
}

function validarReserva()
{
    if (isset($_POST['idUsuario']) && isset($_POST['idServicio']) && isset($_POST['idEmpresa']) &&
        isset($_POST['nombre_apellidos']) && isset($_POST['email']) && isset($_POST['telefono']) &&
        isset($_POST['dia']) && isset($_POST['hora_inicio']) && isset($_POST['hora_fin']) &&
        isset($_POST['comunidad_autonoma']) && isset($_POST['provincia']) && isset($_POST['poblacion']) &&
        isset($_POST['calle_portal_piso'])) {

        $idUsuario = $_POST['idUsuario'];
        $idServicio = $_POST['idServicio'];
        $idEmpresa = $_POST['idEmpresa'];
        $nombre_apellidos = $_POST['nombre_apellidos'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $dia = $_POST['dia'];
        $hora_inicio = $_POST['hora_inicio'];
        $hora_fin = $_POST['hora_fin'];
        $comunidad_autonoma = obtenerComunidadAutonoma($_POST['comunidad_autonoma'])->fetch_assoc();
        $nombre_comunidad_autonoma = $comunidad_autonoma['nombre'];
        $provincia = obtenerProvincia($_POST['provincia'])->fetch_assoc();
        $nombre_provincia = $provincia['nombre'];
        $poblacion = obtenerPoblacion($_POST['poblacion'])->fetch_assoc();
        $nombre_poblacion = $poblacion['nombre'];
        $calle_portal_piso = $_POST['calle_portal_piso'];

        $datos_cliente = array(array(
            "@odata.type" => "#microsoft.graph.bookingCustomerInformation",
            "name" => $nombre_apellidos,
            "emailAddress" => $email,
            "phone" => $telefono,
            "timeZone" => "Europe/Paris"
        ));
        $fecha_inicio = array(
            "@odata.type" => "#microsoft.graph.dateTimeTimeZone",
            "dateTime" => $dia . "T" . $hora_inicio . "+02:00",
            "timeZone" => "Europe/Paris"
        );
        $fecha_fin = array(
            "@odata.type" => "#microsoft.graph.dateTimeTimeZone",
            "dateTime" => $dia . "T" . $hora_fin . "+02:00",
            "timeZone" => "Europe/Paris"
        );
        $direccion = array(
            "@odata.type" => "#microsoft.graph.physicalAddress",
            "city" => $nombre_poblacion,
            "state" => $nombre_provincia,
            "countryOrRegion" => $nombre_comunidad_autonoma,
            "street" => $calle_portal_piso
        );
        $localizacion_servicio = array(
            "@odata.type" => "#microsoft.graph.location",
            "address" => $direccion
        );
        $idsUsuarios = array($idUsuario);

        $datos = array(
            "customers" => $datos_cliente,
            "startDateTime" => $fecha_inicio,
            "endDateTime" => $fecha_fin,
            "serviceId" => $idServicio,
            "serviceLocation" => $localizacion_servicio,
            "staffMemberIds" => $idsUsuarios,
            "customerTimeZone" => "Europe/Paris",
            "maximumAttendeesCount" => 1
        );

        $curl = new Curl();
        $respuesta = $curl->postGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $idEmpresa . '/appointments', $datos);

        if (isset($respuesta["id"])) {
            return "ok_reserva";
        } else {
            return "error_cita_api";
        }

    } else {
        //Error al enviar el formulario
        return "error_formulario_reserva";
    }
}

function obtenerServiciosUsuarioDb($id_usuario)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaServiciosUsuario = "select * from final_Servicio where id_usuario = \"$id_usuario\";";
    $resultadoServiciosUsuario = $conn->query($consultaServiciosUsuario);
    return $resultadoServiciosUsuario;
}

function obtenerCitasApi($id_empresa)
{
    $curl = new Curl();
    $respuesta = $curl->getGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $id_empresa . '/appointments');
    return $respuesta;
}

function obtenerCitaApi($id_empresa, $id_cita)
{
    $curl = new Curl();
    $respuesta = $curl->getGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $id_empresa . '/appointments/' . $id_cita);
    return $respuesta;
}

function obtenerDatosPerfilArray($id_usuario)
{
    $errores = false;
    $usuarioDb = obtenerUsuarioDb($id_usuario)->fetch_assoc();
    $usuarioApi = obtenerUsuarioApi($usuarioDb['id_empresa'], $id_usuario);
    if (!isset($usuarioApi["id"])) {
        $errores = true;
    }
    $datosServiciosDb = obtenerServiciosUsuarioDb($id_usuario);
    $serviciosDb = array();
    $serviciosApi = array();
    while ($datosServicioDb = $datosServiciosDb->fetch_assoc()) {
        $serviciosDb[] = $datosServicioDb;
        $serviciosApi[] = obtenerServicioApi($datosServicioDb['id_empresa'], $datosServicioDb['id']);
        if (!isset($serviciosApi[count($serviciosApi) - 1]["id"])) {
            $errores = true;
        }
    }
    $resultadoCitasApi = obtenerCitasApi($usuarioDb['id_empresa']);
    if (!isset($resultadoCitasApi["value"])) {
        $errores = true;
    }

    $citasApi = array();
    if(isset($resultadoCitasApi["value"])) {
        $listaCitasApi = $resultadoCitasApi["value"];
        for ($numCita = 0; $numCita < count($listaCitasApi); $numCita++) {
            $citasApi[] = obtenerCitaApi($usuarioDb['id_empresa'], $listaCitasApi[$numCita]["id"]);
            if (!isset($citasApi[count($citasApi) - 1]["id"])) {
                $errores = true;
            }
        }
    }else{
        $errores = true;
    }

    $resultado = [$usuarioDb, $usuarioApi, $serviciosDb, $serviciosApi, $citasApi, $errores];
    return $resultado;
}

function validarCancelarCita()
{
    if (isset($_GET['idCita']) && isset($_GET['idUsuario'])) {
        $idCita = $_GET['idCita'];
        $idUsuario = $_GET['idUsuario'];
        $usuarioDb = obtenerUsuarioDb($idUsuario)->fetch_assoc();
        $idEmpresa = $usuarioDb['id_empresa'];
        $emailUsuario = $usuarioDb['email'];

        $datos = array(
            "cancellationMessage" => "Su cita ha sido cancelada por la persona que ofrece el servicio. Para cualquier consulta contacte con ella por medio de correo electrónico: \"" . $emailUsuario . "\""
        );

        $curl = new Curl();
        $respuesta = $curl->postGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $idEmpresa . '/appointments/' . $idCita . '/cancel', $datos);

        if (empty($respuesta)) {
            return "ok_cancelacion";
        } else {
            return "error_cancelacion_api";
        }

    } else {
        return "error_cancelar_cita";
    }
}

function obtenerEmpleado($id_usuario)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaEmpresa = "select id_empresa from final_Usuario where id = \"" . $id_usuario . "\";";
    if ($resultadoEmpresa = $conn->query($consultaEmpresa)) {
        return $resultadoEmpresa;
    }
    return "error_bd";
}

function obtenerEmpresaPorIdApi($id_empresa)
{
    $curl = new Curl();
    $datosempresa = $curl->getGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $id_empresa);

    if (isset($datosempresa['address'])) {
        return $datosempresa;
    } else {
        //echo "No se ha encontrado empresa";
        return "error_obtener_empresa";
    }
}

function obtenerDatosParaEditarPerfil($id_usuario)
{
    $datos = array();
    $datosempleado = obtenerUsuarioDb($id_usuario);
    $datos[] = $datosempleado->fetch_assoc(); //Pos 0 ususariodb

    $datosempleado = obtenerUsuarioApi($datos[0]['id_empresa'], $datos[0]['id']); //Pos 1 usuarioapi
    if (!isset($datosempleado['id'])){
        return "error_api";
    }
    $datos[] = $datosempleado;

    $datosempresa = obtenerEmpresaPorIdApi($datos[0]['id_empresa']); //Pos 2 empresaapi
    if ($datosempresa == "error_obtener_empresa") {
        return "error_api";
    }
    $datos[] = $datosempresa;

    return $datos;
}


function crearServicio($id_usuario)
{
    $respuestaEmpresa = obtenerEmpleado($id_usuario);
    if ($respuestaEmpresa == "error_bd") {
        //echo "No se ha encontrado id empresa";
        return "error_bd";
    }
    $empresa_array = $respuestaEmpresa->fetch_assoc();
    $id_empresa = $empresa_array['id_empresa'];

    $datosempresa = obtenerEmpresaPorIdApi($id_empresa);

    if ($datosempresa == "error_obtener_empresa") {
        return "error_nuevo_servicio";
    }

    $city = $datosempresa['address']['city'];
    $countryOrRegion = $datosempresa['address']['countryOrRegion'];
    $street = $datosempresa['address']['street'];
    $state = $datosempresa['address']['state'];


    if (isset($_POST['nombreServicio']) &&
        isset($_POST['categoriaServicio']) &&
        isset($_POST['descripcionServicio']) &&
        isset($_POST['precioServicio'])) {

        $nombre = $_POST['nombreServicio'];
        $categoria = $_POST['categoriaServicio'];
        $descripcion = $_POST['descripcionServicio'];
        $precio = $_POST['precioServicio'];

        $staffMemberIds = array($id_usuario);
        $address = array(
            "@odata.type" => "#microsoft.graph.physicalAddress",
            "city" => $city,
            "countryOrRegion" => $countryOrRegion,
            "street" => $street,
            "state" => $state
        );
        $defaultLocation = array(
            "@odata.type" => "#microsoft.graph.location",
            "address" => $address
        );

        $datos_servicio = array(
            "@odata.type" => "#microsoft.graph.bookingService",
            "displayName" => $nombre,
            "description" => $descripcion,
            "defaultLocation" => $defaultLocation,
            "defaultPrice" => $precio,
            "defaultPriceType@odata.type" => "#microsoft.graph.bookingPriceType",
            "defaultPriceType" => "hourly",
            "staffMemberIds@odata.type" => "#Collection(String)",
            "staffMemberIds" => $staffMemberIds
        );

        $curl = new Curl();
        $respuesta = $curl->postGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $id_empresa . '/services', $datos_servicio);

        if (isset($respuesta['id'])) {
            $conn = DatabaseConnSingleton::getConn();

            date_default_timezone_set("Europe/Paris");

            $fecha_hoy = date('y-m-d');

            if ($conn->query("INSERT INTO final_Servicio (id, id_categoria, fecha_publicacion, precio, id_empresa, id_usuario) VALUES ('" . $respuesta['id'] . "','" . $categoria . "','" . $fecha_hoy . "','" . $precio . "','" . $id_empresa . "','" . $id_usuario . "')") == TRUE) {
                return "ok";
            } else {
                DatabaseConnSingleton::closeConn();
                //echo "Error en la base de datos";
                return "error_nuevo_servicio";
            }
        } else {
            //echo "Empresa no creada";
            return "error_nuevo_servicio";
        }
    } else {
        //echo "Post incorrecto";
        return "error_nuevo_servicio";
    }
}

function cancelarCita($id_cita, $id_empresa, $correo)
{
        $datos = array(
            "cancellationMessage" => "Su cita ha sido cancelada por la eliminacion del servicio. Para cualquier consulta contacte con ella por medio de correo electrónico: \"" . $correo . "\""
        );

        $curl = new Curl();
        $respuesta = $curl->postGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $id_empresa . '/appointments/' . $id_cita . '/cancel', $datos);

        if (empty($respuesta)) {
            return "ok_cancelacion";
        } else {
            return "error_cancelacion_api";
        }
}

function eliminarServicioApi(){
//TODO


}

function eliminarServicio($id_usuario, $id_Servicio){

    $usuario_ = obtenerUsuarioDb($id_usuario);
    $usuario = $usuario_->fetch_assoc();

    if(!isset($usuario['id_empresa'])){
        return "error";
    }

    $resultadoCitasApi = obtenerCitasApi($usuario['id_empresa']);
    if (!isset($resultadoCitasApi["value"])) {
        return "error_api";
    }

    $citasApi = array();
    if(isset($resultadoCitasApi["value"])) {
        $listaCitasApi = $resultadoCitasApi["value"];
        for ($numCita = 0; $numCita < count($listaCitasApi); $numCita++) {
            $resultado_cancelacion = cancelarCita($listaCitasApi[$numCita]["id"], $usuario['id_empresa'], $usuario['correo']);
            if(!$resultado_cancelacion == "ok_cancelacion"){
                return "error_api";
            }
        }
    }else{
        return "error_error_api";
    }

    //TODO DELETE https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/Contosolunchdelivery@contoso.onmicrosoft.com/services/57da6774-a087-4d69-b0e6-6fb82c339976
    $respuesta = eliminarServicioApi();

    if(isset($respuesta['error'])){
        return "error";
    } else {
        return "servicio_eliminado_ok";
    }
}

function crearEmpresaApi()
{

    if (isset($_POST['nombre']) &&
        isset($_POST['apellidos']) &&
        isset($_POST['direccion']) &&
        isset($_POST['cAutonoma']) &&
        isset($_POST['provincia']) &&
        isset($_POST['poblacion'])) {

        $nombre = $_POST['nombre'] . " " . $_POST['apellidos'];
        $direccion = $_POST['direccion'];
        $cAutonoma_id = $_POST['cAutonoma'];
        $provincia_id = $_POST['provincia'];
        $municipio_id = $_POST['poblacion'];

        $cAutonoma = obtenerNombreComunidadAutonomaPorId($cAutonoma_id);
        $provincia = obtenerNombreProvinciaPorId($provincia_id);
        $municipio = obtenerNombrePoblacionPorId($municipio_id);

        $TimeSlots_ = array(
            "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
            "startTime" => "00:01:00.0000000",
            "endTime" => "23:59:00.0000000");
        $TimeSlots = array($TimeSlots_);
        $businessHoursMonday = array(
            "@odata.type" => "#microsoft.graph.bookingWorkHours",
            "day@odata.type" => "#microsoft.graph.dayOfWeek",
            "day" => "monday",
            "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
            "timeSlots" => $TimeSlots
        );
        $businessHoursTuesday = array(
            "@odata.type" => "#microsoft.graph.bookingWorkHours",
            "day@odata.type" => "#microsoft.graph.dayOfWeek",
            "day" => "tuesday",
            "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
            "timeSlots" => $TimeSlots
        );
        $businessHoursWednesday = array(
            "@odata.type" => "#microsoft.graph.bookingWorkHours",
            "day@odata.type" => "#microsoft.graph.dayOfWeek",
            "day" => "wednesday",
            "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
            "timeSlots" => $TimeSlots
        );
        $businessHoursThursday = array(
            "@odata.type" => "#microsoft.graph.bookingWorkHours",
            "day@odata.type" => "#microsoft.graph.dayOfWeek",
            "day" => "thursday",
            "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
            "timeSlots" => $TimeSlots
        );
        $businessHoursFriday = array(
            "@odata.type" => "#microsoft.graph.bookingWorkHours",
            "day@odata.type" => "#microsoft.graph.dayOfWeek",
            "day" => "friday",
            "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
            "timeSlots" => $TimeSlots
        );
        $businessHoursSaturday = array(
            "@odata.type" => "#microsoft.graph.bookingWorkHours",
            "day@odata.type" => "#microsoft.graph.dayOfWeek",
            "day" => "saturday",
            "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
            "timeSlots" => $TimeSlots
        );
        $businessHoursSunday = array(
            "@odata.type" => "#microsoft.graph.bookingWorkHours",
            "day@odata.type" => "#microsoft.graph.dayOfWeek",
            "day" => "sunday",
            "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
            "timeSlots" => $TimeSlots
        );
        $businessHours = array($businessHoursMonday, $businessHoursTuesday, $businessHoursWednesday, $businessHoursThursday, $businessHoursFriday, $businessHoursSaturday, $businessHoursSunday);

        $address = array(
            "city" => $municipio,
            "countryOrRegion" => $cAutonoma,
            "state" => $provincia,
            "street" => $direccion
        );

        $datos_empresa = array(
            "displayName" => $nombre . "_empresa" . rand(1, 10000),
            "address" => $address,
            "timeZone" => "Europe/Paris",
            "workingHours@odata.type" => "#Collection(microsoft.graph.bookingWorkHours)",
            "businessHours" => $businessHours,
            "defaultCurrencyIso" => "EUR"
        );

        $curl = new Curl();
        $respuesta = $curl->postGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses', $datos_empresa);
        //var_dump($respuesta);
        return $respuesta;
    } else {
        return "error_datos";
    }
}

function editarUsuario($id_empleado){
    $empleado_ = obtenerDatosEmpleadoDb($id_empleado);
    $empleado = $empleado_->fetch_assoc();

    $emplado_actualizado_api = actualizarEmpleadoApi($empleado['id_empresa'], $id_empleado);
    if($emplado_actualizado_api == "error_datos"){
        return "error_api";
    }

    $empresa_actualizada_api = actualizarEmpresaApi($empleado['id_empresa']);
    if($empresa_actualizada_api == "error_datos"){
        return "error_api";
    }

    $emplado_actualizado_db = actualizarEmpleadoDb($id_empleado);
    if($emplado_actualizado_db == "error_datos"){
        return "error_base";
    } elseif ($emplado_actualizado_db == "error_imagen"){
        return "error_imagen_base";
    }
    return "ok";

}

function actualizarEmpleadoDb($id_empleado)
{
    if (isset($_POST['experiencia'])) {
        $vehiculo = 0;
        $experiencia = $_POST['experiencia'];

        if (isset($_POST['vehiculo'])) {
            if ($_POST['vehiculo'] == 'on') {
                $vehiculo = 1;
            }
        } else {
            $vehiculo = 0;
        }

        if ($tipo = $_FILES['imgPerfil']['size'] == 0 && $_FILES['imgPerfil']['error'] == 0){
            $conn = DatabaseConnSingleton::getConn();
            if ($conn->query("UPDATE final_Usuario SET vehiculo_propio='". $vehiculo ."', experiencia='". $experiencia ."' WHERE id='". $id_empleado ."'") == TRUE) {
                return "ok";
            } else {
                DatabaseConnSingleton::closeConn();
                return "error_datos";
            }
        }

        $tipo = $_FILES['imgPerfil']['type'];

        if ($tipo == "image/jpg") {
            $nombrefichero = time() . "-" . uniqid() . ".jpg";
        } elseif ($tipo = "image/jpeg") {
            $nombrefichero = time() . "-" . uniqid() . ".jpeg";
        } elseif ($tipo = "image/png") {
            $nombrefichero = time() . "-" . uniqid() . ".png";
        } elseif ($tipo = "image/gif") {
            $nombrefichero = time() . "-" . uniqid() . ".gif";
        } else {
            return "error_imagen";
        }

        $temporal = $_FILES['imgPerfil']['tmp_name'];

        if ($temporal == ""){
            //chmod($temporal, 777);

            $conn = DatabaseConnSingleton::getConn();
            if ($conn->query("UPDATE final_Usuario SET vehiculo_propio='". $vehiculo ."', experiencia='". $experiencia ."' WHERE id='". $id_empleado ."'") == TRUE) {
                return "ok";
            } else {
                DatabaseConnSingleton::closeConn();
                return "error_datos";
            }
        }

        if (!move_uploaded_file($temporal, '../imagenes/fotosperfil/' . $nombrefichero)) {
            return "error_imagen";
        }
        $conn = DatabaseConnSingleton::getConn();
        if ($conn->query("UPDATE final_Usuario SET vehiculo_propio='". $vehiculo ."', experiencia='". $experiencia . "', imagen_perfil='". $nombrefichero . "' WHERE id='". $id_empleado ."'") == TRUE) {
            return "ok";
        } else {
            DatabaseConnSingleton::closeConn();
            return "error_datos";
        }
    } else {
        return "error_datos";
    }
}

function actualizarEmpresaApi($id_empresa)
{
    if (isset($_POST['direccion']) &&
        isset($_POST['cAutonoma']) &&
        isset($_POST['provincia']) &&
        isset($_POST['poblacion'])) {

        $direccion = $_POST['direccion'];
        $cAutonoma_id = $_POST['cAutonoma'];
        $provincia_id = $_POST['provincia'];
        $municipio_id = $_POST['poblacion'];

        $cAutonoma = obtenerNombreComunidadAutonomaPorId($cAutonoma_id);
        $provincia = obtenerNombreProvinciaPorId($provincia_id);
        $municipio = obtenerNombrePoblacionPorId($municipio_id);

        $address = array(
            "city" => $municipio,
            "countryOrRegion" => $cAutonoma,
            "state" => $provincia,
            "street" => $direccion
        );

        $datos_empresa = array(
            "address" => $address,
        );

        $curl = new Curl();
        $respuesta = $curl->patchGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' .$id_empresa, $datos_empresa);
        return $respuesta;
    } else {
        return "error_datos";
    }
}

function actualizarEmpleadoApi($id_empresa, $id_empleado)
{
    if (isset($_POST['lunesIni']) &&
        isset($_POST['lunesFin']) &&
        isset($_POST['martesIni']) &&
        isset($_POST['martesFin']) &&
        isset($_POST['miercolesIni']) &&
        isset($_POST['miercolesFin']) &&
        isset($_POST['juevesIni']) &&
        isset($_POST['juevesFin']) &&
        isset($_POST['viernesIni']) &&
        isset($_POST['viernesFin']) &&
        isset($_POST['sabadoIni']) &&
        isset($_POST['sabadoFin']) &&
        isset($_POST['domingoIni']) &&
        isset($_POST['domingoFin'])) {

        $lunesIni = $_POST['lunesIni'];
        $lunesFin = $_POST['lunesFin'];
        $martesIni = $_POST['martesIni'];
        $martesFin = $_POST['martesFin'];
        $miercolesIni = $_POST['miercolesIni'];
        $miercolesFin = $_POST['miercolesFin'];
        $juevesIni = $_POST['juevesIni'];
        $juevesFin = $_POST['juevesFin'];
        $viernesIni = $_POST['viernesIni'];
        $viernesFin = $_POST['viernesFin'];
        $sabadoIni = $_POST['sabadoIni'];
        $sabadoFin = $_POST['sabadoFin'];
        $domingoIni = $_POST['domingoIni'];
        $domingoFin = $_POST['domingoFin'];
        //Datos para crear usuario
        $workingHours = array();

        $ini_horas = explode(":", $lunesIni);
        $fin_horas = explode(":", $lunesFin);
        $int_ini_hora = (int)$ini_horas[0];
        $int_fin_hora = (int)$fin_horas[0];
        if (($int_ini_hora - $int_fin_hora) != 0) {
            $TimeSlots_ = array(
                "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                "startTime" => $lunesIni,
                "endTime" => $lunesFin);
            $TimeSlots = array($TimeSlots_);
            $businessHoursMonday = array(
                "@odata.type" => "#microsoft.graph.bookingWorkHours",
                "day@odata.type" => "#microsoft.graph.dayOfWeek",
                "day" => "monday",
                "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                "timeSlots" => $TimeSlots
            );
            $workingHours[] = $businessHoursMonday;
        }

        $ini_horas = explode(":", $martesIni);
        $fin_horas = explode(":", $martesFin);
        $int_ini_hora = (int)$ini_horas[0];
        $int_fin_hora = (int)$fin_horas[0];
        if (($int_ini_hora - $int_fin_hora) != 0) {
            $TimeSlots_ = array(
                "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                "startTime" => $martesIni,
                "endTime" => $martesFin);
            $TimeSlots = array($TimeSlots_);
            $businessHoursTuesday = array(
                "@odata.type" => "#microsoft.graph.bookingWorkHours",
                "day@odata.type" => "#microsoft.graph.dayOfWeek",
                "day" => "tuesday",
                "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                "timeSlots" => $TimeSlots
            );
            $workingHours[] = $businessHoursTuesday;
        }

        $ini_horas = explode(":", $miercolesIni);
        $fin_horas = explode(":", $miercolesFin);
        $int_ini_hora = (int)$ini_horas[0];
        $int_fin_hora = (int)$fin_horas[0];
        if (($int_ini_hora - $int_fin_hora) != 0) {
            $TimeSlots_ = array(
                "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                "startTime" => $miercolesIni,
                "endTime" => $miercolesFin);
            $TimeSlots = array($TimeSlots_);
            $businessHoursWednesday = array(
                "@odata.type" => "#microsoft.graph.bookingWorkHours",
                "day@odata.type" => "#microsoft.graph.dayOfWeek",
                "day" => "wednesday",
                "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                "timeSlots" => $TimeSlots
            );
            $workingHours[] = $businessHoursWednesday;
        }

        $ini_horas = explode(":", $juevesIni);
        $fin_horas = explode(":", $juevesFin);
        $int_ini_hora = (int)$ini_horas[0];
        $int_fin_hora = (int)$fin_horas[0];
        if (($int_ini_hora - $int_fin_hora) != 0) {
            $TimeSlots_ = array(
                "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                "startTime" => $juevesIni,
                "endTime" => $juevesFin);
            $TimeSlots = array($TimeSlots_);
            $businessHoursThursday = array(
                "@odata.type" => "#microsoft.graph.bookingWorkHours",
                "day@odata.type" => "#microsoft.graph.dayOfWeek",
                "day" => "thursday",
                "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                "timeSlots" => $TimeSlots
            );
            $workingHours[] = $businessHoursThursday;
        }

        $ini_horas = explode(":", $viernesIni);
        $fin_horas = explode(":", $viernesFin);
        $int_ini_hora = (int)$ini_horas[0];
        $int_fin_hora = (int)$fin_horas[0];
        if (($int_ini_hora - $int_fin_hora) != 0) {
            $TimeSlots_ = array(
                "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                "startTime" => $viernesIni,
                "endTime" => $viernesFin);
            $TimeSlots = array($TimeSlots_);
            $businessHoursFriday = array(
                "@odata.type" => "#microsoft.graph.bookingWorkHours",
                "day@odata.type" => "#microsoft.graph.dayOfWeek",
                "day" => "friday",
                "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                "timeSlots" => $TimeSlots
            );
            $workingHours[] = $businessHoursFriday;
        }

        $ini_horas = explode(":", $sabadoIni);
        $fin_horas = explode(":", $sabadoFin);
        $int_ini_hora = (int)$ini_horas[0];
        $int_fin_hora = (int)$fin_horas[0];
        if (($int_ini_hora - $int_fin_hora) != 0) {
            $TimeSlots_ = array(
                "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                "startTime" => $sabadoIni,
                "endTime" => $sabadoFin);
            $TimeSlots = array($TimeSlots_);
            $businessHoursSaturday = array(
                "@odata.type" => "#microsoft.graph.bookingWorkHours",
                "day@odata.type" => "#microsoft.graph.dayOfWeek",
                "day" => "saturday",
                "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                "timeSlots" => $TimeSlots
            );
            $workingHours[] = $businessHoursSaturday;
        }

        $ini_horas = explode(":", $domingoIni);
        $fin_horas = explode(":", $domingoFin);
        $int_ini_hora = (int)$ini_horas[0];
        $int_fin_hora = (int)$fin_horas[0];
        if (($int_ini_hora - $int_fin_hora) != 0) {
            $TimeSlots_ = array(
                "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                "startTime" => $domingoIni,
                "endTime" => $domingoFin);
            $TimeSlots = array($TimeSlots_);
            $businessHoursSunday = array(
                "@odata.type" => "#microsoft.graph.bookingWorkHours",
                "day@odata.type" => "#microsoft.graph.dayOfWeek",
                "day" => "sunday",
                "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                "timeSlots" => $TimeSlots
            );
            $workingHours[] = $businessHoursSunday;
        }

        $datos_empleado = array(
            "@odata.type" => "#microsoft.graph.bookingStaffMember",
            "workingHours" => $workingHours
        );

        $curl = new Curl();
        $respuesta = $curl->patchGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $id_empresa . '/staffmembers/'. $id_empleado, $datos_empleado);
        //var_dump($respuesta);
        return $respuesta;

    } else {
        return "error_datos";
    }
}

function crearEmpleadoApi($id_empresa)
{
    if (isset($_POST['nombre']) &&
        isset($_POST['apellidos']) &&
        isset($_POST['correo']) &&
        isset($_POST['lunesIni']) &&
        isset($_POST['lunesFin']) &&
        isset($_POST['martesIni']) &&
        isset($_POST['martesFin']) &&
        isset($_POST['miercolesIni']) &&
        isset($_POST['miercolesFin']) &&
        isset($_POST['juevesIni']) &&
        isset($_POST['juevesFin']) &&
        isset($_POST['viernesIni']) &&
        isset($_POST['viernesFin']) &&
        isset($_POST['sabadoIni']) &&
        isset($_POST['sabadoFin']) &&
        isset($_POST['domingoIni']) &&
        isset($_POST['domingoFin'])) {

        $lunesIni = $_POST['lunesIni'];
        $lunesFin = $_POST['lunesFin'];
        $martesIni = $_POST['martesIni'];
        $martesFin = $_POST['martesFin'];
        $miercolesIni = $_POST['miercolesIni'];
        $miercolesFin = $_POST['miercolesFin'];
        $juevesIni = $_POST['juevesIni'];
        $juevesFin = $_POST['juevesFin'];
        $viernesIni = $_POST['viernesIni'];
        $viernesFin = $_POST['viernesFin'];
        $sabadoIni = $_POST['sabadoIni'];
        $sabadoFin = $_POST['sabadoFin'];
        $domingoIni = $_POST['domingoIni'];
        $domingoFin = $_POST['domingoFin'];
        $nombre = $_POST['nombre'] . " " . $_POST['apellidos'];
        $correo = $_POST['correo'];

        //Datos para crear usuario
        $workingHours = array();

        $ini_horas = explode(":", $lunesIni);
        $fin_horas = explode(":", $lunesFin);
        $int_ini_hora = (int)$ini_horas[0];
        $int_fin_hora = (int)$fin_horas[0];
        if (($int_ini_hora - $int_fin_hora) != 0) {
            /*
             * Resta dos horas, por problemas de graph explorer con horario no UTC
            if (($int_ini_hora - 2) <= 0) {
                $int_ini_hora = 2;
            }
            if (($int_fin_hora - 2) <= 0) {
                $int_fin_hora = 2;
            }
            $lunesIni = ($int_ini_hora - 2) . ":" . $ini_horas[1] . ":" . $ini_horas[2];
            $lunesFin = ($int_fin_hora - 2) . ":" . $fin_horas[1] . ":" . $fin_horas[2];
            */
            $TimeSlots_ = array(
                "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                "startTime" => $lunesIni,
                "endTime" => $lunesFin);
            $TimeSlots = array($TimeSlots_);
            $businessHoursMonday = array(
                "@odata.type" => "#microsoft.graph.bookingWorkHours",
                "day@odata.type" => "#microsoft.graph.dayOfWeek",
                "day" => "monday",
                "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                "timeSlots" => $TimeSlots
            );
            $workingHours[] = $businessHoursMonday;
        }

        $ini_horas = explode(":", $martesIni);
        $fin_horas = explode(":", $martesFin);
        $int_ini_hora = (int)$ini_horas[0];
        $int_fin_hora = (int)$fin_horas[0];
        if (($int_ini_hora - $int_fin_hora) != 0) {
            /*
             * Resta dos horas, por problemas de graph explorer con horario no UTC
            if (($int_ini_hora - 2) <= 0) {
                $int_ini_hora = 2;
            }
            if (($int_fin_hora - 2) <= 0) {
                $int_fin_hora = 2;
            }
            $martesIni = ($int_ini_hora - 2) . ":" . $ini_horas[1] . ":" . $ini_horas[2];
            $martesFin = ($int_fin_hora - 2) . ":" . $fin_horas[1] . ":" . $fin_horas[2];
            */
            $TimeSlots_ = array(
                "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                "startTime" => $martesIni,
                "endTime" => $martesFin);
            $TimeSlots = array($TimeSlots_);
            $businessHoursTuesday = array(
                "@odata.type" => "#microsoft.graph.bookingWorkHours",
                "day@odata.type" => "#microsoft.graph.dayOfWeek",
                "day" => "tuesday",
                "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                "timeSlots" => $TimeSlots
            );
            $workingHours[] = $businessHoursTuesday;
        }

        $ini_horas = explode(":", $miercolesIni);
        $fin_horas = explode(":", $miercolesFin);
        $int_ini_hora = (int)$ini_horas[0];
        $int_fin_hora = (int)$fin_horas[0];
        if (($int_ini_hora - $int_fin_hora) != 0) {
            /*
             * Resta dos horas, por problemas de graph explorer con horario no UTC
            if (($int_ini_hora - 2) <= 0) {
                $int_ini_hora = 2;
            }
            if (($int_fin_hora - 2) <= 0) {
                $int_fin_hora = 2;
            }
            $miercolesIni = ($int_ini_hora - 2) . ":" . $ini_horas[1] . ":" . $ini_horas[2];
            $miercolesFin = ($int_fin_hora - 2) . ":" . $fin_horas[1] . ":" . $fin_horas[2];
            */
            $TimeSlots_ = array(
                "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                "startTime" => $miercolesIni,
                "endTime" => $miercolesFin);
            $TimeSlots = array($TimeSlots_);
            $businessHoursWednesday = array(
                "@odata.type" => "#microsoft.graph.bookingWorkHours",
                "day@odata.type" => "#microsoft.graph.dayOfWeek",
                "day" => "wednesday",
                "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                "timeSlots" => $TimeSlots
            );
            $workingHours[] = $businessHoursWednesday;
        }

        $ini_horas = explode(":", $juevesIni);
        $fin_horas = explode(":", $juevesFin);
        $int_ini_hora = (int)$ini_horas[0];
        $int_fin_hora = (int)$fin_horas[0];
        if (($int_ini_hora - $int_fin_hora) != 0) {
            /*
             * Resta dos horas, por problemas de graph explorer con horario no UTC
            if (($int_ini_hora - 2) <= 0) {
                $int_ini_hora = 2;
            }
            if (($int_fin_hora - 2) <= 0) {
                $int_fin_hora = 2;
            }
            $juevesIni = ($int_ini_hora - 2) . ":" . $ini_horas[1] . ":" . $ini_horas[2];
            $juevesFin = ($int_fin_hora - 2) . ":" . $fin_horas[1] . ":" . $fin_horas[2];
            */
            $TimeSlots_ = array(
                "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                "startTime" => $juevesIni,
                "endTime" => $juevesFin);
            $TimeSlots = array($TimeSlots_);
            $businessHoursThursday = array(
                "@odata.type" => "#microsoft.graph.bookingWorkHours",
                "day@odata.type" => "#microsoft.graph.dayOfWeek",
                "day" => "thursday",
                "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                "timeSlots" => $TimeSlots
            );
            $workingHours[] = $businessHoursThursday;
        }

        $ini_horas = explode(":", $viernesIni);
        $fin_horas = explode(":", $viernesFin);
        $int_ini_hora = (int)$ini_horas[0];
        $int_fin_hora = (int)$fin_horas[0];
        if (($int_ini_hora - $int_fin_hora) != 0) {
            /*
             * Resta dos horas, por problemas de graph explorer con horario no UTC
            if (($int_ini_hora - 2) <= 0) {
                $int_ini_hora = 2;
            }
            if (($int_fin_hora - 2) <= 0) {
                $int_fin_hora = 2;
            }
            $viernesIni = ($int_ini_hora - 2) . ":" . $ini_horas[1] . ":" . $ini_horas[2];
            $viernesFin = ($int_fin_hora - 2) . ":" . $fin_horas[1] . ":" . $fin_horas[2];
            */
            $TimeSlots_ = array(
                "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                "startTime" => $viernesIni,
                "endTime" => $viernesFin);
            $TimeSlots = array($TimeSlots_);
            $businessHoursFriday = array(
                "@odata.type" => "#microsoft.graph.bookingWorkHours",
                "day@odata.type" => "#microsoft.graph.dayOfWeek",
                "day" => "friday",
                "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                "timeSlots" => $TimeSlots
            );
            $workingHours[] = $businessHoursFriday;
        }

        $ini_horas = explode(":", $sabadoIni);
        $fin_horas = explode(":", $sabadoFin);
        $int_ini_hora = (int)$ini_horas[0];
        $int_fin_hora = (int)$fin_horas[0];
        if (($int_ini_hora - $int_fin_hora) != 0) {
            /*
             * Resta dos horas, por problemas de graph explorer con horario no UTC
            if (($int_ini_hora - 2) <= 0) {
                $int_ini_hora = 2;
            }
            if (($int_fin_hora - 2) <= 0) {
                $int_fin_hora = 2;
            }
            $sabadoIni = ($int_ini_hora - 2) . ":" . $ini_horas[1] . ":" . $ini_horas[2];
            $sabadoFin = ($int_fin_hora - 2) . ":" . $fin_horas[1] . ":" . $fin_horas[2];
            */
            $TimeSlots_ = array(
                "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                "startTime" => $sabadoIni,
                "endTime" => $sabadoFin);
            $TimeSlots = array($TimeSlots_);
            $businessHoursSaturday = array(
                "@odata.type" => "#microsoft.graph.bookingWorkHours",
                "day@odata.type" => "#microsoft.graph.dayOfWeek",
                "day" => "saturday",
                "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                "timeSlots" => $TimeSlots
            );
            $workingHours[] = $businessHoursSaturday;
        }

        $ini_horas = explode(":", $domingoIni);
        $fin_horas = explode(":", $domingoFin);
        $int_ini_hora = (int)$ini_horas[0];
        $int_fin_hora = (int)$fin_horas[0];
        if (($int_ini_hora - $int_fin_hora) != 0) {
            /*
             * Resta dos horas, por problemas de graph explorer con horario no UTC
            if (($int_ini_hora - 2) <= 0) {
                $int_ini_hora = 2;
            }
            if (($int_fin_hora - 2) <= 0) {
                $int_fin_hora = 2;
            }
            $domingoIni = ($int_ini_hora - 2) . ":" . $ini_horas[1] . ":" . $ini_horas[2];
            $domingoFin = ($int_fin_hora - 2) . ":" . $fin_horas[1] . ":" . $fin_horas[2];
            */
            $TimeSlots_ = array(
                "@odata.type" => "#microsoft.graph.bookingWorkTimeSlot",
                "startTime" => $domingoIni,
                "endTime" => $domingoFin);
            $TimeSlots = array($TimeSlots_);
            $businessHoursSunday = array(
                "@odata.type" => "#microsoft.graph.bookingWorkHours",
                "day@odata.type" => "#microsoft.graph.dayOfWeek",
                "day" => "sunday",
                "timeSlots@odata.type" => "#Collection(microsoft.graph.bookingWorkTimeSlot)",
                "timeSlots" => $TimeSlots
            );
            $workingHours[] = $businessHoursSunday;
        }

        $datos_empleado = array(
            "@odata.type" => "#microsoft.graph.bookingStaffMember",
            "availabilityIsAffectedByPersonalCalendar" => true,
            "displayName" => $nombre,
            "emailAddress" => $correo,
            "role@odata.type" => "#microsoft.graph.bookingStaffRole",
            "role" => "administrator",
            "timeZone" => "Europe/Paris",
            "useBusinessHours" => false,
            "workingHours@odata.type" => "#Collection(microsoft.graph.bookingWorkHours)",
            "workingHours" => $workingHours
        );

        $curl = new Curl();
        $respuesta = $curl->postGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $id_empresa . '/staffMembers', $datos_empleado);
        //var_dump($respuesta);
        return $respuesta;

    } else {
        return "error_datos";
    }
}
