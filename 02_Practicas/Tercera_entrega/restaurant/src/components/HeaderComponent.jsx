import React from "react"
import ramen from "../assets/ramen.png"
import styles from "./HeaderComponent.module.css"
import { HashLink } from "react-router-hash-link"

const HeaderComponent = () => {
  return (
    <div className={`${styles.Header} container`}>
      <div className={styles.left}>
        <img src={ramen} alt='' />
      </div>
      <div className={styles.right}>
        <h1 className={styles.headerTitle}>Delicioso.</h1>
        <h1 className={styles.headerTitle}>Placentero.</h1>
        <h1 className={styles.headerTitle}>Exquisito.</h1>
        <HashLink to='./#menu'>
          <button className={`${styles.headerBtn} btn`}>MENU</button>
        </HashLink>
      </div>
    </div>
  )
}

export default HeaderComponent
