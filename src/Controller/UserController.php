<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class UserController extends AbstractController
{
    #[Route('/', name: 'homepage')]
public function homepage(): Response
{
    return $this->render('frontend/index.html.twig');
}

    #[Route('/home', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('frontend/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }



    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(): Response
    {
        return $this->render('frontend/inscription.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/inscriptionV', name: 'app_inscriptionV')]
    public function inscriptionV(): Response
    {
        return $this->render('frontend/inscriptionV.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


    #[Route('/back', name: 'backvues')]
    public function indexbax(): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas les droits nécessaires pour accéder à cette page.');
            return $this->redirectToRoute('app_user'); 
        }
        return $this->render('backend/indexbackend.html.twig', [
        ]);
    }

      
   
}
