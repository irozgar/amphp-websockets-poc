<?php


namespace Irozgar\WebsocketsPOC\Infrastructure\WebSocket;

use Aerys\Request;
use Aerys\Response;
use Aerys\Websocket;

class ChatWebSocket implements Websocket
{
    /** @var Websocket\Endpoint */
    private $endpoint;

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
        $this->endpoint->broadcast($body);
    }

    public function onClose(int $clientId, int $code, string $reason)
    {
    }

    public function onStop()
    {
    }
}
