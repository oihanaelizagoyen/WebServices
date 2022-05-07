<?php
require_once __DIR__ . '/DatabaseConnSingleton.php';
require_once __DIR__ . '/pdf.php';
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

function obtenerCategoria($id_categoria)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaCategoria = "select * from final_Categoria where id='". $id_categoria ."';";
    $resultadoCategoria = $conn->query($consultaCategoria);
    return $resultadoCategoria;
}


function obtenerAdminDb($id_admin)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaAdmin = "select * from final_Administrador where id = \"$id_admin\";";
    $resultadoAdmin = $conn->query($consultaAdmin);
    return $resultadoAdmin;
}

function obtenerAdminDbPorNombre($nombre_admin)
{
     $conn = DatabaseConnSingleton::getConn();
     $consultaAdmin = "select * from final_Administrador where nombre_admin = \"$nombre_admin\";";
     $resultadoAdmin = $conn->query($consultaAdmin);
     return $resultadoAdmin;
}

function validarIniciarSesion()
{
    if(isset($_POST['nombreAdmin']) && isset($_POST['contrasena'])){
        $nombreAdmin = $_POST['nombreAdmin'];
        $contrasena = $_POST['contrasena'];

        if($adminDb = obtenerAdminDbPorNombre($nombreAdmin)->fetch_assoc()){
            if(password_verify($contrasena, $adminDb['contrasena'])){
                $_SESSION['id_admin'] = $adminDb['id'];
                //Es la contraseña hashseada
                $_SESSION['contrasena'] = $adminDb['contrasena'];
                $_SESSION['tiempo'] = time();
                return "sesion_iniciada";
            }else{
                return "contrasena_incorrecta";
            }
        }else{
            return "usuario_no_existe";
        }

    }else{
        return "error_formulario";
    }
}

function validarGuardarDatos(){
    if(isset($_POST['nombre_pagina_web']) && isset($_POST['descripcion_pagina_web'])){
        $nombre_pagina_web = $_POST['nombre_pagina_web'];
        $descripcion_pagina_web = $_POST['descripcion_pagina_web'];

        if (($_FILES['logo_pagina_web']['size'] == 0 && $_FILES['logo_pagina_web']['error'] == 0)
            && ($_FILES['imagen_descrip_pagina_web']['size'] == 0 && $_FILES['imagen_descrip_pagina_web']['error'] == 0)){
            $conn = DatabaseConnSingleton::getConn();
            if ($conn->query("UPDATE final_DatosPagina SET nombre='". $nombre_pagina_web ."', descripcion='". $descripcion_pagina_web ."' WHERE id=1") == TRUE) {
                return "correcta_actualizacion_datos_pagina";
            } else {
                DatabaseConnSingleton::closeConn();
                return "error_actualizacion_datos_pagina";
            }
        }

        $tipoLogo = $_FILES['logo_pagina_web']['type'];
        if ($tipoLogo == "image/jpg") {
            $nombreficheroLogo = time() . "-" . uniqid() . ".jpg";
        } elseif ($tipoLogo = "image/jpeg") {
            $nombreficheroLogo = time() . "-" . uniqid() . ".jpeg";
        } elseif ($tipoLogo = "image/png") {
            $nombreficheroLogo = time() . "-" . uniqid() . ".png";
        } elseif ($tipoLogo = "image/gif") {
            $nombreficheroLogo = time() . "-" . uniqid() . ".gif";
        } else {
            return "error_actualizacion_datos_pagina";
        }

        $tipoImagenDescripcion = $_FILES['imagen_descrip_pagina_web']['type'];
        if ($tipoImagenDescripcion == "image/jpg") {
            $nombreficheroImagenDescrip = time() . "-" . uniqid() . ".jpg";
        } elseif ($tipoImagenDescripcion = "image/jpeg") {
            $nombreficheroImagenDescrip = time() . "-" . uniqid() . ".jpeg";
        } elseif ($tipoImagenDescripcion = "image/png") {
            $nombreficheroImagenDescrip = time() . "-" . uniqid() . ".png";
        } elseif ($tipoImagenDescripcion = "image/gif") {
            $nombreficheroImagenDescrip = time() . "-" . uniqid() . ".gif";
        } else {
            return "error_actualizacion_datos_pagina";
        }

        $temporalLogo = $_FILES['logo_pagina_web']['tmp_name'];
        $temporalImagenDescripcion = $_FILES['imagen_descrip_pagina_web']['tmp_name'];

        if($temporalLogo == "" && $temporalImagenDescripcion == ""){
            $conn = DatabaseConnSingleton::getConn();
            if ($conn->query("UPDATE final_DatosPagina SET nombre='". $nombre_pagina_web ."', descripcion='". $descripcion_pagina_web ."' WHERE id=1") == TRUE) {
                return "correcta_actualizacion_datos_pagina";
            } else {
                DatabaseConnSingleton::closeConn();
                return "error_actualizacion_datos_pagina";
            }
        }elseif($temporalLogo == ""){
            //chmod($temporal, 777);

            if (!move_uploaded_file($temporalImagenDescripcion, '../imagenes/' . $nombreficheroImagenDescrip)) {
                return "error_actualizacion_datos_pagina";
            }

            $conn = DatabaseConnSingleton::getConn();
            if ($conn->query("UPDATE final_DatosPagina SET nombre='". $nombre_pagina_web ."', descripcion='". $descripcion_pagina_web ."', imagen_descripcion='". $nombreficheroImagenDescrip ."' WHERE id=1") == TRUE) {
                return "correcta_actualizacion_datos_pagina";
            } else {
                DatabaseConnSingleton::closeConn();
                return "error_actualizacion_datos_pagina";
            }

        }elseif($temporalImagenDescripcion == ""){
            //chmod($temporal, 777);

            if (!move_uploaded_file($temporalLogo, '../imagenes/' . $nombreficheroLogo)) {
                return "error_actualizacion_datos_pagina";
            }

            $conn = DatabaseConnSingleton::getConn();
            if ($conn->query("UPDATE final_DatosPagina SET nombre='". $nombre_pagina_web ."', descripcion='". $descripcion_pagina_web ."', logo='". $nombreficheroLogo ."' WHERE id=1") == TRUE) {
                return "correcta_actualizacion_datos_pagina";
            } else {
                DatabaseConnSingleton::closeConn();
                return "error_actualizacion_datos_pagina";
            }
        }

        //chmod($temporal, 777);

        if (!move_uploaded_file($temporalImagenDescripcion, '../imagenes/' . $nombreficheroImagenDescrip)) {
            return "error_actualizacion_datos_pagina";
        }
        if (!move_uploaded_file($temporalLogo, '../imagenes/' . $nombreficheroLogo)) {
            return "error_actualizacion_datos_pagina";
        }

        $conn = DatabaseConnSingleton::getConn();
        if ($conn->query("UPDATE final_DatosPagina SET nombre='". $nombre_pagina_web ."', descripcion='". $descripcion_pagina_web ."', imagen_descripcion='". $nombreficheroImagenDescrip ."', logo='". $nombreficheroLogo ."' WHERE id=1") == TRUE) {
            return "correcta_actualizacion_datos_pagina";
        } else {
            DatabaseConnSingleton::closeConn();
            return "error_actualizacion_datos_pagina";
        }
    }else{
        return "error_actualizacion_datos_pagina";
    }
}

function obtenerServiciosDb()
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaServicios = "select * from final_Servicio;";
    $resultadoServicios = $conn->query($consultaServicios);
    return $resultadoServicios;
}

function obtenerServicioDb($id_servicio)
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaServicios = "select * from final_Servicio where id='" . $id_servicio . "';";
    $resultadoServicios = $conn->query($consultaServicios);
    return $resultadoServicios;
}

function obtenerServicioApi($id_empresa, $id_servicio)
{
    $curl = new Curl();
    $respuesta = $curl->getGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $id_empresa . '/services/' . $id_servicio);
    return $respuesta;
}

function obtenerDatosServicios()
{
    $datos = obtenerServiciosDb();

    $serviciosDb = array();
    $serviciosApi = array();
    $errores = false;

    while ($datosServicioDb = $datos->fetch_assoc()) {
        $serviciosDb[] = $datosServicioDb;
        $serviciosApi[] = obtenerServicioApi($datosServicioDb['id_empresa'], $datosServicioDb['id']);
        if (!isset($serviciosApi[count($serviciosApi) - 1]["id"])) {
            $errores = true;
        }
    }

    $resultado = [$serviciosDb, $serviciosApi, $errores];

    return $resultado;
}

function obtenerUsuariosDb()
{
    $conn = DatabaseConnSingleton::getConn();
    $consultaUsuarios = "select * from final_Usuario;";
    $resultadoUsuarios = $conn->query($consultaUsuarios);
    return $resultadoUsuarios;
}

//Funcion anadir categoria
function anadirCategoria(){

    if(!isset($_POST['nombre']) && !isset($_POST['descripcion'])){
        return "error_anadir_categoria";
    }

    if ($_FILES['imgCategoria']['size'] == 0 && $_FILES['imgCategoria']['error'] == 0){
        return "error_imagen_anadir_categoria";
    }

    $tipo = $_FILES['imgCategoria']['type'];

    if ($tipo == "image/jpg") {
        $nombrefichero = time() . "-" . uniqid() . ".jpg";
    } elseif ($tipo = "image/jpeg") {
        $nombrefichero = time() . "-" . uniqid() . ".jpeg";
    } elseif ($tipo = "image/png") {
        $nombrefichero = time() . "-" . uniqid() . ".png";
    } elseif ($tipo = "image/gif") {
        $nombrefichero = time() . "-" . uniqid() . ".gif";
    } else {
        return "error_imagen_anadir_categoria";
    }

    $temporal = $_FILES['imgCategoria']['tmp_name'];

    if ($temporal == "") {
        return "error_imagen_anadir_categoria";
    }

    if (!move_uploaded_file($temporal, '../imagenes/' . $nombrefichero)) {
        return "error_imagen_anadir_categoria";
    }
    $conn = DatabaseConnSingleton::getConn();
    if ($conn->query("INSERT INTO final_Categoria (nombre, descripcion, imagen) VALUES ('" . $_POST['nombre'] . "','" . $_POST['descripcion'] . "','" . $nombrefichero . "')") == TRUE) {
        return "correcta_creacion_categoria";
    } else {
        DatabaseConnSingleton::closeConn();
        return "error_anadir_categoria";
    }
}


//Funcion eliminar categoria
function eliminarCategoria($id_categoria){
    $conn = DatabaseConnSingleton::getConn();
    $consultaServicios = "select * from final_Servicio where id_categoria=" . $id_categoria . ";";
    $servicios = $conn->query($consultaServicios);

    while($servicio = $servicios->fetch_assoc()){
        $respuesta = eliminarServicio($servicio['id']);
        if($respuesta == "error_api"){
            return "error_eliminar_categoria";
        }
    }

    $deleteCategoria = "DELETE FROM final_Categoria WHERE id=" . $id_categoria . ";";
    if ($resultadoDelete = $conn->query($deleteCategoria)) {
        return "servicio_eliminado_ok";
    }

    return "error_eliminar_categoria";
}

function obtenerCitasApi($id_empresa)
{
    $curl = new Curl();
    $respuesta = $curl->getGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $id_empresa . '/appointments');
    return $respuesta;
}

function cancelarCita($id_cita, $id_empresa)
{
    $datos = array(
        "cancellationMessage" => "Su cita ha sido cancelada por la eliminacion de la categoría del servicio. Si lo necesita, póngase en contacto con el administrador"
    );

    $curl = new Curl();
    $respuesta = $curl->postGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $id_empresa . '/appointments/' . $id_cita . '/cancel', $datos);

    if (empty($respuesta)) {
        return "ok_cancelacion";
    } else {
        return "error_cancelacion_api";
    }
}

function eliminarServicioApi($id_empresa, $id_servicio){
    $curl = new Curl();
    $respuesta = $curl->deleteGenerate('https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/' . $id_empresa . '/services/' . $id_servicio);

    if(isset($respuesta['error'])){
        return "error";
    } else {
        return "ok";
    }

}

function eliminarServicio($id_servicio){

    $servicio_ = obtenerServicioDb($id_servicio);
    $servicio = $servicio_->fetch_assoc();

    if(!isset($servicio['id_empresa'])){
        return "error_api";
    }
    $id_empresa = $servicio['id_empresa'];
    $resultadoCitasApi = obtenerCitasApi($id_empresa);
    if (!isset($resultadoCitasApi["value"])) {
        return "error_api";
    }

    if(isset($resultadoCitasApi["value"])) {
        $listaCitasApi = $resultadoCitasApi["value"];
        for ($numCita = 0; $numCita < count($listaCitasApi); $numCita++) {
            if ($listaCitasApi[$numCita]['serviceId'] == $id_servicio){
                $resultado_cancelacion = cancelarCita($listaCitasApi[$numCita]["id"], $id_empresa);
                if(!$resultado_cancelacion == "ok_cancelacion"){
                    return "error_api";
                }
            }
        }
    }else{
        return "error_api";
    }

    $respuesta = eliminarServicioApi($servicio['id_empresa'], $id_servicio);
    if($respuesta == "error"){
        return "error_eliminando_servicio";
    }

    $conn = DatabaseConnSingleton::getConn();
    $deleteServicio = "DELETE FROM final_Servicio WHERE id='" . $id_servicio . "';";
    if ($resultadoDelete = $conn->query($deleteServicio)) {
        return "servicio_eliminado_ok";
    }
    return "error_bd";
}

function validarGuardarDatosCategoria()
{
    if(isset($_POST['id_categoria']) && isset($_POST['nombre_categoria']) && isset($_POST['descripcion_categoria'])){
        $id_categoria = $_POST['id_categoria'];
        $nombre_categoria = $_POST['nombre_categoria'];
        $descripcion_categoria = $_POST['descripcion_categoria'];

        if ($_FILES['imagen_categoria']['size'] == 0 && $_FILES['imagen_categoria']['error'] == 0){
            $conn = DatabaseConnSingleton::getConn();
            if ($conn->query("UPDATE final_Categoria SET nombre='". $nombre_categoria ."', descripcion='". $descripcion_categoria ."' WHERE id=". $id_categoria .";") == TRUE) {
                return "correcta_actualizacion_categoria";
            } else {
                DatabaseConnSingleton::closeConn();
                return "error_actualizacion_categoria";
            }
        }

        $tipo = $_FILES['imagen_categoria']['type'];
        if ($tipo == "image/jpg") {
            $nombrefichero = time() . "-" . uniqid() . ".jpg";
        } elseif ($tipo = "image/jpeg") {
            $nombrefichero = time() . "-" . uniqid() . ".jpeg";
        } elseif ($tipo = "image/png") {
            $nombrefichero = time() . "-" . uniqid() . ".png";
        } elseif ($tipo = "image/gif") {
            $nombrefichero = time() . "-" . uniqid() . ".gif";
        } else {
            return "error_actualizacion_categoria";
        }

        $temporal = $_FILES['imagen_categoria']['tmp_name'];

        if($temporal == ""){
            $conn = DatabaseConnSingleton::getConn();
            if ($conn->query("UPDATE final_Categoria SET nombre='". $nombre_categoria ."', descripcion='". $descripcion_categoria ."' WHERE id=". $id_categoria .";") == TRUE) {
                return "correcta_actualizacion_categoria";
            } else {
                DatabaseConnSingleton::closeConn();
                return "error_actualizacion_categoria";
            }
        }

        //chmod($temporal, 777);

        if (!move_uploaded_file($temporal, '../imagenes/' . $nombrefichero)) {
            return "error_actualizacion_categoria";
        }

        $conn = DatabaseConnSingleton::getConn();
        if ($conn->query("UPDATE final_Categoria SET nombre='". $nombre_categoria ."', descripcion='". $descripcion_categoria."', imagen='". $nombrefichero ."' WHERE id=". $id_categoria .";") == TRUE) {
            return "correcta_actualizacion_categoria";
        } else {
            DatabaseConnSingleton::closeConn();
            return "error_actualizacion_categoria";
        }
    }else{
        return "error_actualizacion_categoria";
    }
}

function crearCsvUsuarios(){
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="usuarios.csv"');

    $user_CSV[0] = array('Id usuario', 'Nombre', 'Correo electrónico', 'Vehículo propio', 'Experiencia');

    $usuarios = obtenerUsuariosDb();
    $i = 1;
    while ($usuario = $usuarios->fetch_assoc()){
        $vehiculo = "";
        if ($usuario['vehiculo_propio'] == 0){
            $vehiculo = "No";
        } elseif ($usuario['vehiculo_propio'] == 1){
            $vehiculo = "Si";
        }
        $user_CSV[$i] = array($usuario['id'], $usuario['nombre'], $usuario['email'], $vehiculo, $usuario['experiencia']);
        $i++;
    }

    $fp = fopen('php://output', 'wb');
    foreach ($user_CSV as $line) {
        fputcsv($fp, $line, ',');
    }
    fclose($fp);
}

function obtenerPdfServicios(){

$conn = DatabaseConnSingleton::getConn();
$consultaUServicios = "SELECT id, id_categoria, fecha_publicacion, precio, id_usuario FROM final_Servicio";
$resultadoServicios = $conn->query($consultaUServicios);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->addPage('L');
$pdf->SetFont('Arial','B',8);


while ($row=$resultadoServicios->fetch_assoc()) {
    $pdf->Cell(55,10,$row['id'],1,0,'C',0);
    $pdf->Cell(55,10,$row['id_categoria'],1,0,'C',0);
    $pdf->Cell(55,10,$row['fecha_publicacion'],1,0,'C',0);
    $pdf->Cell(55,10,$row['precio'],1,0,'C',0);
    $pdf->Cell(55,10,$row['id_usuario'],1,1,'C',0);

} 

    $pdf->Output();
}