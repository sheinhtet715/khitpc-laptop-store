<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetSuperadminPassword extends Command
{
    // 1. The exact command you will type in the terminal
    protected $signature = 'superadmin:reset {email}';

    // 2. A short description of what it does
    protected $description = 'Emergency command to reset a Superadmin password directly from the server.';

    public function handle()
    {
        // Grab the email you typed in the terminal
        $email = $this->argument('email');

        // Find the user, BUT ensure they actually have the 'superadmin' role!
        $superadmin = User::where('email', $email)->where('role', 'superadmin')->first();

        if (!$superadmin) {
            $this->error("Failed: No Superadmin found with the email '{$email}'.");
            return Command::FAILURE;
        }

        // Ask you to type the new password securely (it will be invisible as you type)
        $newPassword = $this->secret('Enter the new emergency password for this Superadmin:');

        // Ask you to confirm it
        $confirmPassword = $this->secret('Confirm the new password:');

        // Validation checks
        if ($newPassword !== $confirmPassword) {
            $this->error('Failed: Passwords do not match. Try again.');
            return Command::FAILURE;
        }

        if (strlen($newPassword) < 8) {
            $this->error('Failed: Password must be at least 8 characters for security.');
            return Command::FAILURE;
        }

        // Overwrite the old password in the database
        $superadmin->update([
            'password' => Hash::make($newPassword)
        ]);

        $this->info("Success! The password for Superadmin ({$email}) has been forcibly reset.");

        return Command::SUCCESS;
    }
}
