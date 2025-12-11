<?php

declare(strict_types=1);

namespace App\Domain\Dtos;

use DateTimeImmutable;

class UserDto
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly ?DateTimeImmutable $email_verified_at,
        public readonly ?DateTimeImmutable $created_at,
        public readonly ?DateTimeImmutable $verified_at,
    )
    {
    }
}