<?php

namespace App\Action\Commune;

use App\Domain\Commune\Service\CommuneReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CommuneReaderAction
{
    private CommuneReader $mainService;

    private JsonRenderer $renderer;

    public function __construct(CommuneReader $mainService, JsonRenderer $jsonRenderer)
    {
        $this->mainService = $mainService;
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
            $view = $this->mainService->getCommune($id);
        } catch (\DomainException $e) {
            return $this->renderer->error($response, $e->getMessage());
        }

        // Transform result and render to json
        return $this->renderer->response($response, $view);
    }
}
