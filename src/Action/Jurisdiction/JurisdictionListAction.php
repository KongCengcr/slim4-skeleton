<?php

namespace App\Action\Jurisdiction;

use App\Domain\Jurisdiction\Data\JurisdictionFinderResult;
use App\Domain\Jurisdiction\Service\JurisdictionFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class JurisdictionListAction
{
    private JurisdictionFinder $jurisdictionService;

    private JsonRenderer $renderer;

    public function __construct(JurisdictionFinder $jurisdictionService, JsonRenderer $jsonRenderer)
    {
        $this->jurisdictionService = $jurisdictionService;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            //code...
            $list = $this->jurisdictionService->listJurisdiction();
        } catch (\DomainException $e) {
            return $this->renderer->error($response, $e->getMessage());
        }

        // Transform result and render to json
        return $this->renderer->response($response, $list);
        // return $this->renderer->response($response, $this->transform($list));
    }
}
