<?php

namespace App\Validators\Base;

use App\Models\User;

class UserBaseValidator extends BaseValidator
{
    public function checkEmailOnExists(string $email): bool|User
    {
        return User::findBy('email', $email);
    }
}
