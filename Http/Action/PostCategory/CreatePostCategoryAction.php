<?php

namespace Aropixel\BlogBundle\Http\Action\PostCategory;

use Aropixel\BlogBundle\Entity\PostCategory;
use Aropixel\BlogBundle\Form\PostCategoryType;
use Aropixel\BlogBundle\Repository\PostCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class CreatePostCategoryAction extends AbstractController
{
    public function __construct(
        private readonly PostCategoryRepository $postCategoryRepository,
        private readonly RequestStack $request
    ){}

    public function __invoke() : Response
    {
        $postCategory = new PostCategory();

        $form = $this->createForm(PostCategoryType::class, $postCategory);
        $form->handleRequest($this->request->getMainRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postCategoryRepository->add($postCategory, true);

            $this->addFlash('notice', 'La catégorie a bien été enregistrée.');
            return $this->redirectToRoute('aropixel_blog_category_edit', array('id' => $postCategory->getId()));
        }

        return $this->render('@AropixelBlog/category/form.html.twig', [
            'category' => $postCategory,
            'form' => $form->createView(),
        ]);
    }
}