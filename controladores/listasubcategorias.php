<?php 

    // Iniciamos la sesión cURL.
    $sesion_cURL = curl_init();

    // Preparamos la URL para la petición al endpoint correspondiente.
    $idCategoria = $_GET["idcategoria"];
    $urlPetición = "http://localhost:8080/subcategorias/" . $idCategoria;

    // Configuración de cURL.
    // Fijamos la URL correspondiente al endpoint de la API al cual vamos a hacer nuestra consulta.
    curl_setopt($sesion_cURL, CURLOPT_URL, $urlPetición);
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
        // Si todo ha ido bien, devolvemos la respuesta en formato JSON.
        //var_dump($respuestaAPI);
        //echo json_encode($respuestaAPI);
        $cositas = json_encode($respuestaAPI, true);
        echo $cositas;
        //header('Content-Type: application/json');
        //echo json_encode($cositas, JSON_PRETTY_PRINT);
    }