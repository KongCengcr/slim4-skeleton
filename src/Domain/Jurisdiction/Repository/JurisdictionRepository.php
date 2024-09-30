<?php

namespace App\Domain\Jurisdiction\Repository;

use App\Factory\PdoFactory;
use App\Factory\QueryFactory;
use DomainException;

final class JurisdictionRepository
{
    private PdoFactory $pdoFactory;
    private $table;

    public function __construct(PdoFactory $pdoFactory)
    {

        $this->pdoFactory = $pdoFactory;
        $this->table = 'jurisdiction';
    }

    public function list(): array
    {
        return $this->pdoFactory->all($this->table) ?: [];
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
        $find = $this->pdoFactory->find($this->table,  $id);

        return $find;
    }

    public function update(int $id, array $data): array
    {

        $this->pdoFactory->update($this->table, $id, $data);
        $find = $this->pdoFactory->find($this->table,  $id);

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

    // public function findContractsByOwnerPaginate(int $contractOwner, int $page = 1, int $perPage = 10): array
    // {
    //     // return $this->pdoFactory->findAllBy('contract', 'contractOwner', $contractOwner) ?: [];
    //     return $this->pdoFactory->paginateAllBy('contract', 'contractOwner', $contractOwner, $perPage, $page) ?: [];
    // }

    // public function insertJurisdiction(array $jurisdictions): int
    // {
    //     return (int)$this->queryFactory->newInsert('jurisdiction', $this->toRow($jurisdictions))
    //         ->execute()
    //         ->lastInsertId();
    // }

    private function toRow(array $jurisdiction): array
    {
        return [
            'name' => $jurisdiction['name'],
        ];
    }
}
