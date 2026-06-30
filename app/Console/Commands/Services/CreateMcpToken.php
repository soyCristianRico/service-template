<?php

declare(strict_types=1);

namespace App\Console\Commands\Services;

use App\Models\User;
use Illuminate\Console\Command;

class CreateMcpToken extends Command
{
    protected $signature = 'services:mcp-token
        {--email= : Email of the user to issue the token to (defaults to the first admin user)}
        {--name=mcp-cli : Token label}';

    protected $description = 'Issue a Sanctum personal access token for the MCP server.';

    public function handle(): int
    {
        $email = (string) $this->option('email');
        $user = $email !== ''
            ? User::where('email', $email)->first()
            : User::orderBy('id')->first();

        if (! $user instanceof User) {
            $this->error($email !== ''
                ? "No user found with email {$email}"
                : 'No users found. Run db:seed or create one first.');

            return self::FAILURE;
        }

        $token = $user->createToken((string) $this->option('name'));

        $this->info("Token issued for {$user->email}");
        $this->newLine();
        $this->line('Add this to your MCP client (e.g. claude_desktop_config.json) as a Bearer token:');
        $this->newLine();
        $this->line($token->plainTextToken);
        $this->newLine();
        $this->warn('This is the only time the token is shown in plain text. Store it now.');

        return self::SUCCESS;
    }
}
