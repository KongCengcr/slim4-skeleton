<?php

namespace App\Domain\Jurisdiction\Service;

use App\Domain\Jurisdiction\Repository\JurisdictionRepository;
use App\Factory\LoggerFactory;
use DomainException;
use Psr\Log\LoggerInterface;

final class JurisdictionUpdater
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
            ->addFileHandler('jurisdiction_updater.log')
            ->createLogger();
    }

    public function update($id, array $data): array
    {
        if (!is_numeric($id))
            throw new \DomainException('Parameter id must be a number.');

        // Input validation
        $this->validateJurisdictionUpdate($id, $data);


        // Update the row
        return $this->repository->update($id, $data);

        // Logging
        // $this->logger->info(sprintf('Jurisdiction updated successfully: %s', $id));
    }

    public function validateJurisdictionUpdate(int $id, array $data): void
    {
        if (!$this->repository->existsId($id)) {
            throw new DomainException(sprintf('Jurisdiction not found: %s', $id));
        }

        $this->jurisdictionValidator->validateUpdateJurisdiction($data);
    }
}
