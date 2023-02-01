<?php

namespace Aropixel\BlogBundle\Http\Action\PostCategory;

use Aropixel\BlogBundle\Http\Form\PostCategory\FormFactory;
use Aropixel\BlogBundle\Repository\PostCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class DeletePostCategoryAction extends AbstractController
{

    public function __construct(
        private readonly FormFactory $formFactory,
        private readonly PostCategoryRepository $postCategoryRepository,
        private readonly RequestStack $request,
    )
    {}

    public function  __invoke(int $id) : Response
    {
        $postCategory = $this->postCategoryRepository->find($id);
        $title = $postCategory->getName();


        $form = $this->formFactory->createDeleteForm($postCategory);
        $form->handleRequest($this->request->getMainRequest());

        dump('checkpoint1');
        dump($form);
        if ($form->isSubmitted() && $form->isValid()) {
            dump('checkpoint2');

            $this->postCategoryRepository->remove($postCategory, true);
            $this->addFlash('notice', 'La catégorie "'.$title.'" a bien été supprimée.');
        }

        dump('checkpoint3');
        return $this->redirect($this->generateUrl('aropixel_blog_category_index'));

    }

}