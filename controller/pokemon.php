<?php
require_once '../model/pokemon_sql.php';
require_once '../model/pokemon.php';

class Controller {
    private $pokemonModel;

    public function __construct() {
        $this->pokemonModel = new PokemonModelSQL();
    }

    public function index() {
        $pokemons = $this->pokemonModel->getAll();
        
        require '../views/list.php';
    }

    public function get($name) {
        $pokemon = $this->pokemonModel->get($name);

        print_r($pokemon);

        echo 'Welcome to the ' . $pokemon["name"] . " n: " . $pokemon["id"].  ' page';
    }

    public function add($name) {
        try {
            $pokemon = $this->pokemonModel->add($name);
        } catch (\Throwable $th) {
            echo 'Error: ' . $th->getMessage();
            return;
        }

        header('Location: ?route=pokemon&name=' . $name);
    }

    public function delete($id) {
        $deleted = $this->pokemonModel->delete($id);
        if ($deleted) {
            header('Location: /');
        } else {
            $this->notFound();
        }
    }

    public function notFound() {
        echo '404 Not Found';
    }
}
