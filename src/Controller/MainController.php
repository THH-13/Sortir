<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchFormType;
use App\Repository\SortiesRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{


    /**
     * @Route("/sorties", name="main_home")
     */
    public function home(SortiesRepository $sortiesRepository, Request $request): Response
    {
        $data = new SearchData();
        $form = $this->createForm(SearchFormType::class, $data);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $sorties = $sortiesRepository->findSearch($data);
        } else {
            $sorties = $sortiesRepository->findSorties();
        }
        return $this->render("main/home.html.twig", [
            'searchform' => $form->createView(),
            "sorties" => $sorties
        ]);
    }
    /**
     * @Route("/test", name="main_test")
     */
    public function test()
    {
        return $this->render("main/test.html.twig");
    }
}