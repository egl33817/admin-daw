<?php

require "../modelo/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    echo "Categoría: " . $_POST["categoria"] . "<br>";
    echo "Subcategoría: " . $_POST["subcategoria"] . "<br>";
    echo "Descripción: " . $_POST["descripcion"] . "<br>";
    echo "Formato: " . $_POST["formato"] . "<br>";
    echo "Precio: " . $_POST["precio"] . "<br>";
    echo "Descuento: " . $_POST["descuento"] . "<br>";
    echo "Fecha de alta: " . $_POST["fechadealta"] . "<br>";

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
                    echo "El producto ha sido dado de alta correctamente en la base de datos.";
                }
                else
                {
                    echo "Error en la consulta SQL: $consulta <br> $conexion->error";
                }
                                     
                echo "<p>Imagen subida exitosamente como: $nombre_archivo</p>";
                // Mostramos la imagen cargada.
                echo "<img src='$ruta_archivo' alt='Imagen subida' width='350'>";

                header("Location: ../index.php");
            }
            else
            {
                echo "Error al mover el archivo.";
            }
        }
        else
        {
            echo "El archivo no es una imagen válida.";
        }
    }
    else
    {
        echo "No se seleccionó ninguna imagen.";
    }
}
else
{
    echo "Acceso al script altaproducto.php no permitido.";
}