<?php

namespace Aropixel\BlogBundle\Form;

use Aropixel\AdminBundle\Component\Translation\TranslationResolverInterface;
use Aropixel\AdminBundle\Form\Type\TranslatableType;
use Aropixel\BlogBundle\Entity\PostCategory;
use Aropixel\BlogBundle\Entity\PostCategoryTranslation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class PostCategoryType extends AbstractType
{
    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly TranslationResolverInterface $translationResolver
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isTranslatable = $this->translationResolver->isTranslatable();

        if ($isTranslatable) {
            $builder
                ->add('name', TranslatableType::class, [
                    'label' => $this->translator->trans('categories.form.name.label'),
                    'personal_translation' => PostCategoryTranslation::class,
                    'property_path' => 'translations',
                ])
            ;
        } else {
            $builder
                ->add('name', null, [
                    'label' => $this->translator->trans('categories.form.name.label'),
                ])
            ;
        }

        $builder
            ->add('createdAt', DateTimeType::class, [
                'required' => false,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'date_format' => 'yyyy-MM-dd',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PostCategory::class,
        ]);
    }
}
