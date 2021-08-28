<?php

namespace PhpTask\Controller;

use PhpTask\Lib\JsonResponse;
use PhpTask\Lib\DbConnection;
use PDO;

class TaskController
{
    public function index($request)
    {
        try {
            $pdo = DbConnection::get();

            $sql = "select * from tasks order by dataCriacao desc";
            $statement = $pdo->prepare($sql);
            $tasks = [];
            if ($statement->execute()) {
                $tasks = $statement->fetchAll(\PDO::FETCH_ASSOC);
                JsonResponse::send($tasks, 200);
            } else {
                $mensagem = ['mensagem' => 'DEU PAU NA LISTAGEM'];
                JsonResponse::send($mensagem, 500);
            }
        } catch (\Exception $e) {
            $mensagem = ['mensagem' => $e->getMessage()];
            JsonResponse::send($mensagem, 500);
        }
    }

    public function create($request)
    {
        try {
            if (property_exists($request, 'titulo') == FALSE || $request->titulo == NULL || $request->titulo == '') {
                $mensagem = "Necessario preencher o campo de titulo";
                $retorno = [
                    "mensagem" => $mensagem,
                ];
                JsonResponse::send($retorno, 400);
            }

            $titulo = $request->titulo;

            $descricao = $request->descricao ?? NULL;

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
        } catch (\Error $e) {
            $retorno = [
                "mensagem" => $e->getMessage(),
            ];
            JsonResponse::send($retorno, 500);
        }
    }
    
    public function update($request)
    {
        try {
            if (property_exists($request, 'taskId') == FALSE || $request->taskId == NULL) {
                $mensagem = "Necessario preencher o campo taskId";
                $retorno = [
                    "mensagem" => $mensagem
                ];
                JsonResponse::send($retorno, 400);
            }
        
            if (property_exists($request, 'titulo') == FALSE || $request->titulo == NULL) {
                $mensagem = "Necessario preencher o campo de titulo";
                $retorno = [
                    "mensagem" => $mensagem,
                ];
                JsonResponse::send($retorno, 400);
            }
        
            $titulo = $request->titulo;
            $taskId = $request->taskId;
            $descricao = $request->descricao ?? NULL;
        
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
        } catch (\Error $e) {
            $retorno = [
                "mensagem" => $e->getMessage(),
            ];
            JsonResponse::send($retorno, 500);
        }
        
    }

    public function delete($request)
    {
        try{
            if (property_exists($request, 'taskId') == FALSE || $request->taskId == NULL || $request->taskId == '') {
                $mensagem = "Necessario preencher o campo TaskId";
                $retorno = [
                    "mensagem" => $mensagem,
                ];
                JsonResponse::send($retorno, 400);
            }
            $taskId = $request->taskId;
        
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
        } catch (\Error $e) {
            $retorno = [
                "mensagem" => $e->getMessage(),
            ];
            JsonResponse::send($retorno, 500);
        }
    }

    public function find($request)
    {
        try {
            $pdo = DbConnection::get();
        
            $taskId = $request->taskId;
        
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
    }

    public function concluir($request)
    {
        try {
            if (property_exists($request, 'taskId') == FALSE || $request->taskId == NULL) {
                $mensagem = "Necessario preencher o campo taskId";
                $retorno = [
                    "mensagem" => $mensagem
                ];
                JsonResponse::send($retorno, 400);
            }
        
            $taskId = $request->taskId;
        
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
        
            //********* FIM *********
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
        } catch (\Error $e) {
            $retorno = [
                "mensagem" => $e->getMessage(),
            ];
            JsonResponse::send($retorno, 500);
        }
    }
}
