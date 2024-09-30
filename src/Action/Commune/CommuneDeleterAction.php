<?php

namespace App\Action\Commune;

use App\Domain\Commune\Service\CommuneDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CommuneDeleterAction
{
    private CommuneDeleter $mainService;

    private JsonRenderer $renderer;

    public function __construct(CommuneDeleter $mainService, JsonRenderer $renderer)
    {
        $this->mainService = $mainService;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        try {
            //code...
            // Fetch parameters from the request
            $id = (int)$args['id'];

            // Invoke the domain (service class)
            $this->mainService->delete($id);
        } catch (\DomainException $e) {
            return $this->renderer->error($response, $e->getMessage());
        }

        // Render the json response
        return $this->renderer->response($response, 'Commune deleted!');
    }
}
