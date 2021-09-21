<?php


namespace App\Repository;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface PostRepositoryInterface
{
    /**
     * @return array
     */
    public function getAllPosts(): array;

    /**
     * @return object
     */
    public function getOnePost(int $postId): object;

    /**
     * @param Post $post
     * @param UploadedFile $file
     * @return Post $post
     */
    public function setCreatePost(Post $post, UploadedFile $file): object;

    /**
     * @param Post $post
     * @param UploadedFile $file
     * @return Post $post
     */
    public function setUpdatePost(Post $post, UploadedFile $file): object;

    /**
     * @param Post $post
     * @param string $fileName
     */
    public function setDeletePost(Post $post, string $fileName);
}