<?php 

    require "../modelo/conexion.php";

    // El identificador de la categoría se recibirá vía GET. 
    // Si no recibimos identificador, se asume que está a cero.
    $idcat = $_GET["idcat"] ?? 0;

    $consulta = "SELECT idsubcategoria, descripcion
                 FROM subcategorias
                 WHERE idcategoria = $idcat
                 ORDER BY descripcion";

    $respuesta = $conexion->query($consulta);

    $datos = $respuesta->fetch_all();

    echo json_encode($datos);