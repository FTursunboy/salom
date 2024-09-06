<?php

namespace App\Gateway\Sms;

use App\Services\Common\Helpers\Logger\Logger;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class OsonSmsGateway implements SmsGatewayContract
{
    protected static function sendRequest($method, string $url, array $parameters): array
    {
        $client = new Client();

        try {
            $response = $client->request($method, $url, [
                RequestOptions::QUERY => $parameters,
                RequestOptions::CONNECT_TIMEOUT => 30,
                RequestOptions::TIMEOUT => 10,
            ]);

            $content = $response->getBody();
            $data = json_decode($content, true);

            return [
                'error' => ($data['status'] ?? 'fatal') == 'ok',
                'code' => $response->getStatusCode(),
                'data' => $data,
            ];
        } catch (GuzzleException $e) {
            return [
                'error' => true,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function send($phone, $message, $txnId): bool
    {
        $logger = new Logger("sms", 'seeding');

        $str_hash = hash('sha256', implode(';', [$txnId, config('osonsms.login'),
            config('osonsms.sender_name'), $phone, config('osonsms.hash')]));

        $parameters = array(
            "from" => config('osonsms.sender_name'),
            "phone_number" => $phone,
            "msg" => $message,
            "str_hash" => $str_hash,
            "txn_id" => $txnId,
            "login" => config('osonsms.login'),
        );

        $logger->info('OsonSMS - request with params: ' . json_encode($parameters));

        $result = static::sendRequest("GET", config('osonsms.server_url') . '/sendsms_v1.php', $parameters);

        if ($result['error']) {
            $logger->error('OsonSMS - fatal response with params: ' . json_encode($result));
        }
        else {
            $logger->info('OsonSMS - success response with params: ' . json_encode($result));
        }

        return !$result['error'];
    }
}
