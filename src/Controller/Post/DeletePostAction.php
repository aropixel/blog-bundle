<?php

namespace Aropixel\BlogBundle\Controller\Post;

use Aropixel\BlogBundle\Entity\Post;
use Aropixel\BlogBundle\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class DeletePostAction extends AbstractController
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function __invoke(Request $request, Post $post): Response
    {
        $title = $post->getTitle();

        if ($this->isCsrfTokenValid('delete__post' . $post->getId(), $request->request->get('_token'))) {
            $this->postRepository->remove($post, true);
            $this->addFlash('notice', $this->translator->trans('post.flash.deleted', ['{title}' => $title]));
        }

        return $this->redirect($this->generateUrl('aropixel_blog_post_index'));
    }
}
