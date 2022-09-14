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
        $migrations = array_values(array_diff($migrations, ['.', '..', '0_migrations.sql']));

        foreach ($migrations as $migration) {
            $table = preg_replace('/[\d_]+/i', '', $migration);
            if (!$this->checkIfMigrationWasRun($table)) {
                d("Run [{$table}]..");
                $script = file_get_contents(self::SCRIPT_DIR . $migration);
                $query = Db::connect()->prepare($script);
                if ($query->execute()) {
                    $this->insertIntoMigrations($table);
                    d("[{$table}] done!");
                }
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

    protected function checkIfMigrationWasRun(string $migration): bool
    {
        $query = Db::connect()->prepare("SELECT * FROM migrations WHERE name = :name");
        $query->bindParam('name', $migration);
        $query->execute();

        return (bool) $query->fetch();
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
