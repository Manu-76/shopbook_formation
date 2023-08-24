<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {   
        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setRoles(["ROLE_USER", "ROLE_ADMIN"]);
        $password = $this->hasher->hashPassword($user, 'admin');
        $user->setPassword($password);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('user@user.com');
        $user->setRoles(["ROLE_USER"]);
        $password = $this->hasher->hashPassword($user, 'user');
        $user->setPassword($password);
        $manager->persist($user);

        $manager->flush();
    }
}
