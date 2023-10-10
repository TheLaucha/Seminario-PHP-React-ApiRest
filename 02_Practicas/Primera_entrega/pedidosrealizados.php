<?php include "conexionBD.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pedidos realizados</title>
  <link rel="stylesheet" href="styles/main.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet" />
</head>

<body>
  <?php include "navbar.php" ?>
  <section class="container" id="foodList">
    <div class="cardContainer">
      <?php

      $sql = "SELECT * FROM pedidos ORDER BY created_at DESC";
      $pedidos = $con->query($sql);
      // CONSULTO Y CONSTRUYO EL MENU
      while ($fila = $pedidos->fetch_assoc()) {
        $idItemMenu = $fila["idItemMenu"];
        $consultaPedido = "SELECT * FROM items_menu WHERE id='$idItemMenu'";
        $dataItemMenu = $con->query($consultaPedido);

        if ($dataItemMenu->num_rows > 0) {
          $itemMenu = $dataItemMenu->fetch_assoc();
          $nombre = $itemMenu['nombre'];
          $foto = $itemMenu['foto'];
          $tipo = $itemMenu['tipo'];
          $precio = $itemMenu['precio'];
          $comentarios = $fila["comentarios"];
          $nroMesa = $fila["nromesa"];

          echo '<div class="card">';
          echo '<header class="cardHeader">';
          echo "<img class='card-image' src='$foto' alt='' />";
          echo '</header>';
          echo '<main class="cardMain">';
          echo "<h3 class='card-title'>";
          echo $nombre;
          echo "</h3>";
          echo "<span class='card-price'>$$precio</span>";
          echo '</main>';
          echo '<footer class="cardFooter flex-col">';
          echo "<span class='card-tipo'>";
          echo $tipo;
          echo "</span>";
          echo "<span>";
          echo $comentarios;
          echo "</span>";
          echo '</footer>';
          echo '</div>';
        }
      }
      ?>
    </div>
  </section>
  <?php include "footer.php" ?>
</body>

</html>