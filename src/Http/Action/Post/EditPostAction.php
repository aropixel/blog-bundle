<?php

namespace Aropixel\BlogBundle\Http\Action\Post;

use Aropixel\BlogBundle\Entity\Post;
use Aropixel\BlogBundle\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class EditPostAction extends AbstractController
{
    public function __construct(
        private readonly RequestStack $request,
        private readonly PostRepository $postRepository,
        private readonly ParameterBagInterface $parameterBag,
    ){}

    public function __invoke(int $id) : Response
    {
        $isTranslatable = $this->parameterBag->has('translatable') && $this->parameterBag->get('translatable');

        /** @var Post $post */
        $post = $this->postRepository->find($id);

        if (is_null($post)) {
            throw $this->createNotFoundException();
        }

        $forms = $this->getParameter('aropixel_blog.forms');
        $formName = $isTranslatable ? $forms['post_translatable'] : $forms['post'];

        $editForm = $this->createForm($formName, $post);
        $editForm->handleRequest($this->request->getMainRequest());

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->postRepository->add($post, true);
            $this->addFlash('notice', 'Le post a bien été enregistré.');

            return $this->redirectToRoute('aropixel_blog_post_edit', ['id' => $post->getId()]);
        }

        return $this->render('@AropixelBlog/post/form.html.twig', [
            'post' => $post,
            'form' => $editForm->createView()
        ]);
    }
}