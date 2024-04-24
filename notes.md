# À noter

- **Composer** est un gestionnaire de dépendance. C'est par lui qu'on passe dans l'invite de commande si on veut rajouter des bundles
- les composants de Symfony : le systeme de routage, le système de controller, le système de gestion de dépendence, de formulaire, de templating, de tests unitaires et de tests fonctionnels
- le système de routing : fait correspondre une url entrante avec des actions spécifiques de controller.
- un controller est une classe qui va gérer les requetes http entrantes et retourne une réponse http
- Les dépendances de symfony sont gérées à l'aide du container de services de symfony; on peut faire appel à un gestionnaire de dépendance de type NPN et Composer, des gestionnaires de dépendance, qui nous permettent de télécharger les dépendances nécessaires
- on fait les formulaires à l'aide du composant Form: on crée des classes de formulaire. On les utilise dans le controller pour traiter les données soumises par l'utilisateur
- Doctrine : ORM Object-Relational Mapping : permet d'intéragir avec la base de données et de représenter les entités (classes) sous forme d'objets

## le dossier **src**
- C'est ici qu'on retrouve la logique métier
- symfony fonctonne avec le design pattern MVC - Model Vue Controller
- la couche **Model** est assurée par les dossiers *Entity* et *Repository*
- les **Vues** sont stockées dans *templates*
- pour être plus précis: model MVP - variante de MVC : le Model ne communique pas avec les vues
### Le sous-dossier **Controller**
- c'est ici que se trouvent les controllers
### Le sous-dossier **Entity**
- on y retrouve nos classes POO
### Le sous-dossier **Repository**
- équivalent au dossier Manager dans Forum
- on y retrouve les méthodes qui nous permettent d'intéragir avec la base de données
- on communiquera avec la BDD avec le langage DQL Doctrine Query Language : on interroge la BDD grâce à des objets ou des collections d'objets - Doctrine =ORM : Object Relational Mapping fait la relation entre le projet et la base de données

## Le dossier **templates**
- contient l'ensemble des vues du projet
### base.html
- avec le fichier *base.html.twig* qui est l'équivalent au fichier layout de Forum et qui est le squelette de l'ensemble des vues du projet: il rassemble les éléments qui concernent l'ensemble des vues : la navbar, le footer etc.
- ce fichier est séparé en block : *stylesheet* --> CSS, *javascripts* --> JS, *body* --> tout ce qui est compris par la temporisation de sortie
- il y a une notion d'héritage dans les templates : chacune des vues va hériter du fichier base.html.twig
### twig
- il s'agit d'un **moteur de template** (par défaut pour Symfony: équivalent à blade pour *Laravel*)
- permet de manipuler les vues

## Le dossier **public**
- il comprend les fichier CSS, les fichiers JS, les images
- il comprend également un fichier **index.php** qui permet d'accéder au **Kernel** et au noyau de symfony. **IMPORTANT** ce fichier ne sera pas modifié


## Le fichier **.env**
- permet de configurer l'accès à la BDD
- on commente la ligne qui donne l'accès à postgresql
- on décommente la ligne qui donne accès à mysql
- on modifie le nom d'utilisateur (pas de mdp), le localhost + port par défaut, le nom de la BDD
- c'est ici qu'on paramètre la chaine de connexion vers la BDD (dans Forum : le fichier DAO permettait de se connecter à PDO pour accéder à la BDD)

# Marche à suivre
**NOTE** Ctrl + C permet d'arrêter la commande en cours

## lancer le serveur symfony
- on lance le serveur depuis l'invite de commande grâce à la commande *symfony serve -d*. On vérifie ainsi qua page d'acceuil de Symfony s'affiche bien lorsqu'on se connecte à l'adresse indiquée dans l'affiche de commande.

## créer une nouvelle entité
- on crée une nouvelle entité grâce à la commande *symfony console make:entity (ou m:e)* -- **NOTE** cette commande sert également à modifier une entité
- on nomme l'entité en PascalCase (on garde l'habitude de POO)
- à chaque entité créée, on a un fichier NomEntiteRepository qui est créé pour (équivalent manager dans forum) avoir les différentes méthodes

## créer les propriétés d'une entité
- on crée la propriété
- on attribue le type
- on définit la longueur du varchar/string
- on définit si la propriété est nullable
- on continue à ajouter les propriétés suivantes 
-Symfony génère les getters et les setters pour ces propriétés

## créer une relation entre entités en respectant les cardinalités
- une entreprise peut avoir 1 ou plusieurs employés : 1,n -> OneToMany
- chaque employé peut avoir une entreprise : 1,1 -> ManyToOne
- on part de l'entreprise qui possède une *collection* d'employés : on va donc ajouter la propiété **employes** à **Entreprise** avec la commande *symfony console make:entity*
- on peut utiliser l'outil **relation** qui permet de trouver la relation appropriée en formulant clairement chaque type de relation : on renseigne la relation : ici OneToMany
- on renseigne la propriété à ajouter dans l'entité Employe (entreprise est suggéré)
- on définit si le champ peut-ête nullable ou non
- on définit la relation Orphan (ou non): si on supprime l'entreprise, les employes sont supprimés également

## définir la chaine de connexion à la BDD 
- on commente la ligne qui donne l'accès à postgresql
- on décommente la ligne qui donne accès à mysql
- on modifie le nom d'utilisateur :root (pas de mdp) + @ + le serveur local = le localhost (127.0.0.1) + port par défaut(:3306 - à vérifier sur laragon) + / + le nom de la BDD
- c'est ici qu'on paramètre la chaine de connexion vers la BDD (dans Forum : le fichier DAO permettait de se connecter à PDO pour accéder à la BDD)
- on peut créer la BDD manuellement dans HeidiQSQL --- on peut également la créer en ligne de commande (*symfony console doctrine:database:create*)
- on remplit la BDD avec une **migration** --> 2 étapes :
1. préparer la migration *symfony console make:migration (ou m:mi)*
2. effectuer la migration *symfony console doctrine:migrations:migrate (ou d:m:m)*

## Le routage
-[dans Forum : on faisait appel au méthode du controller en passant par l'URL : index.php?ctrl&action=nomMethode&id]
- ex : #[Route('/lucky/number/{max}', name: 'app_lucky_number')]
        #[Route('/url->nomController/{variable-argument}', name: 'permet de créer des liens vers la méthode' )]
- redirection : $this->redirectToRoute('name dans la route');
**NOTE** - chaque name de route doit être différent dans l'intégralité du projet
        - il y a un ordre de priorité dans les routes : attention à mettre les méthodes avec un  id en argument en dernier

## Les Controllers
https://symfony.com/doc/current/controller.html
### Composition d'un Controller
- déclaration du Controller
- méthodes qui composent le Controller
### créer les Controllers
- on utilise la commande : *symfony console make:controller NomController (ou m:con)* . On peut préciser si on le souhaite le nom du Controller par la suite et pas dans cette commande directement
- Symfony crée le Controller et également une vue dans templates/nomController/index.html.twig

### les vues créées par symfony suite à la création du controller
- *chaque vue étend* (extends) la *base html* dans templates : base.html.twig. C'est à dire que la structure sera la même

## Modifier les vues à l'aide de Twig (le moteur de templates)
https://twig.symfony.com/
- on télécharge l'extension sur VSCode *twig Pack* afin d'avoir accès à des raccourcis
- on inscrit dans le navigateur l'url fournit par Symfony lors de la création du Controller pour accéder à cette vue
- {{name}} = équivalent au *echo* en PHP
- pour les for :
{% for element in tableau %}
    {{ element }}
{% endfor %}
- concaténation: ~ ''
- faire des liens vers une route du projet: (on utilise les names)
<a href="{{ path('nom_route') }}"></a>
- faire les liens au css..tout ce qui est dans public : on utilise la méthode asset('')

## Récupérer les objets de la base de données
### lister les entreprises
1. avec l'entityManager
- une EntityManagerInterface qui permet d'accéder à des méthodes : getRepository(Entite sur laquelle on se base)->Find($id) = méthode prédéfinie dans le repository
- on récupère la response : render qui va nous permettre de renvoyer les informations vers une vue afin de pouvoir les afficher
- on télécharge l'extension php Namespace Resolver qui va nous permettre d'importer des classes depuis le raccourci
- on importe les classes dont on a besoin dans notre méthode (clique droit>import class)
2. avec le repository de l'entité (ici: Entreprise)
- on fait passer en argument de la méthode le repository de l'entité : index(EntrepriseRepository)
- on importe la classe
- on fait appel à la méthode du repository : $entreprises = $entrepriseRepository->findAll()
- si on veut pouvoir ordonner les éléments, on utilise la méthode findBy qui prend des arguments

## Modifier une entité et mettre à jour la BDD
- on utilise la commande *symfony console make:entity* pour modifier l'entité; on remplit les champs de propriété que l'on veut modifier
- on met à jour la BDD avec la commande *symfony console doctrine:schema:update --force* **IMPORTANT** faire une migration supprimerait les données déjà existantes dans la base de données !!

## lister le détail d'une entreprise
- on crée la méthode show dans le Controller
- on importe si besoin la classe 
- on indique la route + en argument l'id + le name
- en argument de la méthode show, on indique l'entreprise : le *paramConverter* va réussir à trouver l'id de l'entreprise
- on fait le lien vers la vue, en ajoutant en argument les données de l'entreprise
- on crée la vue show.html.twig
- dans la vue liste des entreprise, on fait le lien vers le détail de l'entreprise dans le href avec la fonction *path* : avec l'id en argument {{ path('nom_vue', {'id': entreprise.id}) }}

## afficher une date depuis un objet DateTime
1. créer une méthode dans l'entité
- on crée une méthode qui formate la date
- on appelle cette méthode dans la vue pour afficher la date formatée
2. utiliser un filter twig (filter) :| date("d-m-Y")
- {{ entreprise.dateCreation | date("d-m-Y") }}

## les formulaires
- on utilise la commande *symfony console make:form*
- on nomme généralement les classes qui vont gérer les formulaires nomClasseType
- on peut créer un formulaire qui n'est pas lié à une entité
- Symfony crée un nouveau sous-dossier dans *src* qui est *form* avec le fichier qui contient la classe qui va gérer le formulaire
- Symfony crée 2 méthodes dans cette classe : buildForm() et configureOptions()
- buildForm() récupère toutes les propriétés de l'entité
### créer un formulaire
- on crée la méthode dans le Controlleraprès avoir créé les classes qui vont gérer les formulaires
- on importe la classe httpFoundation/Request + la classe NomType
- on ajoute la route avec pour l'url: /nomController/nomMethode + le name: exemple_nomController
- on crée un nouvel objet 
- on attribue au formulaire les propriétés de cet objet
- on renvoie à la vue les données
- dans la vue, on récupère le formulaire avec la fonction {{ form(variable) }}
- on précise le type souhaité pour chaque champ dans les FormType et on importe les classe symfony/component/form. On ajoute le bouton de soumission de type SubmitType
- pour les objets : on précise le type EntityType + 1 tableau d'arugments qui comprend : classe de l'objet + choix du label (opitionnel si on a bien défini le __toString)
- pour améliorer l'aspect des formulaire, on peut ajouter des attributs directement dans les inputs du FormType. Ici, on reprend les attributs bootstrap. Ces attributs sont des tableaux qui prennent d'autres tableaux en arguments
### La soumission d'un formulaire
- la méthode handleRequest() prend en compte la soumission du formulaire
- puis avec la méthode isSubmitted(), si le formulaire est soumis, on affecte les données à l'objet
- on utilise le EntityManager qui est en argument dans la méthode du formulaire pour préparer (persist) et exécuter (flush) la requête dans la BDD : càd ajouter les données saisies du formulaire dans le BDD
