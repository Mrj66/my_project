Ce document est une documentation du projet qui decrit les étapes et une explication rapide des pages et du programme:

    1. Pour la bdd en access : 
        - $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=project_directory/var/bdd/data.mdb;";
        - faut bien definir le chemin du projet sur la machine (pc) utiliser.
    
    2. En assets, bin, node_modules, vendor, et d'autres qui sont pas mentionner ci-dessus : 
        - Il n'y a pas eu des modifications (rien n'a etait changer)
        - ne sont pas upload sur github pour les raisons de securite

    3. En config :
        - route.yaml : modifications de routage pour les entetes de pages
        - services.yaml : les differents services ont etait rajouter pour l'application
        - packages:
            - doctrine.yaml : quelques config de la bdd
            - quelques fichiers ont etaient rajouter : mailer, reset_pwd, etc
            - security.yaml : tous config de la securite de l'appli ont ete mis en place dans cette fichiers
        - routes:
            - security.yaml : definissez les differentes routage de chaque formulaire mis en place
            - service.yaml : definissez les services du 2ieme bdd

    4. En public :
        - les differentes images, icones, logo, etc. utiliser dans la conception de l'appli
        - les differents styles (css, js) utiliser dans la conception de l'appli

    5. En src :
        - Command : 
            - contient la partie tester la liaison de la bdd acces et l'appli
            - contient la partie hashage de mdp dans la bdd (securite de mdp)
        - Controller : controlleur des chaques template (page)
        - Datafixtures : donnee rentree dans la bdd
        - Entity : les entites de la bdd
        - Eventlistener : fonction pour se deconnecter
        - Form : les differentes formulaires
        - Repository : definissez les comportements des entites
        - security : authentification de l'appli
        - service : les differentes services (mail et generateur pdf)

    6. En templates : 
        - tous les reste : definissez le front end de chaque page utiliser
        - base.html.twig : definissez les comportements de chaque page

    7. En test :
        - test les donnees qui sont dedier a rentree dans la bdd
        - pas etait upload sur github pour les raisons de securite

    8. En var :
        - se trouve la bdd locale (acces)
        - les caches (memoire) et les logs (erreur)
    
    9. En .env, .env.local :
        - .env : 
            - definissez les config de la bdd en phpmyadmin (mysql) => on peut changer le port, CRUD, etc
            - configurations de renvoiement de mail de reinitialisation de mot de passe
        - .env.local : 
            - definissez la bdd en locale (Microsoft access) => on peut que rajouter des lignes dans chaque tableau
            - configurations de chemin pour le mail d'assistance

    10. En manifest.json :
        - se trouve les definitions de differentes taille des icones quand l'appli est telecharger
        - permet au navigateur de savoir si on peut telecharger ou pas

    11. En Webpack.Config.js :
        - definitions de chaque js, css et son entree
        - on peut rajouter d'autres bibliotheque js ou meme css


