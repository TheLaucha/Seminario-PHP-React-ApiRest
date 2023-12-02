import React, { useState } from "react"
import { useEffect } from "react"
import styles from "./PedidosPage.module.css"
import { Link } from "react-router-dom"
import ramen_menu from "../../assets/ramen_menu.jpg"

const PedidosPage = () => {
  const [pedidos, setPedidos] = useState([])

  // Al iniciar la pagina se traen todos los items.
  useEffect(() => {
    const getPedidos = async () => {
      // Primero obtengo todos los pedidos
      const response = await fetch("http://localhost:8080/pedidos")
      const data = await response.json()
      let pedidosCompletos = []
      // Luego con el ID de cada pedido obtengo la informacion completa.
      for (const el of data) {
        const responsePedidoById = await fetch(`http://localhost:8080/pedidos/${el.id}`)
        const [fullData] = await responsePedidoById.json()
        console.log(fullData)
        pedidosCompletos.push(fullData)
      }

      setPedidos(pedidosCompletos)
    }

    getPedidos()
  }, [])

  const handleDelete = async (id) => {
    const confirmacion = window.confirm("Esta seguro que desea eliminar este pedido ?")

    console.log(pedidos)

    if (confirmacion) {
      try {
        const response = await fetch(`http://localhost:8080/pedidos/${id}`, {
          method: "DELETE",
        })

        if (!response.ok) {
          const msgError = await response.text()
          alert("Error al intentar elimiar el elemento: " + msgError)
        } else {
          // Eliminación exitosa
          console.log("Elemento eliminado correctamente")
          const filterData = pedidos.filter((el) => el.id !== id)
          setPedidos(filterData)
        }
      } catch (error) {
        console.log(error)
      }
    }
  }

  return (
    <div className={`${styles.PedidosPage} container`}>
      <header className={styles.pedidosPageHeader}>
        <h1 className={`pageTitle`}>PEDIDOS</h1>
        <Link to={"/newPedido"}>
          <button className={`${styles.newPedidoBtn} btn`}>CREAR NUEVO PEDIDO</button>
        </Link>
      </header>
      <div className='cardContainer'>
        {pedidos.length > 0 &&
          pedidos.map((el) => {
            const { id, nombre, nromesa, comentarios, precio, tipo, imagen, tipo_imagen } = el
            let imageUrl = `data:image/${tipo_imagen};base64,${imagen}`
            return (
              <div className='card' key={id}>
                <img src={imageUrl} alt='' className='cardImage' />
                <div className='cardInfo'>
                  <span className={styles.itemName}>{nombre}</span>
                  <span className={styles.itemPrice}>${precio}</span>
                  <span className={styles.itemType}>{tipo}</span>
                  <span className={styles.itemNromesa}>Mesa: {nromesa}</span>
                  <span className={styles.itemComentarios}>Comentario: {comentarios}</span>
                </div>
                <div className='cardActions'>
                  <button className={`${styles.pedidoDelete} btn`} onClick={() => handleDelete(id)}>
                    ELIMINAR
                  </button>
                </div>
              </div>
            )
          })}
      </div>
    </div>
  )
}

export default PedidosPage
