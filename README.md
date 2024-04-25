# Projet Symfony CRUD - Gestion d'Entreprises et Salariés

Ce projet est une application CRUD (Create, Read, Update, Delete) développée avec Symfony permettant de gérer des entreprises et leurs salariés. L'application offre des fonctionnalités pour lister, ajouter, modifier et supprimer des entreprises ainsi que leurs salariés.

## Fonctionnalités

- Liste des Entreprises : Affiche la liste des entreprises enregistrées dans la base de données.
- Ajout d'une Entreprise : Permet d'ajouter une nouvelle entreprise avec ses détails.
- Modification d'une Entreprise : Permet de mettre à jour les informations d'une entreprise existante.
- Suppression d'une Entreprise : Permet de supprimer une entreprise de la base de données.
- Liste des Salariés : Affiche la liste des salariés associés à chaque entreprise.
- Ajout d'un Salarié : Permet d'ajouter un nouveau salarié à une entreprise existante.
- Modification d'un Salarié : Permet de mettre à jour les informations d'un salarié.
- Suppression d'un Salarié : Permet de supprimer un salarié de la base de données.

## Structure du Projet

- src/Controller : Contient les contrôleurs Symfony pour gérer les routes et les actions.
- src/Entity : Définit les entités Doctrine représentant les tables de la base de données.
- src/Form : Contient les formulaires Symfony pour la création et la modification des entités.
- templates/ : Répertoire des fichiers Twig pour les vues et les templates HTML.

## Technologies Utilisées

- Symfony 5 (Framework PHP)
- Doctrine ORM (Mapping Objet-Relationnel)
- Twig (Moteur de Template)
- MySQL (Système de Gestion de Base de Données)
