<?php
require __DIR__.'/vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


$connection = DriverManager::getConnection(
    ['url' => "mysql://{$_ENV['DB_USER']}:{$_ENV['DB_PASSWORD']}@{$_ENV['DB_HOST']}:3306/{$_ENV['DB_NAME']}?serverVersion=8.0"]
);
$connection->executeQuery('CREATE TABLE IF NOT EXISTS Test (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) COLLATE `utf8mb4_unicode_ci` NOT NULL, PRIMARY KEY(id)) DEFAULT COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;');
$schemaManager = $connection->createSchemaManager();
$fromSchema = $schemaManager->createSchema();

$toSchema = new Schema([], [], $schemaManager->createSchemaConfig());
$table = $toSchema->createTable('test');
$table->addColumn(
    'id',
    Types::INTEGER,
    [
        'autoincrement' => true
    ]
);
$table->setPrimaryKey(["id"]);
$table->addColumn(
    'name',
    Types::STRING,
    [
        'length' => 255,
        'notnull' => true,
        'platformOptions' => [
            'version' => false
        ],
        'customSchemaOptions' => [
            // 'charset' => 'utf8mb4', // this is the workaround. uncommenting it results in no diff
            'collation' => 'utf8mb4_unicode_ci'
        ]
    ]
);

$up = $schemaManager->createComparator()->compareSchemas($fromSchema, $toSchema);
$diffSql = $up->toSql($connection->getDatabasePlatform());
echo("Up Diffs:\n");
var_dump($diffSql);

$down = $schemaManager->createComparator()->compareSchemas($toSchema, $fromSchema);
$diffSql = $down->toSql($connection->getDatabasePlatform());
echo("Down Diffs:\n");
var_dump($diffSql);
?>