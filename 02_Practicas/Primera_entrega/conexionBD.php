<?php
$con = new mysqli("localhost", "root", "", "menu_unlp");

if ($con->connect_error) {
  die("Fallo en la conexion: " . $con->connect_error);
} else {
  // echo "Conexion exitosa";
}

?>