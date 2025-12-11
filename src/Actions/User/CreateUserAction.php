<?php declare(strict_types=1);

namespace App\Actions\User;

use App\Domain\Dtos\UserDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserAction
{
    public function __construct(
        protected readonly EntityManagerInterface $em,
        protected readonly UserPasswordHasherInterface $passwordHasher
    ) {}

    public function handle(UserDto $data)
    {
        $user = new User();
        $user->setName($data->name);
        $user->setEmail($data->email);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $data->password,
        );

        $user->setPassword($hashedPassword);

        $this->em->persist($user);

        $this->em->flush();

        return $user;
    }
}
