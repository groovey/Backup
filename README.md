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

use Symfony\Component\Console\Application;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'test_migration',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'    => '',
], 'default');

$capsule->bootEloquent();
$capsule->setAsGlobal();

$container['db'] = $capsule;

$app = new Application();

$app->addCommands([
        new Groovey\Backup\Commands\About(),
        new Groovey\Backup\Commands\Backup($container),
    ]);

$status = $app->run();

exit($status);
```

## List of Commands

- [DB](#db)

## DB

Backups your database on a directory relative to your root folder `./database/migrations`.

    $ groovey backup:db