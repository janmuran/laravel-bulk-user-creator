<?php

declare(strict_types=1);

namespace Janmuran\LaravelBulkUserCreator\Tests\Mock;

use Illuminate\Foundation\Auth\User;

class TestUser extends User
{
    public static function create(array $attributes = []): self
    {
        return new self($attributes);
    }
}