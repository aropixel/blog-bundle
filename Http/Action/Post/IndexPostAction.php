<?php

namespace Aropixel\BlogBundle\Http\Action\Post;

use Aropixel\BlogBundle\Http\Form\Blog\FormFactory;
use Aropixel\BlogBundle\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexPostAction extends AbstractController
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly FormFactory $formFactory,
    ){}

    public function __invoke() : Response
    {
        $posts = $this->postRepository->findAll();

        $delete_forms = array();
        foreach ($posts as $post) {
            $deleteForm = $this->formFactory->createDeleteForm($post);
            $delete_forms[$post->getId()] = $deleteForm->createView();
        }

        return $this->render('@AropixelBlog/post/index.html.twig', [
            'posts' => $this->postRepository->findAll(),
            'delete_forms' => $delete_forms,
        ]);
    }
}