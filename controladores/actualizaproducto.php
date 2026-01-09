<?php

require "../modelo/conexion.php";
require "helpers.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Comprobamos si el archivo ya existe.
    $nombre_archivo = basename($_FILES["imagen"]["name"]);

    if ($nombre_archivo == "")
    {
        // Actualizamos todo salvo el archivo de imagen.
        $consulta = "UPDATE productos 
                     SET idsubcategoria=" . $_POST["subcategoria"] . 
                         ", descripcion='" . $_POST["descripcion"] .
                         "', formato='" . $_POST["formato"] .
                         "', precio=" . $_POST["precio"] .
                         ", descuento=" . $_POST["descuento"] .
                    " WHERE idproducto=" . $_POST["idproducto"];
        
        // Hacemos la actualización de los datos.
        if ($conexion->query($consulta) == true)
        {
            echo actualizacionCorrecta();
        }
        else
        {
            echo errorAlActualizar($consulta, $conexion->error);
        }

        //die("Archivo: {$nombre_archivo} - No hay cambio de imagen - Consulta: {$consulta}");
    }
    else
    {
        // Actualizamos todo incluido el archivo de imagen.
        $consulta = "UPDATE productos 
                     SET idsubcategoria=" . $_POST["subcategoria"] . 
                         ", descripcion='" . $_POST["descripcion"] .
                         "', formato='" . $_POST["formato"] .
                         "', precio=" . $_POST["precio"] .
                         ", descuento=" . $_POST["descuento"] .
                         ", imagen='" . $nombre_archivo . "' " .
                    "WHERE idproducto=" . $_POST["idproducto"];
        
        // Hacemos la actualización de los datos.
        if ($conexion->query($consulta) == true)
        {
            echo actualizacionCorrecta();
        }
        else
        {
            echo errorAlActualizar($consulta, $conexion->error);
        }
        
        // Directorio donde se guardarán las imágenes.
        $directorio_destino_imagen = "../imagenes/productos/";

        // Nombre del archivo.
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
                    //echo "<p>Imagen subida exitosamente como: $nombre_archivo</p>";
                    // Mostramos la imagen cargada.
                    //echo "<img src='$ruta_archivo' alt='Imagen subida' width='350'>";
                }
                else
                {
                    echo "Error al guardar el archivo de imagen en la carpeta correspondiente.";
                }
            }
            else
            {
                echo "El archivo no es una imagen válida.";
            }
        }
        else
        {
            echo "Error al mover el archivo.";
        }

        //die("Archivo: {$nombre_archivo} - Hay cambio de imagen - Consulta: {$consulta}");
    }
}
else
{
    echo "Acceso al script actualizaproducto.php no permitido.";
}