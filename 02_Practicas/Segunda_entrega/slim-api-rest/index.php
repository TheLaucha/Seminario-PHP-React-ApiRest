<?php

use App\Controllers\ItemController;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Models\Db;

require __DIR__ . '/vendor/autoload.php';
require 'src/Models/Db.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

// Conexion a la base de datos.
$db = new Db('localhost', 'menu_unlp_2', 'root', '');
$pdo = $db->getPDO();

$app->get('/', function (Request $request, Response $response, $args) {
  $response->getBody()->write("Hello world GG!");
  return $response;
});

// ITEMS
$app->post("/items", function (Request $req, Response $res, $args) {
  $newItem = $req->getParsedBody();
  $query = "INSERT INTO items_menu (nombre,precio,tipo,imagen) VALUES (:nombre, :precio, :tipo, :imagen)";
  $error = array();

  if (!isset($newItem["nombre"])) {
    $error[] = "El campo 'nombre' es obligatorio.";
  }
  if (!isset($newItem["precio"])) {
    $error[] = "El campo 'precio' es obligatorio.";
  }
  if (!isset($newItem["tipo"])) {
    $error[] = "El campo 'tipo' es obligatorio.";
  }
  if (!isset($newItem["imagen"])) {
    $error[] = "El campo 'imagen' es obligatorio.";
  }

  if (empty($error)) {
    try {
      $db = new Db("localhost", "menu_unlp_2", "root", ""); // Preguntar si en cada endpoint tengo que instanciar la conexion.
      $pdo = $db->getPDO();

      $data = $pdo->prepare($query);
      $data->execute([
        ":nombre" => $newItem["nombre"],
        ":precio" => $newItem["precio"],
        ":tipo" => $newItem["tipo"],
        ":imagen" => $newItem["imagen"],
      ]);

      $json = json_encode(['Item insertado correctamente' => $newItem]);
      $res->withHeader('Content-Type', 'application/json');
      $res->getBody()->write($json);
      return $res->withStatus(200);
    } catch (PDOException $e) {
      $res->withStatus(500)->withHeader("Content-Type", "application/json");
      return $res->getBody()->write($e->getMessage());
    }
  } else {
    $res->withHeader('Content-Type', 'application/json');
    $res->getBody()->write(json_encode(['error' => $error]));
    return $res->withStatus(400);
  }

});

$app->put('/items/{id}', function (Request $req, Response $res, $args) {
  $itemId = $args['id'];
  $updateData = $req->getParsedBody();

  $camposParaActualizar = [];

  foreach ($updateData as $campo => $valor) {
    $camposParaActualizar[] = "$campo = '$valor'";
  }

  $error = array();
  if (empty($camposParaActualizar)) {
    $error[] = "No se encontraron campos para actualizar.";
  }


  if (empty($error)) {
    try {
      $db = new Db("localhost", "menu_unlp_2", "root", ""); // Preguntar si en cada endpoint tengo que instanciar la conexion.
      $pdo = $db->getPDO();
      $query = "UPDATE items_menu SET " . implode(",", $camposParaActualizar) . " WHERE id = $itemId";
      $data = $pdo->prepare($query);
      $data->execute();
      $res->withStatus(200)->withHeader("Content-Type", "application/json");
      $res->getBody()->write("Actualizado corectamente");
      return $res;
    } catch (PDOException $e) {
      $res->withStatus(500)->withHeader("Content-Type", "application/json");
      return $res->getBody()->write($e->getMessage());
    }
  } else {
    $res->withHeader('Content-Type', 'application/json');
    $res->getBody()->write(json_encode(['error' => $error]));
    return $res->withStatus(404);
  }


});

$app->delete("/items/{id}", function (Request $req, Response $res, $args) {
  $itemId = $args['id'];

  $query = "SELECT COUNT(*) as cant_pedidos FROM pedidos WHERE idItemMenu = $itemId";

  try {
    $db = new Db("localhost", "menu_unlp_2", "root", ""); // Preguntar si en cada endpoint tengo que instanciar la conexion.
    $pdo = $db->getPDO();
    $data = $pdo->prepare($query);
    $data->execute();
    $pedidosCount = $data->fetchColumn();
    if ($pedidosCount > 0) {
      // Hay pedidos asociados, no se puede eliminar el ítem
      $res->withStatus(409)->getBody()->write("No se puede eliminar el ítem debido a pedidos asociados.");

    } else {
      $queryDelete = "DELETE FROM items_menu WHERE id = $itemId";
      $data = $pdo->prepare($queryDelete);

      try {
        $data->execute();
        $res->withStatus(204)->getBody()->write("Item elminado correctamente");
        return $res;
      } catch (PDOException $e) {
        $res->withStatus(500)->getBody()->write("Error al eliminar el item");
        return $res;
      }
    }
    return $res;
  } catch (PDOException $e) {
    $res->withHeader('Content-Type', 'application/json');
    return $res->withStatus(400);
  }

});

$app->get("/items", function (Request $req, Response $res, $args) {
  $params = $req->getQueryParams();
  $tipo = $params['tipo'] ?? null;
  $nombre = $params['nombre'] ?? null;
  $orden = $params['orden'] ?? 'asc';

  $query = "SELECT * FROM items_menu WHERE 1=1";

  if (!empty($tipo)) {
    $query .= " AND tipo = '$tipo'";
  }
  if (!empty($nombre)) {
    $query .= " AND nombre LIKE '%$nombre%'";
  }

  $query .= " ORDER BY precio " . ($orden === 'asc' ? 'ASC' : 'DESC');

  try {
    $db = new Db("localhost", "menu_unlp_2", "root", ""); // Preguntar si en cada endpoint tengo que instanciar la conexion.
    $pdo = $db->getPDO();
    $data = $pdo->prepare($query);
    $data->execute();
    if ($data) {
      $results = $data->fetchAll(PDO::FETCH_ASSOC);
      $json = json_encode($results);
      $res->withHeader('Content-Type', 'application/json');
      $res->getBody()->write($json);
    } else {
      $res->getBody()->write('No se encontraron datos');
    }
    return $res;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage(); // Preguntar si la respuesta esta bien que sea un echo o tiene que ser un $response
  }
});

// PEDIDOS
$app->get("/pedidos", function (Request $req, Response $res, $args) {
  $query = "SELECT * FROM pedidos ORDER BY fechaAlta DESC";

  try {
    $db = new Db("localhost", "menu_unlp_2", "root", ""); // Preguntar si en cada endpoint tengo que instanciar la conexion.
    $pdo = $db->getPDO();
    $data = $pdo->prepare($query);
    $data->execute();
    if ($data) {
      $results = $data->fetchAll(PDO::FETCH_ASSOC);
      $json = json_encode($results);
      $res->withHeader('Content-Type', 'application/json');
      $res->getBody()->write($json);
    } else {
      $res->getBody()->write('No se encontraron pedidos');
    }
    return $res;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage(); // Preguntar si la respuesta esta bien que sea un echo o tiene que ser un $response
  }
});

$app->post("/pedidos", function (Request $req, Response $res, $args) {
  $newItem = $req->getParsedBody();
  $query = "INSERT INTO pedidos (nromesa,idItemMenu,comentarios) VALUES (:nromesa,:idItemMenu,:comentarios)";
  $error = array();

  if (!isset($newItem["nromesa"])) {
    $error[] = "El campo 'nromesa' es obligatorio.";
  }
  if (!isset($newItem["idItemMenu"])) {
    $error[] = "El campo 'idItemMenu' es obligatorio.";
  }
  if (!isset($newItem["comentarios"])) {
    $newItem["comentarios"] = "Sin comentarios";
  }

  if (empty($error)) {
    try {
      $db = new Db("localhost", "menu_unlp_2", "root", ""); // Preguntar si en cada endpoint tengo que instanciar la conexion.
      $pdo = $db->getPDO();

      $data = $pdo->prepare($query);
      $data->execute([
        ":nromesa" => $newItem["nromesa"],
        ":idItemMenu" => $newItem["idItemMenu"],
        ":comentarios" => $newItem["comentarios"],
      ]);

      $json = json_encode(['Nuevo pedido realizado' => $newItem]);
      $res->withHeader('Content-Type', 'application/json');
      $res->getBody()->write($json);
      return $res->withStatus(200);
    } catch (PDOException $e) {
      $res->withStatus(500)->withHeader("Content-Type", "application/json");
      return $res->getBody()->write($e->getMessage());
    }
  } else {
    $res->withHeader('Content-Type', 'application/json');
    $res->getBody()->write(json_encode(['error' => $error]));
    return $res->withStatus(400);
  }

});

$app->get("/pedidos/{id}", function (Request $req, Response $res, $args) {
  $idPedido = $args['id'];
  $query = "SELECT pedidos.*, items_menu.nombre, items_menu.precio, items_menu.tipo, items_menu.imagen FROM pedidos INNER JOIN items_menu ON pedidos.idItemMenu = items_menu.id WHERE pedidos.id=$idPedido";
  try {
    $db = new Db("localhost", "menu_unlp_2", "root", ""); // Preguntar si en cada endpoint tengo que instanciar la conexion.
    $pdo = $db->getPDO();
    $data = $pdo->prepare($query);
    $data->execute();
    if ($data->rowCount() > 0) {
      $results = $data->fetchAll(PDO::FETCH_ASSOC);
      $json = json_encode($results);
      $res->withHeader('Content-Type', 'application/json');
      $res->getBody()->write($json);
    } else {
      $res->getBody()->write('No se encontro pedido con ese ID');
    }
    return $res;
  } catch (PDOException $e) {
    $res->getBody()->write($e->getMessage());
    return $res->withStatus(500);
  }
});

$app->delete("/pedidos/{id}", function (Request $req, Response $res, $args) {
  $itemId = $args['id'];


  $queryDelete = "DELETE FROM pedidos WHERE id = $itemId";

  try {
    $db = new Db("localhost", "menu_unlp_2", "root", ""); // Preguntar si en cada endpoint tengo que instanciar la conexion.
    $pdo = $db->getPDO();
    $data = $pdo->prepare($queryDelete);
    $data->execute();
    $res->withStatus(204)->getBody()->write("Pedido elminado correctamente");
    return $res;
  } catch (PDOException $e) {
    $res->withStatus(500)->getBody()->write("Error al eliminar el item");
    return $res;
  }
});

$app->run();

?>