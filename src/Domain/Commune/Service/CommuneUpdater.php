<?php

namespace App\Domain\Commune\Service;

use App\Domain\Commune\Repository\CommuneRepository;
use App\Domain\Jurisdiction\Repository\JurisdictionRepository;
use App\Factory\LoggerFactory;
use DomainException;
use Psr\Log\LoggerInterface;

final class CommuneUpdater
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
            ->addFileHandler('jurisdiction_updater.log')
            ->createLogger();
    }

    public function update($id, array $data): array
    {
        if (!is_numeric($id))
            throw new \DomainException('Parameter id must be a number.');

        // Input validation
        $this->validateCommuneUpdate($id, $data);


        // Update the row
        return $this->repository->update($id, $data);

        // Logging
        // $this->logger->info(sprintf('Commune updated successfully: %s', $id));
    }

    public function validateCommuneUpdate(int $id, array $data): void
    {
        if (isset($data['idJurisdiction'])) {
            $idJurisdiction = $data['idJurisdiction'];
            if (!$this->repositoryJurisdiction->existsId($idJurisdiction)) {
                throw new \DomainException(sprintf('Jurisdiction not found: %s', $idJurisdiction));
            }
        }

        if (!$this->repository->existsId($id)) {
            throw new DomainException(sprintf('Commune not found: %s', $id));
        }

        $this->communeValidator->validateUpdateCommune($data);
    }
}
