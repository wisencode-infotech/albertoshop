<?php

namespace App\Jobs;

use App\Mail\NewCreatedUserMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessUserBatch implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $rows;
    protected $header;

    /**
     * Create a new job instance.
     */
    public function __construct(array $rows, array $header)
    {
        $this->rows = $rows;
        $this->header = $header;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        foreach ($this->rows as $key => $row) {
            $name = $row[0] ?? null;
            // $email = $row[1] ?? null;
            $email = 'test@gmail.com';
            $phone = $row[2] ?? null;

            if (!$name || !$email || !$phone) {
                continue; // Skip invalid rows
            }

            // Insert or update the user in the database
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'phone' => $phone,
                    'password' => Hash::make(str()->random(8)),
                    'user_role_id' => 2,
                ]
            );

            // Generate password reset token
            $token = Password::createToken($user);
            $base_url = request()->getSchemeAndHttpHost();

            // Queue email sending
            Mail::to($email)->queue(new NewCreatedUserMail($token, $base_url));
        }
    }
}
