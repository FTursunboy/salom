<?php

namespace App\Services\Common\Helpers;

class Helper
{
    public static function generateSmsCode(): string
    {
        return self::generateCode();
    }

    private static function generateCode(): string
    {
        $code = rand(0, 99999);

        return str_pad($code, 5, '0', STR_PAD_LEFT);
    }
}
