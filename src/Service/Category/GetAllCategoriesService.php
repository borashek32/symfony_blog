<?php

namespace App\Service\Category;

use App\Repository\CategoryRepository;

class GetAllCategoriesService
{
    public function getAllCategories(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $categories;
    }
}