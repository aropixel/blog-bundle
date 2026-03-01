<?php

namespace Aropixel\BlogBundle\Form;

use Aropixel\AdminBundle\Form\Type\Image\Single\ImageType;
use Aropixel\AdminBundle\Form\Type\TranslatableType;
use Aropixel\BlogBundle\Entity\PostCategory;
use Aropixel\BlogBundle\Entity\PostImage;
use Aropixel\BlogBundle\Entity\PostImageCrop;
use Aropixel\BlogBundle\Entity\PostInterface;
use Aropixel\BlogBundle\Entity\PostTranslation;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class PostTranslatableType extends AbstractType
{
    public function __construct(
        private readonly TranslatorInterface $translator,
        #[Autowire('%aropixel_blog.categories%')]
        private readonly string $categoryMode
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TranslatableType::class, [
                'label' => $this->translator->trans('form.field.title'),
                'personal_translation' => PostTranslation::class,
                'property_path' => 'translations',
            ])
            ->add('excerpt', TranslatableType::class, [
                'label' => $this->translator->trans('form.field.excerpt'),
                'personal_translation' => PostTranslation::class,
                'property_path' => 'translations',
            ])
            ->add('description', TranslatableType::class, [
                'label' => $this->translator->trans('form.field.description'),
                'personal_translation' => PostTranslation::class,
                'property_path' => 'translations',
                'widget' => TextareaType::class,
                'attr' => ['class' => 'ckeditor'],
            ])
            ->add('slug', HiddenType::class)
            ->add('metaTitle', TranslatableType::class, [
                'label' => $this->translator->trans('form.field.meta_title'),
                'personal_translation' => PostTranslation::class,
                'property_path' => 'translations',
                'required' => false,
            ])
            ->add('metaDescription', TranslatableType::class, [
                'label' => $this->translator->trans('form.field.meta_description'),
                'personal_translation' => PostTranslation::class,
                'property_path' => 'translations',
                'required' => false,
            ])
            ->add('metaKeywords', TranslatableType::class, [
                'label' => $this->translator->trans('form.field.meta_keywords'),
                'personal_translation' => PostTranslation::class,
                'property_path' => 'translations',
                'required' => false,
            ])
            ->add('image', ImageType::class, ['data_class' => PostImage::class, 'crop_class' => PostImageCrop::class])
            ->add('status', HiddenType::class)
            ->add('createdAt', DateTimeType::class, [
                'label' => $this->translator->trans('form.field.created_at'),
                'required' => false,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'date_format' => 'yyyy-MM-dd',
            ])
            ->add('publishAt', DateTimeType::class, [
                'label' => $this->translator->trans('form.field.publish_at'),
                'required' => false,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'date_format' => 'yyyy-MM-dd',
                'years' => range(date('Y') - 50, date('Y') + 50),
            ])
            ->add('publishUntil', DateTimeType::class, [
                'label' => $this->translator->trans('form.field.publish_until'),
                'required' => false,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'date_format' => 'yyyy-MM-dd',
                'years' => range(date('Y') - 50, date('Y') + 50),
            ])
        ;

        if ('category' == $this->categoryMode) {
            $builder
                ->add('category', EntityType::class, ['class' => PostCategory::class, 'required' => false, 'label' => $this->translator->trans('form.field.category.label'), 'placeholder' => $this->translator->trans('form.field.category.placeholder'), 'query_builder' => fn (EntityRepository $er) => $er->createQueryBuilder('c')
                    ->orderBy('c.position', 'ASC'), 'choice_label' => 'name'])
            ;
        } elseif ('tags' == $this->categoryMode) {
            $builder
                ->add('categories', EntityType::class, ['class' => PostCategory::class, 'multiple' => true, 'required' => false, 'label' => $this->translator->trans('form.field.tags.label'), 'placeholder' => $this->translator->trans('form.field.tags.placeholder'), 'query_builder' => fn (EntityRepository $er) => $er->createQueryBuilder('c')
                    ->orderBy('c.position', 'ASC'), 'choice_label' => 'name'])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => PostInterface::class]);
    }
}
