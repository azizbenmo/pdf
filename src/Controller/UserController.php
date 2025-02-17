<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class UserController extends AbstractController
{
    #[Route('/home', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('frontend/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('frontend/login.html.twig', [
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


    #[Route('/hometest', name: 'homevues')]
    public function indexview(): Response
    {
        return $this->render('frontend/index.html.twig', [
        ]);
    }
    #[Route('/back', name: 'homevues')]
    public function indexbax(): Response
    {
        return $this->render('backend/indexbackend.html.twig', [
        ]);
    }
}
