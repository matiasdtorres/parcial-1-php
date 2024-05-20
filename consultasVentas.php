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

    // b- El listado de ventas de un usuario ingresado.
    if(isset($_GET["usuario"]))
    {
        $usuario = $_GET["usuario"];
        $ventas = array();
        if (file_exists("./ventas.json"))
        {
            $ventas = json_decode(file_get_contents("./ventas.json"), true);
        }
        $lista = array();
        foreach ($ventas as $ventaIndividual)
        {
            if ($ventaIndividual["email"] == $usuario)
            {
                array_push($lista, $ventaIndividual);
            }
        }
        echo json_encode($lista, JSON_PRETTY_PRINT);
    }

    // c- El listado de ventas por tipo de prenda.
    if(isset($_GET["tipo"]))
    {
        $tipo = $_GET["tipo"];
        $ventas = array();
        if (file_exists("./ventas.json"))
        {
            $ventas = json_decode(file_get_contents("./ventas.json"), true);
        }
        $lista = array();
        foreach ($ventas as $ventaIndividual)
        {
            if ($ventaIndividual["tipo"] == $tipo)
            {
                array_push($lista, $ventaIndividual);
            }
        }
        echo json_encode($lista, JSON_PRETTY_PRINT);
    }

    // d- El listado de prendas cuyo precio esté entre dos números ingresados.
    if(isset($_GET["precio1"]) && isset($_GET["precio2"]))
    {
        $precio1 = $_GET["precio1"];
        $precio2 = $_GET["precio2"];
        $prendas = array();
        if (file_exists("./tienda.json"))
        {
            $prendas = json_decode(file_get_contents("./tienda.json"), true);
        }
        $lista = array();
        foreach ($prendas as $prendaIndividual)
        {
            if ($prendaIndividual["precio"] >= $precio1 && $prendaIndividual["precio"] <= $precio2)
            {
                array_push($lista, $prendaIndividual);
            }
        }
        echo json_encode($lista, JSON_PRETTY_PRINT);
    }

    // e- El listado de ingresos por día de una fecha ingresada. Si no se ingresa una fecha, se muestran los ingresos de todos los días.
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

    $lista = array();

    foreach ($ventas as $ventaIndividual)
    {
        if ($ventaIndividual["fecha"] == $fecha)
        {
            array_push($lista, $ventaIndividual);
        }
    }
    echo json_encode($lista, JSON_PRETTY_PRINT);

    // f- Mostrar el producto más vendido.
    if (file_exists("./ventas.json"))
    {
        $ventas = json_decode(file_get_contents("./ventas.json"), true);
    }

    $lista = array();

    foreach ($ventas as $ventaIndividual)
    {
        array_push($lista, $ventaIndividual["tipo"]);
    }

    $lista = array_count_values($lista);
    arsort($lista);
    echo json_encode($lista, JSON_PRETTY_PRINT);


}

?>