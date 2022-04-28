<?php

    include __DIR__ . '/../model/NumberConvert.php';

    function vMostrarHome ($datosPagina, $categorias){
        $cadena = file_get_contents(__DIR__ . "/home.html");

        $trozos1 = explode("##filaCategoriaNav##", $cadena);
        $trozos2 = explode("##filaCategoriaPag##", $trozos1[2]);

        $datosPagina_aux = $datosPagina->fetch_assoc();

        $trozos1[0] = str_replace("##tituloWeb##", $datosPagina_aux['nombre'], $trozos1[0]);
        $trozos1[0] = str_replace("##imagenLogo##", $datosPagina_aux['logo'], $trozos1[0]);
        $trozos2[0] = str_replace("##imagenDescripcion##", $datosPagina_aux['imagen_descripcion'], $trozos2[0]);
        $trozos2[0] = str_replace("##descripcion##", $datosPagina_aux['descripcion'], $trozos2[0]);

        $categorias_navegador = "";
        $categorias_pagina = "";
        $contador = 0;
        while($datosCategoria = $categorias->fetch_assoc()){
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
