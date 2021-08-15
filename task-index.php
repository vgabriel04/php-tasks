<?php

require_once './vendor/autoload.php';

use PhpTask\Lib\JsonResponse;
use PhpTask\Lib\DbConnection;

try {

    $pdo = DbConnection::get();

    $sql = "select * from tasks";
    $statement = $pdo->prepare($sql);
    $tasks = [];
    if ($statement->execute()) {
        $tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
        JsonResponse::send($tasks, 200);
    } else {
        $mensagem = ['mensagem' => 'DEU PAU NA LISTAGEM'];
        JsonResponse::send($mensagem, 500);
    }
} catch (\Exception $e) {
    $mensagem = ['mensagem' => $e->getMessage() ];
    JsonResponse::send($mensagem, 500);
    // $jsonResponse->send($mensagem, 500);
}
