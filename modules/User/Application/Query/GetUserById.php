<?php

declare(strict_types=1);

namespace Modules\User\Application\Query;

final readonly class GetUserById
{
    public function __construct(
        public string $id,
    ) {}
}
