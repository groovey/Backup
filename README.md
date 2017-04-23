# Backup

Groovey Backup Package

## Installation

    $ composer require groovey/backup

## Setup

```php
#!/usr/bin/env php
<?php

set_time_limit(0);

require_once __DIR__.'/vendor/autoload.php';

use Silex\Application;
use Groovey\Console\Providers\ConsoleServiceProvider;
use Groovey\DB\Providers\DBServiceProvider;

$app = new Application();

$app->register(new ConsoleServiceProvider(), [
        'console.name'    => 'Groovey',
        'console.version' => '1.0.0',
    ]);

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

$console = $app['console'];

$console->addCommands([
        new Groovey\Backup\Commands\About(),
        new Groovey\Backup\Commands\Export($app),
        new Groovey\Migration\Commands\Init($app),
        new Groovey\Migration\Commands\Reset($app),
        new Groovey\Migration\Commands\Listing($app),
        new Groovey\Migration\Commands\Drop($app),
        new Groovey\Migration\Commands\Status($app),
        new Groovey\Migration\Commands\Create($app),
        new Groovey\Migration\Commands\Up($app),
        new Groovey\Migration\Commands\Down($app),
    ]);

$status = $console->run();

exit($status);

```

## List of Commands

- [Export](#export)

## Export

Exports the .sql file to `./storage/backup`.

    $ groovey backup:export