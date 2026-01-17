<?php

declare(strict_types=1);

namespace Modules\User\Infrastructure\Persistence\InMemory;

use Modules\User\Domain\Entity\User;
use Modules\User\Domain\Entity\UserId;
use Modules\User\Domain\Repository\UserRepository;

final class UserInMemoryRepository implements UserRepository
{
    /** @var array<string, User> */
    private array $users = [];

    public function save(User $user): void
    {
        $this->users[$user->id()->value()] = $user;
    }

    public function findById(UserId $id): ?User
    {
        return $this->users[$id->value()] ?? null;
    }

    /** @return array<string, User> */
    public function all(): array
    {
        return $this->users;
    }

    public function clear(): void
    {
        $this->users = [];
    }
}
