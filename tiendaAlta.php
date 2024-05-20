<?php

/*
B- (1 pt.) TiendaAlta.php: (por POST) se ingresa Nombre, Precio, Tipo (“Camiseta” o “Pantalón”), Talla (“S”, “M”,
“L”), Color, Stock (unidades).
Se guardan los datos en el archivo de texto tienda.json, tomando un id autoincremental como identificador
(emulado). Si el nombre y tipo ya existen, se actualiza el precio y se suma al stock existente.
Completar el alta con imagen de la prenda, guardando la imagen con el nombre y tipo como identificación en la
carpeta /ImagenesDeRopa/2024
*/

if (isset($_POST["nombre"]) && isset($_POST["precio"]) && isset($_POST["tipo"]) && isset($_POST["talla"]) && isset($_POST["color"]) && isset($_POST["stock"]) && isset($_FILES["imagen"]))
{
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $tipo = $_POST["tipo"];
    $talla = $_POST["talla"];
    $color = $_POST["color"];
    $stock = $_POST["stock"];
    $imagen = $_FILES["imagen"];

    if ($tipo != "camiseta" && $tipo != "pantalon")
    {
        echo "El tipo de indumentaria debe ser camiseta o pantalon";
        exit;
    }
    elseif ($talla != "S" && $talla != "M" && $talla != "L")
    {
        echo "La talla debe ser S, M o L";
        exit;
    }

    $id = 0;
    $actualizado = false;

    $prendas_array = array();
    if (file_exists("./tienda.json"))
    {
        $prendas_array = json_decode(file_get_contents("./tienda.json", JSON_PRETTY_PRINT), true);
    }

    foreach ($prendas_array as &$prenda)
    {
        if ($prenda["nombre"] == $nombre && $prenda["tipo"] == $tipo)
        {
            $prenda["precio"] = $precio;
            $prenda["stock"] = $stock;
            $actualizado = true;
            break;
        }
        if ($prenda["id"] >= $id)
        {
            $id = $prenda["id"] + 1;
        }
    }

    if (!$actualizado)
    {
        $prenda = array(
            "id" => $id,
            "nombre" => $nombre,
            "precio" => $precio,
            "tipo" => $tipo,
            "talla" => $talla,
            "color" => $color,
            "stock" => $stock,
            "imagen" => $nombre ."_". $tipo . ".png"
        );
        $prendas_array[] = $prenda;
    }

    file_put_contents("./tienda.json", json_encode($prendas_array, JSON_PRETTY_PRINT));

    $imagen_path = "./ImagenesDeRopa/2024/" . $nombre ."_". $tipo . ".png";

    if (!file_exists("./ImagenesDeRopa/2024"))
    {
        //Gracias Arqui
        mkdir("./ImagenesDeRopa/2024", 0777, true);
    }
    move_uploaded_file($imagen["tmp_name"], $imagen_path);

    echo "prenda actualizada/agregado";
}
else
{
    echo "faltan datos/imagen";
}

?>