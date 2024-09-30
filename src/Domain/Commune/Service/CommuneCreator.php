<?php

namespace App\Domain\Commune\Service;

use App\Domain\Commune\Repository\CommuneRepository;
use App\Domain\Jurisdiction\Repository\JurisdictionRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class CommuneCreator
{
    private CommuneRepository $repository;

    private JurisdictionRepository $repositoryJurisdiction;

    private CommuneValidator $communeValidator;

    private LoggerInterface $logger;

    public function __construct(
        CommuneRepository $repository,
        JurisdictionRepository $repositoryJurisdiction,
        CommuneValidator $communeValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->repositoryJurisdiction = $repositoryJurisdiction;
        $this->communeValidator = $communeValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('commune_creator.log')
            ->createLogger();
    }

    public function create(array $data): array
    {
        // Input validation
        $this->validateCreate($data);
        $this->communeValidator->validateCommune($data);

        // Insert customer and get new customer ID
        $created = $this->repository->insert($data);

        // Logging
        // $this->logger->info(sprintf('Customer created successfully: %s', $customerId));

        return $created;
    }

    public function validateCreate(array $data): void
    {
        $idJurisdiction = $data['idJurisdiction'];
        if (!$this->repositoryJurisdiction->existsId($idJurisdiction)) {
            throw new \DomainException(sprintf('Jurisdiction not found: %s', $idJurisdiction));
        }

        $this->communeValidator->validateCommune($data);
    }
}
