<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Productos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./estilos/general.css" class="stylesheet">
    <link rel="stylesheet" href="./estilos/index.css" class="stylesheet">
</head>
<body>
    <div class="contenedor-principal">

        <h1 class="titulo">CRUD DE PRODUCTOS EN PHP-MYSQL</h1>
        <h2 class="subtitulo">Listado de productos</h2>

        <div class="crear-producto">
            <button class="btn btn-crear-producto" onclick="crearProducto();">Crear producto</button>
        </div>
        
        <?php
            require "./modelo/conexion.php";

            $consulta = "SELECT a.idproducto, c.descripcion as categoria, b.descripcion as subcategoria, 
                                a.descripcion, a.formato, a.precio, a.descuento, a.fechadealta
                        FROM productos a, subcategorias b, categorias c
                        WHERE (a.idsubcategoria = b.idsubcategoria) AND (b.idcategoria = c.idcategoria)
                        ORDER BY a.idproducto;";

            $respuesta = $conexion->query($consulta);

        ?>

        <table class="tabla-productos">
            <thead>
                <tr>
                    <th>CATEGORÍA</th>
                    <th>SUBCATEGORÍA</th>
                    <th>DESCRIPCIÓN</th>
                    <th>FORMATO</th>
                    <th>PRECIO</th>
                    <th>DESCUENTO</th>
                    <th colspan="2">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php

                    while ($datos = $respuesta->fetch_assoc()) 
                    {
                        ?>
                        <tr>
                            <td><?= $datos["categoria"] ?></td>
                            <td><?= $datos["subcategoria"] ?></td>
                            <td><?= $datos["descripcion"] ?></td>
                            <td><?= $datos["formato"] ?></td>
                            <td><?= $datos["precio"] ?> €</td>
                            <td><?= $datos["descuento"] ?> %</td>
                            <td colspan="2" class="acciones">
                                <button class="btn btn-editar"
                                        onclick="editarProducto(<?= $datos['idproducto'] ?>);">
                                    <i class="bi bi-pencil-square"></i></i>
                                </button>
                                <button class="btn btn-eliminar" 
                                        onclick="eliminarProducto(<?= $datos['idproducto'] ?>);">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                <?php
                    
                    }

                    $conexion->close();
                ?>
            </tbody>
        </table>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./js/index.js"></script>
</body>
</html>