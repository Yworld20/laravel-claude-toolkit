<?php

declare(strict_types=1);

namespace Modules\User\Application\Command;

use Modules\Shared\Domain\ValueObject\Email;
use Modules\User\Domain\Entity\User;
use Modules\User\Domain\Entity\UserId;
use Modules\User\Domain\Repository\UserRepository;

final readonly class CreateUserHandler
{
    public function __construct(
        private UserRepository $userRepository,
    ) {}

    public function __invoke(CreateUser $command): void
    {
        $user = User::create(
            id: UserId::fromString($command->id),
            name: $command->name,
            email: Email::fromString($command->email),
        );

        $this->userRepository->save($user);
    }
}
