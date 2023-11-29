import Row from 'react-bootstrap/Row';
import Tab from 'react-bootstrap/Tab';
import Products from './Products';
import Deals from './Deals';

const ProductsArea = ({deals, categories}) => {
    return (
        <Tab.Content>
            {deals.length > 0 && 
                <Deals deals={deals} />
            }
            {categories.map((cat, indexCat) => (
                cat.subcategories.map((sub, indexSub) => (
                    <Tab.Pane eventKey={`#cat${indexCat}sub${indexSub}`} key={indexCat + '-' + indexSub}>
                        <Row>
                            <h4 className='w-auto mx-auto'>
                                {cat.name}{cat.subcategories.length > 1  ? ` - ${sub.name}` : ''}
                            </h4>
                        </Row>
                        <Row>
                            <Products products={sub.products}/>
                        </Row>                
                    </Tab.Pane>
                ))
            ))}
        </Tab.Content>
    )
}

export default ProductsArea;