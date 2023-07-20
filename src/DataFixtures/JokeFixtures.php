<?php

namespace App\DataFixtures;

use App\Entity\Joke;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JokeFixtures extends Fixture
{
    public const CATEGORIES = [
        'category_belges',
        'category_blondes',
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
        foreach (self::JOKES as $content) {
            $joke = new Joke();
            $joke->setContent($content['name']);
            $categoryReference = $content['reference'];
            $category = $this->getReference($categoryReference);
            $joke->setCategory($category);
            $manager->persist($joke);
        }

        $manager->flush();
    }
}
