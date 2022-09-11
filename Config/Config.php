<?php

namespace Config;

class Config
{
    protected static $configs = [];

    /**
     * @param string $name - db.password
     */
    public static function get(string $name)
    {
        if (empty(self::$configs)) {
            self::$configs = include __DIR__ . '/configs.php';
        }
        $keys = explode('.', $name);

        return self::findByKeys($keys, self::$configs);
    }

    protected static function findByKeys(array $keys, array $configs)
    {
        $value = null;

        if (empty($keys)) {
            return $value;
        }

        $key = array_shift($keys);

        if (array_key_exists($key, $configs)) {
            $value = is_array($configs[$key]) ? self::findByKeys($keys, $configs[$key]) : $configs[$key];
        }

        return $value;
    }
}