<?php

namespace Core\Traits\DB;

use Core\Db;
use PDO;

trait Queryable
{
    static protected string|null $tableName = "";

    static protected string $query = "";

    protected array $commands = [];

    /**
     * User::select()->where()->get();
     * @param array|string[] $columns
     * @return static
     */
    public static function select(array $columns = ['*']): static
    {
        static::$query = "";
        static::$query = "SELECT " . implode(',', $columns) . " FROM " . static::$tableName . " ";
        $obj = new static();
        $obj->commands[] = 'select';

        return $obj;
    }

    public static function create(array $fields)
    {
        $vars = static::preparedQueryVars($fields);

        $query = "INSERT INTO " . static::$tableName . " ({$vars['keys']}) VALUES ({$vars['placeholders']})";
        $query = Db::connect()->prepare($query);

        $query->execute($fields);

        return (int)Db::connect()->lastInsertId();
    }

    public static function all(): static
    {
        static::$query = "SELECT * FROM " . static::$tableName;
        $obj = new static();
        $obj->commands[] = 'all';

        return $obj;
    }

    public function where(string $column, string $operator, $value): static
    {
        if (!$this->allowMethod(['select'])) {
            throw new \Exception('Wrong request');
        }

        static::$query .= " WHERE {$column}{$operator}:{$column} ";
        // ['select']
        $this->commands[] = 'where';
        // ['select', 'where']

        return $this;
    }

    public function update(array $data)
    {
        if (!$this->allowMethod(['select', 'all', 'where'])) {
            throw new \Exception('Wrong request');
        }

        if (!isset($this->id)) {
            return $this;
        }

        $query = "UPDATE " . static::$tableName . ' SET ' . static::buildPlaceholders($data) . " WHERE id=:id";
        $stmt = Db::connect()->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }

        $stmt->bindValue('id', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        return static::find($this->id);
    }

    /**
     * Post::delete(5)
     * @param int $id
     * @return bool
     */
    public static function delete(int $id)
    {
        $query = 'DELETE FROM ' . static::$tableName . ' WHERE id = :id';

        $stmt = Db::connect()->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * $post = Post::find(5)
     *  ....
     * $post->destroy();
     * @return $this|bool
     */
    public function destroy()
    {
        if (!isset($this->id)) {
            return $this;
        }

        return static::delete($this->id);
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

    protected static function preparedQueryVars(array $fields): array
    {
        $keys = array_keys($fields);
        $placeholders = preg_filter('/^/', ':', $keys);

        return [
            'keys' => implode(', ', $keys),
            'placeholders' => implode(', ', $placeholders),
        ];
    }

    private static function buildPlaceholders(array $data): string
    {
        $ps = [];

        foreach ($data as $key => $value) {
            $ps[] = " {$key}=:{$key}";
        }

        return implode(', ', $ps);
    }
}
