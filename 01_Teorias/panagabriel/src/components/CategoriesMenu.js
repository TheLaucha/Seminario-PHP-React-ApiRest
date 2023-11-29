import Accordion from 'react-bootstrap/Accordion';
import Nav from 'react-bootstrap/Nav';
import SubcategoriesMenu from './SubcategoriesMenu';

const CategoriesMenu = ({deals, categories}) => {
  return (
    <Accordion>
      {categories.map(({name, subcategories}, index) => (
        subcategories.length > 1 ? (
          <Accordion.Item eventKey={index} key={index}>
            <Accordion.Header>
              {name}
            </Accordion.Header>
            <Accordion.Body className='pe-0'>
              <SubcategoriesMenu categoryIndex={index} subcategories={subcategories} />
            </Accordion.Body>
          </Accordion.Item>
        ) : (
          <Accordion.Item /* eventKey={index} */ key={index}>
            <Nav variant="pills" className="flex-column">
              <Nav.Item key={index + '-0'} /* className='px-0' */>
                <Nav.Link eventKey={`#cat${index}sub0`} className='px-cat'>
                  {name}
                </Nav.Link>
              </Nav.Item>
            </Nav>
          </Accordion.Item>
        )
      ))}
    </Accordion>
  )
}

export default CategoriesMenu;