import Modal from 'react-bootstrap/Modal';
import Card from 'react-bootstrap/Card';
import Carousel from 'react-bootstrap/Carousel';

const ModalProduct = ({show, handleClose, product}) => {
  const name = product && product.name ? product.name : '\u00A0';
  const description = product && product.description ? product.description : '\u00A0';
  const price = product && product.price ? `$ ${product.price.toFixed(2)}` : '\u00A0';
  const photos = product ? product.photos : null;
  
  return (
    <Modal show={show} onHide={handleClose}>
      <Modal.Header closeButton>
        <Modal.Title>{name}</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <Card>
          {photos && (
            photos.length === 1 ? 
              <Card.Img variant="top" src={product.photos[0]} /> :
              <Carousel interval={1000}>
                {product.photos.map((photo, index) => (
                  <Carousel.Item key={index}>
                    <img
                      className="d-block w-100"
                      src={photo}
                      alt={name}
                    />
                  </Carousel.Item>
                ))}
              </Carousel>
          )}
          <Card.Body>
            <Card.Title>{name}</Card.Title>
            <Card.Subtitle className="mb-2">{price}</Card.Subtitle>
            <Card.Text>{description}</Card.Text>
          </Card.Body>
        </Card>
      </Modal.Body>
    </Modal>
  )
}

export default ModalProduct;