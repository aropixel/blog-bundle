<?php

namespace Aropixel\BlogBundle\Http\Action\PostCategory;

use Aropixel\BlogBundle\Form\PostCategoryType;
use Aropixel\BlogBundle\Http\Form\PostCategory\FormFactory;
use Aropixel\BlogBundle\Repository\PostCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class EditPostCategoryAction extends AbstractController
{
    public function __construct(
        private readonly FormFactory $formFactory,
        private readonly RequestStack $request,
        private readonly PostCategoryRepository $postCategoryRepository,
    ){}

    public function __invoke(int $id) : Response
    {
         $postCategory = $this->postCategoryRepository->find($id);

        if (is_null($postCategory)) {
            throw $this->createNotFoundException();
        }

        $deleteForm = $this->formFactory->createDeleteForm($postCategory);
        $editForm = $this->createForm(PostCategoryType::class, $postCategory);
        $editForm->handleRequest($this->request->getMainRequest());

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->postCategoryRepository->add($postCategory, true);
            $this->addFlash('notice', 'La catégorie a bien été enregistrée.');

            return $this->redirectToRoute('aropixel_blog_category_edit', array('id' => $postCategory->getId()));
        }

        return $this->render('@AropixelBlog/category/form.html.twig', [
            'category' => $postCategory,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView()
        ]);
    }
}