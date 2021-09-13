<?php

namespace PhpTask\Controller;

use PhpTask\Lib\JsonResponse;
use PhpTask\Lib\DbConnection;
use PDO;
use PhpTask\Model\Situacao;
use PhpTask\Service\SituacaoService;
use PhpTask\Lib\HttpValidator;

class SituacaoController
{

    //propriedades
    protected SituacaoService $situacaoService;

    //comportamentos / metodos / funcoes / procedimentos procedure / rotinas
    public function __construct()
    {
        $this->situacaoService = new SituacaoService();
    }

    public function index($request)
    {
        try {
            $situacoes = $this->situacaoService->findAll();
            JsonResponse::send($situacoes, 200);
        } catch (\Exception $e) {
            $mensagem = ['mensagem' => $e->getMessage()];
            JsonResponse::send($mensagem, 500);
        }
    }

    public function create($request)
    {
        try {
            if (property_exists($request, 'situacao') == FALSE || $request->situacao == NULL || $request->situacao == '') {
                $mensagem = "Necessario preencher o campo de situacao";
                $retorno = [
                    "mensagem" => $mensagem,
                ];
                JsonResponse::send($retorno, 400);
            }
            if (property_exists($request, 'ordem') == FALSE || $request->ordem == NULL || $request->ordem == '') {
                $mensagem = "Necessario preencher o campo de ordem";
                $retorno = [
                    "mensagem" => $mensagem,
                ];
                JsonResponse::send($retorno, 400);
            }

            $situacao = new Situacao();
            $situacao->situacao = $request->situacao;
            $situacao->ordem = $request->ordem;

            $this->situacaoService->create($situacao);

            $retorno = [
                "mensagem" => "Tudo Certo",
            ];
            JsonResponse::send($retorno, 201);
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
            if (property_exists($request, 'situacaoId') == FALSE || $request->situacaoId == NULL) {
                $mensagem = "Necessario preencher o campo taskId";
                $retorno = [
                    "mensagem" => $mensagem
                ];
                JsonResponse::send($retorno, 400);
            }

            if (property_exists($request, 'situacao') == FALSE || $request->situacao == NULL) {
                $mensagem = "Necessario preencher o campo de situação";
                $retorno = [
                    "mensagem" => $mensagem,
                ];
                JsonResponse::send($retorno, 400);
            }

            if (property_exists($request, 'ordem') == FALSE || $request->ordem == NULL) {
                $mensagem = "Necessario preencher o campo de ordem";
                $retorno = [
                    "mensagem" => $mensagem,
                ];
                JsonResponse::send($retorno, 400);
            }

            $situacao = new Situacao;
            $situacao->situacao = $request->situacao;
            $situacao->ordem = $request->ordem;
            $situacao->id = $request->situacaoId;
            $this->situacaoService->update($situacao);

            $retorno = [
                "mensagem" => "Tudo Certo",
            ];
            JsonResponse::send($retorno, 200);
        } catch (\Error $e) {
            $retorno = [
                "mensagem" => $e->getMessage(),
            ];
            JsonResponse::send($retorno, 500);
        }
    }

    // public function delete($request)
    // {
    //     try {
    //         if (property_exists($request, 'taskId') == FALSE || $request->taskId == NULL) {
    //             $mensagem = "Necessario preencher o campo taskId";
    //             JsonResponse::send(["mensagem" => $mensagem], 400);
    //         }

    //         $task = new Task;
    //         $task->id = $request->taskId;
    //         $this->taskService->delete($task);

    //         JsonResponse::send(["mensagem" => "Tudo Certo"], 200);
    //     } catch (\Error $e) {
    //         JsonResponse::send(["mensagem" => $e->getMessage()], 500);
    //     }
    // }

    // public function find($request)
    // {
    //     try {
    //         $task = $this->taskService->find($request->taskId);
    //         JsonResponse::send($task, 200);
    //     } catch (\Exception $e) {
    //         $mensagem = ['mensagem' => $e->getMessage()];
    //         JsonResponse::send($mensagem, 500);
    //         // $jsonResponse->send($mensagem, 500);
    //     }
    // }

}
