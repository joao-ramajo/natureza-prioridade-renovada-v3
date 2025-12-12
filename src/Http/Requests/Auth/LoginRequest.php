<?php declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Symfony\Component\Validator\Constraints as Assert;

class LoginRequest
{
    public function __construct(
        #[Assert\Email]
        #[Assert\NotBlank]
        public readonly string $email,

        #[Assert\NotBlank]
        public readonly string $password,
    ) {}
}
