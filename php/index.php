<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';

$app = AppFactory::create();

// -------- END POINT ALUNNI --------

// Visualizzazione di tutti gli alunni e di uno solo
$app->get('/alunni', "AlunniController:index");
$app->get("/alunni/{id}", "AlunniController:getOne");

// Creazione di un nuovo alunno: curl -X POST localhost:8080/alunni -d '{"nome":"Young","cognome":"Thug","codiceFiscale":"FREEY00UNGTHUG"}' -H "Content-Type: application/json"
$app->post("/alunni", "AlunniController:createOne");

// Aggiornamento di un alunno esistente: curl -X PUT localhost:8080/alunni/3 -d '{"nome":"Andrea","cognome":"Ajdinaj"}' -H "Content-Type: application/json"
$app->put("/alunni/{id}", "AlunniController:updateOne");

// Eliminazione un alunno esistente: curl -X DELETE localhost:8080/alunni/3 
$app->delete("/alunni/{id}", "AlunniController:deleteOne");


// -------- END POINT CERTIFICAZIONI --------

// Visualizzazione di tutte le certificazioni di uno specifico alunno
$app->get("/alunni/{id}/certificazioni", "AlunniController:getAlunnoCert");
// Visualizzazione di una singola certificazione di uno specifico alunno
$app->get("/alunni/{id}/certificazioni/{id_cert}", "AlunniController:getOneCert");

// Creazione di una nuova certificazione per un alunno: curl -X POST localhost:8080/alunni/1/certificazioni -d '{"id":"4","alunno_id":"2","titolo":"C++","votazione":"81","ente":"Meucci"}' -H "Content-Type: application/json
$app->post("/alunni/{id}/certificazioni", "AlunniController:createCert");

$app->run();
