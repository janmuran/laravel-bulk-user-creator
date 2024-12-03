<?php

declare(strict_types=1);

namespace Janmuran\LaravelBulkUserCreator\Model;

class LoginCredentials
{
    private string $email;
    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public static function createFromString(string $importString, string $separator): self
    {
        $parts = explode($separator, $importString);
        return new self(
            $parts[0] ?? '',
            $parts[1] ?? '',
        );
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getName(): string
    {
        $parts = explode('@', $this->email);

        return $parts[0] ?? '';
    }
    
    public function isValid(): bool
    {
        return $this->email !== '' && $this->password !== '';
    }
}