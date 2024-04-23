<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]

    // exemple
    // public function index(): Response 
    // {
    //     $name = 'Elan Formation';
    //     $tableau = ['valeur 1', 'valeur 2', 'valeur 3'];
        
    //     // cette méthode permet de faire le lien entre le controller et la vue
    //     return $this->render('entreprise/index.html.twig', [
    //             // 'variable' => 'chaine de caractère attribuée à la variable'
    //             'name' => $name,
    //         'tableau' => $tableau
    //     ]);
    // }


    // récupérer les données de la BDD en passant par l'entityManager
    // public function index(EntityManagerInterface $entityManager): Response
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
            // on récupère toutes les entreprises de la base de données
            // $entreprises = $entityManager->getRepository(Entreprise::class)->findAll();
            // $entreprises = $entrepriseRepository->findAll();

            // on récupère les entreprises de la BDD et on les classe par ordre croissant
            // pour ce faire on a besoin de la méthode findBy
            // SELECT * FROM entreprise WHERE ville = 'STRASBOURG' ORDER BY raisonSociale
            $entreprises = $entrepriseRepository->findBy(["ville" => "STRASBOURG"], ["raisonSociale" => "ASC"]);

            // on les envoie à travers la méthode render dans la vue index.html.twig: entreprise
        return $this->render('entreprise/index.html.twig', [
            // on fait passer une variable entreprise à laquelle on attribue la valeur de ce que l'on a récupéré
            'entreprises' => $entreprises
        ]);
    }
}
