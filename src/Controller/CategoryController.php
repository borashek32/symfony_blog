<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\CategoryRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category", name="category.")
 */
class CategoryController extends AbstractController
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * @Route("/category", name="index")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $this->categoryRepository->getAllCategory();

        return $this->render('category/index.html.twig', compact('categories'));
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $file = $form->get('image')->getData();
            $this->categoryRepository->setCreateCategory($category, $file);
            $this->addFlash('success', 'Your category was created');

            return $this->redirect($this->generateUrl('category.index'));
        }

        return $this->render('category/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param Category $category
     * @return Response
     */
    public function show(Category $category)
    {
        return $this->render('category/category.html.twig', compact('category'));
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Category $category
     * @return Response
     */
    public function remove(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        $this->addFlash('success', 'Your category was removed');

        return $this->redirect($this->generateUrl('category.index'));
    }

    /**
     * @Route("/edit/{id}", name="edit")
     * @param Category $category
     */
    public function update(Request $request, $id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // entity manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'Your category was updated');

            return $this->redirect($this->generateUrl('category.index'));
        }
        return $this->render('category/edit.html.twig', [
            'form' => $form->createView(),
            'post' => $category
        ]);
    }
}
