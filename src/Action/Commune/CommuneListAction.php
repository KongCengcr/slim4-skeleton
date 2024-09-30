<?php

namespace App\Action\Commune;

use App\Domain\Commune\Service\CommuneFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CommuneListAction
{
    private CommuneFinder $mainService;

    private JsonRenderer $renderer;

    public function __construct(CommuneFinder $mainService, JsonRenderer $jsonRenderer)
    {
        $this->mainService = $mainService;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            //code...
            $list = $this->mainService->list();
        } catch (\DomainException $e) {
            return $this->renderer->error($response, $e->getMessage());
        }

        // Transform result and render to json
        return $this->renderer->response($response, $list);
        // return $this->renderer->response($response, $this->transform($list));
    }
}
