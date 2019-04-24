Blue Factory Task


    /**
     * @Route("getJsonResult", name="getJsonResult")
     * @param                      CategoryRepository $reservationRepository
     * @param MealRepository $mealRepository
     * @param LanguagesRepository $languages
     * @param TagMealRepository $tagMealRepo
     * @param                      Request $request
     * @return                                 Response
     */
    public function getJsonResult(TagMealRepository $tagMealRepo,MealRepository $mealRepository,CategoryRepository $reservationRepository, Request $request,LanguagesRepository $languages)
    {
        $reservations = $mealRepository->findOneBy(['id' => 1]);
        $tagmeal = $tagMealRepo->findBy(['meal' => 1]);

        foreach($tagmeal as $key) {
            $id = $key->getTag()->getId();
            $title = $key->getTag()->getTitle();
            $slug = $key->getTag()->getSlug();

            $values[] = array(
                'id' => $id,
                'url' => $title,
                'slug' => $slug,

            );
        };


        return new JsonResponse(
            [
                'id' => $reservations->getId(),
                'title' => $reservations->getTitle(),
                'description' => $reservations->getDesctription(),
                'status' => $reservations->getStatus(),
                'category' => [
                     'id' => $reservations->getCategory()->getId(),
                     'title' => $reservations->getCategory()->getTitle(),
                     'slug' => $reservations->getCategory()->getSlug()

                ],
                'tags' => [
                    $values,
                ],
                'ingredients' => [
                    $reservations->getIngredients()
                ]
            ]
        );
    }