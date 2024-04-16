<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api', name: 'api_login')]
class ApiLoginController extends AbstractController
{
    public function __construct(private readonly JWTTokenManagerInterface $jwtManager) {}

    #[Parameter(parameter: 'query', name: 'user', description: 'The email of the user', in: 'query', required: true)]
    #[Parameter(parameter: 'query', name: 'password', description: 'The password of the user', in: 'query', required: true)]
    #[Response(response: 200, description: 'Returns the user and token')]
    #[Route('/login_check', name: 'app_api_login', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user): JsonResponse
    {
        if (null === $user) {
            return new JsonResponse([
                'message' => 'missing credentials',
            ], 401);
        }

        $token = $this->jwtManager->create($user);

        return new JsonResponse([
            'user' => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }
}
