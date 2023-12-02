<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Models\Db;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
use Tuupola\Middleware\CorsMiddleware;



require __DIR__ . '/vendor/autoload.php';
require 'src/Models/Db.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

$app->get('/', function (Request $request, Response $response, $args) {
  $response->getBody()->write("Hello world!");
  return $response;
});

// Habilito CORS

$app->options('/{routes:.+}', function ($request, $response, $args) {
  return $response;
});

$app->add(function ($request, $handler) {
  $response = $handler->handle($request);
  return $response
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

// ITEMS
$app->post("/items", function (Request $req, Response $res, $args) {

  $newItem = $req->getParsedBody();
  $query = "INSERT INTO items_menu (nombre,precio,tipo,imagen,tipo_imagen) VALUES (:nombre, :precio, :tipo, :imagen, :tipo_imagen)";
  $error = array();

  if (!isset($newItem["nombre"])) {
    $error[] = "El campo 'nombre' es obligatorio.";
  }
  if (!isset($newItem["precio"])) {
    $error[] = "El campo 'precio' es obligatorio.";
  }
  if (!isset($newItem["tipo"])) {
    $error[] = "El campo 'tipo' es obligatorio.";
  } else {
    $strUpperCase = strtoupper($newItem["tipo"]);
    if ($strUpperCase !== "COMIDA" && $strUpperCase !== "BEBIDA") {
      $error[] = "El campo 'tipo' debe ser COMIDA o BEBIDA";
    }
  }
  if (!isset($newItem["imagen"])) {
    $error[] = "El campo 'imagen' es obligatorio.";
  }
  if (!isset($newItem["tipo_imagen"])) {
    $error[] = "El campo 'tipo_imagen' es obligatorio.";
  }

  if (empty($error)) {
    try {
      $db = new Db();
      $pdo = $db->getPDO();

      $data = $pdo->prepare($query);
      $data->execute([
        ":nombre" => $newItem["nombre"],
        ":precio" => $newItem["precio"],
        ":tipo" => $newItem["tipo"],
        ":imagen" => $newItem["imagen"],
        ":tipo_imagen" => $newItem["tipo_imagen"],
      ]);

      $json = json_encode([$newItem]);
      $res->getBody()->write($json);
      return $res->withStatus(200)->withHeader('Content-Type', 'application/json');
    } catch (PDOException $e) {
      $res->getBody()->write($e->getMessage());
      return $res->withStatus(500)->withHeader("Content-Type", "application/json");
    }
  } else {
    $res->getBody()->write(json_encode(['error' => $error]));
    return $res->withStatus(400)->withHeader('Content-Type', 'application/json');
  }

});

$app->put('/items/{id}', function (Request $req, Response $res, $args) {
  $itemId = $args['id'];
  $updateData = $req->getParsedBody();

  $camposParaActualizar = [];
  $error = array();

  // Evalua que se envie un json.
  if ($updateData !== null) {
    foreach ($updateData as $campo => $valor) {
      $camposParaActualizar[] = "$campo = '$valor'";
    }
  }

  if (empty($camposParaActualizar)) {
    $error[] = "No se encontraron campos para actualizar.";
  }


  if (empty($error)) {
    try {
      $db = new Db();
      $pdo = $db->getPDO();
      $checkId = "SELECT COUNT(*) as cont FROM items_menu WHERE id = $itemId";
      $checkData = $pdo->prepare($checkId);
      $checkData->execute();
      $cont = $checkData->fetchColumn();

      if ($cont > 0) {

        try {
          $query = "UPDATE items_menu SET " . implode(",", $camposParaActualizar) . " WHERE id = $itemId";
          $data = $pdo->prepare($query);
          $data->execute();

          $res->getBody()->write("Actualizado corectamente");
          return $res->withStatus(200)->withHeader("Content-Type", "application/json");
        } catch (PDOException $e) {
          $res->getBody()->write($e->getMessage());
          return $res->withStatus(500)->withHeader("Content-Type", "application/json");
        }

      } else {
        // El elemento con el ID enviado no existe
        $res->getBody()->write("El elemento con ID $itemId no existe.");
        return $res->withStatus(404)->withHeader("Content-Type", "application/json");
      }

    } catch (PDOException $e) {
      $res->withStatus(404)->withHeader("Content-Type", "application/json");
      return $res->getBody()->write($e->getMessage());
    }


  } else {
    // Se envio una solicitud PUT sin datos para actualizar.
    $res->getBody()->write(json_encode(['error' => $error]));
    return $res->withStatus(400)->withHeader('Content-Type', 'application/json');
  }


});

$app->delete("/items/{id}", function (Request $req, Response $res, $args) {
  $itemId = $args['id'];

  $query = "SELECT COUNT(*) as cant_pedidos FROM pedidos WHERE idItemMenu = $itemId";

  try {
    $db = new Db();
    $pdo = $db->getPDO();
    $checkId = "SELECT COUNT(*) as cont FROM items_menu WHERE id = $itemId";
    $checkData = $pdo->prepare($checkId);
    $checkData->execute();
    $cont = $checkData->fetchColumn();

    if ($cont > 0) {

      try {

        $data = $pdo->prepare($query);
        $data->execute();
        $pedidosCount = $data->fetchColumn();
        if ($pedidosCount > 0) {
          // Hay pedidos asociados, no se puede eliminar el ítem
          $res->getBody()->write("No se puede eliminar el ítem debido a pedidos asociados.");
          return $res->withStatus(409)->withHeader("Content-Type", "application/json");
        } else {
          $queryDelete = "DELETE FROM items_menu WHERE id = $itemId";

          try {
            $data = $pdo->prepare($queryDelete);
            $data->execute();
            $res->getBody()->write("Item elminado correctamente");
            return $res->withStatus(200)->withHeader("Content-Type", "application/json");
          } catch (PDOException $e) {
            $res->getBody()->write("Error al eliminar el item");
            return $res->withStatus(409)->withHeader("Content-Type", "application/json");
          }
        }
      } catch (PDOException $e) {
        $res->getBody()->write('Error' . $e->getMessage());
        return $res->withStatus(500)->withHeader('Content-Type', 'application/json');
      }

    } else {
      // No se encontro ID para eliminar
      $res->getBody()->write("El elemento con ID $itemId no existe.");
      return $res->withStatus(409)->withHeader("Content-Type", "application/json");
    }


  } catch (PDOException $e) {
    $res->getBody()->write('Error' . $e->getMessage());
    return $res->withStatus(500)->withHeader('Content-Type', 'application/json');
  }



});

$app->get("/items", function (Request $req, Response $res, $args) {

  $params = $req->getQueryParams();
  $tipo = $params['tipo'] ?? null;
  $nombre = $params['nombre'] ?? null;
  $orden = $params['orden'] ?? null;

  $query = "SELECT * FROM items_menu WHERE 1=1";

  if (!empty($tipo)) {
    $query .= " AND tipo = '$tipo'";
  }
  if (!empty($nombre)) {
    $query .= " AND nombre LIKE '%$nombre%'";
  }
  if (!empty($orden)) {
    $query .= " ORDER BY precio $orden";
  } else {
    $query .= " ORDER BY precio ASC";
  }

  try {
    $db = new Db();
    $pdo = $db->getPDO();
    $data = $pdo->prepare($query);
    $data->execute();
    if ($data) {
      $results = $data->fetchAll(PDO::FETCH_ASSOC);
      $json = json_encode($results);
      $res->getBody()->write($json);
      return $res->withStatus(200)->withHeader('Content-Type', 'application/json');
    } else {
      $res->getBody()->write('No se encontraron datos');
      return $res->withStatus(400)->withHeader('Content-Type', 'application/json');
    }
  } catch (PDOException $e) {
    $res->getBody()->write('Error' . $e->getMessage());
    return $res->withStatus(500)->withHeader('Content-Type', 'application/json');
  }
});

// PEDIDOS
$app->get("/pedidos", function (Request $req, Response $res, $args) {
  $query = "SELECT * FROM pedidos ORDER BY fechaAlta DESC";

  try {
    $db = new Db();
    $pdo = $db->getPDO();
    $data = $pdo->prepare($query);
    $data->execute();
    if ($data) {
      $results = $data->fetchAll(PDO::FETCH_ASSOC);
      $json = json_encode($results);
      $res->getBody()->write($json);
      return $res->withStatus(200)->withHeader('Content-Type', 'application/json');
    } else {
      $res->getBody()->write('No se encontraron pedidos');
      return $res->withStatus(404)->withHeader('Content-Type', 'application/json');
    }
  } catch (PDOException $e) {
    $res->getBody()->write('Error' . $e->getMessage());
    return $res->withStatus(500)->withHeader('Content-Type', 'application/json');
  }
});

$app->post("/pedidos", function (Request $req, Response $res, $args) {
  $newItem = $req->getParsedBody();
  $query = "INSERT INTO pedidos (nromesa,idItemMenu,comentarios, fechaAlta) VALUES (:nromesa,:idItemMenu,:comentarios, :fechaAlta)";
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

  $fechaAlta = date('Y-m-d H:i:s');

  if (empty($error)) {

    try {
      $db = new Db();
      $pdo = $db->getPDO();
      $idItemMenu = $newItem["idItemMenu"];
      $checkId = "SELECT COUNT(*) as cont FROM items_menu WHERE id =  $idItemMenu";
      $checkData = $pdo->prepare($checkId);
      $checkData->execute();
      $cont = $checkData->fetchColumn();

      if ($cont > 0) {

        try {
          $data = $pdo->prepare($query);
          $data->execute([
            ":nromesa" => $newItem["nromesa"],
            ":idItemMenu" => $newItem["idItemMenu"],
            ":comentarios" => $newItem["comentarios"],
            ":fechaAlta" => $fechaAlta
          ]);

          $json = json_encode(['Nuevo pedido realizado' => $newItem]);
          $res->getBody()->write($json);
          return $res->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (PDOException $e) {
          $res->getBody()->write($e->getMessage());
          return $res->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
      } else {
        // No se encontro IdItemMenu para asociar al pedido
        $res->getBody()->write("El elemento del menu con ID $idItemMenu no existe, por lo que no se puede asociar al nuevo pedido.");
        return $res->withStatus(400)->withHeader("Content-Type", "application/json");
      }
    } catch (PDOException $e) {
      $res->getBody()->write($e->getMessage());
      return $res->withStatus(404)->withHeader("Content-Type", "application/json");
    }
  } else {
    // Faltan campos para el pedido
    $res->getBody()->write(json_encode(['error' => $error]));
    return $res->withStatus(400)->withHeader("Content-Type", "application/json");
  }

});

$app->get("/pedidos/{id}", function (Request $req, Response $res, $args) {
  $idPedido = $args['id'];
  $query = "SELECT pedidos.*, items_menu.nombre, items_menu.precio, items_menu.tipo, items_menu.imagen FROM pedidos INNER JOIN items_menu ON pedidos.idItemMenu = items_menu.id WHERE pedidos.id=$idPedido";
  try {
    $db = new Db();
    $pdo = $db->getPDO();
    $data = $pdo->prepare($query);
    $data->execute();
    if ($data->rowCount() > 0) {
      $results = $data->fetchAll(PDO::FETCH_ASSOC);
      $json = json_encode($results);
      $res->getBody()->write($json);
      return $res->withStatus(200)->withHeader('Content-Type', 'application/json');
    } else {
      $res->getBody()->write('No se encontro pedido con ese ID');
      return $res->withStatus(404)->withHeader('Content-Type', 'application/json');
    }
  } catch (PDOException $e) {
    $res->getBody()->write($e->getMessage());
    return $res->withStatus(404)->withHeader('Content-Type', 'application/json');
  }
});

$app->delete("/pedidos/{id}", function (Request $req, Response $res, $args) {
  $itemId = $args['id'];

  $queryDelete = "DELETE FROM pedidos WHERE id = $itemId";

  try {
    $db = new Db();
    $pdo = $db->getPDO();
    $checkId = "SELECT COUNT(*) as cont FROM pedidos WHERE id = $itemId";
    $checkData = $pdo->prepare($checkId);
    $checkData->execute();
    $cont = $checkData->fetchColumn();

    if ($cont > 0) {

      try {
        $db = new Db();
        $pdo = $db->getPDO();
        $data = $pdo->prepare($queryDelete);
        $data->execute();
        $res->getBody()->write("Pedido elminado correctamente");
        return $res->withStatus(200)->withHeader('Content-Type', 'application/json');
      } catch (PDOException $e) {
        $res->getBody()->write($e->getMessage());
        return $res->withStatus(404)->withHeader('Content-Type', 'application/json');
      }

    } else {
      // No se encontro pedido con el ID enviado
      $res->getBody()->write("El elemento con ID $itemId no existe.");
      return $res->withStatus(409)->withHeader('Content-Type', 'application/json');
    }
  } catch (PDOException $e) {
    $res->getBody()->write($e->getMessage());
    return $res->withStatus(404)->withHeader('Content-Type', 'application/json');
  }


});

// LAST ROUTE PARA HABILITAR CORS

use Slim\Exception\HttpNotFoundException;

/**
 * Catch-all route to serve a 404 Not Found page if none of the routes match
 * NOTE: make sure this route is defined last
 */
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
  throw new HttpNotFoundException($request);
});


$app->run();

?>