<?php

include __DIR__ . '/../model/NumberConvert.php';

function vMostrarHome($sesion, $datosPagina, $categorias, $empleado = null, $errores = "ok")
{
    $cadena = file_get_contents(__DIR__ . "/home.html");
    $header = "";
    if ($sesion == true) {
        $header = file_get_contents(__DIR__ . "/headerSession.html");
    } else {
        $header = file_get_contents(__DIR__ . "/header.html");
    }
    $cadena = str_replace("##header##", $header, $cadena);

    if ($empleado != null) {
        $empleado_aux = $empleado->fetch_assoc();
        $cadena = str_replace("##nombreUsuario##", $empleado_aux['nombre'], $cadena);
        $cadena = str_replace("##imagenPerfil##", $empleado_aux['imagen_perfil'], $cadena);
    }

    $trozos1 = explode("##filaCategoriaNav##", $cadena);
    $trozos2 = explode("##filaCategoriaPag##", $trozos1[2]);

    $datosPagina_aux = $datosPagina->fetch_assoc();

    $trozos1[0] = str_replace("##tituloWeb##", $datosPagina_aux['nombre'], $trozos1[0]);
    $trozos1[0] = str_replace("##imagenLogo##", $datosPagina_aux['logo'], $trozos1[0]);
    $trozos2[0] = str_replace("##imagenDescripcion##", $datosPagina_aux['imagen_descripcion'], $trozos2[0]);
    $trozos2[0] = str_replace("##descripcion##", $datosPagina_aux['descripcion'], $trozos2[0]);

    //Notificaciones de errores
    if ($errores == "ok") {
        $trozos2[0] = str_replace("##visibilidad##", "hidden", $trozos2[0]);
    } elseif ($errores == "inicio_ok") {
        $trozos2[0] = str_replace("##tipoAlerta##", "success", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Se ha iniciado sesión con éxito", $trozos2[0]);
    } elseif ($errores == "registro_ok") {
        $trozos2[0] = str_replace("##tipoAlerta##", "success", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Registrado correctamente, ya puede <a href='../controller/Controller.php?accion=abrirIniciarSesion'>iniciar sesión</a>", $trozos2[0]);
    } elseif ($errores == "servicio_ok") {
        $trozos2[0] = str_replace("##tipoAlerta##", "success", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "El servicio se ha creado correctamente", $trozos2[0]);
    } elseif ($errores == "ok_cerrarsesion") {
        $trozos2[0] = str_replace("##tipoAlerta##", "success", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Se ha cerrado sesión con éxito", $trozos2[0]);
    } elseif ($errores == "error_empleado_db") {
        $trozos2[0] = str_replace("##tipoAlerta##", "danger", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Error en la conexión con la base de datos, no se ha creado el usuario", $trozos2[0]);
    } elseif ($errores == "error_nuevo_servicio") {
        $trozos2[0] = str_replace("##tipoAlerta##", "danger", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Lo sentimos, ha ocurrido un error creando el nuevo servicio. Por favor, pruebe otra vez o póngase en contacto con el administrador.<br> Es posible que sea debido al token.", $trozos2[0]);
    } elseif (($errores == "error_empleado_api") || ($errores == "error_empresa_api")) {
        $trozos2[0] = str_replace("##tipoAlerta##", "danger", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Error en la conexión con Microsoft 365, no se ha creado el usuario, verificar token", $trozos2[0]);
    }elseif($errores == "error_formulario_reserva"){
        $trozos2[0] = str_replace("##tipoAlerta##", "danger", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Error al enviar el formulario, no se ha creado la reserva", $trozos2[0]);
    }elseif($errores == "error_api_categoria"){
        $trozos2[0] = str_replace("##tipoAlerta##", "danger", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Error en la conexión con Microsoft 365, no se han podido obtener los datos para mostrar la categoría indicada, verificar token", $trozos2[0]);
    }elseif($errores == "error_api_servicio"){
        $trozos2[0] = str_replace("##tipoAlerta##", "danger", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Error en la conexión con Microsoft 365, no se han podido obtener los datos para mostrar el servicio indicado, verificar token", $trozos2[0]);
    }elseif($errores == "error_api_perfil"){
        $trozos2[0] = str_replace("##tipoAlerta##", "danger", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Error en la conexión con Microsoft 365, no se han podido obtener los datos para mostrar el perfil indicado, verificar token", $trozos2[0]);
    } elseif($errores == "error_api"){
        $trozos2[0] = str_replace("##tipoAlerta##", "danger", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Error en la conexión con Microsoft 365, no se han podido obtener los datos, verificar token", $trozos2[0]);
    } elseif($errores == "error_base"){
        $trozos2[0] = str_replace("##tipoAlerta##", "danger", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Error en la conexión de la base de datos, no se han podido obtener los datos para actualizar", $trozos2[0]);
    }elseif($errores == "error_imagen_base"){
        $trozos2[0] = str_replace("##tipoAlerta##", "danger", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Error en la imagen de perfil, ha tratado de insertar un formato no permitido", $trozos2[0]);
    }  elseif (($errores == "error_generico")) {
        $trozos2[0] = str_replace("##tipoAlerta##", "danger", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Ha ocurrido un error", $trozos2[0]);
    }

    $categorias_navegador = "";
    $categorias_pagina = "";
    $contador = 0;
    while ($datosCategoria = $categorias->fetch_assoc()) {
        $contador++;
        $numActual = numberTowords($contador);

        $aux = $trozos1[1];
        $aux = str_replace("##nombreCategoria##", $datosCategoria['nombre'], $aux);
        $aux = str_replace("##categoriaId##", $datosCategoria['id'], $aux);
        $categorias_navegador .= $aux;

        $aux = $trozos2[1];
        $aux = str_replace("##nombreCategoria##", $datosCategoria['nombre'], $aux);
        $aux = str_replace("##imagenCategoria##", $datosCategoria['imagen'], $aux);
        $aux = str_replace("##contador##", $numActual, $aux);
        $aux = str_replace("##categoriaId##", $datosCategoria['id'], $aux);
        $aux = str_replace("##categoriaDescripcion##", $datosCategoria['descripcion'], $aux);
        $categorias_pagina .= $aux;
    }

    echo $trozos1[0] . $categorias_navegador . $trozos2[0] . $categorias_pagina . $trozos2[2];
}

function vMostrarCategoria($sesion, $datosPagina, $categorias, $arrayDatosServicios, $id_categoria, $empleado = null)
{

    $serviciosDb = $arrayDatosServicios[0];
    $serviciosApi = $arrayDatosServicios[1];
    $usuariosApi = $arrayDatosServicios[2];

    $cadena = file_get_contents(__DIR__ . "/categoria.html");

    if ($sesion == true) {
        $header = file_get_contents(__DIR__ . "/headerSession.html");
    } else {
        $header = file_get_contents(__DIR__ . "/header.html");
    }
    $cadena = str_replace("##header##", $header, $cadena);

    if ($empleado != null) {
        $empleado_aux = $empleado->fetch_assoc();
        $cadena = str_replace("##nombreUsuario##", $empleado_aux['nombre'], $cadena);
        $cadena = str_replace("##imagenPerfil##", $empleado_aux['imagen_perfil'], $cadena);
    }

    $trozos1 = explode("##filaCategoriaNav##", $cadena);
    $trozos2 = explode("##filaServicio##", $trozos1[2]);

    $datosPagina_aux = $datosPagina->fetch_assoc();

    $trozos1[0] = str_replace("##tituloWeb##", $datosPagina_aux['nombre'], $trozos1[0]);
    $trozos1[0] = str_replace("##imagenLogo##", $datosPagina_aux['logo'], $trozos1[0]);

    $categorias_navegador = "";
    while ($datosCategoria = $categorias->fetch_assoc()) {
        $aux = $trozos1[1];
        $aux = str_replace("##nombreCategoria##", $datosCategoria['nombre'], $aux);
        $aux = str_replace("##categoriaId##", $datosCategoria['id'], $aux);
        $categorias_navegador .= $aux;


        if ($datosCategoria['id'] == $id_categoria) {
            $trozos2[2] = str_replace("##categoriaId##", $datosCategoria['id'], $trozos2[2]);
            $trozos2[0] = str_replace("##nombreCategoria##", $datosCategoria['nombre'], $trozos2[0]);
            $trozos2[0] = str_replace("##imagenCategoria##", $datosCategoria['imagen'], $trozos2[0]);
        }

    }

    $servicios = "";
    for ($numServicio = 0; $numServicio < count($serviciosDb); $numServicio++) {
        $aux = $trozos2[1];

        $aux = str_replace('##nombreServicio##', $serviciosApi[$numServicio]["displayName"], $aux);
        $aux = str_replace('##idUsuarioServicio##', $usuariosApi[$numServicio]["id"], $aux);
        $aux = str_replace('##usuarioServicio##', $usuariosApi[$numServicio]["displayName"], $aux);
        $aux = str_replace('##descripcionServicio##', $serviciosApi[$numServicio]["description"], $aux);
        $aux = str_replace('##fechaPublicacionServicio##', $serviciosDb[$numServicio]['fecha_publicacion'], $aux);
        $aux = str_replace('##localizacionServicio##', $serviciosApi[$numServicio]["defaultLocation"]["address"]["city"] . ', ' . $serviciosApi[$numServicio]["defaultLocation"]["address"]["state"] . ', ' . $serviciosApi[$numServicio]["defaultLocation"]["address"]["countryOrRegion"], $aux);
        $aux = str_replace('##precioServicio##', $serviciosApi[$numServicio]["defaultPrice"], $aux);
        $aux = str_replace('##idServicio##', $serviciosApi[$numServicio]["id"], $aux);
        $servicios .= $aux;
    }

    echo $trozos1[0] . $categorias_navegador . $trozos2[0] . $servicios . $trozos2[2];
}

function vMostrarServiciosCategoriaOrdenados($arrayDatosServicios)
{
    $serviciosDb = $arrayDatosServicios[0];
    $serviciosApi = $arrayDatosServicios[1];
    $usuariosApi = $arrayDatosServicios[2];

    $cadena = file_get_contents(__DIR__ . "/listaServicios.html");

    $trozos = explode("##filaServicio##", $cadena);

    $servicios = "";
    for ($numServicio = 0; $numServicio < count($serviciosDb); $numServicio++) {
        $aux = $trozos[1];

        $aux = str_replace('##nombreServicio##', $serviciosApi[$numServicio]["displayName"], $aux);
        $aux = str_replace('##idUsuarioServicio##', $usuariosApi[$numServicio]["id"], $aux);
        $aux = str_replace('##usuarioServicio##', $usuariosApi[$numServicio]["displayName"], $aux);
        $aux = str_replace('##descripcionServicio##', $serviciosApi[$numServicio]["description"], $aux);
        $aux = str_replace('##fechaPublicacionServicio##', $serviciosDb[$numServicio]['fecha_publicacion'], $aux);
        $aux = str_replace('##localizacionServicio##', $serviciosApi[$numServicio]["defaultLocation"]["address"]["city"] . ', ' . $serviciosApi[$numServicio]["defaultLocation"]["address"]["state"] . ', ' . $serviciosApi[$numServicio]["defaultLocation"]["address"]["countryOrRegion"], $aux);
        $aux = str_replace('##precioServicio##', $serviciosApi[$numServicio]["defaultPrice"], $aux);
        $aux = str_replace('##idServicio##', $serviciosApi[$numServicio]["id"], $aux);
        $servicios .= $aux;
    }

    echo $trozos[0] . $servicios . $trozos[2];
}

function vMostrarServicio($sesion, $datosPagina, $categorias, $arrayDatosServicio, $empleado = null, $errores = "ok")
{

    $servicioDb = $arrayDatosServicio[0];
    $servicioApi = $arrayDatosServicio[1];
    $usuarioApi = $arrayDatosServicio[2];
    $usuarioDb = $arrayDatosServicio[3];
    $comunidadesAutonomas = $arrayDatosServicio[4];
    $provincias = $arrayDatosServicio[5];
    $poblaciones = $arrayDatosServicio[6];

    $cadena = file_get_contents(__DIR__ . "/servicio.html");

    if ($sesion == true) {
        $header = file_get_contents(__DIR__ . "/headerSession.html");
    } else {
        $header = file_get_contents(__DIR__ . "/header.html");
    }
    $cadena = str_replace("##header##", $header, $cadena);

    if ($empleado != null) {
        $empleado_aux = $empleado->fetch_assoc();
        $cadena = str_replace("##nombreUsuario##", $empleado_aux['nombre'], $cadena);
        $cadena = str_replace("##imagenPerfil##", $empleado_aux['imagen_perfil'], $cadena);
    }

    $trozos1 = explode("##filaCategoriaNav##", $cadena);
    $trozos2 = explode("##filaDispoibilidad##", $trozos1[2]);
    $trozos3 = explode("##filaComunidadAutonoma##", $trozos2[2]);
    $trozos4 = explode("##filaProvincia##", $trozos3[2]);
    $trozos5 = explode("##filaPoblacion##", $trozos4[2]);

    $datosPagina_aux = $datosPagina->fetch_assoc();

    $trozos1[0] = str_replace("##tituloWeb##", $datosPagina_aux['nombre'], $trozos1[0]);
    $trozos1[0] = str_replace("##imagenLogo##", $datosPagina_aux['logo'], $trozos1[0]);

    $categorias_navegador = "";
    while ($datosCategoria = $categorias->fetch_assoc()) {

        $aux = $trozos1[1];
        $aux = str_replace("##nombreCategoria##", $datosCategoria['nombre'], $aux);
        $aux = str_replace("##categoriaId##", $datosCategoria['id'], $aux);
        $categorias_navegador .= $aux;

    }

    //Notificaciones de errores
    if ($errores == "ok") {
        $trozos2[0] = str_replace("##visibilidad##", "hidden", $trozos2[0]);
    } elseif ($errores == "ok_reserva") {
        $trozos2[0] = str_replace("##tipoAlerta##", "info", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "La reserva del servicio se ha realizado correctamente. Enseguida recibirá un email de confirmación", $trozos2[0]);
    } elseif ($errores == "error_cita_api") {
        $trozos2[0] = str_replace("##tipoAlerta##", "danger", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Error en la conexión con Microsoft 365, no se ha creado la reserva, verificar token", $trozos2[0]);
    } elseif ($errores == "error_formulario_reserva") {
        $trozos2[0] = str_replace("##tipoAlerta##", "danger", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Error al enviar el formulario, no se ha creado la reserva", $trozos2[0]);
    }

    $trozos2[0] = str_replace("##nombreServicio##", $servicioApi["displayName"], $trozos2[0]);
    $trozos2[0] = str_replace("##fechaServicio##", $servicioDb['fecha_publicacion'], $trozos2[0]);
    $trozos2[0] = str_replace("##idUsuarioServicio##", $usuarioApi["id"], $trozos2[0]);
    $trozos2[0] = str_replace("##usuarioServicio##", $usuarioApi["displayName"], $trozos2[0]);
    $trozos2[0] = str_replace("##descripcionServicio##", $servicioApi["description"], $trozos2[0]);

    $disponibilidad = "";
    for ($numHorario = 0; $numHorario < count($usuarioApi["workingHours"]); $numHorario++) {

        $aux = $trozos2[1];
        switch ($usuarioApi["workingHours"][$numHorario]["day"]) {
            case "monday":
                $dia = "Lunes";
                break;
            case "tuesday":
                $dia = "Martes";
                break;
            case "wednesday":
                $dia = "Miércoles";
                break;
            case "thursday":
                $dia = "Jueves";
                break;
            case "friday":
                $dia = "Viernes";
                break;
            case "saturday":
                $dia = "Sábado";
                break;
            default:
                $dia = "Domingo";
        }
        $aux = str_replace("##dia##", $dia, $aux);
        if (isset($usuarioApi["workingHours"][$numHorario]["timeSlots"][0]["startTime"])) {
            $trozosHoraInicial = explode(".", $usuarioApi["workingHours"][$numHorario]["timeSlots"][0]["startTime"]);
            $aux = str_replace("##horaInicial##", $trozosHoraInicial[0], $aux);
            if (isset($usuarioApi["workingHours"][$numHorario]["timeSlots"][0]["endTime"])) {
                $trozosHoraFinal = explode(".", $usuarioApi["workingHours"][$numHorario]["timeSlots"][0]["endTime"]);
                $aux = str_replace("##horaFinal##", $trozosHoraFinal[0], $aux);
                $disponibilidad .= $aux;
            }
        }
    }

    $trozos3[0] = str_replace("##localizacionServicio##", $servicioApi["defaultLocation"]["address"]["city"] . ', ' . $servicioApi["defaultLocation"]["address"]["state"] . ', ' . $servicioApi["defaultLocation"]["address"]["countryOrRegion"], $trozos3[0]);
    if ($usuarioDb['vehiculo_propio'] == 1) {
        $trozos3[0] = str_replace("##vehiculoPropio##", "Sí", $trozos3[0]);
    } else {
        $trozos3[0] = str_replace("##vehiculoPropio##", "No", $trozos3[0]);
    }
    $trozos3[0] = str_replace("##precioServicio##", $servicioApi["defaultPrice"], $trozos3[0]);
    $trozos3[0] = str_replace("##idUsuarioServicio##", $usuarioDb['id'], $trozos3[0]);
    $trozos3[0] = str_replace("##idServicio##", $servicioDb['id'], $trozos3[0]);
    $trozos3[0] = str_replace("##idEmpresa##", $usuarioDb['id_empresa'], $trozos3[0]);
    //TODO copiar de aquí
    $trozoComunidadesAutonomas = "";
    $idComunidadAutonoma = "";
    while ($datosComunidadAutonoma = $comunidadesAutonomas->fetch_assoc()) {
        $aux = $trozos3[1];
        $aux = str_replace("##comunidad_autonoma##", $datosComunidadAutonoma['nombre'], $aux);
        $aux = str_replace("##id_comunidad_autonoma##", $datosComunidadAutonoma['id'], $aux);
        if ($datosComunidadAutonoma['nombre'] == $servicioApi["defaultLocation"]["address"]["countryOrRegion"]) {
            $aux = str_replace("##selected##", "selected", $aux);
            $idComunidadAutonoma = $datosComunidadAutonoma['id'];
        } else {
            $aux = str_replace("##selected##", "", $aux);
        }
        if ($idComunidadAutonoma == "") {
            $idComunidadAutonoma = $datosComunidadAutonoma['id'];
        }
        $trozoComunidadesAutonomas .= $aux;
    }

    $trozoProvincias = "";
    $idProvincia = "";
    while ($datosProvincia = $provincias->fetch_assoc()) {
        if ($datosProvincia['id_comunidad_autonoma'] == $idComunidadAutonoma) {
            $aux = $trozos4[1];
            $aux = str_replace("##provincia##", $datosProvincia['nombre'], $aux);
            $aux = str_replace("##id_provincia##", $datosProvincia['id'], $aux);
            if ($datosProvincia['nombre'] == $servicioApi["defaultLocation"]["address"]["state"]) {
                $aux = str_replace("##selected##", "selected", $aux);
                $idProvincia = $datosProvincia['id'];
            } else {
                $aux = str_replace("##selected##", "", $aux);
            }
            if ($idProvincia == "") {
                $idProvincia = $datosProvincia['id'];
            }
            $trozoProvincias .= $aux;
        }
    }

    $trozoPoblaciones = "";
    while ($datosPoblacion = $poblaciones->fetch_assoc()) {
        if ($datosPoblacion['id_provincia'] == $idProvincia) {
            $aux = $trozos5[1];
            $aux = str_replace("##poblacion##", $datosPoblacion['nombre'], $aux);
            $aux = str_replace("##id_poblacion##", $datosPoblacion['id'], $aux);
            if ($datosPoblacion['nombre'] == $servicioApi["defaultLocation"]["address"]["city"]) {
                $aux = str_replace("##selected##", "selected", $aux);
            } else {
                $aux = str_replace("##selected##", "", $aux);
            }
            $trozoPoblaciones .= $aux;
        }
    }

    $trozos5[2] = str_replace("##calle_portal_piso##", $servicioApi["defaultLocation"]["address"]["street"], $trozos5[2]);

    echo $trozos1[0] . $categorias_navegador . $trozos2[0] . $disponibilidad . $trozos3[0] . $trozoComunidadesAutonomas . $trozos4[0] . $trozoProvincias . $trozos5[0] . $trozoPoblaciones . $trozos5[2];
}

function vMostrarProvincias($provincias)
{
    $cadena = file_get_contents(__DIR__ . "/trozoProvincias.html");

    $trozos = explode("##filaProvincia##", $cadena);

    $trozosProvincias = "";
    while ($datosProvincia = $provincias->fetch_assoc()) {
        $aux = $trozos[1];
        $aux = str_replace("##provincia##", $datosProvincia['nombre'], $aux);
        $aux = str_replace("##id_provincia##", $datosProvincia['id'], $aux);
        $trozosProvincias .= $aux;
    }

    echo $trozos[0] . $trozosProvincias . $trozos[2];
}

function vMostrarPoblaciones($poblaciones)
{
    $cadena = file_get_contents(__DIR__ . "/trozoPoblaciones.html");

    $trozos = explode("##filaPoblacion##", $cadena);

    $trozosPoblaciones = "";
    while ($datosPoblacion = $poblaciones->fetch_assoc()) {
        $aux = $trozos[1];
        $aux = str_replace("##poblacion##", $datosPoblacion['nombre'], $aux);
        $aux = str_replace("##id_poblacion##", $datosPoblacion['id'], $aux);
        $trozosPoblaciones .= $aux;
    }

    echo $trozos[0] . $trozosPoblaciones . $trozos[2];
}

function vMostrarPerfil($autentificado, $datosPagina, $categorias, $arrayDatosPerfil, $empleado = null, $errores = "ok")
{

    $usuarioDb = $arrayDatosPerfil[0];
    $usuarioApi = $arrayDatosPerfil[1];
    $serviciosDb = $arrayDatosPerfil[2];
    $serviciosApi = $arrayDatosPerfil[3];
    $citasApi = $arrayDatosPerfil[4];

    $cadena = file_get_contents(__DIR__ . "/perfil.html");

    if ($autentificado == true) {
        $header = file_get_contents(__DIR__ . "/headerSession.html");
    } else {
        $header = file_get_contents(__DIR__ . "/header.html");
    }
    $cadena = str_replace("##header##", $header, $cadena);

    if ($empleado != null) {
        $empleado_aux = $empleado->fetch_assoc();
        $cadena = str_replace("##nombreUsuario##", $empleado_aux['nombre'], $cadena);
        $cadena = str_replace("##imagenPerfil##", $empleado_aux['imagen_perfil'], $cadena);
    }

    $trozos1 = explode("##filaCategoriaNav##", $cadena);
    $trozos2 = explode("##filaDisponibilidad##", $trozos1[2]);
    $trozos3 = explode("##filaServicio##", $trozos2[2]);
    $trozos4 = explode("##filaCita##", $trozos3[2]);

    $datosPagina_aux = $datosPagina->fetch_assoc();

    $trozos1[0] = str_replace("##tituloWeb##", $datosPagina_aux['nombre'], $trozos1[0]);
    $trozos1[0] = str_replace("##imagenLogo##", $datosPagina_aux['logo'], $trozos1[0]);

    $categorias_navegador = "";
    while ($datosCategoria = $categorias->fetch_assoc()) {

        $aux = $trozos1[1];
        $aux = str_replace("##nombreCategoria##", $datosCategoria['nombre'], $aux);
        $aux = str_replace("##categoriaId##", $datosCategoria['id'], $aux);
        $categorias_navegador .= $aux;

    }

    //Notificaciones de errores
    if ($errores == "ok") {
        $trozos2[0] = str_replace("##visibilidad##", "hidden", $trozos2[0]);
    } elseif ($errores == "ok_cancelacion") {
        $trozos2[0] = str_replace("##tipoAlerta##", "info", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "La cita se ha cancelado correctamente. Se ha enviado un correo al cliente para notificarle la cancelación de la cita.", $trozos2[0]);
    } elseif (($errores == "error_cancelacion_api")) {
        $trozos2[0] = str_replace("##tipoAlerta##", "danger", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Error en la conexión con Microsoft 365, no se ha cancelado la cita, verificar token", $trozos2[0]);
    } elseif ($errores == "error_cancelar_cita") {
        $trozos2[0] = str_replace("##tipoAlerta##", "danger", $trozos2[0]);
        $trozos2[0] = str_replace("##visibilidad##", "", $trozos2[0]);
        $trozos2[0] = str_replace("##mensajeNotificacion##", "Error, no ha podido cancelar la cita", $trozos2[0]);
    }

    $trozos2[0] = str_replace("##fotoPerfil##", $usuarioDb['imagen_perfil'], $trozos2[0]);
    $trozos2[0] = str_replace("##nombrePersona##", $usuarioApi["displayName"], $trozos2[0]);
    $trozos2[0] = str_replace("##experiencia##", $usuarioDb['experiencia'], $trozos2[0]);

    $disponibilidad = "";
    for ($numHorario = 0; $numHorario < count($usuarioApi["workingHours"]); $numHorario++) {

        $aux = $trozos2[1];
        switch ($usuarioApi["workingHours"][$numHorario]["day"]) {
            case "monday":
                $dia = "Lunes";
                break;
            case "tuesday":
                $dia = "Martes";
                break;
            case "wednesday":
                $dia = "Miércoles";
                break;
            case "thursday":
                $dia = "Jueves";
                break;
            case "friday":
                $dia = "Viernes";
                break;
            case "saturday":
                $dia = "Sábado";
                break;
            default:
                $dia = "Domingo";
        }
        $aux = str_replace("##dia##", $dia, $aux);
        if (isset($usuarioApi["workingHours"][$numHorario]["timeSlots"][0]["startTime"])) {
            $trozosHoraInicial = explode(".", $usuarioApi["workingHours"][$numHorario]["timeSlots"][0]["startTime"]);
            $aux = str_replace("##horaInicial##", $trozosHoraInicial[0], $aux);
            if (isset($usuarioApi["workingHours"][$numHorario]["timeSlots"][0]["endTime"])) {
                $trozosHoraFinal = explode(".", $usuarioApi["workingHours"][$numHorario]["timeSlots"][0]["endTime"]);
                $aux = str_replace("##horaFinal##", $trozosHoraFinal[0], $aux);
                $disponibilidad .= $aux;
            }
        }
    }

    if ($usuarioDb['vehiculo_propio'] == 1) {
        $trozos3[0] = str_replace("##vehiculoPropio##", "Sí", $trozos3[0]);
    } else {
        $trozos3[0] = str_replace("##vehiculoPropio##", "No", $trozos3[0]);
    }
    $trozos3[0] = str_replace("##idUsuario##", $usuarioDb['id'], $trozos3[0]);

    if ($autentificado && ($_SESSION["id_usuario"] == $usuarioDb['id'])) {
        $trozos3[0] = str_replace("##visbilidad##", "", $trozos3[0]);
    } else {
        $trozos3[0] = str_replace("##visbilidad##", "hidden", $trozos3[0]);
    }

    $arrayServiciosIdNombre = array();
    $servicios = "";
    for ($numServicio = 0; $numServicio < count($serviciosDb); $numServicio++) {
        $aux = $trozos3[1];
        $aux = str_replace("##nombreServicio##", $serviciosApi[$numServicio]["displayName"], $aux);
        $aux = str_replace("##descripcionServicio##", $serviciosApi[$numServicio]["description"], $aux);
        $aux = str_replace("##fechaServicio##", $serviciosDb[$numServicio]['fecha_publicacion'], $aux);
        $aux = str_replace("##localizacionServicio##", $serviciosApi[$numServicio]["defaultLocation"]["address"]["city"] . ', ' . $serviciosApi[$numServicio]["defaultLocation"]["address"]["state"] . ', ' . $serviciosApi[$numServicio]["defaultLocation"]["address"]["countryOrRegion"], $aux);
        $aux = str_replace("##precioServicio##", $serviciosApi[$numServicio]["defaultPrice"], $aux);
        $aux = str_replace("##idServicio##", $serviciosDb[$numServicio]['id'], $aux);
        $arrayServiciosIdNombre[$serviciosDb[$numServicio]['id']] = $serviciosApi[$numServicio]["displayName"];
        $servicios .= $aux;
    }

    if ($autentificado && ($_SESSION["id_usuario"] == $usuarioDb['id'])) {
        $trozos4[0] = str_replace("##visbilidad##", "", $trozos4[0]);
    } else {
        $trozos4[0] = str_replace("##visbilidad##", "hidden", $trozos4[0]);
    }

    $citas = "";
    if ($autentificado && ($_SESSION["id_usuario"] == $usuarioDb['id'])) {
        for ($numCita = 0; $numCita < count($citasApi); $numCita++) {

            $aux = $trozos4[1];
            if (isset($arrayServiciosIdNombre[$citasApi[$numCita]["serviceId"]])) {
                $aux = str_replace("##nombreServicio##", $arrayServiciosIdNombre[$citasApi[$numCita]["serviceId"]], $aux);
            }
            if (isset($citasApi[$numCita]["customers"][0]["name"])) {
                $aux = str_replace("##nombreCliente##", $citasApi[$numCita]["customers"][0]["name"], $aux);
            }
            if (isset($citasApi[$numCita]["customers"][0]["emailAddress"])) {
                $aux = str_replace("##emailCliente##", $citasApi[$numCita]["customers"][0]["emailAddress"], $aux);
            }

            if (isset($citasApi[$numCita]["startDateTime"]["dateTime"])) {
                $trozosFechaInicio = explode("T", $citasApi[$numCita]["startDateTime"]["dateTime"]);
                $trozosDia = explode("-", $trozosFechaInicio[0]);
                $dia = $trozosDia[2] . "-" . $trozosDia[1] . "-" . $trozosDia[0];
                $aux = str_replace("##dia##", $dia, $aux);

                $trozosHoraInicio = explode("+", $trozosFechaInicio[1]);
                $horaInicio = $trozosHoraInicio[0];
                $aux = str_replace("##horaInicio##", $horaInicio, $aux);
            }

            if (isset($citasApi[$numCita]["endDateTime"]["dateTime"])) {
                $trozosFechaFin = explode("T", $citasApi[$numCita]["endDateTime"]["dateTime"]);
                $trozosHoraFin = explode("+", $trozosFechaFin[1]);
                $horaFin = $trozosHoraFin[0];
                $aux = str_replace("##horaFin##", $horaFin, $aux);
            }

            if (isset($citasApi[$numCita]["serviceLocation"]["displayName"])) {
                $aux = str_replace("##localizacion##", $citasApi[$numCita]["serviceLocation"]["displayName"], $aux);
            }

            $aux = str_replace("##idUsuario##", $usuarioDb['id'], $aux);

            if (isset($citasApi[$numCita]["id"])) {
                $aux = str_replace("##idCita##", $citasApi[$numCita]["id"], $aux);
            }

            $citas .= $aux;
        }
    }

    echo $trozos1[0] . $categorias_navegador . $trozos2[0] . $disponibilidad . $trozos3[0] . $servicios . $trozos4[0] . $citas . $trozos4[2];
}

function vMostrarRegistrar($datosPagina, $ccaa, $provincias, $poblaciones)
{
    $cadena = file_get_contents(__DIR__ . "/register.html");

    $datosPagina_aux = $datosPagina->fetch_assoc();

    $cadena = str_replace("##tituloWeb##", $datosPagina_aux['nombre'], $cadena);
    $cadena = str_replace("##imagenLogo##", $datosPagina_aux['logo'], $cadena);

    $trozos1 = explode("##filaComunidadAutonoma##", $cadena);

    $trozoComunidadesAutonomas = "";
    while ($datosComunidadAutonoma = $ccaa->fetch_assoc()) {
        $aux = $trozos1[1];
        $aux = str_replace("##comunidad_autonoma##", $datosComunidadAutonoma['nombre'], $aux);
        $aux = str_replace("##id_comunidad_autonoma##", $datosComunidadAutonoma['id'], $aux);
        $aux = str_replace("##selected##", "", $aux);
        $trozoComunidadesAutonomas .= $aux;
    }
    echo $trozos1[0] . $trozoComunidadesAutonomas . $trozos1[2];
}

function vMostrarIniciarSesion($datosPagina, $errores = "ok")
{
    $cadena = file_get_contents(__DIR__ . "/login.html");
    $datosPagina_aux = $datosPagina->fetch_assoc();

    //Notificaciones de errores
    if ($errores == "ok") {
        $cadena = str_replace("##visibilidad##", "hidden", $cadena);
    } else {
        $cadena = str_replace("##tipoAlerta##", "danger", $cadena);
        $cadena = str_replace("##visibilidad##", "", $cadena);
        $cadena = str_replace("##mensajeNotificacion##", "No se ha podido iniciar sesión", $cadena);
    }

    $cadena = str_replace("##tituloWeb##", $datosPagina_aux['nombre'], $cadena);
    $cadena = str_replace("##imagenLogo##", $datosPagina_aux['logo'], $cadena);

    echo $cadena;
}

function vMostrarNuevoServicio($datosPagina, $categorias, $empleado = null)
{
    $cadena = file_get_contents(__DIR__ . "/nuevoservicio.html");
    $header = file_get_contents(__DIR__ . "/headerSession.html");

    $cadena = str_replace("##header##", $header, $cadena);

    $datosPagina_aux = $datosPagina->fetch_assoc();
    $cadena = str_replace("##tituloWeb##", $datosPagina_aux['nombre'], $cadena);
    $cadena = str_replace("##imagenLogo##", $datosPagina_aux['logo'], $cadena);
    if ($empleado != null) {
        $empleado_aux = $empleado->fetch_assoc();
        $cadena = str_replace("##nombreUsuario##", $empleado_aux['nombre'], $cadena);
        $cadena = str_replace("##imagenPerfil##", $empleado_aux['imagen_perfil'], $cadena);
    }

    $trozos1 = explode("##filaCategoriaNav##", $cadena);
    $trozos2 = explode("##filaCategoriaPag##", $trozos1[2]);

    $categorias_navegador = "";
    $categorias_pagina = "";
    while ($datosCategoria = $categorias->fetch_assoc()) {
        $aux = $trozos1[1];
        $aux = str_replace("##nombreCategoria##", $datosCategoria['nombre'], $aux);
        $aux = str_replace("##categoriaId##", $datosCategoria['id'], $aux);
        $categorias_navegador .= $aux;

        $aux = $trozos2[1];
        $aux = str_replace("##nombreCategoria##", $datosCategoria['nombre'], $aux);
        $aux = str_replace("##categoriaId##", $datosCategoria['id'], $aux);
        $categorias_pagina .= $aux;
    }

    echo $trozos1[0] . $categorias_navegador . $trozos2[0] . $categorias_pagina . $trozos2[2];

}

function vMostrarEditarPerfil($datosPagina, $categorias, $provincias, $comunidadesAutonomas, $poblaciones, $datosEditarPerfil){

    //DatosPerfil 0 --> Empleado Base de datos
    //DatosPerfil 1 --> Empleado Api
    //DatosPerfil 2 --> Empresa Api

    $cadena = file_get_contents(__DIR__ . "/editarPerfil.html");
    $header = file_get_contents(__DIR__ . "/headerSession.html");

    $cadena = str_replace("##header##", $header, $cadena);
    $cadena = str_replace("##nombreUsuario##", $datosEditarPerfil[0]['nombre'], $cadena);
    $cadena = str_replace("##imagenPerfil##", $datosEditarPerfil[0]['imagen_perfil'], $cadena);

    $datosPagina_aux = $datosPagina->fetch_assoc();

    $cadena = str_replace("##tituloWeb##", $datosPagina_aux['nombre'], $cadena);
    $cadena = str_replace("##imagenLogo##", $datosPagina_aux['logo'], $cadena);

    $cadena = str_replace("##valorDireccion##", $datosEditarPerfil[2]['address']['street'], $cadena);

    $cadena = str_replace("##valueDescripcion##", $datosEditarPerfil[0]['experiencia'], $cadena);

    if ($datosEditarPerfil[0]['vehiculo_propio'] == 1) {
        $cadena = str_replace("##checked##", "checked", $cadena);
    } else {
        $cadena = str_replace("##checked##", "", $cadena);
    }

    $trozos1 = explode("##filaCategoriaNav##", $cadena);
    $trozos2 = explode("##filaComunidadAutonoma##", $trozos1[2]);
    $trozos3 = explode("##filaProvincia##", $trozos2[2]);
    $trozos4 = explode("##filaPoblacion##", $trozos3[2]);

    $categorias_navegador = "";
    while ($datosCategoria = $categorias->fetch_assoc()) {
        $aux = $trozos1[1];
        $aux = str_replace("##nombreCategoria##", $datosCategoria['nombre'], $aux);
        $aux = str_replace("##categoriaId##", $datosCategoria['id'], $aux);
        $categorias_navegador .= $aux;
    }

    $trozoComunidadesAutonomas = "";
    $idComunidadAutonoma = "";
    while ($datosComunidadAutonoma = $comunidadesAutonomas->fetch_assoc()) {
        $aux = $trozos2[1];
        $aux = str_replace("##comunidad_autonoma##", $datosComunidadAutonoma['nombre'], $aux);
        $aux = str_replace("##id_comunidad_autonoma##", $datosComunidadAutonoma['id'], $aux);
        if ($datosComunidadAutonoma['nombre'] == $datosEditarPerfil[2]["address"]["countryOrRegion"]) {
            $aux = str_replace("##selected##", "selected", $aux);
            $idComunidadAutonoma = $datosComunidadAutonoma['id'];
        } else {
            $aux = str_replace("##selected##", "", $aux);
        }
        if ($idComunidadAutonoma == "") {
            $idComunidadAutonoma = $datosComunidadAutonoma['id'];
        }
        $trozoComunidadesAutonomas .= $aux;
    }

    $trozoProvincias = "";
    $idProvincia = "";
    while ($datosProvincia = $provincias->fetch_assoc()) {
        if ($datosProvincia['id_comunidad_autonoma'] == $idComunidadAutonoma) {
            $aux = $trozos3[1];
            $aux = str_replace("##provincia##", $datosProvincia['nombre'], $aux);
            $aux = str_replace("##id_provincia##", $datosProvincia['id'], $aux);
            if ($datosProvincia['nombre'] == $datosEditarPerfil[2]["address"]["state"]) {
                $aux = str_replace("##selected##", "selected", $aux);
                $idProvincia = $datosProvincia['id'];
            } else {
                $aux = str_replace("##selected##", "", $aux);
            }
            if ($idProvincia == "") {
                $idProvincia = $datosProvincia['id'];
            }
            $trozoProvincias .= $aux;
        }
    }

    $trozoPoblaciones = "";
    while ($datosPoblacion = $poblaciones->fetch_assoc()) {
        if ($datosPoblacion['id_provincia'] == $idProvincia) {
            $aux = $trozos4[1];
            $aux = str_replace("##poblacion##", $datosPoblacion['nombre'], $aux);
            $aux = str_replace("##id_poblacion##", $datosPoblacion['id'], $aux);
            if ($datosPoblacion['nombre'] == $datosEditarPerfil[2]["address"]["city"]) {
                $aux = str_replace("##selected##", "selected", $aux);
            } else {
                $aux = str_replace("##selected##", "", $aux);
            }
            $trozoPoblaciones .= $aux;
        }
    }
    $cadena = $trozos1[0] . $categorias_navegador . $trozos2[0] . $trozoComunidadesAutonomas . $trozos3[0] . $trozoProvincias . $trozos4[0] . $trozoPoblaciones . $trozos4[2];

    //Completamos los dias con los datos del api
    $opciones = file_get_contents(__DIR__ . "/opcionesHoras.html");

    $lista_values = array('00:01:00.0000000','01:00:00.0000000','02:00:00.0000000','03:00:00.0000000','04:00:00.0000000','05:00:00.0000000','06:00:00.0000000','07:00:00.0000000','08:00:00.0000000','09:00:00.0000000','10:00:00.0000000','11:00:00.0000000','12:00:00.0000000','13:00:00.0000000','14:00:00.0000000','15:00:00.0000000','16:00:00.0000000','17:00:00.0000000','18:00:00.0000000','19:00:00.0000000','20:00:00.0000000','21:00:00.0000000','22:00:00.0000000','23:00:00.0000000', '23:59:00.0000000');
    $lista_horas = array('00:01','01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00','22:00','23:00', '23:59');
    $dias = array("lunes", "martes", "miercoles", "jueves", "viernes", "sabado", "domingo");
    $dias_rellenados = array();
    $startoend = array('startTime', 'endTime');
    $iniofin = array('Ini', 'Fin');

    for($iniofin_value = 0; $iniofin_value < count($iniofin); $iniofin_value++){
        for ($numHorario = 0; $numHorario < count($datosEditarPerfil[1]["workingHours"]); $numHorario++) {
            $dia = "";
            switch ($datosEditarPerfil[1]["workingHours"][$numHorario]["day"]) {
                case "monday":
                    $dia = $dias[0];
                    break;
                case "tuesday":
                    $dia = $dias[1];
                    break;
                case "wednesday":
                    $dia = $dias[2];
                    break;
                case "thursday":
                    $dia = $dias[3];
                    break;
                case "friday":
                    $dia = $dias[4];
                    break;
                case "saturday":
                    $dia = $dias[5];
                    break;
                case "sunday":
                    $dia = $dias[6];
            }
            $listaopciones = "";
            for($i = 0; $i < count($lista_values); $i++){
                $aux = $opciones;
                $aux = str_replace("##valuehora##", $lista_values[$i], $aux);
                $aux = str_replace("##hora##", $lista_horas[$i], $aux);
                if ($lista_values[$i] == $datosEditarPerfil[1]["workingHours"][$numHorario]["timeSlots"][0][$startoend[$iniofin_value]]){
                    $aux = str_replace("##selected##", 'selected', $aux);
                } else {
                    $aux = str_replace("##selected##", '', $aux);
                }
                $listaopciones .= $aux;
            }
            $cadena = str_replace('##' . $dia . $iniofin[$iniofin_value] . '##', $listaopciones, $cadena);

            if(!in_array($dia, $dias_rellenados)){
                $dias_rellenados[] = $dia;
            }
        }
    }

    //Completamos los dias restantes
    $dias_faltantes = array();
    foreach($dias as $dia_){
        if(!in_array($dia_, $dias_rellenados)){
            $dias_faltantes[] = $dia_;
        }
    }

    for($iniofin_value = 0; $iniofin_value < count($iniofin); $iniofin_value++){
        for ($numHorario = 0; $numHorario < count($dias_faltantes); $numHorario++) {
            $listaopciones = "";
            for($i = 0; $i < count($lista_values); $i++){
                $aux = $opciones;
                $aux = str_replace("##valuehora##", $lista_values[$i], $aux);
                $aux = str_replace("##hora##", $lista_horas[$i], $aux);
                $aux = str_replace("##selected##", '', $aux);
                $listaopciones .= $aux;
            }
            $cadena = str_replace('##' . $dias_faltantes[$numHorario] . $iniofin[$iniofin_value] . '##', $listaopciones, $cadena);
        }
    }

    $cadena = str_replace("##fotoperfil##", $datosEditarPerfil[0]['imagen_perfil'], $cadena);

    echo $cadena;
}

