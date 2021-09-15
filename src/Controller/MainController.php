<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Etat;
use App\Entity\Sorties;
use App\Form\AnnulerSortieType;
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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class MainController extends AbstractController
{


    /**
     * @Route("/sorties", name="main_home")
     */
    public function home(SortiesRepository $sortiesRepository, Request $request, EtatRepository $etatRepository, EntityManagerInterface $entityManager): Response
    {
        $sorties = $entityManager->getRepository(Sorties::class)->findAll();

        foreach ($sorties as $sortie) {

            if ($sortie->getDatedebut() < new DateTime('- 1 month') && ($sortie->getEtat()->getId() != 1)) {
                $etat = $etatRepository->findEtat()[4];
                $sortie->setEtat($etat);
            }
            elseif ($sortie->getEtat()->getId() == 6) {
                $etat = $etatRepository->findEtat()[5];
                $sortie->setEtat($etat);
            }
            elseif (($sortie->getEtat()->getId() == 1) && ($sortie->getEtat()->getId() != 6)) {
                $etat = $etatRepository->findEtat()[0];
                $sortie->setEtat($etat);
            }
            elseif (($sortie->getEtat()->getId() == 2) && ($sortie->getEtat()->getId() != 6)) {
                $etat = $etatRepository->findEtat()[1];
                $sortie->setEtat($etat);
            }
            elseif (($sortie->getDatedebut() === new DateTime('now')) && ($sortie->getEtat()->getId() != 6)) {
                $etat = $etatRepository->findEtat()[3];
                $sortie->setEtat($etat);
            }
            elseif ($sortie->getDatedebut() > new DateTime('- 1 month') && $sortie->getDatedebut() < new DateTime('now') && ($sortie->getEtat()->getId() != 1) && ($sortie->getEtat()->getId() != 6) ) {
                $etat = $etatRepository->findEtat()[6];
                $sortie->setEtat($etat);
            } elseif (($sortie->getDatecloture() < new DateTime('now')) && ($sortie->getEtat()->getId() != 1) && ($sortie->getEtat()->getId() != 6)) {
                $etat = $etatRepository->findEtat()[2];
                $sortie->setEtat($etat);
            }
        }

        $entityManager->persist($sortie);
        $entityManager->flush();

        $data = new SearchData();
        $form = $this->createForm(SearchFormType::class, $data);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $sorties = $sortiesRepository->findSearch($data);
        } else {
            $sorties = $sortiesRepository->findRegistered();
            /*$sortiesEtat = $sortiesRepository->findSorties();*/
        }
        return $this->render("main/home.html.twig", [
            'searchform' => $form->createView(),
            "sorties" => $sorties

        ]);
    }

    /**
     * @Route("/{id}/etat/", name="etat")
     */
    public function etat(Request $request, SortiesRepository $sortiesRepository, int $id, EntityManagerInterface $entityManager, EtatRepository $etatRepository)
    {

        $sorties = $entityManager->getRepository(Sorties::class)->find($id);
        $etat = $etatRepository->findEtat()[1];
        $sorties->setEtat($etat);
        $entityManager->persist($sorties);
        $entityManager->flush();
        return $this->redirectToRoute('main_home');
    }

    /**
     * @Route("/{id}/inscrit/", name="inscrit")
     */
    public function inscrit(int $id, Request $request, SortiesRepository $sortiesRepository, EntityManagerInterface $entityManager, UserInterface $user)
    {

        $sorties = $entityManager->getRepository(Sorties::class)->find($id);
        $user->addSorty($sorties);
        $entityManager->persist($sorties);
        $entityManager->flush();
        return $this->redirectToRoute('main_home');
    }

    /**
     * @Route("/{id}/desister/", name="desister")
     */
    public function desister(int $id, Request $request, SortiesRepository $sortiesRepository, EntityManagerInterface $entityManager, UserInterface $user)
    {

        $sorties = $entityManager->getRepository(Sorties::class)->find($id);
        $user->removeSorty($sorties);
        $entityManager->persist($sorties);
        $entityManager->flush();
        return $this->redirectToRoute('main_home');
    }

    /**
     * @Route("/{id}/annuler/", name="annuler")
     */
    public function annuler(int $id, Request $request, SortiesRepository $sortiesRepository, EntityManagerInterface $entityManager, EtatRepository $etatRepository, UserInterface $user)
    {
        $sorties = $entityManager->getRepository(Sorties::class)->find($id);


        $sortiesForm = $this->createForm(AnnulerSortieType::class, $sorties);
        $sortiesForm->handleRequest($request);
        if (!$sorties) {
            throw $this->createNotFoundException('Non trouvé');
        }
        if ($sortiesForm->isSubmitted()) {
            $etat = $etatRepository->findEtat()[5];
            $sorties->setEtat($etat);
            $entityManager->persist($sorties);
            $entityManager->flush();
            $this->addFlash('Success', 'Sortie annulée');

        }

        return $this->render('sortie/annuler.html.twig', [
            'AnnulerSortieForm' => $sortiesForm->createView(),
            "sortie" => $sorties
        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}