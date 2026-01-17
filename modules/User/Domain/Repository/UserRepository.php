<?php

declare(strict_types=1);

namespace Modules\User\Domain\Repository;

use Modules\User\Domain\Entity\User;
use Modules\User\Domain\Entity\UserId;

interface UserRepository
{
    public function save(User $user): void;

    public function findById(UserId $id): ?User;
}
