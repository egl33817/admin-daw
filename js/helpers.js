// Elementos del DOM.
const selectCategorias = document.getElementById("categorias")
const selectSubcategorias = document.getElementById("subcategorias")

function rellenarSubcategorias(select, arrayDatos)
{
    select.innerHTML = "<option value='0'>Elige una subcategoría de producto...</option>"

    arrayDatos.forEach(subcategoria => {
        const opcion = document.createElement("option")
        opcion.value = subcategoria[0]
        opcion.innerText = subcategoria[1]
        select.appendChild(opcion)
    })

    select.disabled = false
}

selectCategorias.addEventListener("change", (evento) => {
    console.log("Categoría: " + evento.currentTarget.value)

    // Ejecutamos la consulta a la base de datos a través de PHP.
    fetch("../controlador/listasubcategorias.php?idcat=" + evento.currentTarget.value)
        .then(respuesta => respuesta.json())
        .then(datos => rellenarSubcategorias(selectSubcategorias, datos))
        .catch(error => console.log("Error: " + error))
})

selectSubcategorias.addEventListener("change", (evento) => {
    console.log("Subcategoría: " + evento.currentTarget.value)
})