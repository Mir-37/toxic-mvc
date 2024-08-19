<?php

namespace Hellm\ToxicMvc\Console\Commands;

use ConsoleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

require "constants.php";

class AddControllerCommand extends Command
{
    protected static $defaultName = 'add:controller';
    protected static $defaultDescription = 'Creates a new controller file';

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the controller')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force overwrite if the file exists');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $force = $input->getOption('force');

        $break_name = explode("\\", $name);
        $class_name = array_pop($break_name);

        $namespace = 'App\\Http\\Controller';
        if (!empty($break_name)) {
            $namespace .= '\\' . implode('\\', $break_name);
        }

        $stub_path = dirname(__DIR__) . '/Stubs/controller.stub';
        $file_path = APP_DIR . '/app/Http/Controller/' . implode(DIRECTORY_SEPARATOR, $break_name) . "/{$class_name}.php";

        if (!file_exists($stub_path)) {
            throw new ConsoleException("Error finding stub file", 404);
            $output->writeln("<error>Stub file not found: {$stub_path}</error>");
            return Command::FAILURE;
        }

        $stub_content = file_get_contents($stub_path);

        $stub_content = str_replace(
            ['{{ namespace }}', '{{ className }}'],
            [$namespace, $class_name],
            $stub_content
        );

        if (file_exists($file_path) && !$force) {
            $output->writeln("<error>File {$file_path} already exists. Use --force to overwrite.</error>");
            return Command::FAILURE;
        }

        if (!is_dir(dirname($file_path))) {
            mkdir(dirname($file_path), 0777, true);
        }

        file_put_contents($file_path, $stub_content);

        $output->writeln("<info>Controller {$class_name} created successfully.</info>");

        return Command::SUCCESS;
    }
}
