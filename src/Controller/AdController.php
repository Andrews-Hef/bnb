<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
      * permet de créer une annonce 
      * 
      * @Route("/ads/new" , name="ads_create")
      * @return Response
      */
    public function create(Request $request, EntityManagerInterface $manager){
        $ad = new Ad();
        

        

        $form= $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            //$manager =$this->getDoctrine()->getManager();
            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $manager->persist($image);
            }
            
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "l'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
            );
            

            return $this->redirectToRoute('ads_show',[
                'slug' => $ad->getSlug()
            ]);
        }


        return $this->render('ad/new.html.twig',[
            'form'=> $form->createView()
        ]);
  }
    /**
     * permet d'afficher le formulaire d'edition 
     *
     * @Route("/ads/{slug}/edit" , name="ads_edit")
     * 
     * @return Response
     */
    public function edit(Ad $ad,Request $request,EntityManagerInterface $manager) {
        
        $form= $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);
        //
        if($form->isSubmitted() && $form->isValid() ){
            //$manager =$this->getDoctrine()->getManager();
            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $manager->persist($image);
            }
            
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "les modification de l'annonce <strong>{$ad->getTitle()}</strong> ont bien été enregistrées !"
            );
            

            return $this->redirectToRoute('ads_show',[
                'slug' => $ad->getSlug()
            ]);
        }


        return $this->render('ad/edit.html.twig',[
        'form'=> $form->createView(),
        'ad' => $ad

         ]);
    }

   /**
     * permet d'afficher une seule annonce
     *
     * @Route("/ads/{slug}", name="ads_show")
     * 
     * @return Response
     */
    public function show(Ad $ad){
       //je recupere l'annonce du slug
       // $ad =$repo->findOneBySlug($slug);

        return $this->render('ad/show.html.twig',[
            'ad'=>$ad
        ]);
    }
     
}
