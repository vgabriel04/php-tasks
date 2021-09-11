<?php

namespace PhpTask\Model;

class Task
{
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
}
