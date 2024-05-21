<?php

$nombreCamisa = $_POST['nombre_camisa'];
$tipoCamisa = $_POST['tipo_camisa'];
$tallaCamisa = $_POST['talla_camisa'];
$nombrePantalon = $_POST['nombre_pantalon'];
$tipoPantalon = $_POST['tipo_pantalon'];
$tallaPantalon = $_POST['talla_pantalon'];
$imagen = $_FILES['imagen'];

$tiendaPath = 'tienda.json';
$productos = file_exists($tiendaPath) ? json_decode(file_get_contents($tiendaPath), true) : [];

$camisa = null;
$pantalon = null;

foreach ($productos as $producto)
{
    if ($producto['nombre'] === $nombreCamisa && $producto['tipo'] === $tipoCamisa) {
        $camisa = $producto;
    }
    if ($producto['nombre'] === $nombrePantalon && $producto['tipo'] === $tipoPantalon) {
        $pantalon = $producto;
    }
}

if ($camisa && $pantalon) {
    $precioTotal = $camisa['precio'] + $pantalon['precio'];
    $id = count($productos) + 1;
    $conjunto = [
        'id' => $id,
        'tipo' => 'conjunto',
        'nombre_camisa' => $camisa['nombre'],
        'nombre_pantalon' => $pantalon['nombre'],
        'talla_camisa' => $tallaCamisa,
        'talla_pantalon' => $tallaPantalon,
        'precio_total' => $precioTotal
    ];
    $productos[] = $conjunto;
    file_put_contents($tiendaPath, json_encode($productos, JSON_PRETTY_PRINT));

    if ($imagen && $imagen['tmp_name']) {
        $imagenDir = "ImagenesDeConjuntos/2024";
        if (!file_exists($imagenDir)) {
            mkdir($imagenDir, 0777, true);
        }
        $imagenPath = "$imagenDir/{$camisa['nombre']}_{$pantalon['nombre']}.jpg";
        if (move_uploaded_file($imagen['tmp_name'], $imagenPath)) {
            echo "Conjunto registrado exitosamente.";
        } else {
            echo "Error al mover la imagen.";
        }
    } else {
        echo "Conjunto registrado exitosamente.";
    }
} else {
    echo "Uno o ambos productos no existen.";
}
?>
