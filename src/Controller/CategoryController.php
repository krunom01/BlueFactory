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
use App\Repository\LanguagesRepository;
use App\Repository\MealRepository;
use App\Entity\CategoryTrans;
use Symfony\Component\HttpFoundation\JsonResponse;




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
     * @param         LanguagesRepository $languages
     * @return Response
     */
    public function newCategory(
        Request $request,
        EntityManagerInterface $entityManager,
        LanguagesRepository $languages
    )
    {
        $category = new Category;
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $lang = $languages->findAll();
            foreach ($lang as $lan) {
                $trans = new CategoryTrans();
                $trans->setCategory($category);
                $trans->setLanguageCode($lan->getCode());
                $trans->setTranslation('Naslov Kategorije na' . $lan->getName() . 'jeziku');
                $entityManager->persist($trans);
                $entityManager->flush();

            }
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

        $nesto = $category->getCategoryTrans();
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

    /**
     * @Route("getJsonResult", name="getJsonResult")
     * @param MealRepository $mealRepository
     * @param Request $request
     * @return                                 Response
     */
    public function getJsonResultByCategory(MealRepository $mealRepository,Request $request)
    {

        $categoryJson = $mealRepository->findBy(['category' => $request->get('category')]);

        if($categoryJson) {
            foreach ($categoryJson as $key) {
                $id = $key->getId();
                $title = $key->getTitle();
                $status = $key->getStatus();
                $categoryID = $key->getCategory()->getId();
                $categoryTitle = $key->getCategory()->getTitle();
                $categorySlug = $key->getCategory()->getSlug();
                $mealsTag = $key->getTags();
                $mealsIngredient = $key->getIngredients();
                $tags = [];
                $ingredients = [];
                if (count($mealsTag) != 0) {
                    foreach ($mealsTag as $tag) {

                        $tags[] = array(
                            'ID-Tag' => $tag->getId(),
                            'Title-Tag' => $tag->getTitle(),
                            'Slug-Tag' => $tag->getSlug(),
                        );
                    }
                }
                if (count($mealsIngredient) != 0) {
                    foreach ($mealsIngredient as $ingredient) {

                        $ingredients[] = array(
                            'ID-Tag' => $ingredient->getId(),
                            'Title-Tag' => $ingredient->getTitle(),
                            'Slug-Tag' => $ingredient->getSlug(),
                        );
                    }
                }
                $values[] = array(
                    'ID-Meal' => $id,
                    'Title-Meal' => $title,
                    'Status-Meal' => $status,
                    'Category' => array(
                        'Category-ID' => $categoryID,
                        'Category-Title' => $categoryTitle,
                        'Category-Slug' => $categorySlug
                    ),
                    'Tags' => $tags,
                    'Ingredients' => $ingredients

                );
            };
            print_r($values);
        } else {
            $values = 0;
        }

        return new JsonResponse(
            [
                'data' => [
                    $values,
                ]
            ]
        );
    }

}
