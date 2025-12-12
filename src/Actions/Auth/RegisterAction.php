<?php declare(strict_types=1);

namespace App\Actions\Auth;

use App\Domain\Dtos\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterAction
{
    public function __construct(
        protected readonly EntityManagerInterface $em,
        protected readonly UserPasswordHasherInterface $passwordHasher,
        protected readonly UserRepository $userRepository,
    ) {}

    public function handle(UserDto $data)
    {
        $user = new User();
        $user->setName($data->name);
        $user->setEmail($data->email);

        if($this->userRepository->findOneBy(['email' => $user->getEmail()])){
            throw new DomainException('Email não disponivel');
        }

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
