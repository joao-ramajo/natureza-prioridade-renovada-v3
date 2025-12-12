<?php declare(strict_types=1);

namespace App\Controller\Auth;

use App\Actions\Auth\RegisterAction;
use App\Actions\User\CreateUserAction;
use App\Domain\Dtos\UserDto;
use App\Http\Requests\User\CreateUserRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use DomainException;

class RegisterAuthController extends AbstractController
{
    public function __construct(
        protected readonly RegisterAction $createUserAction
    ) {}

    #[Route('/api/v1/register', methods: ['POST'])]
    public function handle(
        #[MapRequestPayload] CreateUserRequest $userRequest
    ) {
        try {
            if ($userRequest->password !== $userRequest->password_confirmation) {
                throw new DomainException('As senhas devem ser iguais');
            }

            $dto = new UserDto($userRequest->name, $userRequest->email, $userRequest->password);

            $result = $this->createUserAction->handle($dto);

            return $this->json([
                'message' => 'Usuário criado com sucesso.',
                'data' => $result
            ]);
        } catch (DomainException $e) {
            return $this->json([
                'message' => 'Erro ao registrar usuário',
                'error' => $e->getMessage(),
            ], 422);
        }
    }
}
