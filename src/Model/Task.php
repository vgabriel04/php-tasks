<?php

namespace PhpTask\Model;

use PhpTask\Model\Model;

class Task extends Model
{
    const tablename = 'tasks';

    public $id;
    public $titulo;
    public $descricao;
    public $dataCriacao;
    public $dataAtualizacao;
    public $concluido;

    public $dataCriacaoReadable;
    public $dataAtualizacaoReadable;

    public function fillReadableDates()
    {
        $date = new \DateTime($this->dataCriacao);
        $this->dataCriacaoReadable = $date->format('d/m/Y');

        return $this;
    }

    public function toggleConcluido()
    {
        $concluido = "1";
        if ($this->concluido == "1") {
            $concluido = "0";
        }
        $this->concluido = $concluido;

        return $this;
    }

    public static function mapArrayToObject($arrayData)
    {
        $taskObject = new self();
        $taskObject->id = $arrayData['id'];
        $taskObject->titulo = $arrayData['titulo'];
        $taskObject->descricao = $arrayData['descricao'];
        $taskObject->dataCriacao = $arrayData['datacriacao'];
        $taskObject->dataAtualizacao = $arrayData['dataatualizacao'];
        $taskObject->concluido = $arrayData['concluido'];
        return $taskObject;
    }
}
