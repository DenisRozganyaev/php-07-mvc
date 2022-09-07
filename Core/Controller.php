<?php

namespace Core;

abstract class Controller
{
    public function before(string $action): bool
    {
        return true;
    }

    public function after(string $action) {}
}
