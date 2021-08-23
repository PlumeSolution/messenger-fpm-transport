<?php

namespace PlumeSolution\MessengerFpmTransport;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class FpmMessageHandler
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function handle(array $message): Envelope
    {
        return $this->serializer->decode($message);
    }
}
