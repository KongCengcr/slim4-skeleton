<?php

namespace App\Domain\Commune\Repository;

use App\Factory\PdoFactory;

final class CommuneRepository
{
    private PdoFactory $pdoFactory;
    private $table;

    public function __construct(PdoFactory $pdoFactory)
    {

        $this->pdoFactory = $pdoFactory;
        $this->table = 'commune';
    }

    public function list(): array
    {
        return $this->pdoFactory->all($this->table) ?: [];
    }

    public function listWithJurisdiction(): array
    {
        $sql = $this->pdoFactory->pdo->query("SELECT c.id, c.name, c.idJurisdiction, j.name AS jurisdiction FROM commune c 
INNER JOIN jurisdiction j ON c.idJurisdiction = j.id");
        $all =  $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $all ?: [];
    }

    public function listPaginate(int $page = 1, int $perPage = 10): array
    {
        // return $this->pdoFactory->all('contract') ?: [];
        return $this->pdoFactory->paginate($this->table, $page, $perPage) ?: [];
    }

    public function view(int $id): array
    {
        return $this->pdoFactory->find($this->table, $id) ?: [];
    }

    public function insert(array $data): array
    {
        $id = $this->pdoFactory->create($this->table, ($data));
        $sql = $this->pdoFactory->pdo->query("SELECT c.id, c.name, c.idJurisdiction, j.name AS jurisdiction FROM commune c 
        INNER JOIN jurisdiction j ON c.idJurisdiction = j.id WHERE c.id = $id");
        $find =  $sql->fetch(\PDO::FETCH_ASSOC);

        return $find;
    }

    public function update(int $id, array $data): array
    {

        $this->pdoFactory->update($this->table, $id, $data);

        $sql = $this->pdoFactory->pdo->query("SELECT c.id, c.name, c.idJurisdiction, j.name AS jurisdiction FROM commune c 
        INNER JOIN jurisdiction j ON c.idJurisdiction = j.id WHERE c.id = $id");
        $find =  $sql->fetch(\PDO::FETCH_ASSOC);

        // $find = $this->pdoFactory->find($this->table,  $id);

        return $find;
    }

    public function delete(int $id): void
    {
        $this->pdoFactory->delete($this->table, $id);
    }

    public function existsId(int $id): bool
    {
        $find = $this->pdoFactory->find($this->table, $id);
        return (bool)$find;
    }
}
