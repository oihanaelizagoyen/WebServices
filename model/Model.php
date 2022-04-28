<?php
    require_once __DIR__ . '/DatabaseConnSingleton.php';

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