<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Productos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../estilos/general.css" class="stylesheet">
    <link rel="stylesheet" href="../estilos/formularios.css" class="stylesheet">
    <link rel="stylesheet" href="../estilos/editarproducto.css" class="stylesheet">
</head>
<body>
    <div class="contenedor-principal">

        <h1 class="titulo">CRUD DE PRODUCTOS EN PHP-MYSQL</h1>
        <h2 class="subtitulo">Editar un producto</h2>

        <?php

            // En primer lugar, recuperamos los datos del producto.
            require "../controladores/helpers.php";

            // El identificador del producto se recibe vía GET. 
            // Si no recibimos identificador, se asume que está a cero.
            $idProducto = $_GET["idproducto"] ?? 0;

            // Iniciamos la sesión cURL.
            $sesion_cURL = curl_init();

            // Configuración de cURL.
            // Fijamos la URL correspondiente al endpoint de la API al cual vamos a hacer nuestra consulta.
            curl_setopt($sesion_cURL, CURLOPT_URL, "http://localhost:8080/productos/" . $idProducto);
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
                $datosProducto = json_decode($respuestaAPI, true);
            }
        ?>

        <form class="form-editar-producto" action="../controladores/actualizaproducto.php" method="post" enctype="multipart/form-data">
            <div class="form-editar-campos">
                <div class="form-editar-producto-campos-izda">
                    <!-- ID del producto -->
                    <input type="hidden" name="idproducto" value="<?= $idProducto ?>">
                    <!-- Categoría -->    
                    <select name="categoria" id="categorias" class="form-select" required>
                        <?php
                            listadoCategorias($datosProducto["idcategoria"]);
                        ?>   
                    </select>
                    <!-- Subcategoría (su contenido depende de la categoría) -->
                    <select name="subcategoria" id="subcategorias" class="form-select" required>
                        <?php
                            listadoSubcategorias($datosProducto["idcategoria"], 
                                                $datosProducto["idsubcategoria"]);
                        ?> 
                    </select>
                    <!-- Descripción -->
                    <input type="text" name="descripcion" placeholder="Descripción del producto (máx. 35 caracteres)" 
                        maxlength="35" value="<?= $datosProducto["descripcion"]; ?>" required>
                    <!-- Formato -->
                    <input type="text" name="formato" placeholder="Formato (máx. 20 caracteres)" maxlength="20" 
                        value="<?= $datosProducto["formato"]; ?>" required>
                    <!-- Precio -->
                    <input type="text" name="precio" placeholder="Precio (ejemplo 2.55)" maxlength="5" 
                        value="<?= $datosProducto["precio"]; ?>" required>
                    <!-- Descuento -->
                    <input type="text" name="descuento" placeholder="Descuento (%)" maxlength="2" 
                            value="<?= $datosProducto["descuento"]; ?>" required>
                    <!-- Nombre archivo de imagen original -->
                    <input type="hidden" name="imagenOriginal" value="<?= $datosProducto["imagen"] ?>">
                </div>
                <div class="form-editar-producto-campos-dcha">
                    <!-- Imagen actual del producto (aceptamos todo tipo de formatos de archivo de imagen) -->
                    <?php $ruta_archivo = "../imagenes/productos/" . $datosProducto["imagen"]; ?>
                    <img id="imagencargada" src=<?= $ruta_archivo ?> alt='Imagen subida' width='350'>
                    <label for="imagen" class="custom-file-upload">Haz clic aquí para cambiar la imagen...</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" 
                           onchange="document.getElementById('imagencargada').src = window.URL.createObjectURL(this.files[0])">
                </div>
            </div>
            <!-- Botones de acción -->
            <div class="form-botones">
                <button type="submit" class="btn btn-form-submit">Actualizar producto</button>
                <button type="reset" class="btn btn-form-reset" onclick="location.href = '../index.php'">Cancelar</button>
            </div>
        </form>
    </div>

    <script src="../js/helpers.js"></script>
</body>
</html>