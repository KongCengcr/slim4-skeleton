<?php

namespace App\Action\Jurisdiction;

use App\Domain\Jurisdiction\Service\JurisdictionUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class JurisdictionUpdaterAction
{
    private JurisdictionUpdater $mainService;

    private JsonRenderer $renderer;

    public function __construct(JurisdictionUpdater $mainService, JsonRenderer $jsonRenderer)
    {
        $this->mainService = $mainService;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        try {
            // Extract the form data from the request body
            $id = $args['id'];
            $data = (array)$request->getParsedBody();

            // Invoke the Domain with inputs and retain the result
            $update = $this->mainService->update($id, $data);
        } catch (\DomainException $e) {
            return $this->renderer->error($response, $e->getMessage());
        }

        // Build the HTTP response
        return $this->renderer->response($response, $update);
    }
}
