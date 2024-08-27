<?php

namespace App\Gateway\Sms;

interface SmsGatewayContract
{
    public static function send($phone, $message, $txnId);
}
