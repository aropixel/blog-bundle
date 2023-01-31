<?php

namespace Aropixel\BlogBundle\Http\Action\Post;

use Aropixel\BlogBundle\Http\Form\Blog\FormFactory;
use Aropixel\BlogBundle\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class DeletePostAction extends AbstractController
{

    public function __construct(
        private readonly FormFactory $formFactory,
        private readonly PostRepository $postRepository,
        private readonly RequestStack $request,
    )
    {}

    public function  __invoke(int $id) : Response
    {
        $post = $this->postRepository->find($id);
        $title = $post->getTitle();

        if (is_null($post)) {
            throw $this->createNotFoundException();
        }


        $form = $this->formFactory->createDeleteForm($post);
        $form->handleRequest($this->request->getMainRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', 'Le post "'.$title.'" a bien été supprimé.');
            $this->postRepository->remove($post, true);
        }

        return $this->redirect($this->generateUrl('aropixel_blog_post_index'));

    }

}