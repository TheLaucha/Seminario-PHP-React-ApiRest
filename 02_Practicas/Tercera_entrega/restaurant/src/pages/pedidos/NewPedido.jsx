import React from "react"
import styles from "./NewPedido.module.css"
import { useState } from "react"
import { useEffect } from "react"

const NewPedido = () => {
  const [newPedido, setNewPedido] = useState({
    idItemMenu: null,
    nromesa: null,
    comentarios: "",
  })
  const [message, setMessage] = useState("")
  const [errorMsg, setErrorMsg] = useState({})
  const [items, setItems] = useState([])

  // Al iniciar la pagina se traen todos los items.
  useEffect(() => {
    try {
      fetch("http://localhost:8080/items")
        .then((response) => response.json())
        .then((data) => setItems(data))
    } catch (error) {
      console.log(error)
    }
  }, [])

  const handleSubmit = (e) => {
    e.preventDefault()

    if (!validarFormulario()) return

    crearPedido()
  }

  const validarFormulario = () => {
    let newErrorMsg = {}

    if (!newPedido.idItemMenu) {
      newErrorMsg = { ...newErrorMsg, idItemMenu: "Debe seleccionar un item del menu." }
    }

    if (!newPedido.nromesa) {
      newErrorMsg = { ...newErrorMsg, nromesa: "Debe seleccionar una mesa donde llevar el pedido." }
    }

    setErrorMsg(newErrorMsg)

    if (newErrorMsg.idItemMenu || newErrorMsg.nromesa) {
      return false
    }
    return true
  }

  const crearPedido = async () => {
    try {
      const response = await fetch("http://localhost:8080/pedidos", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(newPedido),
      })

      if (!response.ok) {
        console.error("Error")
      }

      const data = await response.json()
      setMessage(data)
      return
    } catch (error) {
      console.error("Error en la solicitud", error)
    }
  }

  const handleChange = (e) => {
    setNewPedido({ ...newPedido, [e.target.name]: e.target.value })
  }

  return (
    <div className={`${styles.NewPedidoPage} container`}>
      <h1 className='pageTitle'>CREAR NUEVO PEDIDO</h1>
      <form className={`${styles.form}`} onSubmit={handleSubmit}>
        <div className={styles.formItem}>
          <label htmlFor='idItemMenu'>ITEM DEL MENU</label>
          <select name='idItemMenu' id='idItemMenu' onChange={handleChange}>
            <option value=''>---</option>
            {items &&
              items.map((el) => {
                return (
                  <option value={el.id} key={el.id}>
                    {el.nombre}
                  </option>
                )
              })}
          </select>
          {errorMsg.idItemMenu && <span className={styles.errorMsg}>{errorMsg.idItemMenu}</span>}
        </div>
        <div className={styles.formItem}>
          <label htmlFor='nromesa'>MESA</label>
          <select name='nromesa' id='nromesa' onChange={handleChange}>
            <option value=''>---</option>
            <option value='1'>Mesa #1</option>
            <option value='2'>Mesa #2</option>
            <option value='3'>Mesa #3</option>
            <option value='4'>Mesa #4</option>
            <option value='5'>Mesa #5</option>
          </select>
          {errorMsg.nromesa && <span className={styles.errorMsg}>{errorMsg.nromesa}</span>}
        </div>
        <div className={styles.formItem}>
          <label htmlFor='tipo'>TIPO</label>
          <textarea name='comentarios' id='comentarios' onChange={handleChange}></textarea>
        </div>
        <button type='submit' className={`${styles.createBtn} btn`}>
          CREAR
        </button>
      </form>

      {message && (
        <div className={styles.messageContainer}>
          <pre>{JSON.stringify(message, null, 2)}</pre>
        </div>
      )}
    </div>
  )
}

export default NewPedido
