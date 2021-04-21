<?php

namespace Sipgate\Io\Example\SendSms;

use Sipgate\Io\Example\SendSms\Dto\Sms;
use Zttp\Zttp;
use Zttp\ZttpResponse;

class SipgateClient
{
    protected static $BASE_URL = "https://api.sipgate.com/v2";

    protected $tokenId;
    protected $token;

    public function __construct(string $tokenId, string $token)
    {
        $this->tokenId = $tokenId;
        $this->token = $token;
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
            ->withBasicAuth($this->tokenId, $this->token)
            ->post(self::$BASE_URL."/sessions/sms", $sms->toArray());
    }
}
