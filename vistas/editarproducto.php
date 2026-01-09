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

            // Recuperamos los datos del producto.
            require "../modelo/conexion.php";
            require "../controladores/helpers.php";

            // El identificador del producto se recibe vía GET. 
            // Si no recibimos identificador, se asume que está a cero.
            $idproducto = $_GET["idproducto"] ?? 0;
            
            $consulta = "SELECT b.idcategoria as categoria, a.idsubcategoria as subcategoria, 
                                a.descripcion, a.formato, a.precio, a.descuento, a.imagen
                         FROM productos a, categorias b, subcategorias c
                         WHERE (a.idsubcategoria = c.idsubcategoria) AND 
                                (b.idcategoria = c.idcategoria) AND 
                                (a.idproducto = $idproducto);";

            $respuesta = $conexion->query($consulta);

            if ($respuesta->num_rows == 1)
            {
                $datos = $respuesta->fetch_assoc();
            }
            else
            {
                die("Error al recuperar datos del producto de la base de datos.");
            }
        ?>

        <form class="form-editar-producto" action="actualizarproducto.php" method="post" enctype="multipart/form-data">
            <div class="form-editar-campos">
                <div class="form-editar-producto-campos-izda">
                    <!-- ID del producto -->
                    <input type="hidden" name="idproducto" value="<?= $idproducto ?>">
                    <!-- Categoría -->    
                    <select name="categoria" id="categorias" class="form-select" required>
                        <?php
                            listadoCategorias($datos["categoria"], $conexion);
                        ?>   
                    </select>
                    <!-- Subcategoría (su contenido depende de la categoría) -->
                    <select name="subcategoria" id="subcategorias" class="form-select" required>
                        <?php
                            listadoSubcategorias($datos["categoria"], 
                                                $datos["subcategoria"], 
                                                $conexion);
                        ?> 
                    </select>
                    <!-- Descripción -->
                    <input type="text" name="descripcion" placeholder="Descripción del producto (máx. 35 caracteres)" 
                        maxlength="35" value="<?= $datos["descripcion"]; ?>" required>
                    <!-- Formato -->
                    <input type="text" name="formato" placeholder="Formato (máx. 20 caracteres)" maxlength="20" 
                        value="<?= $datos["formato"]; ?>" required>
                    <!-- Precio -->
                    <input type="text" name="precio" placeholder="Precio (ejemplo 2.55)" maxlength="5" 
                        value="<?= $datos["precio"]; ?>" required>
                    <!-- Descuento -->
                    <input type="text" name="descuento" placeholder="Descuento (%)" maxlength="2" 
                            value="<?= $datos["descuento"]; ?>" required>
                </div>
                <div class="form-editar-producto-campos-dcha">
                    <!-- Imagen actual del producto (aceptamos todo tipo de formatos de archivo de imagen) -->
                    <?php $ruta_archivo = "../imagenes/productos/" . $datos["imagen"]; ?>
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