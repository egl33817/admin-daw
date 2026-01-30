<?php

require "helpers.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Comprobamos si el archivo ya existe.
    $nombreFicheroImagen = basename($_FILES["imagen"]["name"]);

    // Si el nombre del archivo viene en blanco es que no se ha cambiado la imagen.
    if ($nombreFicheroImagen == "")
    {
        $fichero = $_POST["imagenOriginal"];
    }
    else
    {
        // En caso contrario, guardamos el nombre del nuevo archivo de imagen.
        $fichero = $nombreFicheroImagen;
    }
        
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
        "imagen" => $fichero
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
        // Ahora guardamos la nueva imagen en el servidor.
        // Si todo ha ido bien, subimos el archivo de imagen.
        //
        // Colocamos el archivo de imagen en una ubicación temporal.
        $dirTemporal = "../imagenes/productos/";
        $rutaTemporal = $dirTemporal . $nombreFicheroImagen;

        if ($nombreFicheroImagen != "")
        {
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaTemporal))
            {
                // Creamos el objeto JSON que almacenará los datos del fichero de imagen.
                $datosFichero = [
                    "nombreDelFichero" => basename($nombreFicheroImagen),
                    "datosDelFichero" => base64_encode(file_get_contents($rutaTemporal))
                ];

                $datosURL = http_build_query($datosFichero);

                // Reiniciamos la sesión cURL.
                $sesion_cURL = curl_init();
                
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
                echo actualizacionCorrecta();
            }
            else
            {
                echo "Error al mover el archivo de imagen a su ubicación temporal";
            }
        }
        else
        {
            echo actualizacionCorrecta();
        }
    }
}
else
{
    echo errorAlActualizar("Acceso al script actualizaproducto.php no permitido");
}