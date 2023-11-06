<?php

namespace App\Models;

class Db
{
  private $host;
  private $dbname;
  private $username;
  private $password;
  private $pdo;
  public function __construct($host, $dbname, $username, $password)
  {
    $this->host = $host;
    $this->dbname = $dbname;
    $this->username = $username;
    $this->password = $password;

    try {
      $this->pdo = new \PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
      $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      // echo "Conectado a la base de datos";
    } catch (\PDOException $e) {
      die("Error al conectar a la base de datos: " . $e->getMessage());
    }
  }

  public function getPDO()
  {
    return $this->pdo;
  }


}

?>