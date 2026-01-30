<?php

require "helpers.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Comprobamos si el archivo ya existe.
    $nombreFicheroImagen = basename($_FILES["imagen"]["name"]);

    // Actualizamos todo salvo el archivo de imagen usando nuestra API REST.
    // Iniciamos la sesión cURL.
    $sesion_cURL = curl_init();

    // Creamos el objeto JSON que almacenará los datos del producto.
    $datosProducto = [
        "idProducto" => $_POST["idproducto"],
        "idSubcategoria" => $_POST["subcategoria"],
        "descripcion" => $_POST["descripcion"],
        "formato" => $_POST["formato"],
        "precio" => $_POST["precio"],
        "descuento" => $_POST["descuento"],
        "imagen" => $_POST["imagenOriginal"]
    ];

    $datosBody = json_encode($datosProducto);

    // Configuración de cURL.
    // Fijamos la URL correspondiente al endpoint de la API al cual vamos a hacer nuestra consulta.
    curl_setopt($sesion_cURL, CURLOPT_URL, "http://localhost:8080/productos");
    // Especificamos que se trata de una petición POST.
    curl_setopt($sesion_cURL, CURLOPT_CUSTOMREQUEST, "PUT");
    // Metemos los datos del producto en el body de la petición.
    curl_setopt($sesion_cURL, CURLOPT_POSTFIELDS, $datosBody);
    // En vez de mostrar por pantalla la respuesta de la API la convertimos en una cadena "interna".
    curl_setopt($sesion_cURL, CURLOPT_RETURNTRANSFER, true);
    
    // Ejecutamos la consulta al endpoint de la API.
    $respuestaAPI = curl_exec($sesion_cURL);

    // Comprobamos si ha habido algún error.
    if (curl_errno($sesion_cURL))
    {
        // Si ha habido un error, lo mostramos por pantalla.
        echo curl_error($sesion_cURL);
    }
    else
    {
        echo actualizacionCorrecta();
    }

    // Ahora comprobamos si se ha cambiado el archivo de imagen del producto.
    // En caso afirmativo, actualizamos su imagen en el servidor.
    /*
    if ($nombreFicheroImagen == "")
    {
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
            echo errorAlActualizar($conexion->error);
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
                    echo errorAlActualizar("Error al guardar el archivo de imagen");
                }
            }
            else
            {
                echo errorAlActualizar("El archivo no es una imagen válida");
            }
        }
        else
        {
            echo errorAlActualizar("Error al mover el archivo");
        }

        //die("Archivo: {$nombre_archivo} - Hay cambio de imagen - Consulta: {$consulta}");
    }*/
}
else
{
    echo errorAlActualizar("Acceso no permitido al script");
}