<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->setBasePath("/ptaw-grupo4/api");
//$app->setBasePath("/~ptaw-2023-gr4/api");


$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->get('/', function (Request $res, Response $rep) {
    $rep->getBody()->write("Root");
    return $rep;
});

$app->post('/sugestoes', function (Request $request, Response $response) {
    $params = (array) $request->getParsedBody();

    $nome = $params['nome'];
    $email = $params['email'];
    $assunto = $params['assunto'];
    $mensagem = $params['mensagem'];

    $sql = "INSERT INTO sugestoes (nome, email, assunto, mensagem) VALUES (:nome, :email, :assunto, :mensagem)";

    try {
        $db = new database();
        $conn = $db->connectTest();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':assunto', $assunto);
        $stmt->bindParam(':mensagem', $mensagem);
        $result = $stmt->execute();

        $db = null;

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (Exception $e) {
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

// Importar ficheiros de rotas
require __DIR__ . '/../routes/users.php';
require __DIR__ . '/../routes/itens.php';
require __DIR__ . '/../routes/licitacoes.php';

$app->run();
