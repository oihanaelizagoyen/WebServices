<?php

function vMostrarIniciarSesion($comentarios_login = "ok"){
    $cadena = file_get_contents(__DIR__ . "/login.html");

    if($comentarios_login == "ok"){
        $cadena = str_replace("##visibilidad##", "hidden", $cadena);
    }elseif($comentarios_login == "tiempo_expirado"){
        $cadena = str_replace("##tipoAlerta##", "danger", $cadena);
        $cadena = str_replace("##visibilidad##", "", $cadena);
        $cadena = str_replace("##mensajeNotificacion##", "El tiempo de la sesión ha expirado.", $cadena);
    }elseif($comentarios_login == "contrasena_incorrecta" || $comentarios_login == "usuario_no_existe"){
        $cadena = str_replace("##tipoAlerta##", "danger", $cadena);
        $cadena = str_replace("##visibilidad##", "", $cadena);
        $cadena = str_replace("##mensajeNotificacion##", "El usuario o contraseña es incorrecto.", $cadena);
    }elseif($comentarios_login == "error_formulario"){
        $cadena = str_replace("##tipoAlerta##", "danger", $cadena);
        $cadena = str_replace("##visibilidad##", "", $cadena);
        $cadena = str_replace("##mensajeNotificacion##", "Error al enviar los datos de inicio de sesión.", $cadena);
    }

    echo $cadena;
}

function vMostrarHome($datosPagina, $mensajeNotificacion = "ok")
{
    $cadena = file_get_contents(__DIR__ . "/home.html");

    $adminDb = obtenerAdminDb($_SESSION['id_admin'])->fetch_assoc();
    $cadena = str_replace("##nombreAdmin##", $adminDb['nombre_admin'], $cadena);

    if($mensajeNotificacion == "ok"){
        $cadena = str_replace("##visibilidad##", "hidden", $cadena);
    }elseif($mensajeNotificacion == "correcta_actualizacion_datos_pagina"){
        $cadena = str_replace("##tipoAlerta##", "success", $cadena);
        $cadena = str_replace("##visibilidad##", "", $cadena);
        $cadena = str_replace("##mensajeNotificacion##", "Los datos de la página se han actualizado correctamente.", $cadena);
    }elseif($mensajeNotificacion == "error_actualizacion_datos_pagina"){
        $cadena = str_replace("##tipoAlerta##", "danger", $cadena);
        $cadena = str_replace("##visibilidad##", "", $cadena);
        $cadena = str_replace("##mensajeNotificacion##", "Se ha producido un error y los datos de la página no han podido ser actualizados.", $cadena);
    }elseif($mensajeNotificacion == "error_servicios_api"){
        $cadena = str_replace("##tipoAlerta##", "danger", $cadena);
        $cadena = str_replace("##visibilidad##", "", $cadena);
        $cadena = str_replace("##mensajeNotificacion##", "Error en la conexión con Microsoft 365, no se han podido obtener los datos de los servicios, verificar token", $cadena);
    }

    $datosPagina = obtenerDatosPagina()->fetch_assoc();
    $cadena = str_replace("##nombrePaginaWeb##", $datosPagina['nombre'], $cadena);
    $cadena = str_replace("##imagenLogo##", $datosPagina['logo'], $cadena);
    $cadena = str_replace("##descripcionPaginaWeb##", $datosPagina['descripcion'], $cadena);
    $cadena = str_replace("##imagenDescripcion##", $datosPagina['imagen_descripcion'], $cadena);

    echo $cadena;
}

function vMostrarModificarDatos($datosPagina)
{
    $cadena = file_get_contents(__DIR__ . "/trozoModificarDatosWeb.html");

    $datosPagina = obtenerDatosPagina()->fetch_assoc();
    $cadena = str_replace("##nombrePaginaWeb##", $datosPagina['nombre'], $cadena);
    $cadena = str_replace("##descripcionPaginaWeb##", $datosPagina['descripcion'], $cadena);

    echo $cadena;
}

function vMostrarSeccionDatosPagina($datosPagina)
{
    $cadena = file_get_contents(__DIR__ . "/trozoDatosWeb.html");

    $datosPagina = obtenerDatosPagina()->fetch_assoc();
    $cadena = str_replace("##nombrePaginaWeb##", $datosPagina['nombre'], $cadena);
    $cadena = str_replace("##imagenLogo##", $datosPagina['logo'], $cadena);
    $cadena = str_replace("##descripcionPaginaWeb##", $datosPagina['descripcion'], $cadena);
    $cadena = str_replace("##imagenDescripcion##", $datosPagina['imagen_descripcion'], $cadena);

    echo $cadena;
}

function vMostrarSeccionCategoriasServicios($categorias)
{
    $cadena = file_get_contents(__DIR__ . "/trozoCategorias.html");

    $trozos = explode("##filaCategoria##", $cadena);

    $listaCategorias = "";
    while($categoria = $categorias->fetch_assoc()){
        $aux = $trozos[1];
        $aux = str_replace("##imagenCategoria##", $categoria['imagen'], $aux);
        $aux = str_replace("##nombreCategoria##", $categoria['nombre'], $aux);
        $aux = str_replace("##categoriaDescripcion##", $categoria['descripcion'], $aux);

        $listaCategorias .= $aux;
    }

    echo $trozos[0] . $listaCategorias . $trozos[2];
}

function vMostrarSeccionServicios($datosServicios, $categorias)
{
    $serviciosDb = $datosServicios[0];
    $serviciosApi = $datosServicios[1];

    $cadena = file_get_contents(__DIR__ . "/trozoServicios.html");

    $trozos = explode("##filaServicio##", $cadena);

    $arrayCategoriasIdNombre = array();
    while($categoria = $categorias->fetch_assoc()){
        $arrayCategoriasIdNombre[$categoria['id']] = $categoria['nombre'];
    }

    $listaServicios = "";
    for($numServicio=0; $numServicio<count($serviciosDb); $numServicio++){
        $aux = $trozos[1];
        $aux = str_replace("##idServicio##", $serviciosDb[$numServicio]['id'], $aux);
        $aux = str_replace("##nombreServicio##", $serviciosApi[$numServicio]["displayName"], $aux);
        $aux = str_replace("##descripcionServicio##", $serviciosApi[$numServicio]["description"], $aux);
        $aux = str_replace("##precioServicio##", $serviciosDb[$numServicio]['precio'], $aux);
        if(isset($arrayCategoriasIdNombre[$serviciosDb[$numServicio]['id_categoria']])){
            $aux = str_replace("##categoriaServicio##", $arrayCategoriasIdNombre[$serviciosDb[$numServicio]['id_categoria']], $aux);
        }
        $aux = str_replace("##fechaServicio##", $serviciosDb[$numServicio]['fecha_publicacion'], $aux);
        $aux = str_replace("##idUsuarioServicio##", $serviciosDb[$numServicio]['id_usuario'], $aux);

        $listaServicios .= $aux;
    }

    echo $trozos[0] . $listaServicios . $trozos[2];
}

function vMostrarSeccionUsuarios($usuariosDb)
{
    $cadena = file_get_contents(__DIR__ . "/trozoUsuarios.html");

    $trozos = explode("##filaUsuario##", $cadena);

    $listaUsuarios = "";
    while($usuario = $usuariosDb->fetch_assoc()){
        $aux = $trozos[1];
        $aux = str_replace("##idUsuario##", $usuario['id'], $aux);
        $aux = str_replace("##fotoPerfilUsuario##", $usuario['imagen_perfil'], $aux);
        $aux = str_replace("##nombreUsuario##", $usuario['nombre'], $aux);
        $aux = str_replace("##emailUsuario##", $usuario['email'], $aux);
        if($usuario['vehiculo_propio'] == 1){
            $aux = str_replace("##vehiculoPropio##", "Sí", $aux);
        }else{
            $aux = str_replace("##vehiculoPropio##", "No", $aux);
        }
        $aux = str_replace("##experienciaUsuario##", $usuario['experiencia'], $aux);

        $listaUsuarios .= $aux;
    }

    echo $trozos[0] . $listaUsuarios . $trozos[2];
}