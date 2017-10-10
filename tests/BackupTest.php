<?php

use Silex\Application;
use Groovey\Tester\Providers\TesterServiceProvider;
use Groovey\DB\Providers\DBServiceProvider;
use Groovey\Backup\Commands\About;
use Groovey\Backup\Commands\Export;
use Groovey\Migration\Commands\Init;
use Groovey\Migration\Commands\Reset;
use Groovey\Migration\Commands\Listing;
use Groovey\Migration\Commands\Drop;
use Groovey\Migration\Commands\Status;
use Groovey\Migration\Commands\Create;
use Groovey\Migration\Commands\Up;
use Groovey\Migration\Commands\Down;

class BackupTest extends PHPUnit_Framework_TestCase
{
    public $app;

    public function setUp()
    {
        $app = new Application();
        $app['debug'] = true;

        $app->register(new TesterServiceProvider());

        $app->register(new DBServiceProvider(), [
            'db.connection' => [
                'host'      => 'localhost',
                'driver'    => 'mysql',
                'database'  => 'test_backup',
                'username'  => 'root',
                'password'  => '',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
                'logging'   => true,
            ],
        ]);

        $app['tester']->add([
                new About(),
                new Export($app),
                new Init($app),
                new Reset($app),
                new Listing($app),
                new Drop($app),
                new Status($app),
                new Create($app),
                new Up($app),
                new Down($app),
            ]);

        Database::create($app);
        $this->app = $app;
    }

    public function tearDown()
    {
        Database::drop($this->app);
    }

    public function testExport()
    {
        $app     = $this->app;
        $display = $app['tester']->command('backup:export')->input('Y\n')->execute()->display();

        $this->assertRegExp('/Successfully backup file/', $display);
    }

    public function testFileExist()
    {
        $app  = $this->app;
        $file = './storage/backup/'.date('Y-m-d').'.sql';

        $this->assertFileExists($file);
    }
}
