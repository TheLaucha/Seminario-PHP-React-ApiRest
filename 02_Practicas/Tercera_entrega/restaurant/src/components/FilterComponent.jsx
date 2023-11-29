import React, { useState } from "react"
import styles from "./FilterComponent.module.css"

const FilterComponent = ({ handleFilter }) => {
  const [filtro, setFiltro] = useState({
    nombre: "",
    orden: "",
    tipo: "",
  })

  const handleChange = (e) => {
    setFiltro({ ...filtro, [e.target.name]: e.target.value })
  }

  const handleSubmit = (e) => {
    e.preventDefault()
    handleFilter(filtro)
  }

  return (
    <form className={styles.Filter} onSubmit={handleSubmit}>
      <input
        type='text'
        name='nombre'
        placeholder='Milanesas'
        value={filtro.nombre}
        onChange={handleChange}
        className={styles.filterItem}
      />
      <select
        name='tipo'
        id='tipo'
        value={filtro.tipo}
        onChange={handleChange}
        className={styles.filterItem}
      >
        <option value=''>TIPO</option>
        <option value='COMIDA'>Comida</option>
        <option value='BEBIDA'>Bebida</option>
      </select>
      <select
        name='orden'
        id='orden'
        value={filtro.orden}
        onChange={handleChange}
        className={styles.filterItem}
      >
        <option value=''>ORDENAR POR PRECIO</option>
        <option value='asc'>Ascendente</option>
        <option value='desc'>Descendente</option>
      </select>
      <button type='submit' className={`${styles.filterBtn} btn`}>
        FILTRAR
      </button>
    </form>
  )
}

export default FilterComponent
