<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

date_default_timezone_set('Europe/Lisbon');

$app->post('/licitacoes/{auction_id}/bid', function (Request $request, Response $response, $args) {
    $params = (array) $request->getParsedBody();
    $licitacao = $params['licitacao'];
    $user = $params['user'];
    $auction_id = $args['auction_id'];

    try {
        $db =  new database();
        $conn = $db->connectTest();

        $sqlGetEstado = 'SELECT estado FROM items WHERE id = :auction_id';
        $stmt = $conn->prepare($sqlGetEstado);
        $stmt->bindParam(':auction_id', $auction_id);
        $stmt->execute();
        $estado = $stmt->fetch(PDO::FETCH_ASSOC)['estado'];

        if ($estado === 'comprado') {
            $response->getBody()->write(json_encode(["status" => "error", "message" => "The item has already been purchased"]));
            return $response->withHeader('content-type', 'application/json')->withStatus(400);
        }

        if ($estado !== 'aprovado') {
            $response->getBody()->write(json_encode(["status" => "error", "message" => "The item is not approved for bidding"]));
            return $response->withHeader('content-type', 'application/json')->withStatus(400);
        }

        $sqlGetCurrentBid = 'SELECT licitacao_corrente FROM items WHERE id = :auction_id';
        $stmt = $conn->prepare($sqlGetCurrentBid);
        $stmt->bindParam(':auction_id', $auction_id);
        $stmt->execute();
        $currentBid = $stmt->fetch(PDO::FETCH_ASSOC)['licitacao_corrente'];

        if ($licitacao <= $currentBid) {
            $response->getBody()->write(json_encode(["status" => "error", "message" => "New bid must be greater than the current bid"]));
            return $response->withHeader('content-type', 'application/json')->withStatus(400);
        }

        // Update the bid
        $sqlUpdateBid = 'UPDATE items SET licitacao_corrente = :licitacao, num_licitacoes = COALESCE(num_licitacoes, 0) + 1 WHERE id = :auction_id';
        $stmt = $conn->prepare($sqlUpdateBid);
        $stmt->bindParam(':auction_id', $auction_id);
        $stmt->bindParam(':licitacao', $licitacao);
        $stmt->execute();

        $sqlInsert = 'INSERT INTO licitacoes (user_id, item_id, valor, data_licitacao) VALUES (:user_id, :item_id, :valor, :data)';
        $stmt = $conn->prepare($sqlInsert);
        $stmt->bindParam(':user_id', $user);
        $stmt->bindParam(':item_id', $auction_id);
        $stmt->bindParam(':valor', $licitacao);
        $stmt->bindParam(':data', date("Y-m-d H:i:s"));
        $stmt->execute();

        $response->getBody()->write(json_encode(["status" => "success"]));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);

        $db = null;
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


$app->post('/licitacoes/{auction_id}/buy_now', function (Request $request, Response $response, $args) {
    $auction_id = $args['auction_id'];

    $sqlBuyNow = 'UPDATE items SET estado = \'comprado\' WHERE id = :auction_id';

    try {
        $db =  new database();
        $conn = $db->connectTest();

        $sqlGetEstado = 'SELECT estado FROM items WHERE id = :auction_id';
        $stmt = $conn->prepare($sqlGetEstado);
        $stmt->bindParam(':auction_id', $auction_id);
        $stmt->execute();
        $estado = $stmt->fetch(PDO::FETCH_ASSOC)['estado'];
        
        if ($estado === 'comprado') {
            $response->getBody()->write(json_encode(["status" => "error", "message" => "The item has already been purchased"]));
            return $response->withHeader('content-type', 'application/json')->withStatus(400);
        }

        // atualizar para "comprado"
        $stmt = $conn->prepare($sqlBuyNow);
        $stmt->bindParam(':auction_id', $auction_id);
        $stmt->execute();

        $response->getBody()->write(json_encode(["status" => "success"]));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);

        $db = null;
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



