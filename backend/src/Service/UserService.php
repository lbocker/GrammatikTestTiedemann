<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

readonly class UserService
{
    public function __construct(
        private UserRepository $userRepository,
    )
    {}

    public function getAllUsers(): array
    {
        $users = $this->userRepository->getAllUsers();

        if (!$users) {
            throw new HttpException(404, 'No users found');
        }

        return $users;
    }

    public function getUser(int $userId): ?User
    {
        $user = $this->userRepository->getUser($userId);

        if (!$user) {
            throw new HttpException(404, 'No user found for id ' . $userId);
        }

        return $user;
    }

    public function getUserByEmail(string $userEmail): ?User
    {
        $user = $this->userRepository->getUserByEmail($userEmail);

        if (!$user) {
            throw new HttpException(404, 'No user found with the email '. $userEmail);
        }

        return $user;
    }

    public function createUser(User $user): User
    {
        $this->userRepository->createUser($user);

        return $user;
    }

    public function updateUser(User $user): User
    {
        $this->userRepository->updateUser($user);

        return $user;
    }

    public function updateUserPoints(int $userId, int $points): void
    {
        $user = $this->userRepository->getUser($userId);

        if (!$user) {
            throw new HttpException(404, 'No user found for id ' . $userId);
        }

        $user->setPoints($points);

        $this->userRepository->updateUser($user);
    }

    public function deleteUser(int $userId): void
    {
        $user = $this->userRepository->getUser($userId);

        if (!$user) {
            throw new HttpException(404, 'No user found for id ' . $userId);
        }

        $this->userRepository->deleteUser($user);
    }
}