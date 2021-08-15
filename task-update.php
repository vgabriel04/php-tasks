<?php

require_once './vendor/autoload.php';

use PhpTask\Lib\JsonResponse;
use PhpTask\Lib\DbConnection;

$body = file_get_contents("php://input"); //fetch JS
$body = json_decode($body, true);


try {
    if (isset($_GET['taskId']) == FALSE || $_GET['taskId'] == NULL) {
        $mensagem = "Necessario preencher o campo taskId";
        $retorno = [
            "mensagem" => $mensagem
        ];
        JsonResponse::send($retorno, 400);
    }

    if (isset($body['titulo']) == FALSE || $body['titulo'] == NULL) {
        $mensagem = "Necessario preencher o campo de titulo";
        $retorno = [
            "mensagem" => $mensagem,
        ];
        JsonResponse::send($retorno, 400);
    }

    $titulo = $body['titulo'];
    $taskId = $_GET['taskId'];
    $descricao = $body['descricao'] ?? NULL;

    $pdo = DbConnection::get();

    $sql = "update tasks set titulo = :titulo, descricao = :descricao, dataAtualizacao = :dataAtualizacao where id = :taskId";

    $dataAtualizacao = date('Y-m-d H:i:s');

    $statement = $pdo->prepare($sql);

    $statement->bindValue(':titulo', $titulo);
    $statement->bindValue(':descricao', $descricao);
    $statement->bindValue(':dataAtualizacao', $dataAtualizacao);
    $statement->bindValue(':taskId', $taskId);

    $retorno = [];
    if ($statement->execute()) {
        $retorno = [
            "mensagem" => "Tudo Certo",
        ];
        JsonResponse::send($retorno, 200);
    } else {
        $retorno = [
            "mensagem" => "Deu Errado",
        ];
        JsonResponse::send($retorno, 500);
    }
} catch (Error $e) {
    $retorno = [
        "mensagem" => $e->getMessage(),
    ];
    JsonResponse::send($retorno, 500);
}
