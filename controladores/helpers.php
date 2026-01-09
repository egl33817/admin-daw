<?php

    function listadoCategorias($idCategoria, $conexion)
    {
        $consulta = "SELECT idcategoria, descripcion
                     FROM categorias
                     ORDER BY idcategoria;";

        $respuesta = $conexion->query($consulta);

        while ($datos = $respuesta->fetch_assoc()) 
        {
            if ($datos["idcategoria"] == $idCategoria)
            {
                // Hay que marcar esta opción como la seleccionada.
?>
                <option value=<?php echo $datos["idcategoria"]; ?> selected>
                    <?= $datos["descripcion"]; ?>
                </option>";
<?php            
            }
            else
            {
                // Es una opción genérica.
?>
                <option value=<?= $datos["idcategoria"]; ?>>
                    <?= $datos["descripcion"]; ?>
                </option>";
<?php
            }
        }
    }

    function listadoSubcategorias($idCategoria, $idSubcategoria, $conexion)
    {
        $consulta = "SELECT idsubcategoria, descripcion
                     FROM subcategorias
                     WHERE idcategoria = $idCategoria
                     ORDER BY idsubcategoria;";

        $respuesta = $conexion->query($consulta);

        while ($datos = $respuesta->fetch_assoc()) 
        {
            if ($datos["idsubcategoria"] == $idSubcategoria)
            {
                // Hay que marcar esta opción como la seleccionada.
?>
                <option value=<?php echo $datos["idsubcategoria"]; ?> selected>
                    <?= $datos["descripcion"]; ?>
                </option>";
<?php            
            }
            else
            {
                // Es una opción genérica.
?>
                <option value=<?= $datos["idsubcategoria"]; ?>>
                    <?= $datos["descripcion"]; ?>
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
                    text: <?= $mensajeDeError ?>,
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
                    text: <?= $mensajeDeError ?>,
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