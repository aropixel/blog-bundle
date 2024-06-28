<?php

namespace Aropixel\BlogBundle\Http\Action\Post;

use Aropixel\BlogBundle\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexPostAction extends AbstractController
{
    public function __construct(
        private readonly PostRepository $postRepository
    ){}

    public function __invoke() : Response
    {
        $posts = $this->postRepository->findAll();

        return $this->render('@AropixelBlog/post/index.html.twig', [
            'posts' => $posts
        ]);
    }
}