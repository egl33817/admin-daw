<?php

require "../modelo/conexion.php";

// El identificador del producto se recibe vía GET. 
// Si no recibimos identificador, se asume que está a cero.
$idproducto = $_GET["idproducto"] ?? 0;

// Primero borramos la imagen del producto.
$consulta = "SELECT imagen
             FROM productos
             WHERE idproducto = $idproducto";

$respuesta = $conexion->query($consulta);

$nombreFichero = $respuesta->fetch_row();

// Borramos el archivo de imagen del producto.
unlink("../imagenes/productos/" . $nombreFichero[0]);

// Luego borramos el producto en sí.
$consulta = "DELETE FROM productos
             WHERE idproducto = $idproducto";

$respuesta = $conexion->query($consulta);