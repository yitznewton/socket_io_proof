<?php

require_once __DIR__.'/vendor/autoload.php';

use EasyBib\Scholar\Message\NotecardUpdateAnnouncer;
use EasyBib\Scholar\Message\NotecardUpdateDecoder;
use EasyBib\Scholar\Repository\SqlNotecardRepository;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

$rabbitConnection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$decoder = new NotecardUpdateDecoder();
$notecardRepo = new SqlNotecardRepository();

$announcer = new NotecardUpdateAnnouncer($rabbitConnection);

$job = function ($message) use ($decoder, $notecardRepo, $announcer) {
    $messageText = $message->body;
    echo 'Processing message: ' . $messageText . "\n";
    $decodedNotecard = $decoder->decode($messageText);
    
    if ($decodedNotecard) {
        $notecardRepo->update($decodedNotecard['notecard_id'], $decodedNotecard);
    } else {
        echo "Invalid message\n";
    }

    $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
    $announcer->announce($decodedNotecard);
};

$jobsChannel = $rabbitConnection->channel();

$jobsChannel->queue_declare('scholar_notebook_work', false, true, false, false);
$jobsChannel->basic_qos(null, 1, null);
$jobsChannel->basic_consume('scholar_notebook_work', '', false, false, false, false, $job);

echo "listening for jobs on rabbit\n";

while (count($jobsChannel->callbacks)) {
    $jobsChannel->wait();
}

$jobsChannel->close();
$rabbitConnection->close();
