<?php
namespace App\Helpers;

class SessionHelper
{
    public static function authCheck(): bool
    {
        return !empty($_SESSION['user_data']);
    }

    public static function id()
    {
        return $_SESSION['user_data']['id'] ?? null;
    }

    public static function setUserData($id, ...$args)
    {
        $_SESSION['user_data'] = array_merge(
            ['id' => $id],
            ...$args
        );
    }

    public static function isAdmin(): bool
    {
        return $_SESSION['user_data']['is_admin'] ?? false;
    }

    public static function destroy()
    {
        if (session_id()) {
            session_destroy();
        }
    }
}
