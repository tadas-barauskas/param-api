<?php

namespace App\Command;

use App\Service\FilterPublisher;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PublishFiltersCommand extends Command
{
    protected static $defaultName = 'app:publish-filters';
    protected static $defaultDescription = 'Collect Filtering params for articles';

    /**
     * @var FilterPublisher
     */
    private $cache;

    public function __construct(FilterPublisher $cache)
    {
        $this->cache = $cache;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->cache->refresh();

        $io->success('Filter params published');

        return Command::SUCCESS;
    }
}
