<?php

declare(strict_types=1);

namespace Modules\User\Infrastructure\Provider;

use Illuminate\Support\ServiceProvider;
use Modules\User\Domain\Repository\UserRepository;
use Modules\User\Infrastructure\Persistence\Eloquent\Repository\UserEloquentRepository;

final class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepository::class, UserEloquentRepository::class);
    }
}
