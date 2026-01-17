<?php

declare(strict_types=1);

namespace Tests\Unit\User\Domain\Entity;

use InvalidArgumentException;
use Modules\User\Domain\Entity\UserId;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class UserIdTest extends TestCase
{
    #[Test]
    public function it_creates_from_valid_uuid_string(): void
    {
        $uuid = '550e8400-e29b-41d4-a716-446655440000';

        $userId = UserId::fromString($uuid);

        $this->assertSame($uuid, $userId->value());
    }

    #[Test]
    public function it_generates_a_new_uuid(): void
    {
        $userId = UserId::generate();

        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/',
            $userId->value()
        );
    }

    #[Test]
    public function it_throws_exception_for_invalid_uuid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid UUID format');

        UserId::fromString('invalid-uuid');
    }

    #[Test]
    public function it_compares_equality_correctly(): void
    {
        $uuid = '550e8400-e29b-41d4-a716-446655440000';
        $userId1 = UserId::fromString($uuid);
        $userId2 = UserId::fromString($uuid);
        $userId3 = UserId::generate();

        $this->assertTrue($userId1->equals($userId2));
        $this->assertFalse($userId1->equals($userId3));
    }

    #[Test]
    public function it_converts_to_string(): void
    {
        $uuid = '550e8400-e29b-41d4-a716-446655440000';
        $userId = UserId::fromString($uuid);

        $this->assertSame($uuid, (string) $userId);
    }
}
