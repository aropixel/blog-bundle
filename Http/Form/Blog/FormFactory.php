<?php

namespace Aropixel\BlogBundle\Http\Form\Blog;

use Aropixel\BlogBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

class FormFactory extends AbstractController
{
    /**
     * Creates a form to delete a Page entity by id.
     */
    public function createDeleteForm(Post $post) : FormInterface
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aropixel_blog_post_delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}