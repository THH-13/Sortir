<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sorties;
use App\Entity\Ville;
use App\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sorties", name="sortie_")
 */
class SortieController extends AbstractController
{
    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager ) :Response
    {
        /*$users = $this->getUser();
        $usersUsername=$users->getPseudo();*/


        $sorties = new Sorties();
        $campus = new Campus();
       $campus->setNom('test');
        $ville = new Ville();
        $lieu = new Lieu();


        $ville->setNom('testVille');
        $ville->setCodePostal('test');

       $lieu->setNom('testlieu');
        $lieu->setRue('testlieu');
        $lieu->setLatitude(1.3);
        $lieu->setLongitude(1.3);
        $etat = new Etat();
        $etat->setLibelle('testEtat');


        $sortiesForm = $this->createForm(SortieType::class, $sorties);
        $sortiesForm->handleRequest($request);
        if ($sortiesForm->isSubmitted()) {
            $sorties->setSiteOrganisateur($campus);
            $sorties->setEtat($etat);
            $entityManager->persist($sorties);
            $entityManager->persist($campus);

            $entityManager->persist($lieu);
            $entityManager->persist($etat);
            $entityManager->persist($ville);
            $entityManager->flush();

            $this->addFlash('Success', 'Serie créee');


    }
        return $this->render('/sortie/create.html.twig', [
            'sortiesForm' => $sortiesForm->createView()
        ]);
    }

}