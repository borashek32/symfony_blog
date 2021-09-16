<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }

    /**
     * @param Request $request
     * @Route("/custom/{name?}", name="custom")
     * @return Response
     */
    public function custom(Request $request): Response
    {
        $name = $request->get('name');
        return $this->render('main/custom.html.twig', compact('name'));
    }
}
