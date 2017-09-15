<?php
declare(strict_types=1);

namespace Irozgar\WebsocketsPOC\Infrastructure\WebSocket;

use Aerys\Request;
use Aerys\Response;
use Aerys\Websocket;
use Irozgar\WebsocketsPOC\Exception\BadCredentials;
use Irozgar\WebsocketsPOC\Service\SimpleAuthenticator;
use Irozgar\WebsocketsPOC\Service\FizzBuzz;

class MyWebSocket implements Websocket
{
    /** @var SimpleAuthenticator */
    private $authenticator;

    /** @var Websocket\Endpoint */
    private $endpoint;

    /** @var array */
    private $connections;

    public function __construct(SimpleAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function onStart(Websocket\Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
        $this->connections = [];
    }

    public function onHandshake(Request $request, Response $response)
    {
        $username = $request->getParam('username');
        $password = $request->getParam('password');

        if (!is_string($username) || !is_string($password)) {
            $response->setStatus(403);
            $response->end('Both username and password are required');
            return null;
        }

        try {
            $token = $this->authenticator->authenticate(
                $username,
                $password
            );
            var_dump($token);
        } catch (BadCredentials $exception) {
            $response->setStatus(403);
            $response->end($exception->getMessage());

            return null;
        }

        return $token;
    }

    public function onOpen(int $clientId, $handshakeData)
    {
        $this->connections[$clientId] = $handshakeData;
    }

    public function onData(int $clientId, Websocket\Message $msg)
    {
        $body = yield $msg;

        $fizzBuzz = new FizzBuzz();
        $result = implode(' ', $fizzBuzz->run($body));

        $this->endpoint->send($result, $clientId);
    }

    public function onClose(int $clientId, int $code, string $reason)
    {
        unset($this->connections[$clientId]);
    }

    public function onStop()
    {
    }

}
