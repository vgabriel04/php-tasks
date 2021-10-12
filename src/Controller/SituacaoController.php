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

/*

mvc = view controller model  

clean architecture = view controller service repository
*/

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
            $situacao = $this->validateSituacaoCreate($request);
            $this->situacaoService->create($situacao);
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
            $situacao = $this->validateSituacaoUpdate($request);
            $this->situacaoService->update($situacao);

            JsonResponse::send(["mensagem" => "Tudo Certo"], 200);
        } catch (\Exception $e) {
            JsonResponse::send(["mensagem" => $e->getMessage()], 500);
        }
    }

    public function delete($request)
    {
        try {
            $situacao = $this->validateSituacaoId($request);
            $this->situacaoService->delete($situacao);
            JsonResponse::send(["mensagem" => "Tudo Certo"], 200);
        } catch (\Exception $e) {
            JsonResponse::send(["mensagem" => $e->getMessage()], 500);
        }
    }

    public function find($request)
    {
        try {
            $situacao = $this->validateSituacaoId($request);
            $situacao = $this->situacaoService->find($situacao);
            JsonResponse::send($situacao, 200);
        } catch (\Exception $e) {
            JsonResponse::send(['mensagem' => $e->getMessage()], 500);
            // $jsonResponse->send($mensagem, 500);
        }
    }

    private function validateSituacaoId($requestData)
    {
        $validator = HttpValidator::create()->forData($requestData, true);
        $validator->exists('situacaoId')
            ->withMessage("Necessario preencher o campo situacaoId")
            ->validate();
        $validator->notNull('situacaoId')
            ->withMessage("Necessario preencher o campo situacaoId")
            ->validate();
        $validator->not('situacaoId', '')
            ->withMessage("Necessario preencher o campo situacaoId")
            ->validate();

        $situacao = new Situacao;
        $situacao->id = $requestData->situacaoId;
        return $situacao;
    }

    private function validateSituacaoCreate($requestData)
    {
        $validator = HttpValidator::create()->forData($requestData, true);

        $validator->exists('situacao')
            ->withMessage("Necessario preencher o campo situacao")
            ->validate();
        $validator->notNull('situacao')
            ->withMessage("Necessario preencher o campo situacao")
            ->validate();
        $validator->not('situacao', '')
            ->withMessage("Necessario preencher o campo situacao")
            ->validate();

        $validator->exists('ordem')
            ->withMessage("Necessario preencher o campo ordem")
            ->validate();
        $validator->notNull('ordem')
            ->withMessage("Necessario preencher o campo ordem")
            ->validate();
        $validator->not('ordem', '')
            ->withMessage("Necessario preencher o campo ordem")
            ->validate();

        $situacao = new Situacao;
        $situacao->situacao = $requestData->situacao;
        $situacao->ordem = $requestData->ordem;
        return $situacao;
    }

    private function validateSituacaoUpdate($requestData)
    {
        $validator = HttpValidator::create()->forData($requestData, true);

        $validator->exists('situacaoId')
            ->withMessage("Necessario preencher o campo situacaoId")
            ->validate();
        $validator->notNull('situacaoId')
            ->withMessage("Necessario preencher o campo situacaoId")
            ->validate();
        $validator->not('situacaoId', '')
            ->withMessage("Necessario preencher o campo situacaoId")
            ->validate();

        $situacao = $this->validateSituacaoCreate($requestData);
        $situacao->id = $requestData->situacaoId;
        return $situacao;
    }
}
