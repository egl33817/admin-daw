<?php

    function listadoCategorias($idCategoria)
    {
        // Iniciamos la sesión cURL.
        $sesion_cURL = curl_init();

        // Configuración de cURL.
        // Fijamos la URL correspondiente al endpoint de la API al cual vamos a hacer nuestra consulta.
        curl_setopt($sesion_cURL, CURLOPT_URL, "http://localhost:8080/categorias");
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
            // Si todo ha ido bien, convertimos la respuesta JSON en un array asociativo.
            $listaCategorías = json_decode($respuestaAPI, true);
        }

        foreach ($listaCategorías as $categoría)
        {
            if ($categoría["idcategoria"] == $idCategoria)
            {
                // Marcamos esta opción como la seleccionada.
?>
                <option value=<?php echo $categoría["idcategoria"]; ?> selected>
                    <?= $categoría["descripcion"]; ?>
                </option>";
<?php
            }
            else
            {
                // Se trata de una opción no seleccionada.
?>
                <option value=<?= $categoría["idcategoria"]; ?>>
                    <?= $categoría["descripcion"]; ?>
                </option>";
<?php
            }
        }
    }

    function listadoSubcategorias($idCategoria, $idSubcategoria)
    {
        // Iniciamos la sesión cURL.
        $sesion_cURL = curl_init();

        // Configuración de cURL.
        // Fijamos la URL correspondiente al endpoint de la API al cual vamos a hacer nuestra consulta.
        curl_setopt($sesion_cURL, CURLOPT_URL, "http://localhost:8080/subcategorias/" . $idCategoria);
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
            // Si todo ha ido bien, convertimos la respuesta JSON en un array asociativo.
            $listaSubcategorías = json_decode($respuestaAPI, true);
        }

        foreach ($listaSubcategorías as $subcategoría)
        {
            if ($subcategoría["idsubcategoria"] == $idSubcategoria)
            {
                // Hay que marcar esta opción como la seleccionada.
?>
                <option value=<?php echo $subcategoría["idsubcategoria"]; ?> selected>
                    <?= $subcategoría["descripcion"]; ?>
                </option>";
<?php 
            }
            else
            {
                // Es una opción genérica.
?>
                <option value=<?= $subcategoría["idsubcategoria"]; ?>>
                    <?= $subcategoría["descripcion"]; ?>
                </option>";
<?php
            }
        }
    }

    function hayCambioDeImagen($nombre_archivo, $idproducto, $conexion)
    {
        $consulta = "SELECT imagen FROM productos WHERE idproducto={$idproducto}";

        $respuesta = $conexion->query($consulta);

        $datos = $respuesta->fetch_assoc();

        //die("Archivo de la base de datos: {$datos["imagen"]} - Archivo del formulario: '{$nombre_archivo}'");

        die(strcmp($datos["imagen"], $nombre_archivo) == 0); //? false : true);
    }

    function altaDeProductoCorrecta()
    {
?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>CRUD Productos</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
            <link rel="stylesheet" href="../estilos/general.css" class="stylesheet">
            <link rel="stylesheet" href="../estilos/index.css" class="stylesheet">
        </head>
        <body>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Alta correcta",
                    text: "El producto ha sido creado correctamente",
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: "Volver al listado",
                    confirmButtonColor: "#3085d6"
                }).then((result) => {
                    location.href = "../index.php"
                });
            </script>
        </body>
        </html>
        
<?php
    }

    function errorAlCrearProducto($mensajeDeError)
    {
?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>CRUD Productos</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
            <link rel="stylesheet" href="../estilos/general.css" class="stylesheet">
            <link rel="stylesheet" href="../estilos/index.css" class="stylesheet">
        </head>
        <body>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Error al dar de alta",
                    text: "<?= $mensajeDeError ?>",
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: "Volver al listado",
                    confirmButtonColor: "#3085d6"
                }).then((result) => {
                    location.href = "../index.php"
                });
            </script>
        </body>
        </html>
        
<?php     
    }

    function actualizacionCorrecta()
    {
?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>CRUD Productos</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
            <link rel="stylesheet" href="../estilos/general.css" class="stylesheet">
            <link rel="stylesheet" href="../estilos/index.css" class="stylesheet">
        </head>
        <body>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Actualización correcta",
                    text: "El producto ha sido actualizado",
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: "Volver al listado",
                    confirmButtonColor: "#3085d6"
                }).then((result) => {
                    location.href = "../index.php"
                });
            </script>
        </body>
        </html>
        
<?php
    }

    function errorAlActualizar($mensajeDeError)
    {
?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>CRUD Productos</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
            <link rel="stylesheet" href="../estilos/general.css" class="stylesheet">
            <link rel="stylesheet" href="../estilos/index.css" class="stylesheet">
        </head>
        <body>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: "warning",
                    title: "Error al actualizar",
                    text: "<?= $mensajeDeError ?>",
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: "Volver al listado",
                    confirmButtonColor: "#3085d6"
                }).then((result) => {
                    location.href = "../index.php"
                });
            </script>
        </body>
        </html>
        
<?php      
    }