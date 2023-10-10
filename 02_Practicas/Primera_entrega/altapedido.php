<?php include "conexionBD.php";
session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Alta pedido</title>
  <link rel="stylesheet" href="styles/main.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet" />
</head>

<body>
  <?php include "navbar.php" ?>

  <section class="container" id="altaPedido">
    <form action="./src/validarFormulario.php" method="POST" class="formPedido" id="formPedido">
      <div class="formItem">
        <label for="item_menu">Item del menu: </label>
        <select name="item_menu" id="item_select">
          <option value="">---</option>
          <?php
          $sql = "SELECT * FROM items_menu";
          $data = $con->query($sql);
          while ($fila = $data->fetch_assoc()) {
            $id = $fila['id'];
            $nombre = $fila['nombre'];
            $precio = $fila['precio'];
            echo "<option value='$id'>";
            echo $nombre;
            echo "</option>";
          }
          ?>
        </select>
        <span id="item_menu_error" class='error'></span>
      </div>
      <div class="formItem">
        <label for="nromesa">Mesa: </label>
        <select name="nromesa" id="mesa_select">
          <option value="">---</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
        </select>
        <span id="nromesa_error" class='error'></span>
      </div>
      <div class="formItem">
        <label for="comentarios">Nota: </label>
        <textarea name="comentarios" id="comentarios"> </textarea>
      </div>
      <div class="formItem">
        <span class="error">
          <?php
          if (isset($_SESSION["error_item_menu"])) {
            echo $_SESSION["error_item_menu"];
          }
          ?>
        </span>
      </div>
      <div class="formItem">
        <span class="error">
          <?php
          if (isset($_SESSION["error_nromesa"])) {
            echo $_SESSION["error_nromesa"];
          }
          ?>
        </span>
      </div>
      <div class="formItem">
        <button type="submit" class="btn">Enviar</button>
      </div>
    </form>
  </section>

  <?php
  unset($_SESSION['error_item_menu']);
  unset($_SESSION['error_nromesa']);
  ?>

  <?php include "footer.php" ?>

  <script src="./src/validarFormulario.js"></script>
</body>

</html>