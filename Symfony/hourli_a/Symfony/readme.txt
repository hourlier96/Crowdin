I) Création projet :
sudo apt-get install composer
(Download the composer.phar)
composer create-project symfony/website-skeleton my-project
depuis "nom_projet": 
composer require server --dev
php bin/console server:run  (page localhost:8000)

II) Créer une page
- Créer un routage (cf @Route in Controller) (the URL to the page, points to a controller)
- Créer un controller : php bin/console make:controller (PHP function that builds the page)
- Associer template twig à fonction du controller


ORM de Symfony: Doctrine

Entity: Représente une table
Manager: Manipuler / Insérer / Maj de lignes de données 
Repository: Faire des sélections de données

Mdp phpmyadmin et mysql: 01ziezoot  hourli_a

III)(A) Préparation d'une BDD exploitable

php bin/console doctrine:database:create (construit la bdd à partir des infos dans .env)
php bin/console doctrine make:entity (construit une table dans la base + Repository OU Update si existe)
php bin/console doctrine make:migration (Construit les fichiers pour migrer la BDD si besoin)
php bin/console doctrine:migrations:migrate (Met à jour la base en fonction du versionning de la migration 

Générer des données (lignes)
Fixtures : Permet de manipuler un jeu de fausses données
composer require rom_fixtures --dev
php bin/console make:fixtures
Créer une série d'objet dans la fonction load de la nouvelle class générée (+ le use de la classe)
puis: php bin/console doctrine:fixtures:load

III(B) Gestion du css avec bootstrap
Dans config/packages/twig.yaml: ajouter des themes pour twig
Dans chaque twig: inclure {% theme %}
OU
inclure code html directement

ex: form_themes: ['bootstrap_4_layout.html.twig']

IV) Construction d'un formulaire géré par Symfony (cf. Controlleur, create_user())
	- Ajout d'utilisateurs
	- CreateFormBuilder
	- Constraints (verif confirmation)
	- config/packages/security.yaml: 
		encoders
	  + hash dans form + implementation interface UserInterface
	

V) Sécurité et authentification
	Connexion au site
	Providers dans security.yaml (Préciser ou vérifier les infos, avec quels propriétés)
	form_login firewall
	champs required name in <form>


Table Languages + Table qui relie l'id de l'utilisateur à plusieurs languages
	
