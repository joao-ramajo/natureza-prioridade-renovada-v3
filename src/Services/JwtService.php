<?php declare(strict_types=1);

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    private string $secretKey;
    private int $expirationTime;

    public function __construct(string $secretKey, int $expirationTime = 3600)
    {
        $this->secretKey = $secretKey;
        $this->expirationTime = $expirationTime;
    }

    public function generateToken(array $payload): string
    {
        $issuedAt = time();
        $expire = $issuedAt + $this->expirationTime;

        $tokenPayload = array_merge($payload, [
            'iat' => $issuedAt,
            'exp' => $expire
        ]);

        return JWT::encode($tokenPayload, $this->secretKey, 'HS256');
    }

    public function validateToken(string $token): ?object
    {
        try {
            return JWT::decode($token, new Key($this->secretKey, 'HS256'));
        } catch (\Exception $e) {
            return null;
        }
    }

    public function decodeToken(string $token): ?object
    {
        return $this->validateToken($token);
    }
}
