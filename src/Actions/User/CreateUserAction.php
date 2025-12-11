<?php declare(strict_types=1);

namespace App\Actions\User;

use App\Domain\Dtos\UserDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CreateUserAction
{
    public function __construct(
        protected readonly EntityManagerInterface $em,
    ) {}

    public function handle(UserDto $data)
    {
        $user = new User();
        $user->setName($data->name);
        $user->setEmail($data->email);
        $user->setPassword($data->password);

        $this->em->persist($user);

        $this->em->flush();

        return $user;
    }
}
