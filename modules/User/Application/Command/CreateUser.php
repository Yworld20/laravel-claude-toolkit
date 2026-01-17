<?php

declare(strict_types=1);

namespace Modules\User\Application\Command;

final readonly class CreateUser
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
    ) {}
}
