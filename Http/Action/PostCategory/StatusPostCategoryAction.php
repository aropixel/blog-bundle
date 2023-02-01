<?php

namespace Aropixel\BlogBundle\Http\Action\PostCategory;

use Aropixel\AdminBundle\Services\Status;
use Aropixel\BlogBundle\Entity\PostCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class StatusPostCategoryAction extends AbstractController
{
    public function __construct(
        private readonly Status $status,
    )
    {}

    public function __invoke(PostCategory $postCategory) : Response
    {
        return $this->status->changeStatus($postCategory);
    }
}