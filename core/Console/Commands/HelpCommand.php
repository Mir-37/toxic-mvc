<?php

namespace Hellm\ToxicMvc\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MainCommand extends Command
{
    protected static $defaultDescription = 'A toxic command line tool to help you detoxify your app a little';
    protected static $defaultName = 'help';

    protected function configure(): void
    {
        $this->setHelp('This command helps you to navigate the ToxicMVC framework smoothly...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Welcome to ToxicMVC CLI!</info>');
        $output->writeln('<comment>Available Commands:</comment>');
        $output->writeln('<info> php toxic add:model</info>       Add a new model');
        $output->writeln('<info> php toxic add:controller</info>  Add a new controller');
        $output->writeln('<info> php toxic list:routes</info>     List all routes');
        $output->writeln('<info> php toxic cache:clear</info>     Clear the cache');

        return Command::SUCCESS;
    }
}
