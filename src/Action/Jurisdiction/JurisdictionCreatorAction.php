<?php

namespace App\Action\Jurisdiction;

use App\Domain\Customer\Service\CustomerCreator;
use App\Domain\Jurisdiction\Service\JurisdictionCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class JurisdictionCreatorAction
{
    private JurisdictionCreator $jurisdictionService;

    private JsonRenderer $renderer;

    public function __construct(JurisdictionCreator $jurisdictionService, JsonRenderer $jsonRenderer)
    {
        $this->jurisdictionService = $jurisdictionService;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {        // Extract the form data from the request body
            $data = (array)$request->getParsedBody();

            // Invoke the Domain with inputs and retain the result
            $created = $this->jurisdictionService->createJurisdiction($data);
        } catch (\DomainException $e) {
            return $this->renderer->error($response, $e->getMessage());
        }

        // Transform result and render to json
        return $this->renderer->response($response, $created, StatusCodeInterface::STATUS_CREATED);
    }
}
