<?php include "conexionBD.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>UNLP - Food</title>
  <link rel="stylesheet" href="styles/main.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet" />
</head>

<body>
  <?php
  if (isset($_SESSION["nuevo_pedido"])) {
    echo "<div class='container nuevo_pedido'>";
    echo "<p>";
    echo $_SESSION["nuevo_pedido"];
    echo "</p>";
    echo "</div>";
  }
  ?>
  <?php include "navbar.php" ?>
  <?php include "header.php" ?>
  <section class="container" id="foodList">
    <form class="formFilter" action="index.php#foodList" method="POST">
      <div class="formItem">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" placeholder="Milanesas" />
      </div>
      <div class="formItem">
        <label for="tipo">Tipo: </label>
        <select name="tipo" id="tipo">
          <option value="COMIDA">Comida</option>
          <option value="BEBIDA">Bebida</option>
        </select>
      </div>
      <div class="formItem">
        <label for="orderByPrecio">Ordenar por precio</label>
        <select name="orderByPrecio" id="orderByPrecio">
          <option value="asc">Ascendente</option>
          <option value="desc">Descendente</option>
        </select>
      </div>
      <div class="formItem">
        <button type="submit" class="btn">Filtrar</button>
      </div>
    </form>
    <div class="cardContainer">
      <?php

      // CONSTRUYO LA CONSULTA SQL
      $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
      $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
      $orden = isset($_POST['orderByPrecio']) ? $_POST['orderByPrecio'] : '';

      $sql = "SELECT * FROM items_menu WHERE 1";
      if (!empty($nombre)) {
        $sql .= " AND nombre LIKE '%$nombre%'";
      }
      if (!empty($tipo)) {
        $sql .= " AND tipo='$tipo'";
      }
      if (!empty($orden)) {
        $sql .= " ORDER BY precio $orden";
      }

      // CONSULTO Y CONSTRUYO EL MENU
      $sel = $con->query($sql);
      while ($fila = $sel->fetch_assoc()) {
        $nombre = $fila['nombre'];
        $foto = $fila['foto'];
        $tipo = $fila['tipo'];
        $precio = $fila['precio'];

        echo '<div class="card">';
        echo '<header class="cardHeader">';
        echo '<img class="card-image" src="' . $foto . '"alt="" />';
        echo '</header>';
        echo '<main class="cardMain">';
        echo '<h3 class="card-title">' . $nombre . '</h3>';
        echo '<span class="card-price">$' . $precio . '</span>';
        echo '</main>';
        echo '<footer class="cardFooter">';
        echo '<span class="card-tipo">' . $tipo . '</span>';
        echo '<button class="btn nuevoPedido">';
        echo '<img src="./assets/cart.svg" alt="buy cart icon" />';
        echo '</button>';
        echo '</footer>';
        echo '</div>';
      }
      ?>
    </div>

    <!-- <div class="cardContainer">
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
    </div> -->
  </section>
  <?php include "footer.php" ?>
  <?php
  unset($_SESSION['nuevo_pedido']);
  ?>
</body>

</html>