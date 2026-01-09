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