<?php

namespace Aropixel\BlogBundle\Controller\PostCategory;

use Aropixel\AdminBundle\Component\Status\StatusInterface;
use Aropixel\BlogBundle\Entity\PostCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class StatusPostCategoryAction extends AbstractController
{
    public function __construct(
        private readonly StatusInterface $status,
    ) {
    }

    public function __invoke(PostCategory $postCategory): Response
    {
        $this->status->changeStatus($postCategory);

        return new Response('OK', Response::HTTP_OK);
    }
}
