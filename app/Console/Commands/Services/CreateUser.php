<?php

declare(strict_types=1);

namespace App\Console\Commands\Services;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateUser extends Command
{
    protected $signature = 'services:create-user
        {--name= : Display name for the user}
        {--email= : Email address (must be unique)}
        {--password= : Plain password (prompted securely if omitted)}';

    protected $description = 'Create a user (e.g. for admin access and MCP tokens).';

    public function handle(): int
    {
        $name = (string) ($this->option('name') ?: text(
            label: 'Name',
            required: true,
        ));

        $email = (string) ($this->option('email') ?: text(
            label: 'Email',
            required: true,
        ));

        $plainPassword = (string) ($this->option('password') ?: password(
            label: 'Password',
            required: true,
        ));

        try {
            $this->validate($name, $email, $plainPassword);
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    $this->error($message);
                }
            }

            return self::FAILURE;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($plainPassword),
            'email_verified_at' => now(),
        ]);

        $this->info("User created: {$user->email} (#{$user->id})");
        $this->newLine();
        $this->line('Issue an MCP token with:');
        $this->line("  php artisan services:mcp-token --email={$user->email}");

        return self::SUCCESS;
    }

    /**
     * @throws ValidationException
     */
    protected function validate(string $name, string $email, string $plainPassword): void
    {
        validator(
            ['name' => $name, 'email' => $email, 'password' => $plainPassword],
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', Password::default()],
            ],
        )->validate();
    }
}
