<?php

declare(strict_types=1);

namespace App\Handler;

use App\Handler\Contracts\JsonResponder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class HealthHandler
{
    use JsonResponder;

    public function __invoke(Request $request, Response $response): Response
    {
        return $this->json($response, ['status' => 'ok']);
    }
}
