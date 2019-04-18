<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;



class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(
        CategoryRepository $categoryRepository
    )
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

}
