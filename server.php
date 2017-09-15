<?php

require_once __DIR__ .'/vendor/autoload.php';

$router = Aerys\router()
    ->get('/fizz-buzz', Aerys\websocket(new \Irozgar\WebsocketsPOC\Infrastructure\WebSocket\FizzBuzzWebSocket()))
    ->get('/chat', Aerys\websocket(new \Irozgar\WebsocketsPOC\Infrastructure\WebSocket\ChatWebSocket()))
    ->get('/chat/{channel}', Aerys\websocket(new \Irozgar\WebsocketsPOC\Infrastructure\WebSocket\ChatWithChannelsWebSocket()));

$root = Aerys\root(__DIR__ . '/public');

return (new Aerys\Host)->use($router)->use($root);
