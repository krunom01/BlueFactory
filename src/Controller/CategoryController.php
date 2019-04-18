<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CategoryFormType;
use App\Entity\Category;
use Stichoza\GoogleTranslate\GoogleTranslate;


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
    /**
     * @Route("/categories/new", name="newCategory")
     * @param         Request $request
     * @param         EntityManagerInterface $entityManager
     * @return Response
     * @throws
     */
    public function newCategory(
        Request $request,
        EntityManagerInterface $entityManager
    ) {
        $category = new Category;
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
            $tr->setTarget('hr');
            $asd = $tr->translate('dsfsdff');
            $this->addFlash('success', 'Successfully added new Category!');
            return $this->redirectToRoute('categories');
        }
        return $this->render(
            'category/new.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
    /**
     * @Route("/categories/edit/{id}", name="editCategory")
     * @param         Request $request
     * @param         EntityManagerInterface $entityManager
     * @param Category $category
     * @return Response
     */
    public function editCategory(
        Request $request,
        EntityManagerInterface $entityManager,
        Category $category
    ) {
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);
        $nesto = $form->get('title')->getData();


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'Successfully edited Category!');
            return $this->redirectToRoute('categories');
        }
        return $this->render(
            'category/edit.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
    /**
     * @Route("/categories/delete/{id}", name="deleteCategory")
     * @param         EntityManagerInterface $entityManager
     * @param Category $category
     * @return Response
     */
    public function deleteCategory(
        EntityManagerInterface $entityManager,
        Category $category
    ) {

        $entityManager->remove($category);
        $entityManager->flush();
        $this->addFlash('success', 'Successfully deleted Category!');
        return $this->redirectToRoute('categories');


    }
}
