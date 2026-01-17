<?php

declare(strict_types=1);

namespace Modules\User\Infrastructure\Http\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Domain\Entity\User;

/**
 * @property User $resource
 */
final class UserResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id()->value(),
            'name' => $this->resource->name(),
            'email' => $this->resource->email()->value(),
        ];
    }
}
