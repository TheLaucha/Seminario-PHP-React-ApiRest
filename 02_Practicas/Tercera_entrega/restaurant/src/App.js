import { Routes, Route } from "react-router-dom"
import ItemsPage from "./pages/items/ItemsPage"
import EditItem from "./pages/items/EditItem"
import NewItem from "./pages/items/NewItem"
import NewPedido from "./pages/pedidos/NewPedido"
import PedidosPage from "./pages/pedidos/PedidosPage"
import ErrorPage from "./pages/ErrorPage"
import Layout from "./components/Layout"

function App() {
  return (
    <Routes>
      <Route path='/' element={<Layout />}>
        <Route path='/' element={<ItemsPage />}></Route>
        <Route path='/editItem' element={<EditItem />}></Route>
        <Route path='/newItem' element={<NewItem />}></Route>
        <Route path='/newPedido' element={<NewPedido />}></Route>
        <Route path='/pedidosPage' element={<PedidosPage />}></Route>
        <Route path='*' element={<ErrorPage />}></Route>
      </Route>
    </Routes>
  )
}

export default App
