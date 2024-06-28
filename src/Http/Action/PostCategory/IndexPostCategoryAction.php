<?php

namespace Aropixel\BlogBundle\Http\Action\PostCategory;

use Aropixel\BlogBundle\Repository\PostCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexPostCategoryAction extends AbstractController
{
    public function __construct(
        private readonly PostCategoryRepository $postCategoryRepository
    ){}

    public function __invoke() : Response
    {
        return $this->render('@AropixelBlog/category/index.html.twig', [
            'categories' => $this->postCategoryRepository->findAll()
        ]);
    }
}