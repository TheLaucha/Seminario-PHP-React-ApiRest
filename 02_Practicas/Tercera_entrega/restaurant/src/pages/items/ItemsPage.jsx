import React, { useEffect, useState } from "react"
import styles from "./ItemsPage.module.css"
import ramen_menu from "../../assets/ramen_menu.jpg"
import { Link } from "react-router-dom"
import FilterComponent from "../../components/FilterComponent"

const ItemsPage = () => {
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

  // Cada vez que aplico un filtro se ejecuta esta funcion y actualiza la lista.
  const handleFilter = (filtro) => {
    const { nombre, orden, tipo } = filtro
    let urlFinal = `http://localhost:8080/items?nombre=${nombre}&orden=${orden}&tipo=${tipo}`
    console.log(urlFinal)
    fetch(`http://localhost:8080/items?nombre=${nombre}&orden=${orden}&tipo=${tipo}`)
      .then((response) => response.json())
      .then((data) => setItems(data))
  }

  // Manejo el boton de eliminar
  const handleDelete = async (id) => {
    const confirmacion = window.confirm("Esta seguro que desea eliminar este elemento ?")
    if (confirmacion) {
      try {
        const response = await fetch(`http://localhost:8080/items/${id}`, {
          method: "DELETE",
        })

        if (!response.ok) {
          const msgError = await response.text()
          alert("Error al intentar elimiar el elemento: " + msgError)
        } else {
          // Eliminación exitosa
          console.log("Elemento eliminado correctamente")
          const filterItems = items.filter((el) => el.id !== id)
          setItems(filterItems)
        }
      } catch (error) {
        console.log(error)
      }
    }
  }

  return (
    <div className={`${styles.ItemsPage} container`} id='menu'>
      <header className={styles.itemsPageHeader}>
        <h1 className={`pageTitle`}>MENU</h1>
        <Link to={"/newItem"}>
          <button className={`${styles.newItemBtn} btn`}>CREAR NUEVO ITEM</button>
        </Link>
      </header>
      <FilterComponent handleFilter={handleFilter}></FilterComponent>
      <div className='cardContainer'>
        {items.length > 0 &&
          items.map((el) => {
            let imageUrl = `data:image/${el.tipo_imagen};base64,${el.imagen}`
            return (
              <div className='card' key={el.id}>
                <img src={imageUrl} alt='' className='cardImage' />
                <div className='cardInfo'>
                  <span className={styles.itemName}>{el.nombre}</span>
                  <span className={styles.itemPrice}>${el.precio}</span>
                  <span className={`${styles.itemType}`}>{el.tipo}</span>
                </div>
                <div className='cardActions'>
                  <button
                    className={`${styles.itemDelete} btn`}
                    onClick={() => handleDelete(el.id)}
                  >
                    ELIMINAR
                  </button>
                  <Link to='/editItem' state={{ item: el }}>
                    <button className={`${styles.itemEdit} btn`}>EDITAR</button>
                  </Link>
                </div>
              </div>
            )
          })}
      </div>
    </div>
  )
}

export default ItemsPage
