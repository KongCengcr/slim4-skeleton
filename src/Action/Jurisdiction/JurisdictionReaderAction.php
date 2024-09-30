<?php

namespace App\Action\Jurisdiction;

use App\Domain\Jurisdiction\Service\JurisdictionReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class JurisdictionReaderAction
{
    private JurisdictionReader $jurisdictionService;

    private JsonRenderer $renderer;

    public function __construct(JurisdictionReader $jurisdictionService, JsonRenderer $jsonRenderer)
    {
        $this->jurisdictionService = $jurisdictionService;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {

        try {        // Extract the form data from the request body
            // Fetch parameters from the request
            $id = $args['id'];
            // Invoke the domain and get the result
            $view = $this->jurisdictionService->getJurisdiction($id);
        } catch (\DomainException $e) {
            return $this->renderer->error($response, $e->getMessage());
        }

        // Transform result and render to json
        return $this->renderer->response($response, $view);
    }
}
