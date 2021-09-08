<?php

namespace App\Controller;

use App\Entity\Sorties;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sorties", name="sortie_")
 */
class SortieController extends AbstractController
{
    /**
     * @Route("/create", name="create")
     */
    public function create()
    {
       /* $sorties = new Sorties();
        $sortiesForm = $this->createForm(SortieType::class, $sorties);*/
        return $this->render('/sortie/create.html.twig');
    }



}