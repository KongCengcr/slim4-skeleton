<?php

namespace App\Domain\Jurisdiction\Service;

use App\Domain\Jurisdiction\Data\JurisdictionFinderItem;
use App\Domain\Jurisdiction\Data\JurisdictionFinderResult;
use App\Domain\Jurisdiction\Repository\JurisdictionRepository;

final class JurisdictionFinder
{
    private JurisdictionRepository $repository;

    public function __construct(JurisdictionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listJurisdiction(): array
    {
        // Input validation
        // ...

        $jurisdictions = $this->repository->list();

        return $jurisdictions;
        // return $this->createResult($jurisdictions);
    }
}
