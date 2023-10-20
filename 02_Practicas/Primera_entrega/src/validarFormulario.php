<?php
session_start();
include "../conexionBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $itemMenu = isset($_POST['item_menu']) ? $_POST['item_menu'] : '';
  $nromesa = isset($_POST['nromesa']) ? $_POST['nromesa'] : '';
  $comentarios = isset($_POST['comentarios']) ? $_POST['comentarios'] : '';
  $fechaAlta = date("Y-m-d H:i:s");

  if (empty($itemMenu)) {
    $_SESSION["error_item_menu"] = "El item del menu es obligatior.";
  }

  if (empty($nromesa)) {
    $_SESSION["error_nromesa"] = "El numero de mesa es obligatorio.";
  }

  if (isset($_SESSION["error_item_menu"]) || isset($_SESSION["error_nromesa"])) {
    header('Location: ../altapedido.php');
    exit();
  } else {
    $sql = "INSERT INTO pedidos (idItemMenu,nromesa,comentarios, fechaAlta) values ('$itemMenu','$nromesa','$comentarios', '$fechaAlta')";
    if ($con->query($sql)) {
      $_SESSION["nuevo_pedido"] = "Se agrego un nuevo pedido a la lista de pedidos realizados.";
      header('Location: ../index.php');
      exit();
    } else {
      echo "Error al insertar datos: " . $con->error;
    }

    $con->close();
  }
}
?>