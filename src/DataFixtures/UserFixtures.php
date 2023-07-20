<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $isAdmin = $manager->getRepository(User::class)->findOneBy(['username' => 'admin']);
        $isSimpleUser = $manager->getRepository(User::class)->findOneBy(['username' => 'user']);

        if (!$isAdmin) {
            $admin = new User();
            $admin->setUsername('admin');
            $admin->setRoles(['ROLE_ADMIN']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $admin,
                'adminpassword'
            );
            $admin->setPassword($hashedPassword);
            $manager->persist($admin);
            $this->addReference('user_admin', $admin);
        }

        if (!$isSimpleUser) {
            $user = new User();
            $user->setUsername('user');
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                'userpassword'
            );
            $user->setPassword($hashedPassword);
            $manager->persist($user);
            $this->addReference('user_user', $user);
        }

        $manager->flush();
    }
}
