<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    public function index(EmployeRepository $employeRepository): Response
    {
           // on récupère toutes les entreprises de la base de données
            // $entreprises = $entityManager->getRepository(Entreprise::class)->findAll();
            // $employes = $employeRepository->findAll();
            // SELECT * FROM employe ORDER BY nom ASC
            $employes = $employeRepository->findBy([], ["nom" => "ASC"]);

            // on les envoie à travers la méthode render dans la vue index.html.twig: entreprise
        return $this->render('employe/index.html.twig', [
            // on fait passer une variable entreprise à laquelle on attribue la valeur de ce que l'on a récupéré
            'employes' => $employes
        ]);
    }

    // on ajoute la route
    #[Route('/employe/new', name: 'new_employe')]
    public function new(Request $request): Response
    {
        // on crée un nouvel objet employe
        $employe = new Employe();

        // on attribue au formulaire les propriétés de cet objet
        $form = $this->createForm(EmployeType::class, $employe);

        // on renvoie à la vue les données
        return $this->render('employe/new.html.twig', [
            'formAddEmploye' => $form,
        ]);
    }


    #[Route('/employe/{id}', name: 'show_employe')]
    // le paramConverter nous est utile pour récupérer l'id de l'objet qui a été passé en paramètre de show: ici Entreprise $entreprise et l'id de la route
    public function show(Employe $employe): Response
    {
        // on  envoie à travers la méthode render dans la vue show.html.twig
        return $this->render('employe/show.html.twig', [
            // on fait passer une variable employe à laquelle on attribue la valeur de ce que l'on a récupéré
            'employe' => $employe
        ]);
    }
}
