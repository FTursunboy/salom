<?php

namespace App\Jobs;

use App\Gateway\Sms\SmsGatewayContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class  SmsTjJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $phone;
    protected string $message;
    protected string $txtId;
    protected SmsGatewayContract $smsGateway;

    public function __construct(string $phone, string $message, string $txtId)
    {
        $this->phone = $phone;
        $this->txtId = $txtId;
        $this->message = $message;
        $this->smsGateway = \App::make(SmsGatewayContract::class);
    }

    public function handle(): void
    {
        $this->smsGateway::send($this->phone, $this->message, $this->txtId);
    }
}
