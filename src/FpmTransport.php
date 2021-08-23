<?php

namespace PlumeSolution\MessengerFpmTransport;

use Enqueue\Dsn\Dsn;
use hollodotme\FastCGI\Client;
use hollodotme\FastCGI\Requests\PostRequest;
use hollodotme\FastCGI\SocketConnections\NetworkSocket;
use Interop\Queue\Exception\Exception;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\TransportException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\SetupableTransportInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

/**
 *
 */
class FpmTransport implements TransportInterface
{
    private Client $client;
    private Dsn $dsn;
    private array $options;
    private SerializerInterface $serializer;

    public function __construct(string $dsn, array $options, SerializerInterface $serializer)
    {
        $this->client = new Client();
        $this->dsn = Dsn::parseFirst($dsn);
        $this->options = $options;
        $this->serializer = $serializer;
        $this->connection = new NetworkSocket($this->dsn->getHost(), $this->dsn->getPort());
    }

    /**
     * @return iterable
     * @throws FpmTransportException
     */
    public function get(): iterable
    {
        throw new FpmTransportException('You cannot get from FPM');
    }

    /**
     * @param Envelope $envelope
     */
    public function ack(Envelope $envelope): void
    {
        throw new FpmTransportException('You cannot acknowledge from FPM');
    }

    /**
     * @param Envelope $envelope
     */
    public function reject(Envelope $envelope): void
    {
        throw new FpmTransportException('You cannot reject FPM message');
    }

    /**
     * @param Envelope $envelope
     *
     * @return Envelope
     */
    public function send(Envelope $envelope): Envelope
    {
        $request = new PostRequest('index.php', http_build_query(['message' => $this->serializer->encode($envelope)]));

        try {
            $this->client->sendAsyncRequest($this->connection, $request);
        } catch (\Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode(), $e);
        }

        return $envelope;
    }
}
