<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes\Parameter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes\Response;

#[Route('/api', name: 'api_register')]
class RegisterController extends AbstractController
{

    #[Parameter(parameter: 'query', name: 'email', description: 'The email of the user', in: 'query', required: true)]
    #[Parameter(parameter: 'query', name: 'password', description: 'The password of the user', in: 'query', required: true)]
    #[Response(response: 200, description: 'Returns the user and token')]
    #[Route('/register', name: 'register', methods: 'POST')]
    public function registerUser(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): JsonResponse
    {
        $decoded = json_decode($request->getContent());
        $email = $decoded->email;
        $plainPassword = $decoded->password;

        $user = new User();
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plainPassword
        );
        $user->setPassword($hashedPassword);
        $user->setEmail($email);
        $user->setRoles((array)'ROLE_USER');
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Registered Successfully']);
    }
}