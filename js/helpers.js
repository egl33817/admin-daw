// Elementos del DOM.
const selectCategorias = document.getElementById("categorias")
const selectSubcategorias = document.getElementById("subcategorias")

function rellenarSubcategorias(select, arrayDatos)
{
    console.log(arrayDatos)

    select.innerHTML = "<option value='0'>Elige una subcategoría de producto...</option>"

    arrayDatos.forEach(subcategoria => {
        const opcion = document.createElement("option")
        opcion.value = subcategoria["idsubcategoria"]
        opcion.innerText = subcategoria["descripcion"]
        select.appendChild(opcion)
    })

    select.disabled = false
}

selectCategorias.addEventListener("change", (evento) => {
    console.log("Categoría: " + evento.currentTarget.value)
    
    fetch("http://localhost:8080/subcategorias/" + evento.currentTarget.value)
        .then(respuesta => respuesta.json())
        .then(datos => rellenarSubcategorias(selectSubcategorias, datos))
        .catch(error => console.log("Error: " + error))
})

selectSubcategorias.addEventListener("change", (evento) => {
    console.log("Subcategoría: " + evento.currentTarget.value)
})