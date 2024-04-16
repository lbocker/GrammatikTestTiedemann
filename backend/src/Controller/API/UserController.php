<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Entity\User;
use App\Service\UserService;
use OpenApi\Attributes\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_user')]
class UserController extends AbstractController
{
    public function __construct(private readonly UserService $userService) {}

    #[Response(response: 200, description: 'Returns the list of users')]
    #[Response(response: 404, description: 'No users found')]
    #[Route('/users', name: 'get_users', methods: ['GET'])]
    public function getUsers(): JsonResponse
    {
        $users = $this->userService->getAllUsers();

        return new JsonResponse($users);
    }

    #[Response(response: 201, description: 'Creates a new user')]
    #[Route('/users', name: 'create_user', methods: ['POST'])]
    public function createUser(Request $request): User
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);

        return $this->userService->createUser($user);
    }

    #[Response(response: 200, description: 'Updates the user')]
    #[Response(response: 404, description: 'No user found for id {id}')]
    #[Route('/users/{id}', name: 'update_user', methods: ['PUT'])]
    public function updateUser(request $request, int $id): User
    {
        $data = json_decode($request->getContent(), true);

        $user = $this->userService->getUser($id);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);

        return $this->userService->updateUser($user);
    }

    #[Response(response: 200, description: 'Updates the user points')]
    #[Response(response: 404, description: 'No user found for id {id}')]
    #[Route('/users/{id}/points', name: 'update_user_points', methods: ['PUT'])]
    public function updateUserPoints(UserService $userService, Request $request, int $id): void
    {
        $data = json_decode($request->getContent(), true);

        $userService->updateUserPoints($id, $data['points']);
    }

    #[Response(response: 204, description: 'Deletes the user')]
    #[Response(response: 404, description: 'No user found for id {id}')]
    #[Route('/users/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function deleteUser(int $id): void
    {
        $this->userService->deleteUser($id);
    }
}