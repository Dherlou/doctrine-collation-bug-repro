<?php

require 'vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$connection = require(__DIR__.'/migrations-db.php');
$ORMconfig = Setup::createAnnotationMetadataConfiguration(
    [__DIR__ . '/src'],
    true,
    null,
    null,
    false
);
$entityManager = EntityManager::create($connection, $ORMconfig);

return ConsoleRunner::createHelperSet($entityManager);
