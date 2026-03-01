<?php

namespace Aropixel\BlogBundle\Controller\PostCategory;

use Aropixel\BlogBundle\Form\PostCategoryType;
use Aropixel\BlogBundle\Repository\PostCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class EditPostCategoryAction extends AbstractController
{
    public function __construct(
        private readonly RequestStack $request,
        private readonly PostCategoryRepository $postCategoryRepository,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function __invoke(int $id): Response
    {
        $postCategory = $this->postCategoryRepository->find($id);

        if (null === $postCategory) {
            throw $this->createNotFoundException();
        }

        $editForm = $this->createForm(PostCategoryType::class, $postCategory);
        $editForm->handleRequest($this->request->getMainRequest());

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->postCategoryRepository->add($postCategory, true);
            $this->addFlash('notice', $this->translator->trans('category.flash.saved'));

            return $this->redirectToRoute('aropixel_blog_category_edit', ['id' => $postCategory->getId()]);
        }

        return $this->render('@AropixelBlog/category/form.html.twig', [
            'category' => $postCategory,
            'form' => $editForm->createView(),
        ]);
    }
}
