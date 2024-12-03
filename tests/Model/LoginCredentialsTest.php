<?php

declare(strict_types=1);

namespace Janmuran\LaravelBulkUserCreator\Tests\Model;

use Janmuran\LaravelBulkUserCreator\Model\LoginCredentials;
use PHPUnit\Framework\TestCase;

class LoginCredentialsTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $email = 'test@example.com';
        $password = 'password123';
        $credentials = new LoginCredentials($email, $password);

        $this->assertSame($email, $credentials->getEmail());
        $this->assertSame($password, $credentials->getPassword());
    }

    public function testCreateFromString(): void
    {
        $importString = 'test@example.com;password123';
        $separator = ';';
        $credentials = LoginCredentials::createFromString($importString, $separator);

        $this->assertSame('test@example.com', $credentials->getEmail());
        $this->assertSame('password123', $credentials->getPassword());
    }

    public function testGetName(): void
    {
        $email = 'test@example.com';
        $password = 'password123';
        $credentials = new LoginCredentials($email, $password);

        $this->assertSame('test', $credentials->getName());
    }

    public function testIsValid(): void
    {
        $validCredentials = new LoginCredentials('test@example.com', 'password123');
        $invalidCredentials = new LoginCredentials('', '');

        $this->assertTrue($validCredentials->isValid());
        $this->assertFalse($invalidCredentials->isValid());
    }
}