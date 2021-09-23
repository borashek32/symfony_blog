<?php

namespace App\Controller\Blog;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\CategoryRepository;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\PostRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PostController extends AbstractController
{
    private $postRepository;
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository,
                                PostRepositoryInterface $postRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }

    public function posts()
    {
        $posts = $this->postRepository->findAll();

        return $this->render('post/index.html.twig', compact('posts'));
    }

    /**
     * @param Request $request
     * @param CategoryRepository $categoryRepository
     * @return RedirectResponse|Response
     */
    public function create(Request $request, CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->getAllCategory();

        if ($categories) {
            $post = new Post;
            $form = $this->createForm(PostType::class, $post);
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $file = $form->get('image')->getData();
                $this->postRepository->setCreatePost($post, $file);
                $this->addFlash('success', 'Your post was created');

                return $this->redirect($this->generateUrl('posts'));
            }

            // return a response
            return $this->render('post/create.html.twig', [
                'form' => $form->createView()
            ]);
        } else {
            return $this->render('post/no-category.html.twig');
        }
    }

    public function show(Post $post)
    {
        return $this->render('post/post.html.twig', compact('post'));
    }

    public function remove(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        $this->addFlash('success', 'Your post was removed');

        return $this->redirect($this->generateUrl('post.index'));
    }

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
