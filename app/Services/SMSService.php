<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class SMSService
{
    protected $client;

    protected $config;

    public function __construct()
    {
        $this->config = (object)config('services.sms');

        $this->client = Http::baseUrl('http://api.prostor-sms.ru/messages/v2/');
    }

    private function sendRequest($action, $data = [])
    {
        $data['login'] = $this->config->login;
        $data['password'] = $this->config->password;

        // const ERROR_EMPTY_API_LOGIN = 'Empty api login not allowed';
        // const ERROR_EMPTY_API_PASSWORD = 'Empty api password not allowed';
        // const ERROR_EMPTY_RESPONSE = 'errorEmptyResponse';

        // if (empty($apiPassword))
        //     throw new Exception(self::ERROR_EMPTY_API_PASSWORD);

        foreach ($data as $key => $value)
            if (empty($value)) unset($data[$key]);

        return $this->client->post($action . '.json', $data)->body();
    }

    // "messages": [
    //     {
    //         "phone": "71234567890",
    //         "sender": "MySender",
    //         "clientId": "1",
    //         "text": "Message text here"
    //     },
    //     {
    //         "phone": "71234567891",
    //         "clientId": "2",
    //         "text": "text"
    //     }
    // ]
    public function send($messages = [], $statusQueueName = null, $scheduleTime = null, $showBillingDetails = true)
    {
        $data = [
            'scheduleTime' => $scheduleTime,
            'statusQueueName' => $statusQueueName,
            'showBillingDetails' => $showBillingDetails,
            'messages' => $messages
        ];

        return $this->sendRequest('send', $data);
    }

    // "messages": [
    //     {
    //         "smscId": "12345",
    //         "clientId": "1"
    //     },
    //     {
    //         "smscId": "12346"
    //     }
    // ]
    public function status($messages = [])
    {
        $data = [
            'messages' => $messages
        ];

        return $this->sendRequest('status', $data);
    }

    public function statusQueue($statusQueueLimit = 100, $statusQueueName = null)
    {
        $data = [
            'statusQueueLimit' => $statusQueueLimit,
            'statusQueueName' => $statusQueueName
        ];

        return $this->sendRequest('statusQueue', $data);
    }

    public function balance()
    {
        return $this->sendRequest('balance');
    }

    public function senders()
    {
        return $this->sendRequest('senders');
    }

    public function version()
    {
        return $this->sendRequest('version');
    }
}
