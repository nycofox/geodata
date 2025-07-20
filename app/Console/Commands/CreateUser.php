<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Ask for user details
        $name = $this->ask('Enter the user name');
        $email = $this->ask('Enter the user email');
        $password = $this->secret('Enter the user password');
        $confirmPassword = $this->secret('Confirm the user password');
        if ($password !== $confirmPassword) {
            $this->error('Passwords do not match. User creation aborted.');
            return 1; // Return a non-zero exit code to indicate failure
        }
        // Create the user
        $user = \App\Models\User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password), // Hash the password
        ]);

        $this->info('User created successfully: ' . $user->name);
        $this->info('API key: ' . $user->api_token);

        return 0; // Return zero to indicate success
    }
}
