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
        $existingAdmin = $manager->getRepository(User::class)->findOneBy(['username' => 'admin']);

        if (!$existingAdmin) {
            // Créez l'utilisateur 'admin' uniquement s'il n'existe pas déjà
            $userAdmin = new User();
            $userAdmin->setUsername('admin');

            // Hashage du mot de passe 'adminpassword'
            $hashedPassword = $this->passwordHasher->hashPassword(
                $userAdmin,
                'adminpassword'
            );
            $userAdmin->setPassword($hashedPassword);

            // configurez les autres propriétés de l'utilisateur admin
            $manager->persist($userAdmin);
            $this->addReference('user_admin', $userAdmin);
        }

        // ... Créez d'autres utilisateurs et persistez-les avec leurs mots de passe hashés ...

        $manager->flush();
    }
}
