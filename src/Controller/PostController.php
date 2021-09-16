<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post.")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        return $this->render('post/index.html.twig', compact('posts'));
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        // create a new post with a title
        $post = new Post;
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // entity manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Your post was created');

            return $this->redirect($this->generateUrl('post.index'));
        }

        // return a response
        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param Post $post
     * @return Response
     */
    public function show(Post $post)
    {
        return $this->render('post/post.html.twig', compact('post'));
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Post $post
     * @return Response
     */
    public function remove(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        $this->addFlash('success', 'Your post was removed');

        return $this->redirect($this->generateUrl('post.index'));
    }

    /**
     * @Route("/edit/{id}", name="edit")
     * @param Post $post
     */
    public function update(Request $request, $id)
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // entity manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Your post was updated');

            return $this->redirect($this->generateUrl('post.index'));
        }
        return $this->render('post/edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post
        ]);
    }
}
