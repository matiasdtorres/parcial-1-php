<?php

parse_str(file_get_contents("php://input"), $_PUT);

/*
5- (1 pts.) ModificarVenta.php (por PUT)
Debe recibir el número de pedido, el email del usuario, el nombre, tipo, talla y cantidad. Si existe se modifica, de
lo contrario, informar que no existe ese número de pedido.
*/

$numeroPedido = $_PUT["id"]?? '';
$email = $_PUT["email"]?? '';
$nombre = $_PUT["nombre"]?? '';
$tipo = $_PUT["tipo"]?? '';
$talla = $_PUT["talla"]?? '';

$ventasPath = "./ventas.json";
$ventas = file_exists($ventasPath) ? json_decode(file_get_contents($ventasPath), true) : [];
$ventaEncontrada = false;

foreach ($ventas as &$venta) {
    if ($venta["id_pedido"] === $numeroPedido)
    {
        $venta["email"] = $email;
        $venta["nombre"] = $nombre;
        $venta["tipo"] = $tipo;
        $venta["talla"] = $talla;
        $ventaEncontrada = true;
        break;
    }
}

if ($ventaEncontrada) {
    file_put_contents($ventasPath, json_encode($ventas, JSON_PRETTY_PRINT));
    echo "Venta modificada";
} else {
    echo "No existe el pedido.";
}
?>