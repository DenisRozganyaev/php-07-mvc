<?php

namespace App\Validators;

use App\Validators\Base\UserBaseValidator;

class UserCreateValidator extends UserBaseValidator
{
    protected array $errors = [
        'name_error' => 'The name should contain more than 2 symbols',
        'surname_error' => 'The name should contain more than 2 symbols',
        'email_error' => 'Email is invalid',
        'password_error' => 'Password is invalid',
    ];

    protected array $rules = [
        'name' => '/[A-Za-zА-Яа-я]{2,50}/',
        'surname' => '/[A-Za-zА-Яа-я]{2,50}/',
        'email' => '/^[a-zA-Z0-9.!#$%&\'*+\/\?^_`{|}~-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i',
        'password' => '/[a-zA-Z0-9.!#$%&\'*+\/\?^_`{|}~-]{8,}/'
    ];
}
