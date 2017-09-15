<?php
declare(strict_types=1);

namespace Irozgar\WebsocketsPOC\Service;

use Irozgar\WebsocketsPOC\Model\Authenication\TokenInterface;

interface Authenticator
{
    public function authenticate(string $username, string $password): TokenInterface;
}
