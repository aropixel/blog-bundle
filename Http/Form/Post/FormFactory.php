<?php

namespace Aropixel\BlogBundle\Http\Form\Post;

use Aropixel\BlogBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

class FormFactory extends AbstractController
{

    public function createDeleteForm(Post $post) : FormInterface
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aropixel_blog_post_delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}