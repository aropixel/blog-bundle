<?php

namespace Aropixel\BlogBundle\Form;

use Aropixel\BlogBundle\Entity\PostCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class PostCategoryType extends AbstractType
{
    public function __construct(private readonly TranslatorInterface $translator) {
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label'  => $this->translator->trans('categories.form.name.label')])
            ->add('createdAt', DateTimeType::class, ['required' => false, 'date_widget' => 'single_text', 'time_widget' => 'single_text', 'date_format' => 'yyyy-MM-dd'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => PostCategory::class]);
    }


}
