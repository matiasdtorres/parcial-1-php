<?php

/*
2-
(1pt.)
PrendaConsultar.php:
(por POST)
Se ingresa Nombre, Tipo y Color, si coincide con algún registro del archivo
tienda.json, retornar “existe”. De lo contrario, informar si no existe el tipo o el nombre.
*/

if (isset($_POST["nombre"]) && isset($_POST["tipo"]) && isset($_POST["color"]))
{
    $nombre = $_POST["nombre"];
    $tipo = $_POST["tipo"];
    $color = $_POST["color"];

    $prendas = json_decode(file_get_contents("./tienda.json", JSON_PRETTY_PRINT), true);

    foreach ($prendas as $prenda_individual)
    {
        if ($prenda_individual["nombre"] == $nombre && $prenda_individual["tipo"] == $tipo && $prenda_individual["color"] == $color)
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