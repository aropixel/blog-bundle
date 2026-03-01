<?php

namespace Aropixel\BlogBundle\Controller\Post;

use Aropixel\AdminBundle\Component\Status\StatusInterface;
use Aropixel\BlogBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class StatusPostAction extends AbstractController
{
    public function __construct(
        private readonly StatusInterface $status,
    ) {
    }

    public function __invoke(Post $post): Response
    {
        $this->status->changeStatus($post);

        return new Response('OK', Response::HTTP_OK);
    }
}
