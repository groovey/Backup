<?php

namespace Groovey\Backup\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Yaml\Parser;
use Groovey\Migration\Migration;
use Groovey\Support\Output;

class DB extends Command
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
            ->setName('backup:db')
            ->setDescription('Backup the database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app  = $this->app;
        print_r( $app['config']);

        // $yaml = new Parser();

    }
}
