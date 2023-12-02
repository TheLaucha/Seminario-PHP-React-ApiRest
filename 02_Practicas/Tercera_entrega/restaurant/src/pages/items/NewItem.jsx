import React, { useState } from "react"
import styles from "./NewItem.module.css"

const NewItem = () => {
  const [newItem, setNewItem] = useState({
    nombre: "",
    precio: "",
    tipo: "COMIDA",
  })

  const [imagenBase64, setImagenBase64] = useState({
    imagen: "",
    tipo_imagen: "",
  })

  const [message, setMessage] = useState()
  const [errorMsg, setErrorMsg] = useState({})

  const handleChange = (e) => {
    setNewItem({ ...newItem, [e.target.name]: e.target.value })
  }

  const handleImageChange = (e) => {
    const file = e.target.files[0]

    if (file) {
      const tipo_imagen = e.target.files[0].type.split("/")[1]
      convertirBase64(file, tipo_imagen)
    }
  }

  const convertirBase64 = (file, tipo_imagen) => {
    const reader = new FileReader()
    reader.readAsDataURL(file)
    reader.onload = () => {
      const base64String = reader.result.split(",")[1]
      const imagenFinal = { imagen: base64String, tipo_imagen: tipo_imagen }
      // Guardar la cadena base64 en el estado o donde sea necesario
      setImagenBase64(imagenFinal)
    }
    reader.onerror = (error) => {
      console.error("Error al convertir a base64:", error)
    }
  }

  const handleSubmit = (e) => {
    e.preventDefault()

    if (!validarFormulario()) return

    crearItem()
  }

  const validarFormulario = () => {
    let newErrorMsg = {}

    if (!newItem.nombre) {
      newErrorMsg = { ...newErrorMsg, nombre: "El nombre del item es obligatorio." }
    }

    if (!newItem.precio) {
      newErrorMsg = { ...newErrorMsg, precio: "Debe colocar un precio para el item." }
    }

    if (!newItem.tipo) {
      newErrorMsg = { ...newErrorMsg, tipo: "Debe seleccionar el tipo de item (Comida o Bebida)." }
    }

    if (!imagenBase64) {
      newErrorMsg = { ...newErrorMsg, imagen: "Agregar una imagen es obligatorio." }
    }

    setErrorMsg(newErrorMsg)

    if (newErrorMsg.nombre || newErrorMsg.precio || newErrorMsg.tipo || newErrorMsg.imagen) {
      console.log({ newErrorMsg })
      return false
    }
    return true
  }

  const crearItem = async () => {
    try {
      const newItemFinal = { ...newItem, ...imagenBase64 }

      const response = await fetch("http://localhost:8080/items", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(newItemFinal),
      })

      if (!response.ok) {
        console.error("Error")
      }

      const data = await response.json()
      setMessage(data[0])
      console.log(data)
      return
    } catch (error) {
      console.error("Error en la solicitud", error)
    }
  }

  const limitarLongitud = (obj) => {
    const MAX_CARACTERES_BASE64 = 50

    if (obj && obj.imagen) {
      // Limita la longitud del base64
      obj.imagen = obj.imagen.substring(0, MAX_CARACTERES_BASE64)
    }

    return obj
  }

  return (
    <div className={`${styles.NewItemPage} container`}>
      <h1 className='pageTitle'>CREAR NUEVO ITEM</h1>
      <form className={`${styles.form}`} onSubmit={handleSubmit}>
        <div className={styles.formItem}>
          <label htmlFor='nombre'>NOMBRE</label>
          <input type='text' name='nombre' value={newItem.nombre} onChange={handleChange} />
          {errorMsg.nombre && <span className={styles.errorMsg}>{errorMsg.nombre}</span>}
        </div>
        <div className={styles.formItem}>
          <label htmlFor='precio'>PRECIO</label>
          <input type='number' name='precio' value={newItem.precio} onChange={handleChange} />
          {errorMsg.precio && <span className={styles.errorMsg}>{errorMsg.precio}</span>}
        </div>
        <div className={styles.formItem}>
          <label htmlFor='tipo'>TIPO</label>
          <select name='tipo' id='tipo' value={newItem.tipo} onChange={handleChange}>
            <option value='COMIDA'>COMIDA</option>
            <option value='BEBIDA'>BEBIDA</option>
          </select>
          {errorMsg.tipo && <span className={styles.errorMsg}>{errorMsg.tipo}</span>}
        </div>
        <div className={styles.formItem}>
          <label htmlFor='imagen'>IMAGEN</label>
          <input type='file' name='imagen' onChange={handleImageChange} />
          {errorMsg.imagen && <span className={styles.errorMsg}>{errorMsg.imagen}</span>}
        </div>
        <button type='submit' className={`${styles.createBtn} btn`}>
          CREAR
        </button>
      </form>

      {message && (
        <div className={styles.messageContainer}>
          <pre>{JSON.stringify(limitarLongitud(message), null, 2)}</pre>
        </div>
      )}
    </div>
  )
}

export default NewItem
