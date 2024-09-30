<?php

namespace App\Domain\Commune\Service;

use App\Domain\Commune\Repository\CommuneRepository;

final class CommuneFinder
{
    private CommuneRepository $repository;

    public function __construct(CommuneRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list(): array
    {
        // Input validation
        // ...

        $list = $this->repository->listWithJurisdiction();

        return $list;
        // return $this->createResult($jurisdictions);
    }
}
