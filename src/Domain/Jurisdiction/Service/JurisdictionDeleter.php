<?php

namespace App\Domain\Jurisdiction\Service;

use App\Domain\Jurisdiction\Repository\JurisdictionRepository;

final class JurisdictionDeleter
{
    private JurisdictionRepository $repository;

    public function __construct(JurisdictionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function delete($id): void
    {
        if (!is_numeric($id))
            throw new \DomainException('Parameter id must be a number.');

        if (!$this->repository->existsId($id)) {
            throw new \DomainException(sprintf('Jurisdiction not found: %s', $id));
        }

        $this->repository->delete($id);
    }
}
