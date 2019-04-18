<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LanguagesRepository;
use App\Form\LanguagesFormType;
use App\Entity\Languages;

class LanguageController extends AbstractController
{
    /**
     * @Route("/languages", name="languages")
     * @param LanguagesRepository $languagesRepository
     * @return Response
     */
    public function index(
        LanguagesRepository $languagesRepository
    )
    {
        return $this->render('language/index.html.twig', [
            'languages' => $languagesRepository->findAll(),
        ]);
    }
    /**
     * @Route("/languages/new", name="newLanguage")
     * @param         Request $request
     * @param         EntityManagerInterface $entityManager
     * @return Response
     */
    public function newLanguage(
        Request $request,
        EntityManagerInterface $entityManager
    ) {
        $language = new Languages();
        $form = $this->createForm(LanguagesFormType::class, $language);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($language);
            $entityManager->flush();
            $this->addFlash('success', 'Successfully added new Language!');
            return $this->redirectToRoute('languages');
        }
        return $this->render(
            'language/new.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
    /**
     * @Route("/languages/delete/{id}", name="deleteLanguage")
     * @param         EntityManagerInterface $entityManager
     * @param Languages $langueges
     * @return Response
     */
    public function deleteCategory(
        EntityManagerInterface $entityManager,
        Languages $langueges
    ) {

        $entityManager->remove($langueges);
        $entityManager->flush();
        $this->addFlash('success', 'Successfully deleted Language!');
        return $this->redirectToRoute('languages');


    }
}
