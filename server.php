<?php

require_once __DIR__ .'/vendor/autoload.php';

$router = Aerys\router()
    ->get('/fizz-buzz', Aerys\websocket(new \Irozgar\WebsocketsPOC\Infrastructure\WebSocket\FizzBuzzWebSocket()));

$root = Aerys\root(__DIR__ . '/public');

return (new Aerys\Host)->use($router)->use($root);
