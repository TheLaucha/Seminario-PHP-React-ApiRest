import React, { useEffect, useState } from "react"
import styles from "./EditItem.module.css"
import { useLocation } from "react-router-dom"

const EditItem = () => {
  const location = useLocation()
  const { item } = location.state
  const [itemToEdit, setItemToEdit] = useState({
    id: item.id,
    nombre: item.nombre,
    precio: item.precio,
    tipo: item.tipo,
  })

  const [newImage, setNewImage] = useState({
    imagen: "",
    tipo_imagen: "",
  })
  const [currentImage, setCurrentImage] = useState({
    imagen: item.imagen,
    tipo_imagen: item.tipo_imagen,
  })
  const [message, setMessage] = useState()
  const [errorMsg, setErrorMsg] = useState({})

  const handleSubmit = (e) => {
    e.preventDefault()

    setMessage(undefined)

    if (!validarFormulario()) return

    console.log({ itemToEdit })

    editarItem()
  }

  const handleChange = (e) => {
    setItemToEdit({ ...itemToEdit, [e.target.name]: e.target.value })
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
      setNewImage(imagenFinal)
    }
    reader.onerror = (error) => {
      console.error("Error al convertir a base64:", error)
    }
  }

  const validarFormulario = () => {
    let newErrorMsg = {}

    if (!itemToEdit.nombre) {
      newErrorMsg = { ...newErrorMsg, nombre: "El nombre del item no puede estar vacio." }
    }

    if (!itemToEdit.precio) {
      newErrorMsg = { ...newErrorMsg, precio: "El precio no puede estar vacio." }
    }

    if (!itemToEdit.tipo) {
      newErrorMsg = { ...newErrorMsg, tipo: "Debe seleccionar el tipo de item (Comida o Bebida)." }
    }

    setErrorMsg(newErrorMsg)

    if (newErrorMsg.nombre || newErrorMsg.precio || newErrorMsg.tipo) {
      console.log({ newErrorMsg })
      return false
    }
    return true
  }

  const editarItem = async () => {
    try {
      const imagenFinal = !newImage.imagen ? currentImage : newImage
      const newItemFinal = { ...itemToEdit, ...imagenFinal }
      const response = await fetch(`http://localhost:8080/items/${itemToEdit.id}`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(newItemFinal),
      })

      if (!response.ok) {
        console.error(`Error: ${response.statusText}`)
      }

      const data = await response.text()
      setMessage({
        data,
      })
      return
    } catch (error) {
      console.error("Error en la solicitud", error.message)
    }
  }

  return (
    <div className={`${styles.EditItemPage} container`}>
      <h1 className='pageTitle'>EDITAR ITEM</h1>
      <form className={`${styles.form}`} onSubmit={handleSubmit}>
        <div className={styles.formItem}>
          <label htmlFor='nombre'>NOMBRE</label>
          <input type='text' name='nombre' value={itemToEdit.nombre} onChange={handleChange} />
          {errorMsg.nombre && <span className={styles.errorMsg}>{errorMsg.nombre}</span>}
        </div>
        <div className={styles.formItem}>
          <label htmlFor='precio'>PRECIO</label>
          <input type='number' name='precio' value={itemToEdit.precio} onChange={handleChange} />
          {errorMsg.precio && <span className={styles.errorMsg}>{errorMsg.precio}</span>}
        </div>
        <div className={styles.formItem}>
          <label htmlFor='tipo'>TIPO</label>
          <select name='tipo' id='tipo' value={itemToEdit.tipo} onChange={handleChange}>
            <option value='COMIDA'>COMIDA</option>
            <option value='BEBIDA'>BEBIDA</option>
          </select>
          {errorMsg.tipo && <span className={styles.errorMsg}>{errorMsg.tipo}</span>}
        </div>
        <div className={styles.formItem}>
          <label htmlFor='imagen'>IMAGEN</label>
          <input type='file' name='imagen' onChange={handleImageChange} />
        </div>
        <button type='submit' className={`${styles.createBtn} btn`}>
          EDITAR
        </button>
      </form>
      {message && (
        <div className={styles.messageContainer}>
          <code>
            {JSON.stringify(message)}
            {/* {`{`} <br />
            &ensp; nombre: {message.itemToEdit.} <br />
            &ensp; precio: {message.precio} <br />
            &ensp; tipo: {message.tipo} <br />
            &ensp; imagen: {message.imagen.substring(0, 20)} <br />
            &ensp; tipo_imagen: {message.tipo_imagen} <br />
            {`}`} */}
          </code>
        </div>
      )}
    </div>
  )
}

export default EditItem
