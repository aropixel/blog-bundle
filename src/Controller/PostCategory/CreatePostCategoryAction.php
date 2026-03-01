<?php

namespace Aropixel\BlogBundle\Controller\PostCategory;

use Aropixel\BlogBundle\Entity\PostCategory;
use Aropixel\BlogBundle\Form\PostCategoryType;
use Aropixel\BlogBundle\Repository\PostCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class CreatePostCategoryAction extends AbstractController
{
    public function __construct(
        private readonly PostCategoryRepository $postCategoryRepository,
        private readonly RequestStack $request,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function __invoke(): Response
    {
        $postCategory = new PostCategory();

        $form = $this->createForm(PostCategoryType::class, $postCategory);
        $form->handleRequest($this->request->getMainRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postCategoryRepository->add($postCategory, true);

            $this->addFlash('notice', $this->translator->trans('category.flash.saved'));

            return $this->redirectToRoute('aropixel_blog_category_edit', ['id' => $postCategory->getId()]);
        }

        return $this->render('@AropixelBlog/category/form.html.twig', [
            'category' => $postCategory,
            'form' => $form->createView(),
        ]);
    }
}
