<?php

namespace Core\Traits\DB;

use Core\Db;
use PDO;

trait Queryable
{
    static protected string|null $tableName = "users";

    static protected string $query = "";

    protected array $commands = [];

    public static function all(): static
    {
        static::$query = "SELECT * FROM " . static::$tableName;
        $obj = new static();
        $obj->commands[] = 'all';

        return $obj;
    }

    public static function find(int $id)
    {
        $query = "SELECT * FROM " . static::$tableName . " WHERE id=:id";

        $query = Db::connect()->prepare($query);
        $query->bindParam('id', $id, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchObject(static::class);
    }

    public static function findBy(string $column, $value)
    {
        $query = "SELECT * FROM " . static::$tableName . " WHERE {$column}=:{$column}";

        $query = Db::connect()->prepare($query);
        $query->bindParam($column, $value);
        $query->execute();

        return $query->fetchObject(static::class);
    }

    public function orderBy($column, $direction = 'ASC'): static
    {
        if ($this->allowMethod(['all', 'select'])) {
            $this->commands[] = 'order';
            static::$query .= " ORDER BY {$column} {$direction}";
        }
        return $this;
    }

    public function get()
    {
        return Db::connect()->query(static::$query)->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    protected function allowMethod(array $allowedMethods): bool
    {
        foreach ($allowedMethods as $method) {
            if (in_array($method, $this->commands)) {
                return true;
            }
        }
        return false;
    }
}
