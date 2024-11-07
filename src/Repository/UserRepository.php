<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findUserWithDetails(int $userId): ?User
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.addresses', 'a')
            ->addSelect('a')
            ->leftJoin('a.owner', 'o')
            ->addSelect('o')
            ->leftJoin('a.tariff', 't')
            ->addSelect('t')
            ->leftJoin('t.services', 's')
            ->addSelect('s')
            ->where('u.id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
