<?php

namespace App\Http;

use App\Core\Http\ControllerTrait;
use GuzzleHttp\Psr7\Response;
use PDO;

class HomeController {
    use ControllerTrait;

    public function index(Response $response, PDO $db): Response
    {
        return $this->json($response, [
            'status' => 'ok',
        ]);
    }
}
