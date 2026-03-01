<?php

namespace Aropixel\BlogBundle\Controller\PostCategory;

use Aropixel\AdminBundle\Component\Position\PositionInterface;
use Aropixel\BlogBundle\Entity\PostCategory;
use Aropixel\BlogBundle\Repository\PostCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class OrderPostCategoryAction extends AbstractController
{
    public function __construct(
        private readonly RequestStack $request,
        private readonly PositionInterface $position,
        private readonly PostCategoryRepository $postCategoryRepository
    ) {
    }

    public function __invoke(): Response
    {
        if ($this->request->getMainRequest()->isXmlHttpRequest()) {
            $this->position->updatePosition(PostCategory::class);

            return new Response('OK', Response::HTTP_OK);
        }

        $postCategories = $this->postCategoryRepository->findBy([], ['position' => 'ASC']);

        return $this->render('@AropixelBlog/category/order.html.twig', [
            'categories' => $postCategories,
        ]);
    }
}
