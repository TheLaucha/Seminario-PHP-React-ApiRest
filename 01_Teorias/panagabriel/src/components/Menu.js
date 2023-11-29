import Container from 'react-bootstrap/Container';
import Offcanvas from 'react-bootstrap/Offcanvas';
import Navbar from 'react-bootstrap/Navbar';
import Nav from 'react-bootstrap/Nav';
import NavDropdown from 'react-bootstrap/NavDropdown';
/* import Form from 'react-bootstrap/Form'
import Button from 'react-bootstrap/Button' */
import logo from '../assets/img/logo.svg'

const Menu = () => {
  return (
      <Navbar sticky="top" expand="md" className="bg-body-tertiary" data-bs-theme="dark">
        <Container>
          <Navbar.Brand href="/">
            <img
              src={logo}
              width="50"
              height="50"
              className="d-inline-block"
              alt="React Bootstrap logo"
            />
            El Pana Gabriel
          </Navbar.Brand>
          <Navbar.Toggle aria-controls="basic-navbar-nav" />
          <Navbar.Offcanvas id="basic-navbar-nav" placement="end">
            <Offcanvas.Header closeButton>
              <Offcanvas.Title id={"offcanvasNavbarLabel-expand"}>
                <img
                  src={logo}
                  width="50"
                  height="50"
                  className="d-inline-block"
                  alt="React Bootstrap logo"
                />
                El Pana Gabriel
              </Offcanvas.Title>
            </Offcanvas.Header>
            <Offcanvas.Body>
              {/* <Nav className="ms-auto">
                <Form className="d-flex">
                  <Form.Control
                    type="search"
                    placeholder="Buscar"
                    className="me-2"
                    aria-label="Search"
                  />
                  <Button variant="outline-success">Buscar</Button>
                </Form>
              </Nav> */}
              <Nav className="ms-auto">
                <NavDropdown title="Contacto" id="basic-nav-dropdown">
                  <NavDropdown.Item href="#action/3.1">WhatsApp</NavDropdown.Item>
                  <NavDropdown.Item href="#action/3.2">Instagram</NavDropdown.Item>
                  <NavDropdown.Item href="#action/3.3">Facebook</NavDropdown.Item>
                </NavDropdown>
              </Nav>
            </Offcanvas.Body>
          </Navbar.Offcanvas>
        </Container>
      </Navbar>
  )
}

export default Menu;