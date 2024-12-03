<?php

declare(strict_types=1);

namespace Janmuran\LaravelBulkUserCreator\Tests\Command;

use Illuminate\Console\OutputStyle;
use Janmuran\LaravelBulkUserCreator\Command\CreateUsersCommand;
use Janmuran\LaravelBulkUserCreator\Model\LoginCredentials;
use Janmuran\LaravelBulkUserCreator\Tests\Mock\TestUser;
use Janmuran\LaravelBulkUserCreator\Tests\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class CreateUsersCommandTest extends TestCase
{
    public function testHandle(): void
    {
        $data = "test1@example.com;password123\ntest2@example.com;password456";
        $input = new ArrayInput(['data' => $data, '--separator' => ';', '--class' => TestUser::class]);
        $output = new BufferedOutput();
        $command = new CreateUsersCommand();
        $command->setLaravel($this->app);
        $command->setInput($input);
        $command->setOutput(new OutputStyle($input, $output));

        $result = $command->handle();

        $this->assertSame(0, $result);
        $outputContent = $output->fetch();
        $this->assertStringContainsString('test1@example.com', $outputContent);
        $this->assertStringContainsString('User created', $outputContent);
        $this->assertStringContainsString('test2@example.com', $outputContent);
        $this->assertStringContainsString('User created', $outputContent);
    }

//    public function testCreateUser(): void
//    {
//        $command = new CreateUsersCommand();
//        $userCredentials = new LoginCredentials('test@example.com', 'password123');
//
//        $result = $this->invokeMethod($command, 'createUser', [$userCredentials]);
//
//        $this->assertSame('test@example.com', $result['email']);
//        $this->assertSame('User created', $result['status']);
//    }
//
//    protected function invokeMethod(&$object, $methodName, array $parameters = [])
//    {
//        $reflection = new \ReflectionClass(get_class($object));
//        $method = $reflection->getMethod($methodName);
//        $method->setAccessible(true);
//
//        return $method->invokeArgs($object, $parameters);
//    }
}