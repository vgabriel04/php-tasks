<?php

namespace PhpTask\Service;

use Exception;
use PhpTask\Model\Situacao;
use PhpTask\Lib\DbConnection;
use PDO;

use DateTime;
use PhpTask\Lib\Repository;

class SituacaoService
{
    public function findAll()
    {
        $repository = Repository::forClass(Situacao::class);
        $situacao = $repository->findAll();
        return $situacao;
    }

    public function find($situacao)
    {
        $pdo = DbConnection::get();
        $sql = "select * from situacao where id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $situacao->id);

        if (!$statement->execute()) {
            throw new Exception("Erro de banco!");
        }

        $situacao = $statement->fetch(PDO::FETCH_ASSOC);

        $situacaoObject = new Situacao();
        $situacaoObject->id = $situacao['id'];
        $situacaoObject->situacao = $situacao['situacao'];
        $situacaoObject->ordem = $situacao['ordem'];

        return $situacaoObject;
    }

    public function create($situacao)
    {
        $pdo = DbConnection::get();

        $sql = "select * from situacao where ordem = :ordem";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':ordem', $situacao->ordem);
        if (!$statement->execute()) {
            throw new Exception("Erro de banco!");
        }
        $situacoesMesmaOrdem = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($situacoesMesmaOrdem) > 0) {
            throw new Exception('Ordem já usada');
        }

        $sql = "insert into situacao (situacao, ordem) values (:situacao, :ordem)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':situacao', $situacao->situacao);
        $statement->bindValue(':ordem', $situacao->ordem);
        if (!$statement->execute()) {
            throw new Exception("Erro de banco!");
        }
    }

    public function update($situacao)
    {
        $pdo = DbConnection::get();

        $sql = "update situacao set situacao = :situacao, ordem = :ordem where id = :situacaoId";

        $statement = $pdo->prepare($sql);

        $statement->bindValue(':situacao', $situacao->situacao);
        $statement->bindValue(':ordem', $situacao->ordem);
        $statement->bindValue(':situacaoId', $situacao->id);

        if (!$statement->execute()) {
            throw new Exception("Erro de banco!");
        }
    }

    public function delete($situacao)
    {
        $pdo = DbConnection::get();

        $sql = "DELETE FROM situacao WHERE id = :situacaoId";

        $statement = $pdo->prepare($sql);

        $statement->bindValue(':situacaoId', $situacao->id);

        if (!$statement->execute()) {
            throw new Exception("Erro de banco!");
        }
    }
}
