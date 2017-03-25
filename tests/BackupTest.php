<?php

use Silex\Application;
use Groovey\Tester\Providers\TesterServiceProvider;
use Groovey\Backup\Commands\About;
use Groovey\Backup\Commands\Init;

class BackupTest extends PHPUnit_Framework_TestCase
{
    public $app;

    public function setUp()
    {
        $app = new Application();
        $app['debug'] = true;

        $app->register(new ConfigServiceProvider(), [
                'config.path'        => __DIR__.'/../config',
                'config.environment' => 'localhost',
            ]);

        $app->register(new TesterServiceProvider());

        $app['tester']->add([
                new About(),
                new Init($app),
            ]);

        $this->app = $app;
    }

    public function testAbout()
    {
        $app = $this->app;
        $display = $app['tester']->command('backup:about')->execute()->display();
        $this->assertRegExp('/Groovey/', $display);
    }

    // public function testInit()
    // {
    //     $app = $this->app;
    //     $display = $app['tester']->command('migrate:init')->execute()->display();
    //     $this->assertRegExp('/Sucessfully/', $display);
    // }

    // public function testReset()
    // {
    //     $app = $this->app;
    //     $display = $app['tester']->command('migrate:reset')->input('Y\n')->execute()->display();
    //     $this->assertRegExp('/All migration entries has been cleared/', $display);
    // }

    // public function testStatus()
    // {
    //     $app = $this->app;
    //     $display = $app['tester']->command('migrate:status')->execute()->display();
    //     $this->assertRegExp('/Unmigrated YML/', $display);
    //     $this->assertRegExp('/001/', $display);
    //     $this->assertRegExp('/002/', $display);
    // }

    // public function testUp()
    // {
    //     $app = $this->app;
    //     $display = $app['tester']->command('migrate:up')->input('Y\n')->execute()->display();
    //     $this->assertRegExp('/001/', $display);
    //     $this->assertRegExp('/002/', $display);
    // }

    // public function testListing()
    // {
    //     $app = $this->app;
    //     $display = $app['tester']->command('migrate:list')->execute()->display();
    //     $this->assertRegExp('/Version/', $display);
    //     $this->assertRegExp('/001/', $display);
    //     $this->assertRegExp('/002/', $display);
    // }

    // public function testDown()
    // {
    //     $app = $this->app;
    //     $display = $app['tester']->command('migrate:down')->input('Y\n')->execute(['version' => '001'])->display();
    //     $this->assertRegExp('/Downgrading/', $display);
    // }

    // public function testDrop()
    // {
    //     $app = $this->app;
    //     $display = $app['tester']->command('migrate:drop')->input('Y\n')->execute()->display();
    //     $this->assertRegExp('/Migrations table has been deleted/', $display);
    // }
}
