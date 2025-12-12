<?php

declare(strict_types=1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class UpdateUserController extends AbstractController
{
    #[Route('/api/v1/users/update', methods: ['PUT', 'PATCH'])]
    public function handle()
    {
        return $this->json([
            'message' => 'OK'
        ]);
    }
}