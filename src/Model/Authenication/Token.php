<?php
declare(strict_types=1);

namespace Irozgar\WebsocketsPOC\Model\Authenication;

use Irozgar\WebsocketsPOC\Model\User\User;

class Token
{
    /** @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function user(): User
    {
        return $this->user;
    }
}
