<?php
declare(strict_types=1);

namespace Irozgar\WebsocketsPOC\Infrastructure\WebSocket;


use Aerys\Request;
use Aerys\Response;
use Aerys\Websocket;

class ChatWithChannelsWebSocket implements Websocket
{
    /** @var Websocket\Endpoint */
    private $endpoint;

    private $channels = [];
    private $connections = [];

    public function onStart(Websocket\Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function onHandshake(Request $request, Response $response)
    {
        $matches = null;
        if (!preg_match('/\/chat\/([A-z\-0-9]+)$/', $request->getUri(), $matches)) {
            $response->setStatus(404);
            $response->end("Room not found");
            return null;
        }

        return $matches[1];
    }

    public function onOpen(int $clientId, $handshakeData)
    {
        if (isset($this->connections[$clientId])) {
            unset($this->channels[$this->connections[$clientId]][$clientId]);
        }

        $this->connections[$clientId] = $handshakeData;
        $this->channels[$handshakeData][$clientId] = true;
    }

    public function onData(int $clientId, Websocket\Message $msg)
    {
        $body = yield $msg;

        $channel = $this->connections[$clientId];
        $receivers = array_keys($this->channels[$channel]);

        $this->endpoint->multicast($body, $receivers);
    }

    public function onClose(int $clientId, int $code, string $reason)
    {
        $channel = $this->connections[$clientId];
        unset($this->connections[$clientId]);
        unset($this->channels[$channel][$clientId]);

        if (count($this->channels[$channel]) === 0) {
            unset($this->channels[$channel]);
        }
    }

    public function onStop()
    {
    }
}
