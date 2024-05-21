<?php

parse_str(file_get_contents("php://input"), $_DELETE);

$numeroPedido = $_DELETE["id"] ?? '';

$ventasPath = './ventas.json';
$ventas = file_exists($ventasPath) ? json_decode(file_get_contents($ventasPath), true) : [];
$existeVenta = false;

foreach ($ventas as &$venta)
{
    if ($venta["id_pedido"] === $numeroPedido)
    {
        $venta['borrado'] = "si";
        $existeVenta = true;

        $imagen_carpeta = "ImagenesDeVenta/2024";
        $backup_carpeta  = "ImagenesBackupVentas/2024";
        if (!file_exists($backup_carpeta))
        {
            //Gracias Arqui
            mkdir($backup_carpeta , 0777, true);
        }
        $imagen_nombre = "{$venta['nombre']}_{$venta['tipo']}_{$venta['talla']}_{$venta['email']}_{$venta['fecha']}_.png";
        $imagen_path = "$imagen_carpeta/$imagen_nombre";
        $backup_path = "$backup_carpeta/$imagen_nombre";
        if (file_exists($imagen_path))
        {
            rename($imagen_path, $backup_path);
            $venta["imagen"] = $backup_path;
            echo "Pedido borrado exitosamente";
        }
        else
        {
            echo "Pedido borrado";
        }


        break;
    }
}

if (!$existeVenta) {
    echo "no existe el pedido.";
}

file_put_contents($ventasPath, json_encode($ventas, JSON_PRETTY_PRINT));

?>
