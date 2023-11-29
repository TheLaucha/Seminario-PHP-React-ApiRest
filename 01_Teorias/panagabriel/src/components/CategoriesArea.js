import { useState } from 'react';
import Row from 'react-bootstrap/Row';
import { Button } from 'react-bootstrap';
import Collapse from 'react-bootstrap/Collapse';
import CategoriesMenu from './CategoriesMenu';

const CategoriesArea = ({deals, categories}) => {
  const [openCategories, setOpenCategories] = useState(false);

  return (
    <>
      <Row className='d-none d-md-flex'>
        <h4 className='w-auto mx-auto'>&nbsp;</h4>
      </Row>
      <Button
        onClick={() => setOpenCategories(!openCategories)}
        className='d-flex d-md-none w-100 h5'
        aria-controls="collapse-categories"
        aria-expanded={openCategories}
      >
        <div className="text-center w-100">{openCategories ? "Ocultar Categorías" : "Mostrar Categorías"}</div>
      </Button>
      <Collapse in={openCategories} className={`my-0 my-md-3 ${!openCategories ? 'd-none d-md-block' : ''}`}>
        <div id="collapse-categories">
          <CategoriesMenu deals={deals} categories={categories} />
        </div>
      </Collapse>
    </>
  )
}

export default CategoriesArea;