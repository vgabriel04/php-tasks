<?php

require_once './vendor/autoload.php';

use PhpTask\Lib\DbConnection;
use PhpTask\Lib\JsonResponse;

$body = file_get_contents("php://input"); //fetch JS
$body = json_decode($body, true);

try {
    if (isset($body['titulo']) == FALSE || $body['titulo'] == NULL) {
        $mensagem = "Necessario preencher o campo de titulo";
        $retorno = [
            "mensagem" => $mensagem,
        ];
        JsonResponse::send($retorno, 400);
    }

    $titulo = $body['titulo'];

    $descricao = $body['descricao'] ?? NULL;

    $pdo = DbConnection::get();

    $sql = "insert into tasks (titulo, descricao, dataCriacao, dataAtualizacao) values (:titulo, :descricao, :dataCriacao, :dataAtualizacao)"; //implementar depois

    $dataCricao = date('Y-m-d H:i:s');
    $dataAtualizacao = date('Y-m-d H:i:s');

    $statement = $pdo->prepare($sql);

    $statement->bindValue(':titulo', $titulo);
    $statement->bindValue(':descricao', $descricao);
    $statement->bindValue(':dataCriacao', $dataCricao);
    $statement->bindValue(':dataAtualizacao', $dataAtualizacao);

    $retorno = [];
    if ($statement->execute()) {
        $retorno = [
            "mensagem" => "Tudo Certo",
        ];
        JsonResponse::send($retorno, 201);
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
