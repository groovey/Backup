<?php

namespace Groovey\Backup\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Parser;

class Backup extends Command
{
    private $app;

    public function __construct($app)
    {
        parent::__construct();

        $this->app = $app;
    }

    protected function configure()
    {
        $this
            ->setName('backup:start')
            ->setDescription('Backup the database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app      = $this->app;
        $host     = $app['db.connection']['host'];
        $database = $app['db.connection']['database'];
        $username = $app['db.connection']['username'];
        $password = $app['db.connection']['password'];






    }
}
