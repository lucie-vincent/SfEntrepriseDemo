# À noter

- **Composer** est un gestionnaire de dépendance. C'est par lui qu'on passe dans l'invite de commande si on veut rajouter des bundles

## le dossier **src**
- C'est ici qu'on retrouve la logique métier
- symfony fonctonne avec le design pattern MVC - Model Vue Controller
- la couche **Model** est assurée par les dossiers *Entity* et *Repository*
- les **Vues** sont stockées dans *templates*
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

## Marche à suivre
**NOTE** Ctrl + C permet d'arrêter la commande en cours

### lancer le serveur symfony
- on lance le serveur depuis l'invite de commande grâce à la commande *symfony serve -d*. On vérifie ainsi qua page d'acceuil de Symfony s'affiche bien lorsqu'on se connecte à l'adresse indiquée dans l'affiche de commande.

### créer une nouvelle entité
- on crée une nouvelle entité grâce à la commande *symfony console make:entity (ou m:e)* -- **NOTE** cette commande sert également à modifier une entité
- on nomme l'entité en PascalCase (on garde l'habitude de POO)
- à chaque entité créée, on a un fichier NomEntiteRepository qui est créé pour (équivalent manager dans forum) avoir les différentes méthodes

### créer les propriétés d'une entité
- on crée la propriété
- on attribue le type
- on définit la longueur du varchar/string
- on définit si la propriété est nullable
- on continue à ajouter les propriétés suivantes 
-Symfony génère les getters et les setters pour ces propriétés

### créer une relation entre entités en respectant les cardinalités
- une entreprise peut avoir 1 ou plusieurs employés : 1,n -> OneToMany
- chaque employé peut avoir une entreprise : 1,1 -> ManyToOne
- on part de l'entreprise qui possède une *collection* d'employés : on va donc ajouter la propiété **employes** à **Entreprise** avec la commande *symfony console make:entity*
- on peut utiliser l'outil **relation** qui permet de trouver la relation appropriée en formulant clairement chaque type de relation : on renseigne la relation : ici OneToMany
- on renseigne la propriété à ajouter dans l'entité Employe (entreprise est suggéré)
- on définit si le champ peut-ête nullable ou non
- on définit la relation Orphan (ou non): si on supprime l'entreprise, les employes sont supprimés également

### définir la chaine de connexion à la BDD 
- on commente la ligne qui donne l'accès à postgresql
- on décommente la ligne qui donne accès à mysql
- on modifie le nom d'utilisateur :root (pas de mdp) + @ + le serveur local = le localhost (127.0.0.1) + port par défaut(:3306 - à vérifier sur laragon) + / + le nom de la BDD
- c'est ici qu'on paramètre la chaine de connexion vers la BDD (dans Forum : le fichier DAO permettait de se connecter à PDO pour accéder à la BDD)
- on peut créer la BDD manuellement dans HeidiQSQL --- on peut également la créer en ligne de commande (*symfony console doctrine:database:create*)
- on remplit la BDD avec une **migration** --> 2 étapes :
1. préparer la migration *symfony console make:migration (ou m:mi)*
2. effectuer la migration *symfony console doctrine:migrations:migrate (ou d:m:m)*

### Les Controllers
https://symfony.com/doc/current/controller.html
#### Composition d'un Controller
- déclaration du Controller
- méthodes qui composent le Controller
#### Le routage
-[dans Forum : on faisait appel au méthode du controller en passant par l'URL : index.php?ctrl&action=nomMethode&id]
- ex : #[Route('/lucky/number/{max}', name: 'app_lucky_number')]
        #[Route('/url->nomController/nomMethode/{variable/argument}', name: 'permet de créer des liens vers la méthode' )]
- redirection : $this->redirectToRoute('name dans la route');
**NOTE** chaque name de route doit être différent dans l'intégralité du projet

#### créer les Controllers
- on utilise la commande : *symfony console make:controller NomController (ou m:con)* . On peut préciser si on le souhaite le nom du Controller par la suite et pas dans cette commande directement
- Symfony crée le Controller et également une vue dans templates/nomController/index.html.twig

#### les vues créées par symfony suite à la création du controller
- *chaque vue étend* (extends) la *base html* dans templates : base.html.twig. C'est à dire que la structure sera la même

### Modifier les vues à l'aide de Twig (le moteur de templates)
https://twig.symfony.com/
- on télécharge l'extension sur VSCode *twig Pack* afin d'avoir accès à des raccourcis
- on inscrit dans le navigateur l'url fournit par Symfony lors de la création du Controller pour accéder à cette vue
- {{name}} = équivalent au *echo* en PHP
- pour les for :
{% for element in tableau %}
    {{ element }}
{% endfor %}
- concaténation: ~ ''

### Récupérer les objets de la base de données
1. avec l'entityManager
- une EntityManagerInterface qui permet d'accéder à des méthodes : getRepository(Entite sur laquelle on se base)->Find($id) = méthode prédéfinie dans le repository
- on récupère la response : render qui va nous permettre de renvoyer les informations vers une vue afin de pouvoir les afficher
- on télécharge l'extension php Namespace Resolver qui va nous permettre d'importer des classes depuis le raccourci
- on importe les classes dont on a besoin dans notre méthode (clique droit>import class)
2. avec le repository de l'entité (ici: Entreprise)
- on fait passer en argument de la méthode le repository de l'entité : index(EntrepriseRepository)
- on importe la classe
- on fait appel à la méthode du repository : $entreprises = $entrepriseRepository->findAll()


