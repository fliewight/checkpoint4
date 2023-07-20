<?php

namespace App\DataFixtures;

use App\Entity\Joke;
use App\Entity\User;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class JokeFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    public const CATEGORIES = [
        'category_belges',
        'category_blondes',
    ];

    public const USERS = [
        'admin',
        'user',
    ];

    public const JOKES = [
        [
            'name' => "Comment fait-on pour rentrer douze Belges dans un coffre de voiture ?
            <br>On jette une frite à l’intérieur !",
            'reference' => 'category_belges'
        ],
        [
            'name' => "Comment reconnaît-on un belge dans un aéroport ?<br>C’est le seul qui donne du pain aux avions.",
            'reference' => 'category_belges'
        ],
        [
            'name' => "Pourquoi les Belges ne mangent pas de bretzels ?<br>Parce qu’ils n’arrivent pas à défaire les nœuds !",
            'reference' => 'category_belges'
        ],
        [
            'name' => "Comment appelle-t-on une blonde qui ne comprends rien à l’informatique ?<br><br>Une e-conne",
            'reference' => 'category_blondes'
        ],
        [
            'name' => "Un type annonce à sa collègue de bureau, blonde :<br>
            – Je pars pour Milan !<br>
            – Quoi ! Si longtemps que ça ?",
            'reference' => 'category_blondes'
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        if (!$this->hasReference('user_admin')) {
            $userAdmin = new User();
            $userAdmin->setUsername('admin');
            $hashedPassword = $this->passwordHasher->hashPassword(
                $userAdmin,
                'adminpassword'
            );
            $userAdmin->setPassword($hashedPassword);
            $manager->persist($userAdmin);
            $this->setReference('user_admin', $userAdmin);
        }

        foreach (self::JOKES as $jokeData) {
            $joke = new Joke();
            $joke->setContent($jokeData['name']);
            $categoryReference = $jokeData['reference'];
            $category = $this->getReference($categoryReference);
            $joke->setCategory($category);
            $userReference = 'user_admin';
            $user = $this->getReference($userReference);
            $joke->setUser($user);
            $manager->persist($joke);
        }

        $manager->flush();
    }
}
