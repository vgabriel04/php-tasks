<?php

namespace PhpTask\Controller;

use PhpTask\Lib\JsonResponse;
use PhpTask\Lib\DbConnection;
use PDO;
use PhpTask\Model\Task;
use PhpTask\Service\TaskService;
use PhpTask\Lib\HttpValidator;

class TaskController
{

    //propriedades
    protected TaskService $taskService;

    //comportamentos / metodos / funcoes / procedimentos procedure / rotinas
    public function __construct()
    {
        $this->taskService = new TaskService();
    }

    public function index($request)
    {
        try {
            $tasks = $this->taskService->findAll();
            JsonResponse::send($tasks, 200);
        } catch (\Exception $e) {
            $mensagem = ['mensagem' => $e->getMessage()];
            JsonResponse::send($mensagem, 500);
        }
    }

    public function create($request)
    {
        try {
            $task = $this->validateTaskCreate($request);
            $this->taskService->create($task);
            $retorno = [
                "mensagem" => "Tudo Certo",
            ];
            JsonResponse::send($retorno, 201);
        } catch (\Exception $e) {
            JsonResponse::send(["mensagem" => $e->getMessage()], 500);
        }
    }

    public function update($request)
    {
        try {
            $task = $this->validateTaskUpdate($request);
            $this->taskService->update($task);

            JsonResponse::send(["mensagem" => "Tudo Certo"], 200);
        } catch (\Exception $e) {
            JsonResponse::send(["mensagem" => $e->getMessage()], 500);
        }
    }

    public function delete($request)
    {
        try {
            if (property_exists($request, 'taskId') == FALSE || $request->taskId == NULL) {
                $mensagem = "Necessario preencher o campo taskId";
                JsonResponse::send(["mensagem" => $mensagem], 400);
            }

            $task = new Task;
            $task->id = $request->taskId;
            $this->taskService->delete($task);

            JsonResponse::send(["mensagem" => "Tudo Certo"], 200);
        } catch (\Error $e) {
            JsonResponse::send(["mensagem" => $e->getMessage()], 500);
        }
    }

    public function find($request)
    {
        try {
            $task = $this->taskService->find($request->taskId);
            JsonResponse::send($task, 200);
        } catch (\Exception $e) {
            $mensagem = ['mensagem' => $e->getMessage()];
            JsonResponse::send($mensagem, 500);
            // $jsonResponse->send($mensagem, 500);
        }
    }

    public function concluir($request)
    {
        try {
            $validator = HttpValidator::create()->forData($request, true);

            $validator->exists('taskId')
                ->withMessage("Necessario preencher o campo taskId")
                ->validate();

            $validator->notNull('taskId')
                ->withMessage("Necessario preencher o campo taskId")
                ->validate();

            $task = new Task();
            $task->id = $request->taskId;
            $this->taskService->concluir($task);

            JsonResponse::send(["mensagem" => "Tudo Certo"], 200);
        } catch (\Exception $e) {
            JsonResponse::send(["mensagem" => $e->getMessage()], 500);
        }
    }

    private function validateTaskUpdate($requestData)
    {
        $validator = HttpValidator::create()->forData($requestData, true);

        $validator->exists('taskId')
            ->withMessage("Necessario preencher o campo taskId")
            ->validate();
        $validator->notNull('taskId')
            ->withMessage("Necessario preencher o campo taskId")
            ->validate();
        $validator->not('taskId', '')
            ->withMessage("Necessario preencher o campo taskId")
            ->validate();

        $task = $this->validateTaskCreate($requestData);
        $task->id = $requestData->taskId;
        return $task;
    }

    private function validateTaskCreate($requestData)
    {
        $validator = HttpValidator::create()->forData($requestData, true);

        $validator->exists('titulo')
            ->withMessage("Necessario preencher o campo t??tulo")
            ->validate();
        $validator->notNull('titulo')
            ->withMessage("Necessario preencher o campo t??tulo")
            ->validate();
        $validator->not('titulo', '')
            ->withMessage("Necessario preencher o campo t??tulo")
            ->validate();

        $validator->exists('descricao')
            ->withMessage("Necessario preencher o campo descri????o")
            ->validate();

        $validator->exists('situacao')
            ->withMessage("Necessario preencher o campo situacao")
            ->validate();
        $validator->notNull('situacao')
            ->withMessage("Necessario preencher o campo situacao")
            ->validate();
        $validator->not('situacao', '')
            ->withMessage("Necessario preencher o campo situacao")
            ->validate();

        $task = new Task;
        $task->titulo = $requestData->titulo;
        $task->descricao = $requestData->descricao;
        $task->situacao = $requestData->situacao;
        return $task;
    }
}
