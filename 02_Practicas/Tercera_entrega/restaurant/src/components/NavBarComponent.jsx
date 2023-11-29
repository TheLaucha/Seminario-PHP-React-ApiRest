import React from "react"
import { NavLink } from "react-router-dom"
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
          <NavLink to='/' className={styles.navLink}>
            Otro
          </NavLink>
        </li>
        <li>
          <NavLink to='/' className={styles.navLink}>
            Otro
          </NavLink>
        </li>
        <li>
          <NavLink to='/' className={styles.navLink}>
            Otro
          </NavLink>
        </li>
      </ul>
    </div>
  )
}

export default NavBarComponent
