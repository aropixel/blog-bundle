<?php

namespace Aropixel\BlogBundle\Http\Form\PostCategory;

use Aropixel\BlogBundle\Entity\PostCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

class FormFactory extends AbstractController
{
    /**
     * Creates a form to delete a Page entity by id.
     */
    public function createDeleteForm(PostCategory $category): FormInterface
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aropixel_blog_category_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}