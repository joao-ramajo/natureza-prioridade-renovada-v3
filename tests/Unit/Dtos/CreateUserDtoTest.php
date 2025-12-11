<?php declare(strict_types=1);

namespace App\Tests\Unit\Dtos;

use App\Domain\Dtos\UserDto;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;

class CreateUserDtoTest extends TestCase
{
    public function testCanCreateDtoWithRequiredFieldsOnly(): void
    {
        $dto = new UserDto(
            name: 'John Doe',
            email: 'john@gmail.com',
            password: 'Aa12323'
        );

        $this->assertSame('John Doe', $dto->name);
        $this->assertSame('john@gmail.com', $dto->email);
        $this->assertSame('Aa12323', $dto->password);

        // Campos opcionais devem ser null por padrão
        $this->assertNull($dto->id);
        $this->assertNull($dto->email_verified_at);
        $this->assertNull($dto->created_at);
        $this->assertNull($dto->updated_at);
    }

    public function testCanCreateDtoWithAllFields(): void
    {
        $now = new DateTimeImmutable();

        $dto = new UserDto(
            name: 'Jane Doe',
            email: 'jane@gmail.com',
            password: 'Password123',
            id: 1,
            email_verified_at: $now,
            created_at: $now,
            updated_at: $now
        );

        $this->assertSame('Jane Doe', $dto->name);
        $this->assertSame('jane@gmail.com', $dto->email);
        $this->assertSame('Password123', $dto->password);
        $this->assertSame(1, $dto->id);
        $this->assertSame($now, $dto->email_verified_at);
        $this->assertSame($now, $dto->created_at);
        $this->assertSame($now, $dto->updated_at);
    }
}
