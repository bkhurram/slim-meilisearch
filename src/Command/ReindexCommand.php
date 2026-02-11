<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\ProductService;
use App\Service\SearchService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ReindexCommand extends Command
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly SearchService $searchService
    ) {
        parent::__construct('app:reindex');
        $this->setDescription('Reindex products into Meilisearch');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $products = $this->productService->productsForIndexing();
        $task = $this->searchService->reindexProducts($products);

        $output->writeln(sprintf('Reindex requested. Products: %d', count($products)));
        $output->writeln('Task: ' . json_encode($task, JSON_THROW_ON_ERROR));

        return Command::SUCCESS;
    }
}
