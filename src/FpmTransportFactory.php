<?php

namespace PlumeSolution\MessengerFpmTransport;

use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class FpmTransportFactory implements \Symfony\Component\Messenger\Transport\TransportFactoryInterface
{
    /**
     * @param string              $dsn
     * @param array               $options
     * @param SerializerInterface $serializer
     *
     * @return TransportInterface
     */
    public function createTransport(string $dsn, array $options, SerializerInterface $serializer): TransportInterface
    {
        return new FpmTransport($dsn, $options, $serializer);
    }

    /**
     * @param string $dsn
     * @param array  $options
     *
     * @return bool
     */
    public function supports(string $dsn, array $options): bool
    {
        return 0 === strpos($dsn, 'fpm://');
    }
}
