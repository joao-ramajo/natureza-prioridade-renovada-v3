<?php declare(strict_types=1);

namespace App\Http\Requests\User;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserRequest
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $name,

        #[Assert\NotBlank]
        #[Assert\Email]
        public readonly string $email,

        #[Assert\NotBlank]
        public readonly string $password,

        #[Assert\NotBlank]
        public readonly string $password_confirmation,
    ) {}
}
