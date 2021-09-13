<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Etat;
use App\Entity\Sorties;
use App\Form\SearchFormType;
use App\Repository\EtatRepository;
use App\Repository\SortiesRepository;

use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{


    /**
     * @Route("/sorties", name="main_home")
     */
    public function home(SortiesRepository $sortiesRepository, Request $request,EtatRepository $etatRepository, EntityManagerInterface $entityManager): Response
    {
        $sorties = $entityManager->getRepository(Sorties::class)->findAll();
        foreach ($sorties as $sortie){
            if ($sortie->getDatedebut()<= $sortie->getDatecloture() && $sortie->getDatedebut() > new DateTime('now')){
                $etat = $etatRepository->findAll()[1];
                $sortie->setEtat($etat);
            }elseif ($sortie->getDatedebut()> $sortie->getDatecloture() && $sortie->getDatecloture() < new DateTime('now') ){
                $etat = $etatRepository->findAll()[2];
                $sortie->setEtat($etat);
            }/*
            elseif ($sortie->getDatedebut()> $sortie->getDatecloture() && $sortie->getDatecloture() < new DateTime('now') ){
                $etat = $etatRepository->findAll()[4];
                $sortie->setEtat($etat);
            }*/
        }


        $entityManager->persist($sortie);
        $entityManager->flush();

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