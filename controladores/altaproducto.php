<?php

require "../modelo/conexion.php";
require "helpers.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Directorio donde se guardarán las imágenes.
    $directorio_destino_imagen = "../imagenes/productos/";

    // Nombre del archivo.
    $nombre_archivo = "";
    
    // Comprobamos si se seleccionó un archivo de imagen para el producto.
    if (isset($_FILES["imagen"]))
    {
        // En caso afirmativo, recuperamos su nombre.
        $nombre_archivo = basename($_FILES["imagen"]["name"]);
    }
    else
    {
        // En caso contrario, dejamos la imagen por defecto.
        $nombre_archivo = "sinImagen.png";
    }
    
    $ruta_archivo = $directorio_destino_imagen . $nombre_archivo;
    $tipo_archivo = strtolower(pathinfo($ruta_archivo, PATHINFO_EXTENSION));

    // Comprobamos si el archivo es una imagen.
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["tmp_name"] != "")
    {
        $comprobar_imagen = getimagesize($_FILES["imagen"]["tmp_name"]);

        if($comprobar_imagen !== false) 
        {
            // Mover el archivo de imagen al directorio destino.
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_archivo))
            {
                // Guardamos los datos del producto en la base de datos.
                $consulta = "INSERT INTO productos (idsubcategoria, descripcion, formato, precio, descuento, fechadealta,imagen)
                             VALUES (" . $_POST["subcategoria"] . ",'" . 
                                         $_POST["descripcion"] . "','" .
                                         $_POST["formato"] . "'," .
                                         $_POST["precio"] . "," .
                                         $_POST["descuento"] . ",'" .
                                         $_POST["fechadealta"] . "','" .
                                         $nombre_archivo . "');";

                if ($conexion->query($consulta) == true)
                {
                    echo altaDeProductoCorrecta();
                }
                else
                {
                    echo errorAlCrearProducto($conexion->error);
                }
            }
            else
            {
                echo errorAlCrearProducto("Error al mover el archivo");
            }
        }
        else
        {
            echo errorAlCrearProducto("El archivo no es una imagen válida");
        }
    }
    else
    {
        echo errorAlCrearProducto("No se seleccionó ninguna imagen");
    }
}
else
{
    echo errorAlCrearProducto("Acceso al script altaproducto.php no permitido");
}