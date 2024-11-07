<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class UserService
{
    public function __construct(private UserRepository $userRepository, private UserAddressService $userAddressService) {}

    public function getWithDetails(int $id): array
    {
        $user = $this->userRepository->findUserWithDetails($id);
        if ($user === null) {
            $this->throwNotFoundException('User not exist');
        }

        return [
            'username' => $user->getUsername(),
            'phone' => $user->getPhone(),
            'email' => $user->getEmail(),
            'language' => $user->getLanguage(),
            'theme' => $user->getTheme(),
            'deviceId' => $user->getDeviceId(),
            'addresses' => $this->userAddressService->getAddresses($user),
        ];
    }

    private function throwNotFoundException(string $message): void
    {
        throw new NotFoundHttpException($message);
    }
}
