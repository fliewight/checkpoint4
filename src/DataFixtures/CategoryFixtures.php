<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        [
            'name' => "Belges",
            'reference' => 'category_belges'
        ],
        [
            'name' => "Blondes",
            'reference' => 'category_blondes'
        ],
        // ...
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $categoryData) {
            $category = new Category();
            $category->setName($categoryData['name']);
            $this->addReference($categoryData['reference'], $category);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
