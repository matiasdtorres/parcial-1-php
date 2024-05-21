<?php

/*
A- (1 pt.)
index.php
Recibe todas las peticiones que realiza el postman, y administra a qué archivo se debe incluir.

## PARTE POR PARTE ##
https://github.com/matiasdtorres/parcial-1-php
*/

if (isset($_GET["get"]) || isset($_POST["post"]) || $_SERVER["REQUEST_METHOD"] === "DELETE" || $_SERVER["REQUEST_METHOD"] === "PUT")
{
    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            switch ($_GET["get"]) {
                case "consultaventas":
                    require_once "./consultasVentas.php";
                    break;
                default:
                    echo "parametro no permitido";
                    break;
            }
            break;
        case "POST":
            switch ($_POST["post"]) {
                case "tiendaalta":
                    require_once "./tiendaAlta.php";
                    break;
                case "prendaconsultar":
                    require_once "./prendaConsultar.php";
                    break;
                case "altaventa":
                    require_once "./altaVenta.php";
                    break;
                default:
                    echo "tipo no permitido";
                    break;
            }
            break;
        case "DELETE":
            parse_str(file_get_contents("php://input"), $_DELETE);
            switch ($_DELETE["delete"]) {
                case "borrarventa":
                    require_once "./borrarVenta.php";
                    break;
                default:
                    echo "parametro no permitido";
                    break;
            }
            break;
        case "PUT":
            parse_str(file_get_contents("php://input"), $_PUT);
            switch ($_PUT["put"])
            {
                case "modificarventa":
                    require_once "./modificarVenta.php";
                    break;
                default:
                    echo "parametro no permitido";
                    break;
            }
            break;
        default:
            echo "metodo no permitido";
            break;
    }
}
else
{
    echo "parametro no permitido";
}


/*
1 - dar de alta una prenda con los datos
nombre: "JeanAzul", precio: 300, tipo: "pantalon", talla: "S", color: "negro", stock: 2
2 - Dar de alta una venta en el producto que acabamos de crear
4 - Hacer consultas de listados
5 - Modificar la venta del punto 2
6 - Dar de alta un conjunto que incluya el pantalón del punto 1
*/
?>