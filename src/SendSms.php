<?php

use Sipgate\Io\Example\SendSms\SipgateClient;

require_once __DIR__."/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/..");
$dotenv->load();

$tokenId = $_ENV['TOKEN_ID'];
$token = $_ENV['TOKEN'];

$smsId = $_ENV['SMS_ID'];

$message = "YOUR_MESSAGE";
$recipient = $_ENV['RECIPIENT'];

$client = new SipgateClient($tokenId, $token);

$response = $client->sendNow($message, $recipient, $smsId);
//$response = $client->sendAt($message, $recipient, $smsId, time() + 60);

echo "Status: ".$response->status();
echo "\n";
echo "Body: ".$response->body();
echo "\n";
