<?php

namespace Sipgate\Io\Example\SendSms\Dto;

class Sms
{
    protected $smsId;
    protected $message;
    protected $recipient;
    protected $sendAt;

    public function __construct($smsId, $message, $recipient, $sendAt = null)
    {
        $this->smsId = $smsId;
        $this->message = $message;
        $this->recipient = $recipient;
        $this->sendAt = $sendAt;
    }

    public function toArray()
    {
        return [
            "smsId" => $this->smsId,
            "message" => $this->message,
            "recipient" => $this->recipient,
            "sendAt" => $this->sendAt
        ];
    }
}
