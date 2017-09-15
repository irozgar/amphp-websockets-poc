<?php

require_once __DIR__ .'/vendor/autoload.php';


$userRepository = new \Irozgar\WebsocketsPOC\Infrastructure\Model\User\InMemoryUserRepository([
    new Irozgar\WebsocketsPOC\Model\User\User(
        \Irozgar\WebsocketsPOC\Model\User\UserId::generate(),
        'John',
        'secure_password'
    )
]);

$authenticator = new \Irozgar\WebsocketsPOC\Service\SimpleAuthenticator($userRepository);

$router = Aerys\router()
    ->get('/fizz-buzz', Aerys\websocket(new \Irozgar\WebsocketsPOC\Infrastructure\WebSocket\FizzBuzzWebSocket()))
    ->get('/chat', Aerys\websocket(new \Irozgar\WebsocketsPOC\Infrastructure\WebSocket\ChatWebSocket()))
    ->get('/chat/{channel}', Aerys\websocket(new \Irozgar\WebsocketsPOC\Infrastructure\WebSocket\ChatWithChannelsWebSocket()))
    ->get('/chat-auth', Aerys\websocket(new \Irozgar\WebsocketsPOC\Infrastructure\WebSocket\ChatWithAuthenticationWebSocket($authenticator)));

$root = Aerys\root(__DIR__ . '/public');

return (new Aerys\Host)->use($router)->use($root);
