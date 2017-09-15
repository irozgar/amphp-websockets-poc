<?php

require_once __DIR__ .'/vendor/autoload.php';

$userRepository = new \TDF\Websockets\Infrastructure\Model\User\InMemoryUserRepository([
    new Irozgar\Websockets\Model\User\User(
        \Irozgar\Websockets\Model\User\UserId::generate(),
        'John',
        'secure_password'
    )
]);

$authenticator = new \Irozgar\Websockets\Service\Authenticator($userRepository);

try {
    $token = $authenticator->authenticate('John', 'secure_password');
} catch (\TDF\Websockets\Exception\BadCredentials $exception) {
    echo $exception->getMessage() . PHP_EOL;
    exit(1);
}

var_dump($token);
