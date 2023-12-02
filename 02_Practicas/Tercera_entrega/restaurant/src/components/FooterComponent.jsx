import React from "react"
import styles from "./FooterComponent.module.css"
import chef from "../assets/chef_logo.svg"

const FooterComponent = () => {
  return (
    <div className={`${styles.Footer} container`} id='footer'>
      <h3>Los creadores de nuestros platos en 2023</h3>
      <div className={styles.integrante}>
        <img src={chef} alt='' />
        <p>Lautaro Espinillo - Grupo 07</p>
      </div>
    </div>
  )
}

export default FooterComponent
