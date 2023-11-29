import { useState } from 'react';
import Row from 'react-bootstrap/Row';
import ModalProduct from './ModalProduct';
import AliceCarousel from 'react-alice-carousel';
import 'react-alice-carousel/lib/alice-carousel.css';
import '../assets/css/alice-carousel.css';
import Product from './Product';

const itemsFit = 'contain';    // contain | fill | undefined

const responsive = {
    0: {        //  xs:    0 -  497 (576)
        items: 1,
        itemsFit: {itemsFit}
    },
    497: {      //  sm:  497 (576) -  768
        items: 2,
        itemsFit: {itemsFit}
    },
    768: {      //  md:  768 -  992
        items: 2,
        itemsFit: {itemsFit}
    },
    992: {      //  lg:  992 - 1200
        items: 3,
        itemsFit: {itemsFit}
    },
    1200: {      //  xl: 1200 - 1400
        items: 3,
        itemsFit: {itemsFit}
    },
    1400: {      // xxl: 1400 - 9999
        items: 4,
        itemsFit: {itemsFit}
    }
};

const Deals = ({deals}) => {
    const [show, setShow] = useState(false);
    const [modalProduct, setModalProduct] = useState(null);
    const handleClose = () => setShow(false);
    const handleShow = (i) => {
      setModalProduct(deals[i]);
      setShow(true)
    };

    const items = deals.map((deal, index) => (
        <Product product={deal} dark onClick={() => handleShow(index)} />
    ));

    return (
        <>
            <Row>
                <h4 className='w-auto mx-auto'>
                    Promociones
                </h4>
            </Row>
            <Row className="my-3">
                <AliceCarousel
                    items={items}
                    responsive={responsive}
                    autoPlay={true}
                    infinite={true}
                    autoPlayInterval="2000"
                    animationDuration="1000"
                    disableButtonsControls={true}
                    mouseTracking={true}
                />
            </Row>
            <ModalProduct show={show} handleClose={handleClose} product={modalProduct} />
       </>
    )
}

export default Deals;