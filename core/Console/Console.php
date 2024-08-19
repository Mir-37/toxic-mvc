<?php

namespace Hellm\ToxicMvc\Console;

use Hellm\ToxicMvc\Console\Commands\AddControllerCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\HelpCommand;

class Console
{
    public function __construct()
    {
        $app = new Application("Toxic Php", "1.0.0");
        $app->add(new HelpCommand());
        $app->add(new AddControllerCommand());
        $app->run();
    }
}
