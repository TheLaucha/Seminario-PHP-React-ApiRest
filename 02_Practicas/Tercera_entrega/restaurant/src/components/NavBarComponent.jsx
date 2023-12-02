import React from "react"
import { NavLink } from "react-router-dom"
import { HashLink } from "react-router-hash-link"
import ramenLogo from "../assets/ramen_logo.svg"
import styles from "./NavBarComponent.module.css"

const NavBarComponent = () => {
  return (
    <div className={`${styles.Navbar}`}>
      <div className={`${styles.header}`}>
        <div className={`${styles.left}`}>
          <img src={ramenLogo} alt='' />
        </div>
        <div className={`${styles.right}`}>
          <h1>UNLP MENU</h1>
        </div>
      </div>
      <ul className={styles.nav}>
        <li>
          <NavLink to='/' className={styles.navLink}>
            Home
          </NavLink>
        </li>
        <li>
          <NavLink to='/pedidosPage' className={styles.navLink}>
            Pedidos realizados
          </NavLink>
        </li>
        <li>
          <NavLink to='/newItem' className={styles.navLink}>
            Crear nuevo item
          </NavLink>
        </li>
        <li>
          <NavLink to='/newPedido' className={styles.navLink}>
            Crear pedido
          </NavLink>
        </li>
        <li>
          <HashLink to='#footer' className={styles.navLink}>
            Nuestros Chefs
          </HashLink>
        </li>
      </ul>
    </div>
  )
}

export default NavBarComponent
