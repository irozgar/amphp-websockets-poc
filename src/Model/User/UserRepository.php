<?php
declare(strict_types=1);

namespace Irozgar\WebsocketsPOC\Model\User;

interface UserRepository
{
    public function find(UserId $id): ?User;

    public function findWithUsername(string $username): ?User;
}
