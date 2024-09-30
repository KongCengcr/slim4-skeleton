<?php

namespace App\Domain\Commune\Service;

use App\Domain\Commune\Repository\CommuneRepository;

final class CommuneReader
{
    private CommuneRepository $repository;

    public function __construct(CommuneRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getCommune($id): array
    {
        if (!is_numeric($id))
            throw new \DomainException('Parameter id must be a number.');

        $find = $this->repository->view($id);

        return $find;
        // return $this->createResult($jurisdictions);
    }
}
