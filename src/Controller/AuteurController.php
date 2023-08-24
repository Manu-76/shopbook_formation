<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Repository\AuteurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AuteurController extends AbstractController
{
    #[Route('/auteur', name: 'app_auteur')]
    public function index(AuteurRepository $auteurRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        // On injecte PaginatorInterface dans la methode
        $auteurs = $auteurRepository->findAll();
        // On crée une variable contenant la pagination souhaité
        $pagination = $paginatorInterface->paginate(
            $auteurs, //query noy the result
            $request->query->getInt('page',1), //Page number
            2  //limit par page
        );


        return $this->render('auteur/index.html.twig', [
            // 'auteurs' => $auteurRepository->findAll(),
            'auteurs' => $pagination,
        ]);
    }

    #[Route('/auteur/{id}', name: 'app_auteur-detail')]
    public function detail(Auteur $auteur): Response
    {
        return $this->render('auteur/detail.html.twig', [
            'auteur' => $auteur,
        ]);
    }
}
