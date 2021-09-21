<?php

namespace App\Repository;

use App\Entity\Category;
use App\Service\FileManagerServiceInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    private $em; // entity manager
    private $fm; // file manager

    public function __construct(ManagerRegistry $registry,
                                EntityManagerInterface $manager,
                                FileManagerServiceInterface $fileManagerService)
    {
        $this->em = $manager;
        $this->fm = $fileManagerService;
        parent::__construct($registry, Category::class);
    }

    public function getAllCategory(): array
    {
        return parent::findAll();
    }

    public function getOneCategory(int $categoryId): object
    {
        return parent::find($categoryId);
    }

    public function setCreateCategory(Category $category, UploadedFile $file): object
    {
        if ($file) {
            $fileName = $this->fm->imageUpload($file);
            $category->setImage($fileName);
        }
        $category->setCreateAtValue();
        $category->setUpdateAtValue();
        $category->setIsPublished();
        $this->em->persist($category);
        $this->em->flush();

        return $category;
    }

    public function setUpdateCategory(Category $category, UploadedFile $file): object
    {
        $fileName = $category->getImage();
        if ($file) {
            if ($fileName) {
                $this->fm->removeImage($fileName);
            }
            $fileName = $this->fm->imageUpload($file);
            $category->setImage($fileName);
        }
        $category->setUpdateAtValue();
        $this->em->flush();

        return $category;
    }

    public function setDeleteCategory(Category $category): object
    {
        // TODO: Implement setDeletePost() method.
    }
}
