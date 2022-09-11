<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__));
$dotenv->load();

use Core\Db;


class Migration
{
    const SCRIPT_DIR = __DIR__ . '/scripts/';

    public function __construct()
    {
        try {
            $this->checkMigrationsTable();
            $this->runAllMigrations();
        } catch (PDOException $exception) {
            dd($exception->getMessage());
        }
    }

    protected function runAllMigrations()
    {
        d('Fetching migrations...');

        $migrations = scandir(self::SCRIPT_DIR);
        $migrations = array_values(array_diff($migrations, ['.', '..', 'migrations.sql']));

        foreach ($migrations as $migration) {
            d("Run [{$migration}]..");
            $script = file_get_contents(self::SCRIPT_DIR . $migration);
            $query = Db::connect()->prepare($script);
            if ($query->execute()) {
                $this->insertIntoMigrations($migration);
                d("[{$migration}] done!");
            }
        }

        d('Fetching migrations - done!');
    }

    protected function insertIntoMigrations(string $migration)
    {
        $query = Db::connect()->prepare("INSERT INTO migrations (name) VALUES (:name)");
        $query->bindParam('name', $migration);
        $query->execute();
    }

    protected function checkMigrationsTable()
    {
        $query = Db::connect()->prepare("SHOW TABLES LIKE 'migrations'");
        $query->execute();

        if (!$query->fetch()) {
            $this->createMigrationsTable();
        }
    }

    protected function createMigrationsTable()
    {
        $script = file_get_contents(self::SCRIPT_DIR . 'migrations.sql');
        $query = Db::connect()->prepare($script);
        if ($query->execute()) {
            d('#Migrations table was created');
        }
    }

} new Migration();
