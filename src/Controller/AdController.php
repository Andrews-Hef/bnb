<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo): Response
    {
       

        $ads= $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads'=>$ads
        ]);
    }
    /**
     * permet d'afficher une seule annonce
     *
     * @Route("/ads/{slug}", name="ads_show")
     * 
     * @return Response
     */
    public function show($slug,AdRepository $repo){
       //je recupere l'annonce du slug
        $ad =$repo->findBySlug();
    }
}
//video4  22 min
