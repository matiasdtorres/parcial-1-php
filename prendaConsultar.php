<?php

/*
2-
(1pt.)
PrendaConsultar.php:
(por POST)
Se ingresa Nombre, Tipo y Color, si coincide con algún registro del archivo
tienda.json, retornar “existe”. De lo contrario, informar si no existe el tipo o el nombre.

## PARTE POR PARTE ##
https://github.com/matiasdtorres/parcial-1-php
*/

if (isset($_POST["nombre"]) && isset($_POST["tipo"]) && isset($_POST["color"]))
{
    $nombre = $_POST["nombre"];
    $tipo = $_POST["tipo"];
    $color = $_POST["color"];

    $prendas = json_decode(file_get_contents("./tienda.json", JSON_PRETTY_PRINT), true);

    foreach ($prendas as $prendaIndividual)
    {
        if ($prendaIndividual["nombre"] == $nombre && $prendaIndividual["tipo"] == $tipo && $prendaIndividual["color"] == $color)
        {
            echo "existe";
            exit;
        }
    }

    echo "no existe";
    exit;
}
else
{
    echo "faltan datos";
}

?>