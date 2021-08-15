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

    //    ********* INICIO *********
    $concluido = "1";

    $sql = "select * from tasks where id = :taskId";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':taskId', $taskId);
    $statement->execute();
    $tarefa = $statement->fetch(PDO::FETCH_ASSOC);

    if ($tarefa == false) {
        JsonResponse::send(['mensagem' => 'Tarefa não encontrada'], 500);
    } //jsonresponse::send encerra o script, da um exit

    if ($tarefa['concluido'] == "1") {
        $concluido = "0";
    }

    //    ********* FIM *********
    $sql = "update tasks set dataAtualizacao = :dataAtualizacao, concluido = :concluido where id = :taskId";

    $dataAtualizacao = date('Y-m-d H:i:s');

    $statement = $pdo->prepare($sql);

    $statement->bindValue(':dataAtualizacao', $dataAtualizacao);
    $statement->bindValue(':taskId', $taskId);
    $statement->bindValue(':concluido', $concluido);

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
