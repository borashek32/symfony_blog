<?php


namespace App\Service;


use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManagerService implements FileManagerServiceInterface
{

    private $imageDirectory;

    public function __construct($imageDirectory)
    {
        $this->imageDirectory = $imageDirectory;
    }

    /**
     * @return mixed
     */
    public function getImageDirectory()
    {
        return $this->imageDirectory;
    }

    public function imageUpload(UploadedFile $file): string
    {
        $fileName = uniqid().'.'.$file->guessExtension();
        $file->move($this->getImageDirectory(), $fileName);

        return $fileName;
    }

    public function removeImage(string $fileName)
    {
        $fileSystem = new Filesystem();
        $fileImage = $this->getImageDirectory().''.$fileName;
        $fileSystem->remove($fileImage);
    }

}