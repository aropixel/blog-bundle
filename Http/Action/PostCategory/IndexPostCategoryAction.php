<?php

namespace Aropixel\BlogBundle\Http\Action\PostCategory;

use Aropixel\BlogBundle\Http\Form\PostCategory\FormFactory;
use Aropixel\BlogBundle\Repository\PostCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexPostCategoryAction extends AbstractController
{
    public function __construct(
        private readonly PostCategoryRepository $postCategoryRepository,
        private readonly FormFactory $formFactory,
    ){}

    public function __invoke() : Response
    {
        $postCategories = $this->postCategoryRepository->findAll();

        $delete_forms = array();
        foreach ($postCategories as $postCategory) {
            $deleteForm = $this->formFactory->createDeleteForm($postCategory);
            $delete_forms[$postCategory->getId()] = $deleteForm->createView();
        }

        return $this->render('@AropixelBlog/category/index.html.twig', [
            'categories' => $this->postCategoryRepository->findAll(),
            'delete_forms' => $delete_forms,
        ]);
    }
}