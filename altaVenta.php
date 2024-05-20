<?php

/*
3-
a- (1 pt.)
AltaVenta.php: (por POST) se recibe el email del usuario y el Nombre, Tipo, Talla y Stock, si el ítem existe
en tienda.json y hay stock, guardar en ventas.json (con la fecha, número de pedido y id autoincremental). Se debe
descontar la cantidad vendida del stock.
b- (1 pt) Completar el alta de la venta con imagen de la venta (ej: una imagen del usuario), guardando la imagen
con el nombre+tipo+talla+email(solo usuario hasta el @) y fecha de la venta en la carpeta
/ImagenesDeVenta/2024.

## PARTE POR PARTE ##
https://github.com/matiasdtorres/parcial-1-php
*/

if (isset($_POST["email"]) && isset($_POST["nombre"]) && isset($_POST["tipo"]) && isset($_POST["talla"]) && isset($_POST["stock"]) && isset($_FILES["imagen"]))
{
    $email = $_POST["email"];
    $nombre = $_POST["nombre"];
    $tipo = $_POST["tipo"];
    $talla = $_POST["talla"];
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

    $prendas = json_decode(file_get_contents("./tienda.json", JSON_PRETTY_PRINT), true);

    foreach ($prendas as &$heladoIndividual)
    {
        if ($heladoIndividual["nombre"] == $nombre && $heladoIndividual["tipo"] == $tipo && $heladoIndividual["stock"] >= $stock)
        {
            $heladoIndividual["stock"] -= $stock;
            file_put_contents("./tienda.json", json_encode($prendas, JSON_PRETTY_PRINT));
            $ventas = json_decode(file_get_contents("./ventas.json", JSON_PRETTY_PRINT), true);

            $id = 0;
            if (file_exists("./ventas.json"))
            {
                foreach ($ventas as $venta)
                {
                    if ($venta["id"] >= $id)
                    {
                        $id = $venta["id"] + 1;
                    }
                }
            }

            $imagenNombre = $nombre ."_". $tipo ."_". $talla ."_". explode("@", $email)[0] . date("_d-m-Y_") . ".png";

            if (!file_exists("./ImagenesDeVenta/2024"))
            {
                //Gracias Arqui
                mkdir("./ImagenesDeVenta/2024", 0777, true);
            }
            move_uploaded_file($imagen["tmp_name"], "./ImagenesDeVenta/2024/" . $imagenNombre);

            $venta = array(
                "id" => $id,
                "email" => $email,
                "nombre" => $nombre,
                "tipo" => $tipo,
                "talla" => $talla,
                "stock" => $stock,
                "imagen" => $imagenNombre,
                "fecha" => date("d-m-Y")
            );

            $ventas[] = $venta;
            file_put_contents("./ventas.json", json_encode($ventas, JSON_PRETTY_PRINT));
            echo "venta realizada";
            exit;
        }
    }

    echo "no existe";
    exit;
}
else
{
    echo "faltan datos/imagen";
}


?>