<?php

namespace Aropixel\BlogBundle\Controller\Post;

use Aropixel\AdminBundle\Component\Translation\TranslationResolverInterface;
use Aropixel\BlogBundle\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class EditPostAction extends AbstractController
{
    public function __construct(
        private readonly RequestStack $request,
        private readonly PostRepository $postRepository,
        private readonly TranslationResolverInterface $translationResolver,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function __invoke(int $id): Response
    {
        $isTranslatable = $this->translationResolver->isTranslatable();

        $post = $this->postRepository->find($id);
        if (null === $post) {
            throw $this->createNotFoundException();
        }

        $forms = $this->getParameter('aropixel_blog.forms');
        $formName = $isTranslatable ? $forms['post_translatable'] : $forms['post'];

        $editForm = $this->createForm($formName, $post);
        $editForm->handleRequest($this->request->getMainRequest());

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->postRepository->add($post, true);
            $this->addFlash('notice', $this->translator->trans('post.flash.saved'));

            return $this->redirectToRoute('aropixel_blog_post_edit', ['id' => $post->getId()]);
        }

        return $this->render('@AropixelBlog/post/form.html.twig', [
            'post' => $post,
            'form' => $editForm->createView(),
        ]);
    }
}
