<?php

use Sipgate\Io\Example\SendSms\SipgateClient;

require_once __DIR__."/../vendor/autoload.php";

$tokenId = "YOUR_SIPGATE_TOKEN_ID";
$token = "YOUR_SIPGATE_TOKEN";

$smsId = "YOUR_SIPGATE_SMS_EXTENSION";

$message = "YOUR_MESSAGE";
$recipient = "RECIPIENT_PHONE_NUMBER";

$client = new SipgateClient($tokenId, $token);

$response = $client->sendNow($message, $recipient, $smsId);
//$response = $client->sendAt($message, $recipient, $smsId, time() + 60);

echo "Status: ".$response->status();
echo "\n";
echo "Body: ".$response->body();
echo "\n";
