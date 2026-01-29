<?php

require "helpers.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Nombre del archivo de imagen del producto.
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
        $nombre_archivo = "sinimagen.png";
    }

    // Guardamos los datos del producto en la base de datos a través de la API REST.
    // Iniciamos la sesión cURL.
    $sesion_cURL = curl_init();

    // Creamos el objeto JSON que almacenará los datos del producto.
    $datosProducto = array(
        "idSubcategoria" => $_POST["subcategoria"],
        "descripcion" => $_POST["descripcion"],
        "formato" => $_POST["formato"],
        "precio" => $_POST["precio"],
        "descuento" => $_POST["descuento"],
        "fechadealta" => $_POST["fechadealta"],
        "imagen" => $nombre_archivo
    );

    $datosBody = json_encode($datosProducto);

    // Configuración de cURL.
    // Fijamos la URL correspondiente al endpoint de la API al cual vamos a hacer nuestra consulta.
    curl_setopt($sesion_cURL, CURLOPT_URL, "http://localhost:8080/productos");
    // Especificamos que se trata de una petición POST.
    curl_setopt($sesion_cURL, CURLOPT_CUSTOMREQUEST, "POST");
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
        // Si todo ha ido bien, mostramos el mensaje adecuado.
        echo altaDeProductoCorrecta();
    }
}
else
{
    echo errorAlCrearProducto("Acceso al script altaproducto.php no permitido");
}