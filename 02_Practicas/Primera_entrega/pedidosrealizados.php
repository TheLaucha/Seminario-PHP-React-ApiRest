<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pedidos realizados</title>
    <link rel="stylesheet" href="styles/main.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <nav class="navbar">
      <div class="logo">
        <img src="./assets/menu_logo.svg" alt="Logo de menu" />
      </div>
      <ul>
        <li>
          <a href="#">Inicio</a>
        </li>
        <li>
          <a href="#">Menu</a>
        </li>
        <li>
          <a href="#">Sobre nosotros</a>
        </li>
      </ul>
    </nav>
    <section class="container" id="foodList">
      <div class="cardContainer">
        <div class="card">
          <header class="cardHeader">
            <img class="card-image" src="./assets/vacio.jpg" alt="" />
          </header>
          <main class="cardMain">
            <h3 class="card-title">Vacio</h3>
            <span class="card-price">$20</span>
          </main>
          <footer class="cardFooter">
            <span class="card-tipo">Comida</span>
            <button class="btn nuevoPedido">
              <img src="./assets/cart.svg" alt="buy cart icon" />
            </button>
          </footer>
        </div>
        <div class="card">
          <header class="cardHeader">
            <img class="card-image" src="./assets/vacio.jpg" alt="" />
          </header>
          <main class="cardMain">
            <h3 class="card-title">Vacio</h3>
            <span class="card-price">$20</span>
          </main>
          <footer class="cardFooter">
            <span class="card-tipo">Comida</span>
            <button class="btn nuevoPedido">
              <img src="./assets/cart.svg" alt="buy cart icon" />
            </button>
          </footer>
        </div>
        <div class="card">
          <header class="cardHeader">
            <img class="card-image" src="./assets/vacio.jpg" alt="" />
          </header>
          <main class="cardMain">
            <h3 class="card-title">Vacio</h3>
            <span class="card-price">$20</span>
          </main>
          <footer class="cardFooter">
            <span class="card-tipo">Comida</span>
            <button class="btn nuevoPedido">
              <img src="./assets/cart.svg" alt="buy cart icon" />
            </button>
          </footer>
        </div>
      </div>
    </section>
    <footer class="footer">
      <h2>Los creadores de nuestros platos en 2023:</h2>
      <div class="integrante">
        <img class="icon_chef" src="./assets/chef_logo.svg" alt="Logo chef" />
        <span>Lautaro Espinillo</span>
      </div>
    </footer>
  </body>
</html>
