<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\Audit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateAdmin extends Command
{
    protected $signature = 'origina:admin';

    protected $description = 'Interactively provision a verified administrator without a default password';

    public function handle(): int
    {
        $data = ['name' => $this->ask('Full name'), 'email' => strtolower((string) $this->ask('Email address')), 'password' => $this->secret('Password (12+ characters, letters and numbers)')];
        $validator = Validator::make($data, ['name' => 'required|string|max:100', 'email' => 'required|email|max:254|unique:users,email', 'password' => ['required', Password::min(12)->letters()->numbers()]]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

return self::FAILURE;
        }
        DB::transaction(function () use ($data): void {
            $user = User::create($data);
            $user->forceFill(['role' => 'admin', 'email_verified_at' => now()])->save();
            Audit::record('admin.provisioned', $user);
        });
        $this->info('Administrator created. Sign in using the supplied credentials.');

        return self::SUCCESS;
    }
}
