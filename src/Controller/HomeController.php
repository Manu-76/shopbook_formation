<?php

namespace App\Controller;

use App\Repository\HomeRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    // 1. Méthode qui prend en charge l'affichage des routes 
    #[Route('/', name: 'app_home')]
    public function index(HomeRepository $homeRepository, LivreRepository $livreRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'homeContent' => $homeRepository->find(1),
            'livres' => $livreRepository->findBy([], ['updatedAt' => 'DESC'], 4)
        ]);
    }
}
