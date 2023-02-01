<?php

namespace Aropixel\BlogBundle\Http\Action\PostCategory;

use Aropixel\AdminBundle\Services\Position;
use Aropixel\BlogBundle\Entity\PostCategory;
use Aropixel\BlogBundle\Repository\PostCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class OrderPostCategoryAction extends AbstractController
{
    public function __construct(
        private readonly RequestStack $request,
        private readonly PostCategoryRepository $postCategoryRepository
    )
    {}


    public function __invoke(Position $position) : Response
    {
        if ($this->request->getMainRequest()->isXmlHttpRequest()) {
            return $position->updatePosition(PostCategory::class);
        }
        else {

            $postCategories = $this->postCategoryRepository->findBy(array(), array('position' => 'ASC'));
            return $this->render('@AropixelBlog/category/order.html.twig', [
                'categories' => $postCategories,
            ]);
        }
    }
}