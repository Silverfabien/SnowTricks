<?php

namespace SnowTricksBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use SnowTricksBundle\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneByEmail($email)
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function findOneByResetToken($token)
    {
       return $this->findOneBy(['resetToken' => $token]);
    }
}