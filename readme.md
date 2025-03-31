# Consignes

Dans ce repository, le code du pokedex suivant le pattern MVC. Il est fonctionnel.

1. Vous devez modifier la connexion à la base de données via `new PDO()` pour supporter une connexion à votre base de données locale. (Laragon, Xampp, uWamp etc..)
2. Modifier la base de données pour accepter une colonne supplémentaire `image` de type `VARCHAR(255)`.
3. Modifier la fonciton qui récupère les infos d'un pokémon pour inclure l'image du pokémon.
4. Vous devez ajouter la vue au controller qui se déclanche via la route: `route=pokemon&name=pikachu`, utilisez pour cela toutes les infos du pokémon.
5. En ajoutant une vue, un méthode au controller qui se déclenche via la route `route=comparator&1=pikachu&2=pichu`, sur cette vue vous utiliserez les informations des 2 pokemons pour les comparer.


