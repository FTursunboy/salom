<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ramsey\Uuid\Uuid;

class SendNewsLetterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $users;
    private string $message;

    public function __construct(array $users, string $message)
    {
        $this->users = $users;
        $this->message = $message;
    }

    public function handle(): void
    {
        foreach ($this->users as $user) {
            SmsTjJob::dispatch($user->phone, $this->message, Uuid::uuid4());
        }
    }
}
