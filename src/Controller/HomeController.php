<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LanguagesRepository;
use App\Repository\CategoryRepository;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param LanguagesRepository $languages
     * @param CategoryRepository $categories
     * @return Response
     */
    public function index(
        LanguagesRepository $languages,
        CategoryRepository $categories
    )
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'languages' => $languages->findAll(),
            'categories' => $categories->findAll()
        ]);
    }
}
