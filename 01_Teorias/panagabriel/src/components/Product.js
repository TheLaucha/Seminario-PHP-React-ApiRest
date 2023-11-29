import Card from 'react-bootstrap/Card';

const Product = ({product, dark, onClick} /* {name, description, price, photos} */) => {
  const name = product.name ? product.name : '\u00A0';
  const description = product.description ? product.description : '\u00A0';
  const price = product.price ? `$ ${product.price.toFixed(2)}` : '\u00A0';
  
  let bg, text  
  dark && (bg = 'dark') && (text = 'white')

  return (
    <Card className='h-100 pointer' bg={bg} text={text} onClick={onClick}>
      <Card.Img variant="top" src={product.photos[0]} />
      <Card.Body>
        <Card.Title>{name}</Card.Title>
        <Card.Subtitle className="mb-2">{price}</Card.Subtitle>
        <Card.Text>{description}</Card.Text>
      </Card.Body>
    </Card>
  )
}

export default Product;