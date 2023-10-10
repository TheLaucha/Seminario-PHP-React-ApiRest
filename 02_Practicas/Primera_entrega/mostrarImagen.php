<?php
include "conexionBD.php";

$id = $_GET["idItem"];

$sql = "SELECT foto FROM items_menu WHERE id=$id";
$sel = $con->query($sql);

if ($sel->num_rows > 0) {
  $fila = $sel->fetch_assoc();

  header("Content-type: image/jpg");
  // echo $fila;
  echo $fila['foto'];
} else {
  echo "Imagen no encontrada";
}

?>