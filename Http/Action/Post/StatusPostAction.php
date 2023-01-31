<?php

namespace Aropixel\BlogBundle\Http\Action\Post;

use Aropixel\AdminBundle\Services\Status;
use Aropixel\BlogBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class StatusPostAction extends AbstractController
{
    public function __construct(
        private readonly Status $status,
    )
    {}

    public function __invoke(Post $post) : Response
    {
        return $this->status->changeStatus($post);
    }
}