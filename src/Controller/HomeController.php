<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LanguagesRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use App\Repository\MealRepository;
use App\Repository\CategoryTransRepository;
use App\Repository\MealTransRepository;
use App\Repository\TagTransRepository;
use App\Repository\IngredeintTransRepository;
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param LanguagesRepository $languages
     * @param CategoryRepository $categories
     * @param TagRepository $tags
     * @return Response
     */
    public function index(
        LanguagesRepository $languages,
        CategoryRepository $categories,
        TagRepository $tags
    )
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'languages' => $languages->findAll(),
            'categories' => $categories->findAll(),
            'tags' => $tags->findAll()
        ]);
    }
    /**
     * @Route("getJsonResultbyTags", name="getJsonResultbyTags")
     * @param MealRepository $mealRepository
     * @param Request $request
     * @return                                 Response
     */
    public function getJsonResultByTags(MealRepository $mealRepository,Request $request)
    {

        $tagJson = $mealRepository->getMealByTags($request->get('tags')); //get tags get request, array with JavaScript

        if($tagJson) {
            foreach ($tagJson as $key) {
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
    /**
     * @Route("getJsonResultByLang", name="getJsonResultByLang")
     * @param CategoryTransRepository $categoryTrans
     * @param MealTransRepository $mealTransRepository
     * @param TagTransRepository $tagTransRepository
     * @param IngredeintTransRepository $ingredientTransRepository
     * @param Request $request
     * @return                                 Response
     */
    public function getJsonResultByLang(
        IngredeintTransRepository $ingredientTransRepository,
        TagTransRepository $tagTransRepository,
        MealTransRepository $mealTransRepository,
        CategoryTransRepository $categoryTrans,
        Request $request)
    {

        $mealTrans = $mealTransRepository->findBy(['languageCode' => $request->get('lang')]);

        if($mealTrans) {
            foreach ($mealTrans as $key) {
                $mealID = $key->getMeal()->getId();
                $mealTransTitle = $key->getTranslation();
                $mealStatus = $key->getMeal()->getStatus();
                $catTrans = $categoryTrans->findOneBy([
                    'category' => $key->getMeal()->getCategory()->getId(),
                    'languageCode' => $request->get('lang')
                    ]);

                $mealsTag = $key->getMeal()->getTags();
                $mealIngredients = $key->getMeal()->getIngredients();
                $tags = [];
                $ingredients = [];
                if (count($mealsTag) != 0) {
                    foreach ($mealsTag as $tag) {
                        $tagTrans = $tagTransRepository->findOneBy([
                            'tag' => $tag->getId(),
                            'languageCode' => $request->get('lang')
                        ]);

                        $tags[] = array(
                            'ID-Tag' => $tag->getId(),
                            'Title-Tag-Lang' => $tagTrans->getTranslation(),
                            'Slug-Tag' => $tag->getSlug(),
                        );
                    }
                }
                if (count($mealIngredients) != 0) {
                    foreach ($mealIngredients as $ingredient) {
                        $ingredientTrans = $ingredientTransRepository->findOneBy([
                            'ingredient' => $ingredient->getId(),
                            'languageCode' => $request->get('lang')
                        ]);

                        $ingredients[] = array(
                            'ID-ingredients' => $ingredient->getId(),
                            'Title-ingredients-Lang' => $ingredientTrans->getTranslation(),
                            'Slug-ingredients' => $ingredient->getSlug(),
                        );
                    }
                }

                $values[] = array(
                    'ID-Meal' => $mealID,
                    'Title-Meal-Lang' => $mealTransTitle,
                    'Status-Meal' => $mealStatus,
                    'Category' => array(
                        'Category-ID' =>  $key->getMeal()->getCategory()->getId(),
                        'Category-Title-Lang' => $catTrans->getTranslation(),
                        'Category-Slug' => $key->getMeal()->getCategory()->getSlug()
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
    /**
     * @Route("getJsonResultWith", name="getJsonResultWith")
     * @param MealRepository $mealRepository
     * @param Request $request
     * @return                                 Response
     */
    public function getJsonResultWith(MealRepository $mealRepository,Request $request)
    {
        $meals = $mealRepository->findAll();
        $requestArray = $request->get('with');
        $category = 0;
        $t = 0;
        $int = 0;
         foreach ($requestArray as $key =>$value){
             if($value == 'category"'){
                 $category = 1;
             }
             if($value == 'tags"'){
                 $t = 1;
             }
             if($value == 'ingredients"'){
                 $int = 1;
             }
         }
        if($meals) {
            foreach ($meals as $key) {
                $id = $key->getId();
                $title = $key->getTitle();
                $status = $key->getStatus();
                $mealsTag = $key->getTags();
                $mealsIngredient = $key->getIngredients();
                $tags = [];
                $categories = [];
                $ingredients = [];
                if($category === 1){
                    $categories[] = array(
                        'Category-ID' => $key->getCategory()->getId(),
                        'Category-Title' => $key->getCategory()->getTitle(),
                        'Category-Slug' => $key->getCategory()->getSlug(),
                    );
                }
                if($t === 1) {
                    if (count($mealsTag) != 0) {
                        foreach ($mealsTag as $tag) {

                            $tags[] = array(
                                'ID-Tag' => $tag->getId(),
                                'Title-Tag' => $tag->getTitle(),
                                'Slug-Tag' => $tag->getSlug(),
                            );
                        }
                    }
                }
                if($int === 1) {
                    if (count($mealsIngredient) != 0) {
                        foreach ($mealsIngredient as $ingredient) {

                            $ingredients[] = array(
                                'Ingredient-ID' => $ingredient->getId(),
                                'Ingredient-Title' => $ingredient->getTitle(),
                                'Ingredient-Slug' => $ingredient->getSlug(),
                            );
                        }
                    }
                }
                $values[] = array(
                    'ID-Meal' => $id,
                    'Title-Meal' => $title,
                    'Status-Meal' => $status,
                    'Category' => $categories,
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

    /**
     * @Route("getJsonResultByGetParam", name="getJsonResultByGetParam")
     * @param CategoryTransRepository $categoryTrans
     * @param MealTransRepository $mealTransRepository
     * @param TagTransRepository $tagTransRepository
     * @param IngredeintTransRepository $ingredientTransRepository
     * @param MealRepository $mealRepository
     * @param Request $request
     * @return                                 Response
     */
    public function getJsonResultByGetParam(
        IngredeintTransRepository $ingredientTransRepository,
        TagTransRepository $tagTransRepository,
        MealTransRepository $mealTransRepository,
        CategoryTransRepository $categoryTrans,
        MealRepository $mealRepository,
        Request $request)
    {
        $tagJson = $mealRepository->getMealByTagsTime($request->get('tags'),$request->get('date') );
        $requestArray = $request->get('with');
        $category = 0;
        $t = 0;
        $int = 0;
        if ($requestArray){
            foreach ($requestArray as $key => $value) {
                if ($value == 'category') {
                    $category = 1;
                }
                if ($value == 'tags') {
                    $t = 1;
                }
                if ($value == 'ingredients') {
                    $int = 1;
                }
            }
        }

        if($tagJson) {
            foreach ($tagJson as $key) {
                $id = $key->getId();
                $title = $key->getTitle();
                $status = $key->getStatus();
                $catTrans = $categoryTrans->findOneBy([
                    'category' => $key->getCategory()->getId(),
                    'languageCode' => $request->get('lang')
                ]);
                $tags = [];
                $categories = [];
                $ingredients = [];
                if($category === 1){
                    $categories[] = array(
                        'Category-ID' => $key->getCategory()->getId(),
                        'Category-Title' => $catTrans->getTranslation(),
                        'Category-Slug' => $key->getCategory()->getSlug(),
                    );
                }
                $mealsTag = $key->getTags();
                $mealsIngredient = $key->getIngredients();
                $tags = [];
                $ingredients = [];
                if($t === 1) {
                    if (count($mealsTag) != 0) {
                        foreach ($mealsTag as $tag) {
                            $tagTrans = $tagTransRepository->findOneBy([
                                'tag' => $tag->getId(),
                                'languageCode' => $request->get('lang')
                            ]);
                            $tags[] = array(
                                'ID-Tag' => $tag->getId(),
                                'Title-Tag' => $tagTrans->getTranslation(),
                                'Slug-Tag' => $tag->getSlug(),
                            );
                        }
                    }
                }
                if($int === 1) {
                    if (count($mealsIngredient) != 0) {
                        foreach ($mealsIngredient as $ingredient) {
                            $ingredientTrans = $ingredientTransRepository->findOneBy([
                                'ingredient' => $ingredient->getId(),
                                'languageCode' => $request->get('lang')
                            ]);

                            $ingredients[] = array(
                                'ID-Tag' => $ingredient->getId(),
                                'Title-Tag' => $ingredientTrans->getTranslation(),
                                'Slug-Tag' => $ingredient->getSlug(),
                            );
                        }
                    }
                }
                $values[] = array(
                    'ID-Meal' => $id,
                    'Title-Meal' => $title,
                    'Status-Meal' => $status,
                    'Category' => $categories,
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
