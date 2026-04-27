<?php

namespace Aropixel\BlogBundle\Tests\DataFixtures;

use Aropixel\AdminBundle\Entity\Publishable;
use Aropixel\BlogBundle\Entity\Post;
use Aropixel\BlogBundle\Entity\PostCategory;
use Aropixel\BlogBundle\Entity\PostTranslation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixture extends Fixture implements DependentFixtureInterface
{
    private const POSTS = [
        [
            'category' => 'category-tutoriels',
            'status' => Publishable::STATUS_ONLINE,
            'titles' => [
                'fr' => 'Introduction à Symfony 8',
                'en' => 'Introduction to Symfony 8',
                'de' => 'Einführung in Symfony 8',
                'es' => 'Introducción a Symfony 8',
                'it' => 'Introduzione a Symfony 8',
                'cs' => 'Úvod do Symfony 8',
            ],
            'excerpts' => [
                'fr' => 'Découvrez les nouvelles fonctionnalités de Symfony 8.',
                'en' => 'Discover the new features of Symfony 8.',
                'de' => 'Entdecken Sie die neuen Funktionen von Symfony 8.',
                'es' => 'Descubra las nuevas funciones de Symfony 8.',
                'it' => 'Scopri le nuove funzionalità di Symfony 8.',
                'cs' => 'Objevte nové funkce Symfony 8.',
            ],
        ],
        [
            'category' => 'category-actualites',
            'status' => Publishable::STATUS_ONLINE,
            'titles' => [
                'fr' => 'Nos dernières actualités',
                'en' => 'Our latest news',
                'de' => 'Unsere neuesten Nachrichten',
                'es' => 'Nuestras últimas noticias',
                'it' => 'Le nostre ultime notizie',
                'cs' => 'Naše nejnovější zprávy',
            ],
            'excerpts' => [
                'fr' => 'Restez informé de toutes nos actualités.',
                'en' => 'Stay informed about all our news.',
                'de' => 'Bleiben Sie über alle unsere Neuigkeiten informiert.',
                'es' => 'Manténgase informado sobre todas nuestras noticias.',
                'it' => 'Resta informato su tutte le nostre notizie.',
                'cs' => 'Zůstaňte informováni o všech našich novinkách.',
            ],
        ],
        [
            'category' => 'category-annonces',
            'status' => Publishable::STATUS_ONLINE,
            'titles' => [
                'fr' => 'Annonce importante',
                'en' => 'Important announcement',
                'de' => 'Wichtige Ankündigung',
                'es' => 'Anuncio importante',
                'it' => 'Annuncio importante',
                'cs' => 'Důležité oznámení',
            ],
            'excerpts' => [
                'fr' => 'Nous avons une annonce importante à vous communiquer.',
                'en' => 'We have an important announcement to share with you.',
                'de' => 'Wir haben eine wichtige Ankündigung für Sie.',
                'es' => 'Tenemos un anuncio importante para comunicarle.',
                'it' => 'Abbiamo un annuncio importante da comunicarvi.',
                'cs' => 'Máme pro vás důležité oznámení.',
            ],
        ],
        [
            'category' => 'category-tutoriels',
            'status' => Publishable::STATUS_ONLINE,
            'titles' => [
                'fr' => 'Tutoriel avancé Doctrine',
                'en' => 'Advanced Doctrine tutorial',
                'de' => 'Erweitertes Doctrine-Tutorial',
                'es' => 'Tutorial avanzado de Doctrine',
                'it' => 'Tutorial avanzato su Doctrine',
                'cs' => 'Pokročilý tutoriál Doctrine',
            ],
            'excerpts' => [
                'fr' => 'Maîtrisez les fonctionnalités avancées de Doctrine.',
                'en' => 'Master the advanced features of Doctrine.',
                'de' => 'Meistern Sie die erweiterten Funktionen von Doctrine.',
                'es' => 'Domine las funciones avanzadas de Doctrine.',
                'it' => 'Padroneggia le funzionalità avanzate di Doctrine.',
                'cs' => 'Ovládněte pokročilé funkce Doctrine.',
            ],
        ],
        [
            'category' => 'category-actualites',
            'status' => Publishable::STATUS_OFFLINE,
            'titles' => [
                'fr' => 'Article brouillon',
                'en' => 'Draft article',
                'de' => 'Entwurfsartikel',
                'es' => 'Artículo borrador',
                'it' => 'Articolo bozza',
                'cs' => 'Článek v návrhu',
            ],
            'excerpts' => [
                'fr' => 'Cet article est encore en cours de rédaction.',
                'en' => 'This article is still being written.',
                'de' => 'Dieser Artikel wird noch geschrieben.',
                'es' => 'Este artículo aún está siendo redactado.',
                'it' => 'Questo articolo è ancora in fase di scrittura.',
                'cs' => 'Tento článek je stále v procesu psaní.',
            ],
        ],
    ];

    public function getDependencies(): array
    {
        return [PostCategoryFixture::class];
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::POSTS as $data) {
            $post = new Post();
            $post->setTitle($data['titles']['en']);
            $post->setExcerpt($data['excerpts']['en']);
            $post->setStatus($data['status']);

            /** @var PostCategory $category */
            $category = $this->getReference($data['category'], PostCategory::class);
            $post->setCategory($category);

            foreach ($data['titles'] as $locale => $title) {
                $post->addTranslation(new PostTranslation($locale, 'title', $title));
            }

            foreach ($data['excerpts'] as $locale => $excerpt) {
                $post->addTranslation(new PostTranslation($locale, 'excerpt', $excerpt));
            }

            $manager->persist($post);
        }

        $manager->flush();
    }
}
