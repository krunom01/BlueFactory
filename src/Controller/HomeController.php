<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MealRepository;
use App\Repository\CategoryTransRepository;
use App\Repository\MealTransRepository;
use App\Repository\TagTransRepository;
use App\Repository\IngredeintTransRepository;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param MealRepository $mealRepository
     * @param Request $request
     * @param CategoryTransRepository $categoryTransRepository
     * @param MealTransRepository $mealTransRepository
     * @param TagTransRepository $tagTransRepository
     * @param IngredeintTransRepository $ingredientTransRepository
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(
        PaginatorInterface $paginator,
        MealRepository $mealRepository,
        CategoryTransRepository $categoryTransRepository,
        TagTransRepository $tagTransRepository,
        IngredeintTransRepository $ingredientTransRepository,
        Request $request,
        MealTransRepository $mealTransRepository
    ) {
        // filter by Category -  example:?category=1

        if (isset($request->query->all()['category'])) {
            $mealsWithCategories = $mealRepository->findBy(['category' => $request->get('category')]);

            $this->validator($mealsWithCategories);

            $mealsWithCategories = $paginator->paginate(
                $mealsWithCategories, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                $request->query->getInt('per_page', 10)/*limit per page*/
            );
            $meals = [];
            foreach ($mealsWithCategories as $key) {
                $meals[] = $key->getMealsByGet();
            }
            return $this->returnJson($meals);
        } // filter by Tags -  example:?tags=2,3
        elseif (isset($request->query->all()['tags'])) {
            // check if isset GET paramater diff_time  example for test : diff_time = 1549753200
            if (isset($request->query->all()['diff_time'])) {
                if ($request->get('diff_time') > 0) {
                    $mealJson = $mealRepository->getMealByTagsTime(
                        $request->get('tags'),
                        date('Y-m-d', $request->get('diff_time'))
                    );
                } else {
                    echo "wrong diff time value!";
                    exit;
                }
            } else {
                $mealJson = $mealRepository->getMealByTags($request->get('tags'));
            }

            // meals paginator
            $mealJson = $paginator->paginate(
                $mealJson, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                $request->query->getInt('per_page', 10)/*limit per page*/
            );
            // meals validator, if meals not exists, exit
            $this->validator($mealJson->getItems());

            // if isset GET lang, find translate
            if (isset($request->query->all()['lang'])) {
                foreach ($mealJson as $key) {
                    $mealTrans = $mealTransRepository->findOneBy([
                        'meal' => $key->getId(),
                        'languageCode' => $request->get('lang')
                    ]);

                    $categoryTrans = $categoryTransRepository->findOneBy([
                        'category' => $key->getCategory()->getId(),
                        'languageCode' => $request->get('lang')
                    ]);
                    $category = null;
                    $tags = [];
                    $ingredients = [];
                    $category = array(
                        'category-ID' => $key->getCategory()->getId(),
                        'category-Title' => $categoryTrans->getTranslation(),
                        'category-Slug' => $key->getCategory()->getSlug()
                    );
                    foreach ($key->getTags() as $tag) {
                        $tagTrans = $tagTransRepository->findOneBy([
                            'tag' => $tag['ID-Tag'],
                            'languageCode' => $request->get('lang')
                        ]);
                        $tags[] = array(
                            'ID-Tag' => $tag['ID-Tag'],
                            'Title-Tag-Lang' => $tagTrans->getTranslation(),
                            'Slug-Tag' => $tag['Slug-Tag'],
                        );
                    }
                    foreach ((array)$key->getIngredients() as $ingredient) {
                        $ingredientsTrans = $ingredientTransRepository->findOneBy([
                            'ingredient' => $ingredient['ID-ingredients'],
                            'languageCode' => $request->get('lang')
                        ]);
                        $ingredients[] = array(
                            'ID-ingredients' => $ingredient['ID-ingredients'],
                            'Title-Tag-Lang' => $ingredientsTrans->getTranslation(),
                            'Slug-Tag' => $ingredient['Slug-ingredients'],
                        );
                    }
                    if (isset($request->query->all()['with'])) {
                        $array = array(
                            'meal-Id' => $key->getId(),
                            'meal-Title' => $mealTrans->getTranslation(),
                            'meal-Status' => $key->getStatus(),
                        );
                        // if get WTIH = category,tags or ingredients, add data to array

                        if (strpos($request->query->all()['with'], 'category') !== false) {
                            $array['category'] = $category;
                        }
                        if (strpos($request->query->all()['with'], 'tags') !== false) {
                            $array['tags'] = $tags;
                        }
                        if (strpos($request->query->all()['with'], 'ingredient') !== false) {
                            $array['ingredients'] = $ingredients;
                        }
                        $meal[] = $array;
                    } else {
                        $meal[] = array(
                            'meal-Id' => $key->getId(),
                            'meal-Title' => $mealTrans->getTranslation(),
                            'meal-Status' => $key->getStatus(),
                            'category' => $category,
                            'tags' => $tags,
                            'ingredients' => $ingredients
                        );
                    }
                }
            } else {
                foreach ($mealJson as $key) {
                    $tags = $key->getTags();
                    $ingredients = $key->getIngredients();
                    $category = null;

                    $category = array(
                        'category-ID' => $key->getCategory()->getId(),
                        'category-Title' => $key->getCategory()->getTitle(),
                        'category-Slug' => $key->getCategory()->getSlug()
                    );
                    $meal[] = array(
                        'meal-Id' => $key->getId(),
                        'meal-Title' => $key->getTitle(),
                        'meal-Status' => $key->getStatus(),
                        'category' => $category,
                        'tags' => $tags,
                        'ingredients' => $ingredients
                    );
                }
            }
            return $this->returnJson($meal);
        } else {
            return $this->render('test.html.twig');
        }
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function returnJson($data)
    {
        $response = new JsonResponse(['data' => $data,]);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        return $response;
    }

    /**
     * @param $validator
     */
    public function validator($validator)
    {

        if (empty($validator)) {
            echo "wrong values!";
            exit;
        }
    }


}