Ce document est une documentation du projet qui decrit les étapes et une explication rapide des pages et du programme:

    1. Pour la bdd en access : 
        - $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=project_directory/var/bdd/data.mdb;";
        - faut bien definir le chemin du projet sur la machine (pc) utiliser.
    
    2. En assets, bin, node_modules, vendor, et d'autres qui ne sont pas mentionnes ci-dessus : 
        - Il n'y a pas eu de modification (rien n'a ete change)
        - ne sont pas upload sur github pour les raisons de securite

    3. En config :
        - route.yaml : modification de routage pour les entetes de page
        - services.yaml : les differents services ont ete rajoutes pour l'appli
        - packages:
            - doctrine.yaml : quelques config de la bdd
            - quelques fichiers ont ete rajoute : mailer, reset_pwd, etc
            - security.yaml : tous config de la securite de l'appli ont ete mis en place dans ces fichiers
        - routes:
            - security.yaml : definissez les differents routages de chaque formulaire mis en place
            - service.yaml : definissez les services du 2ieme bdd

    4. En public :
        - les differentes images, icones, logo, etc. utilises dans la conception de l'appli
        - les differents styles (css, js) utilises dans la conception de l'appli

    5. En src :
        - Command : 
            - contient la partie tester la liaison de la bdd access et l'appli
            - contient la partie hashage de mdp dans la bdd (securite de mdp)
        - Controller : controleur de chaque template (page)
        - Datafixtures : donnees rentrees dans la bdd
        - Entity : les entites de la bdd
        - Eventlistener : fonction pour se deconnecter
        - Form : les differents formulaires
        - Repository : definissez les comportements des entites
        - security : authentification de l'appli
        - service : les differents services (mail et generateur pdf)

    6. En templates : 
        - tous les restes : definissez le front end de chaque page utiliser
        - base.html.twig : definissez les comportements de chaque page

    7. En test :
        - test les donnees qui sont dediees a rentres dans la bdd
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
        - se trouve les definitions de differentes tailles des icones quand l'appli est telecharger
        - permet au navigateur de savoir si on peut telechargee ou pas

    11. En Webpack.Config.js :
        - definitions de chaque js, css et son entree
        - on peut rajouter d'autres bibliotheque js ou meme css


