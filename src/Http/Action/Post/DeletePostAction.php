<?php

namespace Aropixel\BlogBundle\Http\Action\Post;

use Aropixel\BlogBundle\Entity\Post;
use Aropixel\BlogBundle\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeletePostAction extends AbstractController
{

    public function __construct(
        private readonly PostRepository $postRepository
    )
    {}

    public function  __invoke(Request $request, Post $post) : Response
    {
        $title = $post->getTitle();

        if ($this->isCsrfTokenValid('delete__post' . $post->getId(), $request->request->get('_token'))) {
            $this->postRepository->remove($post, true);
            $this->addFlash('notice', 'Le post "'.$title.'" a bien été supprimé.');
        }

        return $this->redirect($this->generateUrl('aropixel_blog_post_index'));

    }

}