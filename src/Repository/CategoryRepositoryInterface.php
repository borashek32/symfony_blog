<?php


namespace App\Repository;


use App\Entity\Category;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

interface CategoryRepositoryInterface
{
    /**
     * @return array
     */
    public function getAllCategory(): array;

    /**
     * @return object
     */
    public function getOneCategory(int $categoryId): object;

    /**
     * @param Category $post
     * @param UploadedFile $file
     * @return Category $category
     */
    public function setCreateCategory(Category $category, UploadedFile $file): object;

    /**
     * @param Category $post
     * @param UploadedFile $file
     * @return Category $category
     */
    public function setUpdateCategory(Category $category, UploadedFile $file): object;

    /**
     * @param Category $category
     * @param string $fileName
     */
    public function setDeleteCategory(Category $category): object;
}