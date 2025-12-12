<?php declare(strict_types=1);

namespace App\Actions\Auth;

use App\Repository\UserRepository;
use App\Services\JwtService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use DomainException;

class LoginAction
{
    public function __construct(
        protected readonly UserRepository $userRepository,
        protected readonly UserPasswordHasherInterface $passwordHasher,
        protected readonly JwtService $jwtService,
    ) {}

    public function handle(string $email, string $password)
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user || !$this->passwordHasher->isPasswordValid($user, $password)) {
            throw new DomainException('Credenciais inválidas');
        }

        return $this->jwtService->generateToken([
            'user_id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ]);
    }
}
