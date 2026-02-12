<?php

declare(strict_types=1);

namespace App\Service;

use Meilisearch\Client;

final class MeiliSearchService
{
    public function __construct(private readonly Client $client)
    {
    }

    public function getTask(string $uid): array
    {
        return $this->client->getTask($uid);
    }
}
