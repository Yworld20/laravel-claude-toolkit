<?php

declare(strict_types=1);

namespace Tests\Unit\User\Domain\Entity;

use Modules\Shared\Domain\ValueObject\Email;
use Modules\User\Domain\Entity\User;
use Modules\User\Domain\Entity\UserId;
use Modules\User\Domain\Exception\InvalidUserException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    #[Test]
    public function it_creates_a_user(): void
    {
        $id = UserId::generate();
        $name = 'John Doe';
        $email = Email::fromString('john@example.com');

        $user = User::create($id, $name, $email);

        $this->assertTrue($id->equals($user->id()));
        $this->assertSame($name, $user->name());
        $this->assertTrue($email->equals($user->email()));
    }

    #[Test]
    public function it_trims_the_name(): void
    {
        $user = User::create(
            UserId::generate(),
            '  John Doe  ',
            Email::fromString('john@example.com')
        );

        $this->assertSame('John Doe', $user->name());
    }

    #[Test]
    public function it_throws_exception_for_empty_name(): void
    {
        $this->expectException(InvalidUserException::class);
        $this->expectExceptionMessage('User name cannot be empty');

        User::create(
            UserId::generate(),
            '',
            Email::fromString('john@example.com')
        );
    }

    #[Test]
    public function it_throws_exception_for_whitespace_only_name(): void
    {
        $this->expectException(InvalidUserException::class);
        $this->expectExceptionMessage('User name cannot be empty');

        User::create(
            UserId::generate(),
            '   ',
            Email::fromString('john@example.com')
        );
    }

    #[Test]
    public function it_throws_exception_for_name_too_long(): void
    {
        $this->expectException(InvalidUserException::class);
        $this->expectExceptionMessage('User name cannot exceed 255 characters');

        User::create(
            UserId::generate(),
            str_repeat('a', 256),
            Email::fromString('john@example.com')
        );
    }
}
