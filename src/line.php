<?php
$channelAccessToken = getenv('CAtoken');
$channelSecret = getenv('Csecret');

use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\Constant\HTTPHeader;

require_once(__DIR__ . "../vendor/autoload.php");

if (isset($_SERVER["HTTP_" . HTTPHeader::LINE_SIGNATURE])) {

    $message = file_get_contents("php://input");

    $httpClient = new CurlHTTPClient($channelAccessToken);
    $Bot = new LINEBot($httpClient, ['channelSecret' => $channelSecret]);
    $signature = $_SERVER["HTTP_" . HTTPHeader::LINE_SIGNATURE];
    $events = $Bot->parseEventRequest($message, $signature);

    foreach($events as $event){
        $SendMessage = new MultiMessageBuilder();
        $TextMessageBuilder = new TextMessageBuilder("Hi");
        $SendMessage->add($TextMessageBuilder);
        $Bot->replyMessage($event->getReplyToken(), $SendMessage);
    }
}


