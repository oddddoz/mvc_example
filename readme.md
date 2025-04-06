# Fonctionnement actuel

## Architecture MVC mis en place.

Le code de ce repository est un pokedex fonctionnel. L'architecture MVC est respectée et fonctionne de la façon suivante:  
    1. Les requêtes de l'utilisateur arrivent sur la page `index.php` du dossier public. 
    2. Sur cette page, à l'aide de condition on déclanche la bonne méthode du controlleur en fonction des parametres de la requête (GET ou POST, route etc...)
    3. Le controlleur déclanche la bonne méthode du model pour intéragir avec la donnée (ajout, suppression, modification et lecture)
    4. Ensuite cette donnée récupérée via le model est passée à la "vue" (par example `list.php` dans le cas de l'index.)  


### Connexion à l'API externe dans `retrieve_data_from_api`

Les informations des pokémons nous viennent d'une source externe, vous pouvez voir la méthode privée `retrieve_data_from_api` du model pour voir comment elle le fait. (n'hésitez pas a copier le code et demander à chatgpt de l'expliquer si cela vous intéresse).


## Cahier des charges

On vous demande de:  
    1. Créer une base de donnée, et modifier les informations de connexion du PokemonModelSQL pour se connecter à cette base. Ce qui devrait faire disparaitre l'erreur de connexion à la base de donnée. (très facile)
    2. Modifier la base de données et le code pour récuperer, sauvegarder et afficher l'image du pokémon dans la vue de l'index. (facile)
    3. Créer et utiliser une nouvelle vue pour afficher les informations d'un pokémon en particulier. (ex: `route=pokemon&name=pikachu`) (facile)
    4. Créer et utiliser une nouvelle vue pour comparer deux pokémons entre eux. (ex: `route=comparator&1=pikachu&2=pichu`), attention cette fois cela demande aussi d'ajouter une méthode au Controlleur ainsi qu'une condition supplémentaire dans le `index.php` pour déclencher la bonne méthode du controlleur. (avancé)


Attention de bien respecter l'architecture MVC, et de ne pas faire de requêtes SQL dans les vues ou dans le controlleur!!!

## Avancé: Moteur de recherche

Pour la vue `list.php` vous pouvez ajouter un moteur de recherche pour filtrer les pokémons affichés.

1. Recherche par nom: si l'utilisateur tape "Pi" il doit voir tous les pokémons qui contiennent "Pi" dans leur nom (ex: Pikachu, Pichu, etc...)
2. Recherche par type: si l'utilisateur tape "Feu" il doit voir tous les pokémons qui contiennent "Feu" dans leur type (ex: Salamèche, Dracaufeu, etc...)
3. Recherche global: Mettre en commun dans un seul input les deux recherches précédentes. L'utilisateur peut taper un nom ou un type et il doit voir tous les pokémons qui contiennent ce nom ou ce type.
