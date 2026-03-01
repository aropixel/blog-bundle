<?php

namespace Aropixel\BlogBundle\Controller\Post;

use Aropixel\AdminBundle\Component\Translation\TranslationResolverInterface;
use Aropixel\AdminBundle\Entity\Publishable;
use Aropixel\BlogBundle\Entity\PostInterface;
use Aropixel\BlogBundle\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class CreatePostAction extends AbstractController
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly RequestStack $request,
        private readonly TranslationResolverInterface $translationResolver,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function __invoke(): Response
    {
        $isTranslatable = $this->translationResolver->isTranslatable();
        $entities = $this->getParameter('aropixel_blog.entities');
        $forms = $this->getParameter('aropixel_blog.forms');
        $entityName = $entities[PostInterface::class];
        $formName = $isTranslatable ? $forms['post_translatable'] : $forms['post'];

        $post = new $entityName();
        $post->setStatus(Publishable::STATUS_OFFLINE);

        $form = $this->createForm($formName, $post);
        $form->handleRequest($this->request->getMainRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postRepository->add($post, true);

            $this->addFlash('notice', $this->translator->trans('post.flash.saved'));

            return $this->redirectToRoute('aropixel_blog_post_edit', ['id' => $post->getId()]);
        }

        return $this->render('@AropixelBlog/post/form.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
}
