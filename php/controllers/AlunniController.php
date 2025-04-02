<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  

  public function index(Request $request, Response $response, $args){
    $queryParams = $request -> getQueryParams();

    $search = $queryParams['search'] ?? null;
    $sortCol = $queryParams['sortCol'] ?? null;
    $sort = $queryParams['sort'] ?? null;

    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni WHERE nome LIKE '%$search%' ORDER BY '$sortCol' '$sort'");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json");
  }

  public function getOne(Request $request, Response $response, $args){
    $id = $args['id'];
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni WHERE id=$id");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function createOne(Request $request, Response $response, $args){
    $body = json_decode($request->getBody());
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $query = "INSERT INTO alunni (nome, cognome, codiceFiscale) VALUES ('$body->nome', '$body->cognome', '$body->codiceFiscale');";
    $mysqli_connection->query($query) or die ('Unable to execute query. '. mysqli_error($query));
    return $response->withStatus(201);
  }

  public function updateOne(Request $request, Response $response, $args){
    $id = $args['id'];
    $body = json_decode($request->getBody());
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $query = "UPDATE alunni SET nome = '$body->nome', cognome= '$body->cognome', codiceFiscale = '$body->codiceFiscale' WHERE id = $id;";
    $mysqli_connection->query($query) or die ('Unable to execute query. '. mysqli_error($query));
    return $response->withStatus(200);
  }

  public function deleteOne(Request $request, Response $response, $args){
    $id = $args['id'];
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $mysqli_connection->query("DELETE FROM alunni WHERE id='$id';") or die ('Unable to execute query. '. mysqli_error($query));
    return $response->withStatus(200);
  }

  public function getAlunnoCert(Request $request, Response $response, $args){
    $id = $args['id'];
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM certificazioni WHERE alunno_id='$id'");
    $results = $result->fetch_all();

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function getOneCert(Request $request, Response $response, $args){
    $id = $args['id'];
    $c_id = $args['id_cert'];
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT *
                                         FROM certificazioni  
                                         WHERE alunno_id=$id AND id=$c_id");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    if(!$results)
    {
      $response->getBody()->write("Certificazione non trovata");
      return $response -> withHeader("Content-Type", "text/html") -> withStatus(404);
    }
    else
    {
      $response->getBody()->write(json_encode($results));
      return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }
  }


  public function createCert(Request $request, Response $response, $args){
    $body = json_decode($request->getBody());
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $query = "INSERT INTO certificazioni (id, alunno_id, titolo, votazione, ente) VALUES ('$body->id', '$body->alunno_id', '$body->titolo', '$body->votazione', '$body->ente');";

    if(!$mysqli_connection -> query($query))
    {
      $response -> getBody() -> write("Insuccesso, probabilmente qualche dato mancante oppure errore nella query");
      return $response -> withHeader("Content-type", "text/html")->withStatus(500);
    }
    else
    {
      $response->getBody()->write("Successo nella fase di creazione del corso");
      return $response->withHeader("Content-type", "application/json")->withStatus(201);
    }
  }

  public function updateCert(Request $request, Response $response, $args){
    $id = $args['id'];
    $c_id = $args['id_cert'];

    $body = json_decode($request->getBody());
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $query = "UPDATE certificazioni SET titolo = '$body->titolo', votazione= '$body->votazione', ente = '$body->ente' WHERE alunno_id = $id AND id = $c_id;";
    $mysqli_connection->query($query);
    if($mysqli_connection -> affected_rows === 0)
    {
      $response -> getBody() -> write("Insuccesso, dato non trovato oppure dato già presente");
      return $response -> withHeader("Content-type", "text/html")->withStatus(404);
    }
    else
    {
      $response->getBody()->write("Successo nella fase di aggiornamento di un corso");
      return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }
  }

  public function deleteCert(Request $request, Response $response, $args){
    $id = $args['id'];
    $c_id = $args['id_cert'];

    $query = "DELETE FROM certificazioni WHERE alunno_id='$id' AND id='$c_id;";

    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $mysqli_connection->query($query);

    if($mysqli_connection -> affected_rows === 1)
    {
      $response->getBody()->write("Successo nella fase di eliminazione di un corso");
      return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }
    else
    {
      $response -> getBody() -> write("Insuccesso, certificazione da eliminare non trovata");
      return $response -> withHeader("Content-type", "text/html")->withStatus(404);
    }

    return $response->withStatus(200);
  }
  





}
