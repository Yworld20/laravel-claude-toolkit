<?php

declare(strict_types=1);

namespace Modules\User\Domain\Entity;

use Modules\Shared\Domain\ValueObject\Email;
use Modules\User\Domain\Exception\InvalidUserException;

final readonly class User
{
    private function __construct(
        private UserId $id,
        private string $name,
        private Email $email,
    ) {}

    public static function create(
        UserId $id,
        string $name,
        Email $email,
    ): self {
        $name = trim($name);

        if ($name === '') {
            throw InvalidUserException::emptyName();
        }

        if (strlen($name) > 255) {
            throw InvalidUserException::nameTooLong();
        }

        return new self($id, $name, $email);
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): Email
    {
        return $this->email;
    }
}
