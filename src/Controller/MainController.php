<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\PostRepository;
use App\Repository\PostRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    public function __construct(CategoryRepositoryInterface $categoryRepository,
                                PostRepositoryInterface $postRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }

    public function custom(PostRepository $postRepository,
                           CategoryRepository $categoryRepository)
    {
        $posts = $postRepository->findAll(['create_at'], ['sort' => 'desc'], 4);
        $categories = $categoryRepository->findAll();

        return $this->render('main/custom.html.twig',
            compact('posts', 'categories'));
    }
}
