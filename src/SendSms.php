<?php

use Sipgate\Io\Example\Sendsms\SipgateClient;

require_once __DIR__."/../vendor/autoload.php";

$username = "YOUR_SIPGATE_EMAIL";
$password = "YOUR_SIPGATE_PASSWORD";

$smsId = "YOUR_SIPGATE_SMS_EXTENSION";

$message = "YOUR_MESSAGE";
$recipient = "RECIPIENT_PHONE_NUMBER";

$client = new SipgateClient($username, $password);

$response = $client->sendNow($message, $recipient, $smsId);
//$response = $client->sendAt($message, $recipient, $smsId, time() + 60);

echo "Status: ".$response->status();
echo "\n";
echo "Body: ".$response->body();
echo "\n";
