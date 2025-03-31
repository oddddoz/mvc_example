<?php

class PokemonModelSQL {
    private $pdo;
    private $tableName = 'pokemons';
    
    public function __construct() {
        // Initialize PDO connection
        $this->pdo = new PDO('mysql:host=mysql-container;dbname=testdb', 'user', 'password');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create table if it doesn't exist
        $this->createTableIfNotExists();
    }

    private function createTableIfNotExists() {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->tableName} (
            id INT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            type1 VARCHAR(255) NOT NULL,
            type2 VARCHAR(255),
            UNIQUE(name)
        )";
        $this->pdo->exec($sql);
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->tableName}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($name) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE name = :name");
        $stmt->execute([':name' => $name]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function add($name) {
        $pokemon = $this->retrieve_data_from_api($name);
        
        $stmt = $this->pdo->prepare("INSERT INTO {$this->tableName} (id, name, type1, type2) 
                                    VALUES (:id, :name, :type1, :type2)");
        $stmt->execute([
            ':id' => $pokemon['id'],
            ':name' => $pokemon['name'],
            ':type1' => $pokemon['type1'],
            ':type2' => $pokemon['type2']
        ]);
        
        return $this->get($pokemon['name']);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->tableName} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    private function retrieve_data_from_api($name) {
        $url = 'https://tyradex.app/api/v1/pokemon/' . $name;

        $options = [
            "http" => [
                "header" => "Content-Type: application/json\r\n" .
                    "cache-control: no-cache\r\n",
                "method" => "GET"
            ],
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false
            ]
        ];

        $context = stream_context_create($options);

        $content = file_get_contents($url);
        $data = json_decode($content, true);

        if (!isset($data['pokedex_id'])) {
            throw new Exception("Pokemon not found", 1);
        }

        $pokemon = [
            "id" => $data['pokedex_id'],
            "name" => $data['name']['fr'],
            "type1" => $data['types'][0]['name'],
            "type2" => isset($data['types'][1]) ? $data['types'][1]['name'] : null
        ];

        return $pokemon;
    }
}
