<?php

namespace Sipgate\Io\Example\Sendsms;

use Sipgate\Io\Example\Sendsms\Dto\Sms;
use Zttp\Zttp;
use Zttp\ZttpResponse;

class SipgateClient
{
    protected static $BASE_URL = "https://api.sipgate.com/v2";

    protected $username;
    protected $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function sendNow($message, $recipient, $smsId): ZttpResponse
    {
        return $this->send(
            new Sms($smsId, $message, $recipient)
        );
    }

    public function sendAt($message, $recipient, $smsId, $sendAt): ZttpResponse
    {
        return $this->send(
            new Sms($smsId, $message, $recipient, $sendAt)
        );
    }

    protected function send(Sms $sms): ZttpResponse
    {
        return Zttp::withHeaders([
                "Accept" => "application/json",
                "Content-Type" => "application/json"
            ])
            ->withBasicAuth($this->username, $this->password)
            ->post(self::$BASE_URL . "/sessions/sms", $sms->toArray());
    }
}
