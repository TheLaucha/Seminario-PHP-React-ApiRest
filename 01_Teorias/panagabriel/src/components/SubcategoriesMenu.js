import Nav from 'react-bootstrap/Nav';

const SubcategoriesMenu = ({categoryIndex, subcategories}) => {
  return (
    <Nav variant="pills" className="flex-column">
      {subcategories.map(({name}, index) => (
        <Nav.Item key={categoryIndex + '-' + index} /* className='px-0' */ >
          <Nav.Link eventKey={`#cat${categoryIndex}sub${index}`}>
            {name}
          </Nav.Link>
        </Nav.Item>
      ))}
    </Nav>
  )
}

export default SubcategoriesMenu;