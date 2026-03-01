<?php

namespace Aropixel\BlogBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

#[ORM\MappedSuperclass]
#[ORM\Table(name: 'aropixel_post_translation')]
#[ORM\Index(name: 'post_translation_idx', columns: ['locale', 'object_id', 'field'])]
class PostTranslation extends AbstractPersonalTranslation implements PostTranslationInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER)]
    protected $id;

    #[ORM\Column(name: 'locale', type: Types::STRING, length: 20)]
    protected $locale;

    #[ORM\Column(name: 'field', type: Types::STRING, length: 32)]
    protected $field;

    #[ORM\Column(name: 'content', type: Types::TEXT, nullable: true)]
    protected $content;

    #[ORM\ManyToOne(targetEntity: PostInterface::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'object_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected $object;

    public function __construct(string $locale, string $field, ?string $value = null)
    {
        $this->setLocale($locale);
        $this->setField($field);
        if ($value) {
            $this->setContent($value);
        }
    }
}
