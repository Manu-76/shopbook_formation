<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivreController extends AbstractController
{
    #[Route('/livre', name: 'app_livre')]
    // La méthode index renvoit à la vue un tableau associatif (dans une variable) contenant l'ensemble des objets de la classe Livre par l'intermédiaire du repository de la classe avec la méthode findAll()
    public function index(LivreRepository $livreRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        // 2. on pagine aussi
        $livres = $livreRepository->findAll();
        $pagination = $paginatorInterface->paginate(
            $livres,
            $request->query->getInt('page', 1),
            2
        );

        return $this->render('livre/index.html.twig', [
            'livres' => $pagination
        ]);
        // 1.La méthode render attends 2 param, la vue a renvoyer et un tableau associatif nommé variable et son contenu
        // return $this->render('livre/index.html.twig', [
        //     'livres' => $livreRepository->findAll(),
        // ]);
    }

    // 2. Fonction de recherche sans paginator ->Ici, si l'on met cette route apres livre-detail il y aura un probleme car la route matchée en premier est celle de livre detail et donc elle n'est pas prise en compte, il faut donc la mettre AVANT livre-detail
    #[Route('/livre/search/', name: 'search-livre', methods: ['GET'])]
    public function search(LivreRepository $livreRepository, PaginatorInterface $paginatorInterface, Request $request) {
        // return new Response("coucou");
        // On va recuperer dans la query de la value recherché
        $value = $request->query->get('search-value');
        // dd($value);
        // 1.recherche sans pagination
        // // Apres creation de la query dans la repo
        // $livres = $livreRepository->search($value);
        // return $this->render('livre/search.html.twig', [
        //     'livres' => $livres
        // ]);

        // 2.recherche avec pagination
        $livres = $livreRepository->searchForPaginator($value);
        $pagination = $paginatorInterface->paginate(
            $livres,
            $request->query->getInt('page', 1),
            2
        );
        return $this->render('livre/index.html.twig', [
            'livres' => $pagination
        ]);
    }

    // La route déclarée est une route contenant une partie dynamique (slug) d'ou utilisation des accolades dans la déclaration, ressemblant un get méthod. Pour connaitre les routes existantes : symfony console debug:router
    #[Route('/livre/{id}', name: 'livre-detail')]
    // 1ere methode 
    // public function detail(LivreRepository $livreRepository, int $slug) : Response
    // 2eme methode
    public function detail(Livre $livre) : Response
    {
        return $this->render('livre/detail.html.twig', [
            // 1ere methode (ne pas oublier de changer slug par id dans la vue index)
            // 'livre' => $livreRepository->find($slug),
            // 2eme méthode avec injection de l'objet directement dans la méthode, symfony sait que $livre est le livre à recuper selon le slug
            'livre' => $livre
        ]);
    }

}
