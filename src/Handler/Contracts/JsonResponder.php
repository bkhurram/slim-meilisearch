<?php

declare(strict_types=1);

namespace App\Handler\Contracts;

use Psr\Http\Message\ResponseInterface;

trait JsonResponder
{
    /** @param array<string, mixed> $payload */
    private function json(ResponseInterface $response, array $payload, int $status = 200): ResponseInterface
    {
        $response->getBody()->write(json_encode($payload, JSON_THROW_ON_ERROR));

        return $response->withStatus($status)
                ->withHeader('Content-Type', 'application/json');
    }
}
