<?php

declare(strict_types=1);

namespace Modules\User\Domain\Exception;

use Exception;

final class InvalidUserException extends Exception
{
    public static function emptyName(): self
    {
        return new self('User name cannot be empty');
    }

    public static function nameTooLong(): self
    {
        return new self('User name cannot exceed 255 characters');
    }
}
