<?php

namespace App\Domain\Jurisdiction\Service;

// use App\Domain\Jurisdictiion\Service\JurisdictionValidator;
use App\Domain\Jurisdiction\Repository\JurisdictionRepository;
// use App\Domain\Jurisdiction\Service\JurisdictionValidator;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class JurisdictionCreator
{
    private JurisdictionRepository $repository;

    private JurisdictionValidator $jurisdictionValidator;

    private LoggerInterface $logger;

    public function __construct(
        JurisdictionRepository $repository,
        JurisdictionValidator $jurisdictionValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->jurisdictionValidator = $jurisdictionValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('customer_creator.log')
            ->createLogger();
    }

    public function createJurisdiction(array $data): array
    {
        // Input validation
        $this->jurisdictionValidator->validateJurisdiction($data);

        // Insert customer and get new customer ID
        $created = $this->repository->insert($data);

        // Logging
        // $this->logger->info(sprintf('Customer created successfully: %s', $customerId));

        return $created;
    }
}
