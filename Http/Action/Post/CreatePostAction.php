<?php

namespace Aropixel\BlogBundle\Http\Action\Post;

use Aropixel\AdminBundle\Entity\Publishable;
use Aropixel\BlogBundle\Entity\PostInterface;
use Aropixel\BlogBundle\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class CreatePostAction extends AbstractController
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly RequestStack $request
    ){}

    public function __invoke() : Response
    {
        $entities = $this->getParameter('aropixel_blog.entities');
        $forms = $this->getParameter('aropixel_blog.forms');
        $entityName = $entities[PostInterface::class];
        $formName = $forms['post'];

        $post = new $entityName();
        $post->setStatus(Publishable::STATUS_OFFLINE);

        $form = $this->createForm($formName, $post);
        $form->handleRequest($this->request->getMainRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postRepository->add($post, true);

            $this->addFlash('notice', 'Le post a bien été enregistré.');
            return $this->redirectToRoute('aropixel_blog_post_edit', array('id' => $post->getId()));
        }

        return $this->render('@AropixelBlog/post/form.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
}