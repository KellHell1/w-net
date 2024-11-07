<?php

namespace App\Service;

use App\Entity\{User, UserAddress};
use App\Enums\{AddressStatusEnum, ServiceTypeEnum};

class UserAddressService
{
    public function getAddresses(User $user): array
    {
        return array_map(fn ($address) => $this->prepareAddressData($address), $user->getAddresses()->toArray());
    }

    public function prepareAddressData(UserAddress $address): array
    {
        return [
            'address' => $address->getAddress(),
            'status' => AddressStatusEnum::from($address->getStatus())->name,
            'tariff' => $address->getTariff()->getName(),
            'balance' => $address->getBalance(),
            'services' => $this->getAddressServices($address),
        ];
    }

    private function getAddressServices(UserAddress $address): array
    {
        return array_reduce($address->getTariff()->getServices()->toArray(), function ($services, $service) {
            $serviceType = ServiceTypeEnum::from($service->getType())->name;
            $services[$serviceType] = $service->getName();

            return $services;
        }, []);
    }
}
