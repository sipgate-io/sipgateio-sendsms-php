<?php

namespace Sipgate\Io\Example\Sendsms\Dto;

use Tightenco\Collect\Contracts\Support\Arrayable;

class Sms implements Arrayable {
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

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'smsId' => $this->smsId,
            'message' => $this->message,
            'recipient' => $this->recipient,
            'sendAt' => $this->sendAt
        ];
    }
}
