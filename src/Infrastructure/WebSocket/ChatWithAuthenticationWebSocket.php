<?php
declare(strict_types=1);

namespace Irozgar\WebsocketsPOC\Infrastructure\WebSocket;


use Aerys\Request;
use Aerys\Response;
use Aerys\Websocket;
use Irozgar\WebsocketsPOC\Exception\BadCredentials;
use Irozgar\WebsocketsPOC\Model\Authenication\TokenInterface;
use Irozgar\WebsocketsPOC\Service\Authenticator;

class ChatWithAuthenticationWebSocket implements Websocket
{
    /** @var Websocket\Endpoint */
    private $endpoint;
    /** @var Authenticator */
    private $authenticator;

    /** @var TokenInterface[] */
    private $connections;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function onStart(Websocket\Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function onHandshake(Request $request, Response $response)
    {
        $username = $request->getParam('username');
        $password = $request->getParam('password');

        if ($username === null || $password === null) {
            $response->setStatus(403);
            $response->end('Username and password are required');

            return null;
        }

        try {
            $token = $this->authenticator->authenticate($username, $password);
        } catch (BadCredentials $exception) {
            $response->setStatus(401);
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
        $body = json_decode(yield $msg, true);

        $user = $this->connections[$clientId]->user();

        if (!method_exists($user, 'username')) {
            throw new \RuntimeException(sprintf('The class "%s" has no method called "%s"', get_class($user), 'username'));
        }

        $body['username'] = $user->username();

        $this->endpoint->broadcast($body);
    }

    public function onClose(int $clientId, int $code, string $reason)
    {
        unset($this->connections[$clientId]);
    }

    public function onStop()
    {
    }
}
