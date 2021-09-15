<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sorties;
use App\Entity\User;
use App\Entity\Ville;
use App\Form\AnnulerSortieType;
use App\Form\CampusType;
use App\Form\SortieType;
use App\Repository\CampusRepository;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use App\Repository\SortiesRepository;
use App\Repository\UserRepository;
use App\Repository\VilleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/sorties", name="sortie_")
 */
class SortieController extends AbstractController
{
    /**
     * @Route("/create", name="create", methods={"GET","POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, EtatRepository $etatRepository, LieuRepository $lieuRepository, VilleRepository $villeRepository, UserInterface $user, UserRepository $userRepository, SortiesRepository $sortiesRepository): Response
    {


        $user->getId();


        $sorties = new Sorties();
        $sorties->setDuree(90);
        $etat = $etatRepository->findEtat()[0];
        $sorties->setEtat($etat);

        /*$users = $sortiesRepository->findRegistered();*/
        $sorties->setOrganisateur($this->getUser());
        /*$sorties->setSiteOrganisateur($this->getUser()->getCampusNoCampus());*/
        $sortiesForm = $this->createForm(SortieType::class, $sorties);
        $sortiesForm->handleRequest($request);

        if ($sortiesForm->isSubmitted() /*&& $sortiesForm->isValid()*/) {

            $entityManager->persist($sorties);
            $entityManager->flush();
            $this->addFlash('Success', 'Sortie créee');
        }
        if ($sortiesForm->get('publier')->isClicked()) {
            $etat = $etatRepository->findEtat()[1];
            $sorties->setEtat($etat);
            $entityManager->persist($sorties);
            $entityManager->flush();
            return $this->redirectToRoute('main_home');
        }

        return $this->render('/sortie/create.html.twig', [
            'sortiesForm' => $sortiesForm->createView()

        ]);
    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function details(int $id, Request $request, UserRepository $userRepository): Response
    {
        $sortie = $this->getDoctrine()
            ->getRepository(Sorties::class)
            ->find($id);
        $sortiesForm = $this->createForm(SortieType::class, $sortie);
        $sortiesForm->handleRequest($request);
        $users = $userRepository->findAll();
        if (!$sortie) {
            throw $this->createNotFoundException('Non trouvé');
        }

        return $this->render('sortie/details.html.twig', [
            'sortiesForm' => $sortiesForm->createView(),
            "sortie" => $sortie,
            '$users' => $users
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(int $id, Request $request, EntityManagerInterface $entityManager, EtatRepository $etatRepository): Response
    {
        $sortie = $entityManager->getRepository(Sorties::class)->find($id);
        $sortiesForm = $this->createForm(SortieType::class, $sortie);
        $sortiesForm->handleRequest($request);
        if (!$sortie) {
            throw $this->createNotFoundException('Non trouvé');
        }
        if ($sortiesForm->get('publier')->isClicked()) {
            $etat = $etatRepository->findEtat()[1];
            $sortie->setEtat($etat);
            $entityManager->persist($sortie);
            $entityManager->flush();
            return $this->redirectToRoute('main_home');
        }
        if ($sortiesForm->get('supprimer')->isClicked()) {

            $entityManager->remove($sortie);
            $entityManager->flush();
            return $this->redirectToRoute('main_home');
        }
        if ($sortiesForm->isSubmitted() && $sortiesForm->isValid()) {
            $entityManager->persist($sortie);
            $entityManager->flush();
            $this->addFlash('Success', 'Sortie modifiée');
        }


        return $this->render('sortie/update.html.twig', [
            'sortiesForm' => $sortiesForm->createView(),
            "sortie" => $sortie
        ]);
    }


}