<?php
    require_once __DIR__ . '/DatabaseConnSingleton.php';
    require_once __DIR__ . '/Curl.php';

    function obtenerDatosPagina(){
        $conn = DatabaseConnSingleton::getConn();
        $consultaDatosPagina = "select nombre, logo, descripcion, imagen_descripcion from final_DatosPagina;";
        $resultadoDatosPagina = $conn->query($consultaDatosPagina);
        return $resultadoDatosPagina;
    }

    function obtenerCategorias(){
        $conn = DatabaseConnSingleton::getConn();
        $consultaCategorias = "select * from final_Categoria;";
        $resultadoCategorias = $conn->query($consultaCategorias);
        return $resultadoCategorias;
    }

    function obtenerServiciosCategoriaDb($id_categoria){
        $conn = DatabaseConnSingleton::getConn();
        $consultaServicios = "select * from final_Servicio where id_categoria = " . $id_categoria . ";";
        $resultadoServicios = $conn->query($consultaServicios);
        return $resultadoServicios;
    }

    function obtenerServiciosApi($id_empresa, $id_servicio) {
        $curl = new Curl();
        $respuesta = $curl->getGenerate('GET https://graph.microsoft.com/v1.0/solutions/bookingBusinesses/'. $id_empresa .'/services/' . $id_servicio);
        return $respuesta;
    }

    function obtenerServiciosArray($id_categoria){
        $datos = obtenerServiciosCategoriaDb($id_categoria);
        $servicios = array();
        while($datosServicio = $datos->fetch_assoc()){
            $servicios[] = obtenerServiciosApi($datosServicio['id_empresa'], $datosServicio['id']);
        }
        return $servicios;
    }
/*
$datos = obtenerServiciosCategoriaDb(1);
while($datosServicio = $datos->fetch_assoc()){
        echo "<p>". $datosServicio['id']. ", " . $datosServicio['id_categoria'] ."</p>";
}
*/
$datos = obtenerServiciosArray(1);
var_dump($datos);
