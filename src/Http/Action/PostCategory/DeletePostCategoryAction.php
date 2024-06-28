<?php

namespace Aropixel\BlogBundle\Http\Action\PostCategory;

use Aropixel\BlogBundle\Entity\PostCategory;
use Aropixel\BlogBundle\Repository\PostCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeletePostCategoryAction extends AbstractController
{

    public function __construct(
        private readonly PostCategoryRepository $postCategoryRepository
    )
    {}

    public function  __invoke(Request $request, PostCategory $postCategory) : Response
    {
        $title = $postCategory->getName();

        if ($this->isCsrfTokenValid('delete__post_category' . $postCategory->getId(), $request->request->get('_token'))) {
            $this->postCategoryRepository->remove($postCategory, true);
            $this->addFlash('notice', 'La catégorie "'.$title.'" a bien été supprimée.');
        }

        return $this->redirect($this->generateUrl('aropixel_blog_category_index'));

    }

}