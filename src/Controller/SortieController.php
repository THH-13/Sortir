<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sorties;
use App\Entity\User;
use App\Entity\Ville;
use App\Form\CampusType;
use App\Form\SortieType;
use App\Repository\CampusRepository;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use App\Repository\SortiesRepository;
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
    public function create(Request $request, EntityManagerInterface $entityManager, EtatRepository $etatRepository, LieuRepository $lieuRepository, VilleRepository $villeRepository, UserInterface $user): Response
    {


        $user->getId();


        $sorties = new Sorties();
        $sorties->setDuree(90);
        $etat = $etatRepository->findAll()[0];
        $sorties->setEtat($etat);
        $lieu = $lieuRepository->findAll()[0];
        $sorties->setLieu($lieu);
        $ville = $villeRepository->findAll()[0];
        $lieu->setVille($ville);

        $sorties -> setOrganisateur($this->getUser());

        $sortiesForm = $this->createForm(SortieType::class, $sorties);
        $sortiesForm->handleRequest($request);

        if ($sortiesForm->isSubmitted()) {
            $entityManager->persist($sorties);
            $entityManager->flush();
            $this->addFlash('Success', 'Sortie créee');
        }
        return $this->render('/sortie/create.html.twig', [
            'sortiesForm' => $sortiesForm->createView()
        ]);
    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function details(int $id, Request $request): Response
    {
        $sortie = $this->getDoctrine()
            ->getRepository(Sorties::class)
            ->find($id);
        $sortiesForm = $this->createForm(SortieType::class, $sortie);
        $sortiesForm->handleRequest($request);
        if (!$sortie) {
            throw $this->createNotFoundException('Non trouvé');
        }

        return $this->render('sortie/details.html.twig', [
            'sortiesForm' => $sortiesForm->createView(),
            "sortie" => $sortie
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $sortie = $entityManager->getRepository(Sorties::class)->find($id);
        $sortiesForm = $this->createForm(SortieType::class, $sortie);
        $sortiesForm->handleRequest($request);
        if (!$sortie) {
            throw $this->createNotFoundException('Non trouvé');
        }
        if ($sortiesForm->isSubmitted()) {
            $entityManager->persist($sortie);
            $entityManager->flush();
            $this->addFlash('Success', 'Sortie modifiée');
        }
        return $this->render('sortie/update.html.twig', [
            'sortiesForm' => $sortiesForm->createView(),
            "sortie" => $sortie
        ]);
    }

    /**
     * @Route("/annuler/{id}", name="annuler")
     */
    public function remove(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->render('sortie/annuler.html.twig');
    }

}