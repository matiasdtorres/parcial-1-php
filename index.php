<?php

/*
A- (1 pt.)
index.php
Recibe todas las peticiones que realiza el postman, y administra a qué archivo se debe incluir.

*/

if(isset($_GET["get"]) || isset($_POST["post"]))
{
    switch ($_SERVER["REQUEST_METHOD"])
    {
        case "GET":
            switch ($_GET["get"])
            {
                case "consultaventas":
                    require_once "./ConsultasVentas.php";
                    break;
                default:
                    echo "parametro no permitido";
                    break;
            }
            break;
        case "POST":
            switch ($_POST["post"])
            {
                case "tiendaalta":
                    require_once "./tiendaAlta.php";
                    break;
                case "prendaconsultar":
                    require_once "./prendaConsultar.php";
                    break;
                default:
                    echo "tipo no permitido";
                    break;
            }
            break;
            default:
                echo "metodo no permitido";
                break;
        case "PUT":
            require_once "ModificarVenta.php";
            break;
        }
        
}
else
{
    echo "parametro no permitido";
}

?>