<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


date_default_timezone_set('Europe/Lisbon');

$app->post('/users/add', function (Request $request, Response $response) {
    $params = (array) $request->getParsedBody();
    $fn = $params['fn'];
    $ln = $params['ln'];
    $email = $params['email'];
    $password = $params['password'];

    $select = "SELECT COUNT(*) as case FROM users WHERE email = :email";
    $sql = 'INSERT INTO users (email, password, primeiro_nome, ultimo_nome, data_registo, tipo_utilizador) VALUES (:email, :pwd, :fn, :ln, :date, :tipo)';


    try {
        $db = new database();
        $conn = $db->connectTest();

        $query = $conn->prepare($select);
        $query->bindParam(':email', $email);
        $query->execute();
        $queryR = $query->fetch(PDO::FETCH_ASSOC);

        if (!$queryR['case']) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $tipo = "normal";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pwd', $hashed_password);
            $stmt->bindParam(':fn', $fn);
            $stmt->bindParam(':ln', $ln);
            $stmt->bindParam(':date', date("Y-m-d H:i:s"));
            $stmt->bindParam(':tipo', $tipo);


            $result = $stmt->execute();

            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } else {
            $response->getBody()->write(json_encode($queryR));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(409);
        }

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

$app->post('/users/login', function (Request $request, Response $response) {
    $params = (array) $request->getParsedBody();
    $email = $params['email'];
    $password = $params['password'];

    $sql = 'SELECT * FROM users WHERE email = :email';

    try {
        $db = new database();
        $conn = $db->connectTest();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if (password_verify($password, $result['password'])) {

                session_start();
                $_SESSION['id'] = $result['id'];
                $_SESSION['user_email'] = $result['email'];
                $_SESSION['nome'] = $result['primeiro_nome'] . " " . $result['ultimo_nome'];
                $_SESSION['sobre'] = $result['sobre'];
                $_SESSION['tipo_utilizador'] = $result['tipo_utilizador'];

                return $response
                    ->withHeader('content-type', 'application/json')
                    ->withStatus(200);
            } else {
                return $response
                    ->withHeader('content-type', 'application/json')
                    ->withStatus(401);
            }
        } else {
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(404);
        }


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

$app->get('/users/all', function (Request $request, Response $response) {
    $sql = "SELECT * FROM users";

    try {
        $db = new database();
        $conn = $db->connectTest();

        $stmt = $conn->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        $response->getBody()->write(json_encode($users));
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

$app->get('/users/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $sql = "SELECT * FROM users where id = :id";

    try {
        $db = new database();
        $conn = $db->connectTest();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        $db = null;

        $response->getBody()->write(json_encode($item));
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

$app->post('/users/atualiza', function (Request $request, Response $response) {
    $params = (array) $request->getParsedBody();
    $id = $params['id'];
    $fn = $params['fn'];
    $ln = $params['ln'];
    $email = $params['email'];
    $password = $params['password'];
    $sobre = $params['sobre'];
    $imagem_perfil = $params['imagem_perfil'];

    $select = "SELECT COUNT(*) as case FROM users WHERE email = :email";
    $sql = 'UPDATE users 
    SET email = :email, password = :pwd, primeiro_nome = :fn, ultimo_nome = :ln, sobre= :sobre, imagem_perfil= :imagem_perfil 
    WHERE id = :id
    ';


    try {
        $db = new database();
        $conn = $db->connectTest();

        $query = $conn->prepare($select);
        $query->bindParam(':email', $email);
        $query->execute();
        $queryR = $query->fetch(PDO::FETCH_ASSOC);

        if ($queryR['case']) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $tipo = "normal";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pwd', $hashed_password);
            $stmt->bindParam(':fn', $fn);
            $stmt->bindParam(':ln', $ln);
            $stmt->bindParam(':sobre', $sobre);
            $stmt->bindParam(':imagem_perfil', $imagem_perfil);


            $result = $stmt->execute();

            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } else {
            $response->getBody()->write(json_encode($queryR));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(409);
        }

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

$app->get('/user/sobre', function (Request $request, Response $response) {
    // Verifica se o utilizador está autenticado
    if (!isset($_SESSION['email'])) {
        return $response->withStatus(401)->write('utilizador não autenticado');
    }

    // informações "sobre" do usuário na base de dados
    $sobre = getSobre($_SESSION['email']);

    // Retorna as informações "sobre" do utilizador como uma resposta JSON
    return $response->withHeader('Content-Type', 'application/json')
        ->withJson(['sobre' => $sobre]);
});

// Rota para ir buscar os leilões recentes do utilizador
$app->get('/user/leiloes_recentes', function (Request $request, Response $response) {
    // Verifica se o utilizador está autenticado
    if (!isset($_SESSION['email'])) {
        return $response->withStatus(401)->write('utilizador não autenticado');
    }

    // Vai buscar os leilões recentes do utilizador na base de dados
    $leiloesRecentes = getLicitacoesRecentes($_SESSION['id']);

    // Retorna os leilões recentes do utilizador como uma resposta JSON
    return $response->withHeader('Content-Type', 'application/json')
        ->withJson(['leilõesRecentes' => $leiloesRecentes]);
});

$app->post('/users/add_img/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    $db = new database();
    $conn = $db->connectTest();

    $directory_images = "../../uploads/user_images";
    $uploadedFiles = $request->getUploadedFiles();

    try {
        // Apanhar os ficheiros no objecto iamgen
        $uploadedFile = $uploadedFiles['image'];
        if ($uploadedFiles['image']->getError() === UPLOAD_ERR_OK) {

            $basename = "user_{$id}";
            $insert_image = "UPDATE users SET imagem_perfil = :name WHERE id = :id";
            $stmt_image = $conn->prepare($insert_image);
            $stmt_image->bindParam(':name', $basename);
            $stmt_image->bindParam(':id', $id);
            $stmt_image->execute();
            $stmt_image->fetch(PDO::FETCH_ASSOC);

        $uploadedFile->moveTo($directory_images . DIRECTORY_SEPARATOR . $basename);

        }

        // Resposta de sucesso
        $response->getBody()->write(json_encode($id));
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