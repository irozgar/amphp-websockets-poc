<?php
declare(strict_types=1);

namespace Irozgar\WebsocketsPOC\Infrastructure\Model\User;


use Irozgar\WebsocketsPOC\Model\User\User;
use Irozgar\WebsocketsPOC\Model\User\UserId;
use Irozgar\WebsocketsPOC\Model\User\UserRepository;

final class InMemoryUserRepository implements UserRepository
{
    /** @var User[] */
    private $users = [];

    public function __construct(array $users = [])
    {
        foreach ($users as $user) {
            $this->add($user);
        }
    }

    private function add(User $user)
    {
        $this->users[$user->id()->toString()] = $user;
    }

    public function find(UserId $id): ?User
    {
        if (!isset($this->users[$id->toString()])) {
            return null;
        }

        return $this->users[$id->toString()];
    }

    public function findWithUsername(string $username): ?User
    {
        foreach ($this->users as $user) {
            if ($user->username() === $username) {
                return $user;
            }
        }

        return null;
    }
}
