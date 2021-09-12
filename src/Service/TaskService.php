<?php

namespace PhpTask\Service;

use Exception;
use PhpTask\Model\Task;
use PhpTask\Lib\DbConnection;
use PDO;

use DateTime;
use PhpTask\Lib\Repository;

class TaskService
{
    public function findAll()
    {

        $repository = Repository::forClass(Task::class);

        $tasks = $repository->findAll();

        foreach ($tasks as $key => $task) {
            $tasks[$key] = $task->fillReadableDates();
            // $task->fillReadableDates();
            // $tasks[$key] = $task;
        }

        return $tasks;
    }

    public function find($taskId)
    {
        $pdo = DbConnection::get();
        $sql = "select * from tasks where id = :taskId";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":taskId", $taskId);

        if (!$statement->execute()) {
            throw new Exception("Erro de banco!");
        }

        $task = $statement->fetch(PDO::FETCH_ASSOC);

        $taskObject = new Task();
        $taskObject->id = $task['id'];
        $taskObject->titulo = $task['titulo'];
        $taskObject->descricao = $task['descricao'];
        $taskObject->dataCriacao = $task['datacriacao'];
        $taskObject->dataAtualizacao = $task['dataatualizacao'];
        $taskObject->concluido = $task['concluido'];

        $taskObject->fillReadableDates();

        return $taskObject;
    }

    public function create($task)
    {
        $pdo = DbConnection::get();

        $sql = "insert into tasks (titulo, descricao, dataCriacao, dataAtualizacao) values (:titulo, :descricao, :dataCriacao, :dataAtualizacao)"; //implementar depois

        $dataCricao = date('Y-m-d H:i:s');
        $dataAtualizacao = date('Y-m-d H:i:s');

        $statement = $pdo->prepare($sql);

        $statement->bindValue(':titulo', $task->titulo);
        $statement->bindValue(':descricao', $task->descricao);
        $statement->bindValue(':dataCriacao', $dataCricao);
        $statement->bindValue(':dataAtualizacao', $dataAtualizacao);

        if (!$statement->execute()) {
            throw new Exception("Erro de banco!");
        }
    }

    public function update($task)
    {
        $pdo = DbConnection::get();

        $sql = "update tasks set titulo = :titulo, descricao = :descricao, dataAtualizacao = :dataAtualizacao, concluido = :concluido where id = :taskId";

        $dataAtualizacao = date('Y-m-d H:i:s');

        $statement = $pdo->prepare($sql);

        $statement->bindValue(':titulo', $task->titulo);
        $statement->bindValue(':descricao', $task->descricao);
        $statement->bindValue(':dataAtualizacao', $dataAtualizacao);
        $statement->bindValue(':concluido', $task->concluido);
        $statement->bindValue(':taskId', $task->id);

        if (!$statement->execute()) {
            throw new Exception("Erro de banco!");
        }
    }

    public function delete($task)
    {
        $pdo = DbConnection::get();

        $sql = "DELETE FROM tasks WHERE id = :taskId";

        $dataAtualizacao = date('Y-m-d H:i:s');

        $statement = $pdo->prepare($sql);

        $statement->bindValue(':taskId', $task->id);

        if (!$statement->execute()) {
            throw new Exception("Erro de banco!");
        }
    }

    public function concluir($task)
    {
        //buscar o task atual
        $task = $this->find($task->id);

        //alterna o concluido (true/false)
        $task->toggleConcluido();

        //atualiza
        $this->update($task);
    }
}
