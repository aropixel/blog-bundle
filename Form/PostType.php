<?php

namespace Aropixel\BlogBundle\Form;

use Aropixel\AdminBundle\Form\Type\Image\Single\ImageType;
use Aropixel\BlogBundle\Entity\Post;
use Aropixel\BlogBundle\Entity\PostCategory;
use Aropixel\BlogBundle\Entity\PostImage;
use Aropixel\BlogBundle\Entity\PostImageCrop;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class PostType extends AbstractType
{
    private TranslatorInterface $translator;
    private string $categoryMode;

    /**
     * PostType constructor.
     */
    public function __construct(TranslatorInterface $translator, $categoryMode)
    {
        $this->translator = $translator;
        $this->categoryMode = $categoryMode;
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array('label'  => $this->translator->trans('Title')))
            ->add('excerpt', null, array('label'  => $this->translator->trans('Excerpt')))
            ->add('description', null, array('label'  => 'Description', 'attr' => array('class' => 'ckeditor')))
            ->add('slug', HiddenType::class)
            ->add('metaTitle', null, array('label'  => 'Meta title'))
            ->add('metaDescription', null, array('label'  => 'Meta description'))
            ->add('metaKeywords', null, array('label'  => 'Meta keywords'))
            ->add('image', ImageType::class, array(
                'data_class' => PostImage::class,
                'crop_class' => PostImageCrop::class,
            ))
            ->add('status', HiddenType::class)
            ->add('createdAt', DateTimeType::class, array(
                'required' => false,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'date_format' => 'yyyy-MM-dd',
            ))
            ->add('publishAt', null, array(
                'required' => false,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'date_format' => 'yyyy-MM-dd',
                'years' => range(date('Y') - 50, date('Y') + 50),
            ))
            ->add('publishUntil', null, array(
                'required' => false,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'date_format' => 'yyyy-MM-dd',
                'years' => range(date('Y') - 50, date('Y') + 50),
            ))
        ;

        if ($this->categoryMode == 'category') {

            $builder
                ->add('category', EntityType::class, array(
                    'class' => PostCategory::class,
                    'required' => false,
                    'label' => "Catégorie",
                    'placeholder' => "Sélectionner une catégorie",
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy('c.position', 'ASC');
                    },
                    'choice_label' => 'name'
                ))
            ;
        }
        else if ($this->categoryMode == 'tags') {

            $builder
                ->add('categories', EntityType::class, array(
                    'class' => PostCategory::class,
                    'multiple' => true,
                    'required' => false,
                    'label' => "Catégories",
                    'placeholder' => "Sélectionner des catégories",
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy('c.position', 'ASC');
                    },
                    'choice_label' => 'name'
                ))
            ;
        }

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Post::class
        ));
    }


}
