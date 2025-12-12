<?php declare(strict_types=1);

namespace App\EventSubscriber;

use App\Services\JwtService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class JwtAuthSubscriber implements EventSubscriberInterface
{
    private array $publicRoutes = [
        '/api/v1/login',
        '/api/v1/register',
    ];

    public function __construct(
        private JwtService $jwtService
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 10],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $path = $request->getPathInfo();

        // Verificar se é uma rota pública
        foreach ($this->publicRoutes as $publicRoute) {
            if (str_starts_with($path, $publicRoute)) {
                return;
            }
        }

        // Verificar se é uma rota da API
        if (!str_starts_with($path, '/api')) {
            return;
        }

        $authHeader = $request->headers->get('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            $event->setResponse(new JsonResponse([
                'error' => 'Missing or invalid authorization header'
            ], 401));
            return;
        }

        $token = substr($authHeader, 7);
        $decoded = $this->jwtService->validateToken($token);

        if (!$decoded) {
            $event->setResponse(new JsonResponse([
                'error' => 'Invalid or expired token'
            ], 401));
            return;
        }

        // Adicionar dados do usuário ao request
        $request->attributes->set('jwt_payload', $decoded);
        $request->attributes->set('user_id', $decoded->user_id);
    }
}
