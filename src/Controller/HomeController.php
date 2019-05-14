<?php

namespace App\Controller;

use App\Service\Paths;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MealRepository;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param MealRepository $mealRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(
        PaginatorInterface $paginator,
        MealRepository $mealRepository,
        Request $request
    ) {
        // validator to check if isset GET parameters, Category, tags or lang parameters
        if (empty($request->query->all()) or
            !isset($request->query->all()['category']) and
            !isset($request->query->all()['tags'])  or
            !isset($request->query->all()['lang'])) {
            // get erorrs
            $error = $this->getValidator($request);
            return $error;
        } else {
            $meal = $this->getMealResults($request, $mealRepository, $paginator);

            $language = $request->query->all()['lang'];

            // validator to check if meal is empty, if not continue
            if (empty($meal->getItems())) {
                $error = $this->validator($meal->getItems());
                return $error;
            } else {
                if (isset($request->query->all()['with'])) {
                    $with = $request->query->all()['with'];
                } else {
                    $with = null;
                }
                $meals[] = $this->getMealInfo($meal, $language, $with);

                return $this->returnJson($meals, $meal, $this->getLinks($meal));
            }

        }
    }

    /**
     * @param $data
     * @param $metaInfo
     * @param $links
     * @return JsonResponse
     */
    public function returnJson($data, $metaInfo, $links)
    {
        $meta = array(
            'currentPage' => $metaInfo->getCurrentPageNumber(),
            'totalItems' => $metaInfo->getTotalItemCount(),
            'itemsPerPage' => $metaInfo->getItemNumberPerPage(),
            'totalPages' => $metaInfo->getPageCount()
        );
        $response = new JsonResponse([
            'meta' => $meta,
            'data' => $data,
            'links' => $links
        ]);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        return $response;
    }

    /**
     * @param Request $request
     * @param MealRepository $mealRepository
     * @param PaginatorInterface $paginator
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function getMealResults(Request $request, MealRepository $mealRepository, PaginatorInterface $paginator)
    {
        // get meal by category
        if (isset($request->query->all()['category']) and isset($request->query->all()['diff_time'])) {
            $meal = $mealRepository->getMealsByCategoryTime(
                $request->query->all()['category'],
                $request->query->all()['diff_time']
            );
        } elseif (isset($request->query->all()['category'])) {
            $meal = $mealRepository->getMealsByCategory($request->query->all()['category']);
        }
        // get meal by tags
        if (isset($request->query->all()['tags']) and isset($request->query->all()['diff_time'])) {
            $meal = $mealRepository->getMealByTagsTime(
                $request->query->all()['tags'],
                $request->query->all()['diff_time']
            );
        } elseif (isset($request->query->all()['tags'])) {
            $meal = $mealRepository->getMealByTags($request->query->all()['tags']);
        }
        $meal = $this->paginator($meal, $request, $paginator);
        return $meal;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getValidator($request)
    {
        if (empty($request->query->all())) {
            $error = 'insert GET Parameters';
        } elseif (!isset($request->query->all()['category']) and !isset($request->query->all()['tags'])) {
            $error = 'Insert Category or Tags';
        } elseif (!isset($request->query->all()['lang'])) {
            $error = 'Insert Lang Parameter';
        }
        $response = new JsonResponse([
            'Errors' => $error,

        ]);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        return $response;
    }

    /**
     * @param $validator
     * @return JsonResponse
     */
    public function validator($validator)
    {
        if (empty($validator)) {
            $response = new JsonResponse([
                'Errors' => 'Wrong get values',

            ]);
        }
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        return $response;
    }

    /**
     * @param $meals
     * @param $lang
     * @param $with
     * @return array
     */
    public function getMealInfo($meals, $lang, $with)
    {
        foreach ($meals as $meal) {
            $mealTitle = $this->getDoctrine()->getRepository('App\Entity\MealTrans')
                ->findOneBy([
                    'meal' => $meal->getId(),
                    'languageCode' => $lang
                ]);
            if (empty($meal->getCategory())) {
                $category = 'Meal dont have category';
            } else {
                // get Category with language
                $category = null;
                $CategoryTitle = $this->getDoctrine()->getRepository('App\Entity\CategoryTrans')
                    ->findOneBy([
                        'category' => $meal->getCategory()->getId(),
                        'languageCode' => $lang
                    ]);
                $category[] = array(
                    'Category-ID' => $meal->getCategory()->getId(),
                    'Category-Title' => $CategoryTitle->getTranslation(),
                    'Category-Slug' => $meal->getCategory()->getSlug()
                );
            }
            // get Tags with language
            $tags = null;
            foreach ($meal->getTags() as $tag) {
                $tagTitle = $this->getDoctrine()->getRepository('App\Entity\TagTrans')
                    ->findOneBy([
                        'tag' => $tag['ID-Tag'],
                        'languageCode' => $lang
                    ]);
                $tags[] = array(
                    'ID-Tag' => $tag['ID-Tag'],
                    'Title-Tag-Lang' => $tagTitle->getTranslation(),
                    'Slug-Tag' => $tag['Slug-Tag'],
                );
            }
            // get Ingredients with language
            $ingredients = null;
            foreach ($meal->getIngredients() as $ingredient) {
                $ingredientTitle = $this->getDoctrine()->getRepository('App\Entity\IngredeintTrans')
                    ->findOneBy([
                        'ingredient' => $ingredient['ID-ingredients'],
                        'languageCode' => $lang
                    ]);
                $ingredients[] = array(
                    'ID-ingredients' => $ingredient['ID-ingredients'],
                    'Title-Tag-Lang' => $ingredientTitle->getTranslation(),
                    'Slug-Tag' => $ingredient['Slug-ingredients'],
                );
            }

            //get Meal info
            $arrayMeals = array(
                'Meal-ID' => $meal->getId(),
                'Meal-Title' => $mealTitle->getTranslation(),
                'Meal-STATUS' => $meal->getStatus(),
            );

            // if isset GET with
            if ($with != null) {
                $withParameter = explode(',', $with);
                if (in_array('category', $withParameter)) {
                    $arrayMeals['category'] = $category;
                }
                if (in_array('tags', $withParameter)) {
                    $arrayMeals['tags'] = $tags;
                }
                if (in_array('ingredients', $withParameter)) {
                    $arrayMeals['ingredients'] = $ingredients;
                }
            } else {
                $arrayMeals['category'] = $category;
                $arrayMeals['tags'] = $tags;
                $arrayMeals['ingredients'] = $ingredients;
            }
            $me[] = $arrayMeals;
        }
        return $me;
    }

    /**
     * @param $meal
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function paginator($meal, Request $request, PaginatorInterface $paginator)
    {

        $meal = $paginator->paginate(
            $meal, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('per_page', 10)
        );/*limit per page*/
        return $meal;
    }

    /**
     * @param $mealJson
     * @return array
     */
    public function getLinks($mealJson)
    {
        $path = new Paths($_SERVER['REQUEST_URI']);
        if ($mealJson->getCurrentPageNumber() < 2) {
            $prev = null;
        } else {
            $path->editQuery('page', $mealJson->getCurrentPageNumber() - 1);
            $prev = $_SERVER['HTTP_HOST'] . $path->returnUrl();
        }
        if ($mealJson->getCurrentPageNumber() == $mealJson->getPageCount()) {
            $next = null;
        } else {
            $path->editQuery('page', $mealJson->getCurrentPageNumber() + 1);
            $next = $_SERVER['HTTP_HOST'] . $path->returnUrl();
        }

        $links = array(
            'prev' => $prev,
            'self' => $_SERVER['HTTP_HOST'] . $path->returnUrl(),
            'next' => $next

        );
        return $links;
    }
}