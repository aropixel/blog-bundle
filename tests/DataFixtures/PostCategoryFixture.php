<?php

namespace Aropixel\BlogBundle\Tests\DataFixtures;

use Aropixel\BlogBundle\Entity\PostCategory;
use Aropixel\BlogBundle\Entity\PostCategoryTranslation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostCategoryFixture extends Fixture
{
    private const CATEGORIES = [
        'category-actualites' => [
            'fr' => 'Actualités',
            'en' => 'News',
            'de' => 'Aktuelles',
            'es' => 'Noticias',
            'it' => 'Notizie',
            'cs' => 'Aktuality',
        ],
        'category-tutoriels' => [
            'fr' => 'Tutoriels',
            'en' => 'Tutorials',
            'de' => 'Tutorials',
            'es' => 'Tutoriales',
            'it' => 'Tutorial',
            'cs' => 'Výukové programy',
        ],
        'category-annonces' => [
            'fr' => 'Annonces',
            'en' => 'Announcements',
            'de' => 'Ankündigungen',
            'es' => 'Anuncios',
            'it' => 'Annunci',
            'cs' => 'Oznámení',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $position = 1;

        foreach (self::CATEGORIES as $ref => $names) {
            $category = new PostCategory();
            $category->setName($names['en']);
            $category->setPosition($position++);

            foreach ($names as $locale => $name) {
                $category->addTranslation(new PostCategoryTranslation($locale, 'name', $name));
            }

            $manager->persist($category);
            $this->addReference($ref, $category);
        }

        $manager->flush();
    }
}
