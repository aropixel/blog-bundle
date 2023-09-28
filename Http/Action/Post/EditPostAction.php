<?php

namespace Aropixel\BlogBundle\Http\Action\Post;

use Aropixel\BlogBundle\Form\PostType;
use Aropixel\BlogBundle\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class EditPostAction extends AbstractController
{
    public function __construct(
        private readonly RequestStack $request,
        private readonly PostRepository $postRepository
    ){}

    private string $form = PostType::class;

    public function __invoke(int $id) : Response
    {
         $post = $this->postRepository->find($id);

        if (is_null($post)) {
            throw $this->createNotFoundException();
        }

        $editForm = $this->createForm($this->form, $post);
        $editForm->handleRequest($this->request->getMainRequest());

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->postRepository->add($post, true);
            $this->addFlash('notice', 'Le post a bien été enregistré.');

            return $this->redirectToRoute('aropixel_blog_post_edit', array('id' => $post->getId()));
        }

        return $this->render('@AropixelBlog/post/form.html.twig', [
            'post' => $post,
            'form' => $editForm->createView()
        ]);
    }
}