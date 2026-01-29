<?php

require "helpers.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Nombre del archivo de imagen del producto.
    $nombreFicheroImagen = "";
    
    // Comprobamos si se seleccionó un archivo de imagen para el producto.
    if (isset($_FILES["imagen"]))
    {
        // En caso afirmativo, recuperamos su nombre.
        $nombreFicheroImagen = basename($_FILES["imagen"]["name"]);
    }
    else
    {
        // En caso contrario, dejamos la imagen por defecto.
        $nombreFicheroImagen = "sinimagen.png";
    }

    // Guardamos los datos del producto en la base de datos a través de la API REST.
    // Iniciamos la sesión cURL.
    $sesion_cURL = curl_init();

    // Creamos el objeto JSON que almacenará los datos del producto.
    $datosProducto = [
        "idSubcategoria" => $_POST["subcategoria"],
        "descripcion" => $_POST["descripcion"],
        "formato" => $_POST["formato"],
        "precio" => $_POST["precio"],
        "descuento" => $_POST["descuento"],
        "fechadealta" => $_POST["fechadealta"],
        "imagen" => $nombreFicheroImagen
    ];

    $datosBody = json_encode($datosProducto);

    // Configuración de cURL.
    // Fijamos la URL correspondiente al endpoint de la API al cual vamos a hacer nuestra consulta.
    curl_setopt($sesion_cURL, CURLOPT_URL, "http://localhost:8080/productos");
    // Especificamos que se trata de una petición POST.
    curl_setopt($sesion_cURL, CURLOPT_POST, true);
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
        echo errorAlCrearProducto($conexion->error);
    }
    else
    {
        // Si todo ha ido bien, subimos el archivo de imagen.
        //
        // Colocamos el archivo de imagen en una ubicación temporal.
        $dirTemporal = "../temporal/";
        $rutaTemporal = $dirTemporal . $nombreFicheroImagen;

        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaTemporal))
        {
            // Creamos el objeto JSON que almacenará los datos del fichero de imagen.
            $datosFichero = [
                "nombreDelFichero" => basename($nombreFicheroImagen),
                "datosDelFichero" => base64_encode(file_get_contents($rutaTemporal))
            ];

            $datosURL = http_build_query($datosFichero);
            
            // Ejecutamos la carga del fichero en el servidor a través de la API con un archivo creado al efecto.
            curl_setopt($sesion_cURL, CURLOPT_URL, "http://localhost:8080/cargarimagen.php");
            // Sin cabeceras.
            curl_setopt($sesion_cURL, CURLOPT_HEADER, false);
            // Especificamos que se trata de una petición POST.
            curl_setopt($sesion_cURL, CURLOPT_POST, true);
            // En vez de mostrar por pantalla la respuesta de la API la convertimos en una cadena "interna".
            curl_setopt($sesion_cURL, CURLOPT_RETURNTRANSFER, true);
            // Metemos los datos del producto en el body de la petición.
            curl_setopt($sesion_cURL, CURLOPT_POSTFIELDS, $datosURL);

            $respuestaAPI = curl_exec($sesion_cURL);

            unlink($rutaTemporal);

            echo altaDeProductoCorrecta();
        }
        else
        {
            echo "Error al trabajar con el archivo en admin";
        }
    }
}
else
{
    echo errorAlCrearProducto("Acceso al script altaproducto.php no permitido");
}