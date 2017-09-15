<?php
declare(strict_types=1);

namespace Irozgar\WebsocketsPOC\Model\User;

class User
{
    /** @var UserId */
    private $id;

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    public function __construct(UserId $userId, string $username, string $password)
    {
        $this->id = $userId;
        $this->username = $username;
        $this->password = $password;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function password(): string
    {
        return $this->password;
    }
}
