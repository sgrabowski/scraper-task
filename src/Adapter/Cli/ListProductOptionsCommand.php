<?php

namespace App\Adapter\Cli;

use App\Application\Service\SortedProductOptionsPresenter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListProductOptionsCommand extends Command
{
    protected static $defaultName = 'app:list-options';

    public function __construct(private readonly SortedProductOptionsPresenter $optionsPresenter)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Lists product options, most expensive (annually) first');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->optionsPresenter->present());

        return self::SUCCESS;
    }
}