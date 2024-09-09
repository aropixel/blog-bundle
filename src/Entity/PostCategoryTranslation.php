<?php

namespace Aropixel\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;

#[ORM\Index(name: 'post_category_translation_idx', columns: ['locale', 'object_id', 'field'])]
#[ORM\Entity(repositoryClass: TranslationRepository::class)]
class PostCategoryTranslation extends AbstractPersonalTranslation implements PostTranslationInterface
{
    public function __construct($locale, $field, $value)
    {
        $this->setLocale($locale);
        $this->setField($field);
        $this->setContent($value);
    }

    protected $object;
}