<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\UploadedFileInterface;

date_default_timezone_set('Europe/Lisbon');

$app->post('/itens/add', function (Request $request, Response $response) {
    // Apanhar o objecto data dentro do corpo do pedido http
    $params = (array) $request->getParsedBody()['data'];

    $titulo = $params['titulo'];
    $desc = $params['desc'];
    $id = $params['id'];
    $lInicial = $params['lInicial'];
    $Pvenda = $params['Pvenda'];
    $data_inicio = $params['DataComeco'];
    $data_fim = $params['DataFim'];
    $estado = "por_aprovar";
    $categoria = $params['categoria'];

    $sql = 'INSERT INTO items (titulo, descricao, vendedor_id, primeira_licitacao, comprar_agora_preco, data_inicio, data_final, estado, categoria, data_sub)
            VALUES (:titulo, :desc, :id, :primeira, :compra, :inicio, :final, :estado, :categoria, :data_sub) RETURNING id';
    try {
        if (empty($titulo) || empty($desc) || empty($id) || empty($lInicial) || empty($Pvenda) || empty($data_inicio) || empty($data_fim)) {
            $error = array(
                "titulo" => $titulo,
                "desc" => $desc,
                "id" => $id,
                "lInicial" => $lInicial,
                "Pvenda" => $Pvenda,
                "DataComeco" => $data_inicio,
                "DataFim" => $data_fim,
                "categoria" => $categoria
            );
            // Retorna um erro 418 quando algum dos valores enviados pelo post estiver vazio, juntamente com o erro envia todos os elementos
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(418);
        }

        $db = new database();
        $conn = $db->connectTest();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':desc', $desc);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':primeira', $lInicial);
        $stmt->bindParam(':compra', $Pvenda);
        $stmt->bindParam(':inicio', $data_inicio);
        $stmt->bindParam(':final', $data_fim);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':data_sub', date("Y-m-d H:i:s"));

        $stmt->execute();
        $InsertID = $stmt->fetch(PDO::FETCH_ASSOC);

        // Caminhos onde os ficheiros são guardados
        $directory_images = "../../uploads/images";
        $directory_files = "../../uploads/files";

        // Apanhar os ficheiros enviados
        $uploadedFiles = $request->getUploadedFiles();

        // Apanhar os ficheiros no objecto iamgens
        $i = 1;
        foreach ($uploadedFiles['images'] as $uploadedFile) {
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {

                $insert_image = "INSERT INTO imagens (item_id, image_number, data) VALUES (:item_id, :number, :data)";
                $stmt_image = $conn->prepare($insert_image);
                $stmt_image->bindParam(':item_id', $InsertID['id']);
                $stmt_image->bindParam(':number', $i);
                $stmt_image->bindParam(':data', date("Y-m-d H:i:s"));
                $stmt_image->execute();
                $stmt_image->fetch(PDO::FETCH_ASSOC);

                $basename = "{$InsertID['id']}_{$i}";
                moveUploadedFiles($basename, $directory_images, $uploadedFile);
            }
            $i++;
        }

        // Apanhar os ficheiros no objecto files
        $f = 1;
        foreach ($uploadedFiles['files'] as $uploadedFile) {
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {

                $insert_file = "INSERT INTO ficheiros (item_id, files_number, data) VALUES (:item_id, :number, :data)";
                $stmt_file = $conn->prepare($insert_file);
                $stmt_file->bindParam(':item_id', $InsertID['id']);
                $stmt_file->bindParam(':number', $f);
                $stmt_file->bindParam(':data', date("Y-m-d H:i:s"));
                $stmt_file->execute();
                $stmt_file->fetch(PDO::FETCH_ASSOC);

                $basename = "{$InsertID['id']}_{$f}";
                moveUploadedFiles($basename, $directory_files, $uploadedFile);
            }
            $f++;
        }

        // Resposta de sucesso
        $response->getBody()->write(json_encode($InsertID));
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

$app->get('/itens', function (Request $request, Response $response) {
    $sql = "SELECT * FROM items";

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
$app->get('/itens/leiloesativos/{vendedor_id}', function (Request $request, Response $response, $args) {
    $sql = "SELECT * FROM items WHERE estado like 'aprovado' AND data_final > CURRENT_TIMESTAMP AND vendedor_id = :vendedor_id";

    try {
        $db = new database();
        $conn = $db->connectTest();

        $stmt = $conn->prepare($sql);
        $stmt->execute([':vendedor_id' => $args['vendedor_id']]);
        $items = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        $response->getBody()->write(json_encode($items));
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

$app->get('/itens/leiloesrecentes/{id}', function (Request $request, Response $response, $args) {
    $sql = "SELECT *FROM items i JOIN licitacoes l ON i.id = l.item_id WHERE l.user_id = :id ORDER BY l.data_licitacao DESC";

    try {
        $db = new database();
        $conn = $db->connectTest();

        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $args['id']]);
        $items = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        $response->getBody()->write(json_encode($items));
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

$app->get('/itens/avaliar', function (Request $request, Response $response) {
    $sql = "SELECT * FROM items WHERE estado like 'por_aprovar' AND data_final > CURRENT_TIMESTAMP order by id";

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

$app->get('/itens/avaliar/aceitar/{id}', function (Request $request, Response $response,  array $args) {
    $id = $args['id'];
    $sql = "UPDATE items SET estado = 'aprovado' WHERE id = :id AND estado = 'por_aprovar' ";

    try {
        $db = new database();
        $conn = $db->connectTest();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
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

$app->get('/itens/avaliar/rejeitar/{id}', function (Request $request, Response $response,  array $args) {
    $id = $args['id'];
    $sql = "UPDATE items SET estado = 'desaprovado' WHERE id = :id AND estado = 'por_aprovar' ";

    try {
        $db = new database();
        $conn = $db->connectTest();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
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

$app->post('/itens/filter', function (Request $request, Response $response) {
    $params = (array) $request->getParsedBody();

    $categoria = $params['categoria'];
    $prec_min = $params['min'];
    $prec_max = $params['max'];

    $sql = "SELECT * FROM items WHERE coalesce(categoria, '') like :cat AND comprar_agora_preco BETWEEN :min AND :max ORDER BY id";

    try {
        $db = new database();
        $conn = $db->connectTest();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cat', $categoria);
        $stmt->bindParam(':min', $prec_min);
        $stmt->bindParam(':max', $prec_max);

        $stmt->execute();
        $itens = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        $response->getBody()->write(json_encode($itens));
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

$app->get('/itens/{id}', function (Request $request, Response $response,  array $args) {
    $id = $args['id'];
    $sql = "SELECT * FROM items where id = :id";

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

$app->get('/images/count/{id}', function (Request $request, Response $response,  array $args) {
    $id = $args['id'];
    $sql = "SELECT count(*) FROM imagens where item_id = :item_id";

    try {
        $db = new database();
        $conn = $db->connectTest();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':item_id', $id);
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

$app->get('/file/count/{id}', function (Request $request, Response $response,  array $args) {
    $id = $args['id'];
    $sql = "SELECT count(*) FROM ficheiros where item_id = :item_id";

    try {
        $db = new database();
        $conn = $db->connectTest();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':item_id', $id);
        $stmt->execute();
        $file = $stmt->fetch(PDO::FETCH_ASSOC);

        $db = null;

        $response->getBody()->write(json_encode($file));
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

function moveUploadedFiles(string $basename, string $directory, UploadedFileInterface $uploadedFile)
{
    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $basename);
}
