<?php

namespace App\Core\Http;

use GuzzleHttp\Psr7\Response;

trait ControllerTrait
{
    protected function json(Response $response, mixed $data, int $status = 200): Response
    {
        $response->getBody()->write(json_encode($data) ?: '');

        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}
