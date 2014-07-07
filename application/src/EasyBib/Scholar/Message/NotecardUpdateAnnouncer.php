<?php

namespace EasyBib\Scholar\Message;

use PhpAmqpLib\Message\AMQPMessage;

class NotecardUpdateAnnouncer
{
    const CHANNEL_NAME = 'notecard_updates';

    private $channel;

    public function __construct($connection)
    {
        $this->channel = $connection->channel();
        $this->channel->exchange_declare(self::CHANNEL_NAME, 'fanout', false, false, false);
    }

    public function announce(array $data)
    {
        $json = json_encode($data);
        printf("Broadcasting to rabbit %s: %s\n", self::CHANNEL_NAME, $json);
        $message = new AMQPMessage($json);
        $this->channel->basic_publish($message, self::CHANNEL_NAME);
    }
}
