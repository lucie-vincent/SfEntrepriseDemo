<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntrepriseController extends AbstractController
{
    
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
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
            // on récupère toutes les entreprises de la base de données
            // $entreprises = $entityManager->getRepository(Entreprise::class)->findAll();
            // $entreprises = $entrepriseRepository->findAll();

            // on récupère les entreprises de la BDD et on les classe par ordre croissant
            // pour ce faire on a besoin de la méthode findBy
            // SELECT * FROM entreprise ORDER BY raisonSociale
            $entreprises = $entrepriseRepository->findBy([], ["raisonSociale" => "ASC"]);

            // on les envoie à travers la méthode render dans la vue index.html.twig: entreprise
        return $this->render('entreprise/index.html.twig', [
            // on fait passer une variable entreprise à laquelle on attribue la valeur de ce que l'on a récupéré
            'entreprises' => $entreprises
        ]);
    }
    
    // on ajoute la route
    #[Route('/entreprise/new', name: 'new_entreprise')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // on crée un nouvel objet Entreprise
        $entreprise = new Entreprise();
       
        // on attribue au formulaire les propriétés de cet objet
        $form = $this->createForm(EntrepriseType::class, $entreprise);

        // on traite la soumission du formulaire
        // on utilise la méthode handleRequest()
        $form->handleRequest($request);

        // si le forumlaire a été soumis et que le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {

            // on récupère les données du formulaire et on les transmets à l'objet entreprise
            $entreprise = $form->getData();

            // on dit à Doctrine de persister càd préparer la requête pour l'ajout en BDD
            $entityManager->persist($entreprise);

            // Doctrine exécute la requête
            $entityManager->flush();

            // on redirige vers la liste des entreprises
            return $this->redirectToRoute('app_entreprise');
        }

        // on renvoie à la vue les données
        return $this->render('entreprise/new.html.twig', [
            'formAddEntreprise' => $form,
        ]);
    }

    #[Route('/entreprise/{id}', name: 'show_entreprise')]
    // le paramConverter nous est utile pour récupérer l'id de l'objet qui a été passé en paramètre de show: ici Entreprise $entreprise et l'id de la route
    public function show(Entreprise $entreprise): Response
    {
        // on  envoie à travers la méthode render dans la vue show.html.twig
        return $this->render('entreprise/show.html.twig', [
            // on fait passer une variable entreprise à laquelle on attribue la valeur de ce que l'on a récupéré
            'entreprise' => $entreprise
        ]);
    }


}
