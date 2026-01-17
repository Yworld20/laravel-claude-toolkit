<?php

declare(strict_types=1);

namespace Modules\User\Infrastructure\Persistence\Eloquent\Repository;

use Modules\Shared\Domain\ValueObject\Email;
use Modules\User\Domain\Entity\User;
use Modules\User\Domain\Entity\UserId;
use Modules\User\Domain\Repository\UserRepository;
use Modules\User\Infrastructure\Persistence\Eloquent\Model\UserModel;

final readonly class UserEloquentRepository implements UserRepository
{
    public function save(User $user): void
    {
        UserModel::query()->updateOrCreate(
            ['id' => $user->id()->value()],
            [
                'name' => $user->name(),
                'email' => $user->email()->value(),
            ]
        );
    }

    public function findById(UserId $id): ?User
    {
        $model = UserModel::query()->find($id->value());

        if ($model === null) {
            return null;
        }

        return User::create(
            id: UserId::fromString($model->id),
            name: $model->name,
            email: Email::fromString($model->email),
        );
    }
}
