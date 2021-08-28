<?php

require_once './vendor/autoload.php';

use PhpTask\Lib\JsonResponse;
use PhpTask\Lib\DbConnection;

try {
    $pdo = DbConnection::get();

    $taskId = $body["taskId"];

    $sql = "select * from tasks where id = :taskId";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(":taskId", $taskId);
    // $task = [];
    if ($statement->execute()) {
        $task = $statement->fetch(PDO::FETCH_ASSOC);
        JsonResponse::send($task, 200);
    } else {
        $mensagem = ['mensagem' => 'DEU PAU NA LISTAGEM'];
        JsonResponse::send($mensagem, 500);
    }
} catch (\Exception $e) {
    $mensagem = ['mensagem' => $e->getMessage()];
    JsonResponse::send($mensagem, 500);
    // $jsonResponse->send($mensagem, 500);
}
