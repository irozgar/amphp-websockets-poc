<?php
declare(strict_types=1);

namespace Irozgar\WebsocketsPOC\Infrastructure\WebSocket;

use Aerys\Request;
use Aerys\Response;
use Aerys\Websocket;
use Irozgar\WebsocketsPOC\Service\FizzBuzz;

class FizzBuzzWebSocket implements Websocket
{
    /** @var Websocket\Endpoint */
    private $endpoint;

    /** @var FizzBuzz */
    private $fizzBuzz;

    public function __construct()
    {
        $this->fizzBuzz = new FizzBuzz();
    }

    public function onStart(Websocket\Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function onHandshake(Request $request, Response $response)
    {
    }

    public function onOpen(int $clientId, $handshakeData)
    {
    }

    public function onData(int $clientId, Websocket\Message $msg)
    {
        $body = yield $msg;

        $result = implode(' ', $this->fizzBuzz->run($body));

        $this->endpoint->send($result, $clientId);
    }

    public function onClose(int $clientId, int $code, string $reason)
    {
    }

    public function onStop()
    {
    }

}
