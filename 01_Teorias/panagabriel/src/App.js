import Container from 'react-bootstrap/Container';
import Tab from 'react-bootstrap/Tab';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import Menu from './components/Menu';
import ProductsArea from './components/ProductsArea';
import CategoriesArea from './components/CategoriesArea';
import data from './assets/json/data.json';
import './App.css';

const App = () => {
  return (
    <>
      <Menu />
      <Container>
        <Tab.Container id="list-group-tabs" defaultActiveKey="#cat0sub0">
          <Row>
            <Col className='px-0 my-3 col-12 col-md-3 col-xl-2'>
              <CategoriesArea deals={data.deals} categories={data.categories}/>
            </Col>
            <Col className='mx-auto my-3 col-12 col-md-9 col-xl-10'>
              <ProductsArea deals={data.deals} categories={data.categories} />
            </Col>
          </Row>
        </Tab.Container>
      </Container>
    </>
  );
}

export default App;
