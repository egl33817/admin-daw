<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conexion = mysqli_connect(
    "localhost",
    "root",
    "CNPpolicia10387033.",
    "supermercado"
);

if ($conexion == false)
{
    die("Error al conectar con la base de datos: ". mysqli_connect_error());
}

$conexion->set_charset("utf8");

date_default_timezone_set("Europe/Madrid");