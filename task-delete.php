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

    $taskId = $_GET['taskId'];

    $pdo = DbConnection::get();

    $sql = "DELETE FROM tasks WHERE id = :taskId";

    $dataAtualizacao = date('Y-m-d H:i:s');

    $statement = $pdo->prepare($sql);

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
