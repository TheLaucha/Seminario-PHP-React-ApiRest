const form = document.querySelector("#formPedido")

form.addEventListener("submit", validarFormulario)

function validarFormulario(e) {
  let itemMenu = document.querySelector("#item_select")
  let mesa = document.querySelector("#mesa_select")
  let itemMenuError = document.querySelector("#item_menu_error")
  let nroMesaError = document.querySelector("#nromesa_error")

  let errores = false

  if (itemMenu.value == "") {
    itemMenu.classList.add("campoInvalido")
    itemMenuError.textContent = "El campo item del menu no puede estar vacio"
    errores = true
  } else {
    itemMenu.classList.remove("campoInvalido")
    itemMenuError.textContent = ""
  }

  if (mesa.value == "") {
    mesa.classList.add("campoInvalido")
    nroMesaError.textContent = "El campo nro de mesa no puede estar vacio"
    errores = true
  } else {
    mesa.classList.remove("campoInvalido")
    nroMesaError.textContent = ""
  }

  if (errores) {
    e.preventDefault()
  }
}
