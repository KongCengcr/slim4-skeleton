<?php

namespace App\Domain\Jurisdiction\Service;

use App\Domain\Jurisdiction\Repository\JurisdictionRepository;

final class JurisdictionReader
{
    private JurisdictionRepository $repository;

    public function __construct(JurisdictionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getJurisdiction($id): array
    {
        if (!is_numeric($id))
            throw new \DomainException('Parameter id must be a number.');

        $find = $this->repository->view($id);

        return $find;
        // return $this->createResult($jurisdictions);
    }
}
