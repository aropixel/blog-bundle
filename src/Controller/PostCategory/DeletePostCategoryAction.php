<?php

namespace Aropixel\BlogBundle\Controller\PostCategory;

use Aropixel\BlogBundle\Entity\PostCategory;
use Aropixel\BlogBundle\Repository\PostCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class DeletePostCategoryAction extends AbstractController
{
    public function __construct(
        private readonly PostCategoryRepository $postCategoryRepository,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function __invoke(Request $request, PostCategory $postCategory): Response
    {
        $title = $postCategory->getName();

        if ($this->isCsrfTokenValid('delete__post_category' . $postCategory->getId(), $request->request->get('_token'))) {
            $this->postCategoryRepository->remove($postCategory, true);
            $this->addFlash('notice', $this->translator->trans('category.flash.deleted', ['{title}' => $title]));
        }

        return $this->redirect($this->generateUrl('aropixel_blog_category_index'));
    }
}
