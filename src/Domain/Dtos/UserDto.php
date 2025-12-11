<?php declare(strict_types=1);

namespace App\Domain\Dtos;

use DateTimeImmutable;

/**
 * @param string $name
 * @param string $email
 * @param string $password
 * @param ?int $id
 * @param ?DateTimeImmutable $email_verified_at
 * @param ?DateTimeImmutable $created_at
 * @param ?DateTimeImmutable $updated_at
 */
class UserDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly ?int $id = null,
        public readonly ?DateTimeImmutable $email_verified_at = null,
        public readonly ?DateTimeImmutable $created_at = null,
        public readonly ?DateTimeImmutable $updated_at = null,
    ) {}
}
