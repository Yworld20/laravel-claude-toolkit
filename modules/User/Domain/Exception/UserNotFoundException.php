<?php

declare(strict_types=1);

namespace Modules\User\Domain\Exception;

use Exception;
use Modules\User\Domain\Entity\UserId;

final class UserNotFoundException extends Exception
{
    public static function withId(UserId $id): self
    {
        return new self(
            sprintf('User not found with ID: %s', $id->value())
        );
    }
}
