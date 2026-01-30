function crearProducto()
{
    location.href = './vistas/crearproducto.php'
}

function eliminarProducto(idProducto)
{
    // Solicitamos confirmación del borrado antes de proceder.
    Swal.fire({
        title: "¿Estás seguro?",
        text: "No se podrá recuperar el producto",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#de0808",
        confirmButtonText: "Sí, borrar producto",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) 
        {
            // Borrarmos el producto de la base de datos.
            fetch("http://localhost:8080/productos/" + idProducto, {
                method: "DELETE"
            })
                .catch(error => {
                        Swal.fire({
                            title: "Error",
                            text: error,
                            icon: "error"
                        });
            })
                    
            // Mostramos mensaje confirmando el borrado.
            Swal.fire({
                title: "¡Eliminado!",
                text: "El producto seleccionado ha sido eliminado",
                icon: "success"
            });

            // Recargamos la página.
            location.reload()
        }
    });
}

function editarProducto(idProducto)
{
    location.href = "./vistas/editarproducto.php?idproducto=" + idProducto
}