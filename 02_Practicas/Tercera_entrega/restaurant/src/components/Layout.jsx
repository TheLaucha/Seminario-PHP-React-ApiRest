import React from "react"
import { Outlet } from "react-router-dom"
import NavBarComponent from "./NavBarComponent"
import HeaderComponent from "./HeaderComponent"
import FooterComponent from "./FooterComponent"

const Layout = () => {
  return (
    <>
      <NavBarComponent />
      <HeaderComponent />
      <Outlet />
      <FooterComponent />
    </>
  )
}

export default Layout
