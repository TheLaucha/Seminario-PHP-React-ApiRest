function validarFormulario() {
  let itemMenu = document.querySelector("#item_select")
  let mesa = document.querySelector("#mesa_select")

  let itemMenuValido = itemMenu.value !== ""
  let itemMesaValido = mesa.value !== ""

  console.log(itemMenu.value)
  console.log(mesa.value)

  if (!itemMenuValido) {
    itemMenu.classList.add("campoInvalido")
  } else {
    itemMenu.classList.remove("campoInvalido")
  }

  if (!itemMesaValido) {
    mesa.classList.add("campoInvalido")
  } else {
    mesa.classList.add("campoInvalido")
  }

  if (!itemMenuValido || !itemMesaValido) {
    return false // Detiene el envio del formulario
  }

  return true
}
