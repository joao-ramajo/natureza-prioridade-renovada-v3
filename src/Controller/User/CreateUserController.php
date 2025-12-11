<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Http\Requests\User\CreateUserRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class CreateUserController extends AbstractController
{
    #[Route('/users', name: 'user_create', methods: ['POST'])]
    public function handle(
        #[MapRequestPayload] CreateUserRequest $userRequest
    )
    {
        if($userRequest->password !== $userRequest->password_confirmation){
            return $this->json([
                'message' => 'As senhas devem ser iguais'
            ], 422);
        }

        return $this->json([
            'data' => $userRequest
        ]);
    }
}