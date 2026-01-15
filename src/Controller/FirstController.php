<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        return new Response("HELLO WARUDO !");
    }

    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return new Response("Page d'accueil !");
    }

    #[Route('/welcome', name: 'app_welcome')]
    public function welcome(): Response
    {
        return $this->render('first/welcome.html.twig', [
            'message' => 'Bienvenue sur mon site Symfony !'
        ]);
    }
}
