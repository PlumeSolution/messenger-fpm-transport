<?php

namespace PlumeSolution\MessengerFpmTransport;

use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class FpmTransportFactory implements \Symfony\Component\Messenger\Transport\TransportFactoryInterface
{
    public function createTransport(string $dsn, array $options, SerializerInterface $serializer): TransportInterface
    {
        // TODO: Implement createTransport() method.
    }

    public function supports(string $dsn, array $options): bool
    {
        // TODO: Implement supports() method.
    }
}
