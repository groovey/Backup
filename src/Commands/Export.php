<?php

namespace Groovey\Backup\Commands;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Export extends Command
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
            ->setName('backup:export')
            ->setDescription('Backup the database.')
            ->addArgument('destination', InputArgument::OPTIONAL, 'The storage location of your backup sql files.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app         = $this->app;
        $host        = $app['db.connection']['host'];
        $database    = $app['db.connection']['database'];
        $username    = $app['db.connection']['username'];
        $password    = $app['db.connection']['password'];
        $destination = $input->getArgument('destination');

        if (!$destination) {
            $destination = './storage/backup/';
        }

        $destination = $destination.date('Y-m-d').'.sql';

        $command = "mysqldump --user={$username} --password={$password} --host={$host} $database > $destination";

        $process = new Process($command);
        $process->setTimeout(999999999);
        $process->run();

        while ($process->isRunning()) {
            $output->writeln('<comment>Please wait for mysqldump to finish.</comment>');
        }

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        } else {
            $output->writeln('<info>Successfully backup file.</info>');
            $output->writeln("<info>Please check destination folder at ($destination)</info>");
        }
    }
}
