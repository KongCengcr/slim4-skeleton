<?php

namespace App\Action\Commune;

use App\Domain\Commune\Service\CommuneCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CommuneCreatorAction
{
    private CommuneCreator $mainService;

    private JsonRenderer $renderer;

    public function __construct(CommuneCreator $mainService, JsonRenderer $jsonRenderer)
    {
        $this->mainService = $mainService;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {        // Extract the form data from the request body
            $data = (array)$request->getParsedBody();

            // Invoke the Domain with inputs and retain the result
            $created = $this->mainService->create($data);
        } catch (\DomainException $e) {
            return $this->renderer->error($response, $e->getMessage());
        }

        // Transform result and render to json
        return $this->renderer->response($response, $created, StatusCodeInterface::STATUS_CREATED);
    }
}
