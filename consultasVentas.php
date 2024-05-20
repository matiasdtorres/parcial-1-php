<?php

/*
4- (2 pts.) ConsultasVentas.php: (por GET)
Datos a consultar:
a- La cantidad de prendas vendidas en un día en particular (se envía por parámetro), si no se pasa fecha,
se muestran las del día de ayer.
b- El listado de ventas de un usuario ingresado.
c- El listado de ventas por tipo de prenda.
d- El listado de prendas cuyo precio esté entre dos números ingresados.
e- El listado de ingresos por día de una fecha ingresada. Si no se ingresa una fecha, se muestran los ingresos de
todos los días.
f- Mostrar el producto más vendido.

## PARTE POR PARTE ##
https://github.com/matiasdtorres/parcial-1-php
*/

if(isset($_GET["get"]))
{
    if(isset($_GET["fecha"]))
    {
        $fecha = $_GET["fecha"];
    }
    else
    {
        $fecha = strtotime("-1 day");
        $fecha = date("d-m-Y", $fecha);
    }

    $fecha = strtotime($fecha);
    $fecha = date("d-m-Y", $fecha);

    $ventas = array();
    if (file_exists("./ventas.json"))
    {
        $ventas = json_decode(file_get_contents("./ventas.json"), true);
    }

    $cantidad = 0;

    foreach ($ventas as $ventaIndividual)
    {
        if ($ventaIndividual["fecha"] == $fecha)
        {
            $cantidad += $ventaIndividual["stock"];
        }
    }
    echo $cantidad;

}

?>