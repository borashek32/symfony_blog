<?php

namespace App\Controller\Category;

use App\Repository\CategoryRepository;
use App\Service\Category\GetAllCategoriesService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetAllCategoryController extends AbstractController
{
    /**
     * @Route("/category/json", name="categpry.json", methods={"GET"})
     */
    public function allCatsJson(GetAllCategoriesService $allCategoriesService,
                                CategoryRepository $categoryRepository,
                                SerializerInterface $serializer)
    {
        $cats = $allCategoriesService->getAllCategories($categoryRepository);
        $catsJson = $serializer->serialize(
            $cats,
            'json',
            ['category' => 'show_category']
        );
        $response = new Response($catsJson);

        return $response;
    }
}