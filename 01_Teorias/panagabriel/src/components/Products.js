import { useState } from 'react';
import Col from 'react-bootstrap/Col';
import Product from './Product';
import ModalProduct from './ModalProduct';

const Products = ({products}) => {
  const [show, setShow] = useState(false);
  const [modalProduct, setModalProduct] = useState(null);
  const handleClose = () => setShow(false);
  const handleShow = (i) => {
    setModalProduct(products[i]);
    setShow(true)
  };

  return (
    <>
    {products.map((product /* {name, description, price, photos} */, index) => (
      <Col className='mx-auto my-3 minw-240px' key={index}>
        <Product product={product} onClick={() => handleShow(index)} />
      </Col>
    ))}
    <ModalProduct show={show} handleClose={handleClose} product={modalProduct} />
    </>
  )
}

export default Products;