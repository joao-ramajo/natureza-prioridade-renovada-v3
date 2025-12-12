<?php declare(strict_types=1);

namespace App\Controller\Auth;

use App\Actions\Auth\LoginAction;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use DomainException;

class LoginAuthController extends AbstractController
{
    public function __construct(
        protected readonly LoginAction $loginAction,
    ) {}

    #[Route('/api/v1/login', name: 'auth_login', methods: ['POST'])]
    public function handle(
        #[MapRequestPayload] LoginRequest $request
    ) {
        try {
            $token = $this->loginAction->handle($request->email, $request->password);

            return $this->json([
                'token' => $token,
                'message' => 'login realizado',
            ]);
        } catch (DomainException $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], 401);
        }
    }
}
