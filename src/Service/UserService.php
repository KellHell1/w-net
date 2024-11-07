<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserAddress;
use App\Enums\ServiceTypeEnum;
use App\Repository\UserRepository;

readonly class UserService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function getData(int $userId): array
    {
        $user = $this->userRepository->findUserWithDetails($userId)
            ?? throw new \Exception('User not found');

        return [
            'username' => $user->getUsername(),
            'phone' => $user->getPhone(),
            'email' => $user->getEmail(),
            'language' => $user->getLanguage(),
            'theme' => $user->getTheme(),
            'deviceId' => $user->getDeviceId(),
            'addresses' => $this->getAddresses($user),
        ];
    }

    private function getAddresses(User $user): array
    {
        return array_map(fn ($address) => $this->getAddressData($address), $user->getAddresses()->toArray());
    }

    private function getAddressData(UserAddress $address): array
    {
        return [
            'address' => $address->getAddress(),
            'status' => $address->getStatus(),
            'tariff' => $address->getTariff()->getName(),
            'balance' => $address->getBalance(),
            'services' => $this->getAddressServices($address),
        ];
    }

    private function getAddressServices(UserAddress $address): array
    {
        return array_reduce($address->getTariff()->getServices()->toArray(), function ($services, $service) {
            $serviceType = ServiceTypeEnum::from($service->getType())->name;
            $services[$serviceType] = $service->getDescription();

            return $services;
        }, []);
    }
}
