# Create Value Object

Create a domain value object following DDD principles with test-first approach.

## Arguments
- `$ARGUMENTS` - Format: `<Module> <ValueObjectName>` (e.g., `User Email`, `Order Money`)

## Instructions

1. **Parse arguments**: Extract module and value object name from `$ARGUMENTS`

2. **Create the test first** (TDD):
   ```
   tests/Unit/<Module>/Domain/ValueObject/<ValueObjectName>Test.php
   ```
   - Test creation with valid data
   - Test creation with invalid data throws exception
   - Test `equals()` method with same and different values
   - Test serialization methods (`toString()`, `toArray()`, etc.)

3. **Run the test** to see it fail (Red phase):
   ```bash
   ./vendor/bin/sail test --filter <ValueObjectName>Test
   ```

4. **Create the value object class**:
   ```
   modules/<Module>/Domain/ValueObject/<ValueObjectName>.php
   ```
   - Pure PHP, no Laravel dependencies
   - Private constructor with static factory method(s)
   - Immutable (readonly properties)
   - Validate invariants in factory method
   - Implement `equals()` for comparison

5. **Run the test again** to see it pass (Green phase)

6. **Refactor if needed** while keeping tests green

## Value Object Template

```php
<?php

declare(strict_types=1);

namespace Modules\<Module>\Domain\ValueObject;

use Modules\<Module>\Domain\Exception\Invalid<ValueObjectName>;

final readonly class <ValueObjectName>
{
    private function __construct(
        private string $value,
    ) {
    }

    public static function fromString(string $value): self
    {
        if (empty($value)) {
            throw Invalid<ValueObjectName>::empty();
        }

        // Add validation logic here

        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
```

## ID Value Object Template

For entity identifiers, use this specialized template:

```php
<?php

declare(strict_types=1);

namespace Modules\<Module>\Domain\Entity;

use Ramsey\Uuid\Uuid;

final readonly class <EntityName>Id
{
    private function __construct(
        private string $value,
    ) {
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public static function fromString(string $value): self
    {
        if (!Uuid::isValid($value)) {
            throw new \InvalidArgumentException("Invalid UUID: {$value}");
        }

        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
```

## Exception Template

```php
<?php

declare(strict_types=1);

namespace Modules\<Module>\Domain\Exception;

final class Invalid<ValueObjectName> extends \DomainException
{
    public static function empty(): self
    {
        return new self('<ValueObjectName> cannot be empty');
    }

    public static function withFormat(string $value): self
    {
        return new self("Invalid <ValueObjectName> format: {$value}");
    }

    public static function withReason(string $reason): self
    {
        return new self("Invalid <ValueObjectName>: {$reason}");
    }
}
```

## Test Template

```php
<?php

declare(strict_types=1);

namespace Tests\Unit\<Module>\Domain\ValueObject;

use Modules\<Module>\Domain\ValueObject\<ValueObjectName>;
use Modules\<Module>\Domain\Exception\Invalid<ValueObjectName>;
use PHPUnit\Framework\TestCase;

final class <ValueObjectName>Test extends TestCase
{
    public function test_can_create_from_valid_string(): void
    {
        $value = <ValueObjectName>::fromString('valid-value');

        $this->assertSame('valid-value', $value->toString());
    }

    public function test_throws_exception_for_invalid_value(): void
    {
        $this->expectException(Invalid<ValueObjectName>::class);

        <ValueObjectName>::fromString('');
    }

    public function test_equals_returns_true_for_same_value(): void
    {
        $value1 = <ValueObjectName>::fromString('same-value');
        $value2 = <ValueObjectName>::fromString('same-value');

        $this->assertTrue($value1->equals($value2));
    }

    public function test_equals_returns_false_for_different_value(): void
    {
        $value1 = <ValueObjectName>::fromString('value-one');
        $value2 = <ValueObjectName>::fromString('value-two');

        $this->assertFalse($value1->equals($value2));
    }
}
```

## ID Value Object Test Template

```php
<?php

declare(strict_types=1);

namespace Tests\Unit\<Module>\Domain\Entity;

use Modules\<Module>\Domain\Entity\<EntityName>Id;
use PHPUnit\Framework\TestCase;

final class <EntityName>IdTest extends TestCase
{
    public function test_can_generate_new_id(): void
    {
        $id = <EntityName>Id::generate();

        $this->assertNotEmpty($id->toString());
    }

    public function test_can_create_from_valid_uuid(): void
    {
        $uuid = '550e8400-e29b-41d4-a716-446655440000';
        $id = <EntityName>Id::fromString($uuid);

        $this->assertSame($uuid, $id->toString());
    }

    public function test_throws_exception_for_invalid_uuid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        <EntityName>Id::fromString('not-a-valid-uuid');
    }

    public function test_equals_returns_true_for_same_id(): void
    {
        $uuid = '550e8400-e29b-41d4-a716-446655440000';
        $id1 = <EntityName>Id::fromString($uuid);
        $id2 = <EntityName>Id::fromString($uuid);

        $this->assertTrue($id1->equals($id2));
    }

    public function test_equals_returns_false_for_different_id(): void
    {
        $id1 = <EntityName>Id::generate();
        $id2 = <EntityName>Id::generate();

        $this->assertFalse($id1->equals($id2));
    }
}
```

## Common Value Object Patterns

### Composite Value Object
```php
final readonly class Address
{
    private function __construct(
        private string $street,
        private string $city,
        private string $postalCode,
        private string $country,
    ) {}

    public static function create(string $street, string $city, string $postalCode, string $country): self
    {
        // Validate all fields
        return new self($street, $city, $postalCode, $country);
    }

    public function equals(self $other): bool
    {
        return $this->street === $other->street
            && $this->city === $other->city
            && $this->postalCode === $other->postalCode
            && $this->country === $other->country;
    }
}
```

### Numeric Value Object
```php
final readonly class Money
{
    private function __construct(
        private int $amount,
        private string $currency,
    ) {}

    public static function fromCents(int $amount, string $currency): self
    {
        return new self($amount, strtoupper($currency));
    }

    public function add(self $other): self
    {
        if ($this->currency !== $other->currency) {
            throw new \DomainException('Cannot add money with different currencies');
        }
        return new self($this->amount + $other->amount, $this->currency);
    }
}
```

## Test Base Class Note

Domain tests should use `PHPUnit\Framework\TestCase` directly (no Laravel), keeping the domain layer framework-agnostic.

## Checklist
- [ ] Test file created first
- [ ] Test fails initially (Red)
- [ ] Value object class created
- [ ] Exception class created
- [ ] Test passes (Green)
- [ ] Code refactored if needed
- [ ] No Laravel dependencies in Domain layer
- [ ] `equals()` method implemented
- [ ] Factory method validates invariants
