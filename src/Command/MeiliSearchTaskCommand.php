<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\MeiliSearchService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class MeiliSearchTaskCommand extends Command
{
    public function __construct(
        private readonly MeiliSearchService $meiliSearchService
    ) {
        parent::__construct('app:meilisearch-task');
        $this->setDescription('Detail Task Meilisearch');
        $this->addOption('uid', 'u', InputOption::VALUE_REQUIRED, 'Meilisearch task uid');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $uid = (string) $input->getOption('uid');
        if ($uid === '') {
            $output->writeln('<error>Option --uid is required.</error>');
            return Command::INVALID;
        }

        $task = $this->meiliSearchService->getTask($uid);

        $output->writeln('Task: ' . json_encode($task, JSON_THROW_ON_ERROR));

        return Command::SUCCESS;
    }
}
