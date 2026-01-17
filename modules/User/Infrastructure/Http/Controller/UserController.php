<?php

declare(strict_types=1);

namespace Modules\User\Infrastructure\Http\Controller;

use Illuminate\Http\JsonResponse;
use Modules\Shared\Domain\ValueObject\Uuid;
use Modules\User\Application\Command\CreateUser;
use Modules\User\Application\Command\CreateUserHandler;
use Modules\User\Application\Query\GetUserById;
use Modules\User\Application\Query\GetUserByIdHandler;
use Modules\User\Domain\Exception\UserNotFoundException;
use Modules\User\Infrastructure\Http\Request\CreateUserRequest;
use Modules\User\Infrastructure\Http\Resource\UserResource;

final readonly class UserController
{
    public function __construct(
        private CreateUserHandler $createUserHandler,
        private GetUserByIdHandler $getUserByIdHandler,
    ) {}

    public function store(CreateUserRequest $request): JsonResponse
    {
        $id = Uuid::generate()->value();

        ($this->createUserHandler)(new CreateUser(
            id: $id,
            name: $request->validated('name'),
            email: $request->validated('email'),
        ));

        $user = ($this->getUserByIdHandler)(new GetUserById($id));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }

    public function show(string $id): JsonResponse
    {
        try {
            $user = ($this->getUserByIdHandler)(new GetUserById($id));

            return (new UserResource($user))->response();
        } catch (UserNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
