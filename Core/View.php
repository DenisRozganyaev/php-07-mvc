<?php

namespace Core;

class View
{
    public static function render($view, $args = [])
    {
        /**
         *  $args = ['name' => 'Denys', 'age' => 20]
         */
        extract($args, EXTR_SKIP);
        /**
         * $name = "Denys";
         * $age = 20;
         */
        // VIEW_DIR . 'auth/register.php';
        // /Users/drozg/Sites/php-07-mvc/App/Views/auth/register.php
        $file = VIEW_DIR . $view . '.php';

        if (!is_readable($file)) {
            throw new \Exception("[{$file}] not found", 404);
        }

//      require /Users/drozg/Sites/php-07-mvc/App/Views/auth/register.php;
        require $file;
    }
}
