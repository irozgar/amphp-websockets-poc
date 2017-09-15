<?php
declare(strict_types=1);

namespace Irozgar\WebsocketsPOC\Service;

use Irozgar\WebsocketsPOC\Exception\BadCredentials;
use Irozgar\WebsocketsPOC\Model\Authenication\Token;
use Irozgar\WebsocketsPOC\Model\Authenication\TokenInterface;
use Irozgar\WebsocketsPOC\Model\User\UserRepository;

class SimpleAuthenticator implements Authenticator
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate(string $username, string $password): TokenInterface
    {
        $user = $this->userRepository->findWithUsername($username);

        if ($user === null || $user->password() !== $password) {
            throw new BadCredentials('There is no user with those credentials');
        }

        return new Token($user);
    }
}
