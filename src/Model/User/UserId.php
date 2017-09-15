<?php
declare(strict_types=1);

namespace Irozgar\WebsocketsPOC\Model\User;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UserId
{
    /** @var Uuid */
    private $uuid;

    public static function fromString(string $uuid): self
    {
        return new self(Uuid::fromString($uuid));
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4());
    }

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals(UserId $anotherUserId): bool
    {
        return $this->uuid->equals($anotherUserId->uuid);
    }
}
