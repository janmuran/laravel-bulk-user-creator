<?php

declare(strict_types=1);

namespace Janmuran\LaravelBulkUserCreator\Command;

use Illuminate\Auth\Authenticatable;
use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Janmuran\LaravelBulkUserCreator\Model\LoginCredentials;

class CreateUsersCommand extends Command
{
    /**
     * @var class-string<Authenticatable>
     */
    private string $user = User::class;

    /**
     * @var string
     */
    protected $signature = 'create:users {data} {--separator=;} {--class=}';

    /**
     * @var string
     */
    protected $description = 'Command create users base on config';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function handle()
    {
        $this->setUserClass();
        $usersData = $this->getUserData();
        $progressBar = $this->output->createProgressBar(count($usersData));

        $report = [];
        foreach ($usersData as $userData) {
            $report[] = $this->createUser($userData);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
        $this->table(['Email', 'Status'], $report);

        return Command::SUCCESS;
    }

    /**
     * @return array{email: string, status: string}
     */
    private function createUser(LoginCredentials $userCredentials): array
    {
        if (!$userCredentials->isValid()) {
            return [
                'email' => $userCredentials->getEmail(),
                'status' => 'Empty email or password',
            ];
        }

        $existingUser = $this->user::where('email', $userCredentials->getEmail())->first();
        if ($existingUser !== null) {
            return [
                'email' => $userCredentials->getEmail(),
                'status' => 'User already exists',
            ];
        }

        $this->user::create([
            'name' => $userCredentials->getName(),
            'email' => $userCredentials->getEmail(),
            'password' => Hash::make($userCredentials->getPassword()),
        ]);

        return [
            'email' => $userCredentials->getEmail(),
            'status' => 'User created',
        ];
    }

    /**
     * @return array<LoginCredentials>
     */
    private function getUserData(): array
    {
        $data = trim($this->argument('data'));
        $separator = $this->option('separator');
        $lines = explode("\n", $data);

        return array_map(
            static function (string $line) use ($separator): LoginCredentials {
                return LoginCredentials::createFromString($line, $separator);
            },
            $lines,
        );
    }

    private function setUserClass(): void
    {
        $class = $this->option('class');
        if ($class === null) {
            return;
        }

        $this->user = $class;
    }
}
