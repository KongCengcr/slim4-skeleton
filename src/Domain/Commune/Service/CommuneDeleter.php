<?php

namespace App\Domain\Commune\Service;

use App\Domain\Commune\Repository\CommuneRepository;

final class CommuneDeleter
{
    private CommuneRepository $repository;

    public function __construct(CommuneRepository $repository)
    {
        $this->repository = $repository;
    }

    public function delete($id): void
    {
        if (!is_numeric($id))
            throw new \DomainException('Parameter id must be a number.');

        if (!$this->repository->existsId($id)) {
            throw new \DomainException(sprintf('Commune not found: %s', $id));
        }

        $this->repository->delete($id);
    }
}
