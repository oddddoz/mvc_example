<?php

class PokemonModel {
    private $csvFile = 'pokemon.csv';
    
    public function __construct() {
        // Create the CSV file with headers if it doesn't exist
        if (!file_exists($this->csvFile)) {
            $file = fopen($this->csvFile, 'w');
            fputcsv($file, ['id', 'name', 'type1', 'type2']);
            fclose($file);
        }
    }

    public function getAll() {
        $pokemons = [];
        
        if (($file = fopen($this->csvFile, 'r')) !== false) {
            // Skip header row
            fgetcsv($file, null, ',', '"', "\\");
            
            while (($data = fgetcsv($file,null, ',', '"', "\\")) !== false) {
                $pokemons[] = [
                    'id' => $data[0],
                    'name' => $data[1],
                    'type1' => $data[2],
                    'type2' => $data[3] ?? null // type2 is optional
                ];
            }
            fclose($file);
        }
        
        return $pokemons;
    }

    public function get($name) {
        if (($file = fopen($this->csvFile, 'r')) !== false) {
            // Skip header row
            fgetcsv($file, null, ',', '"', "\\");
            while (($data = fgetcsv($file, null, ',', '"', "\\")) !== false) {
                if ($data[1] == $name) {
                    fclose($file);
                    return [
                        'id' => $data[0],
                        'name' => $data[1],
                        'type1' => $data[2],
                        'type2' => $data[3] ?? null
                    ];
                }
            }
            fclose($file);
        }
        
        return null;
    }

    public function add($name) {

        $pokemon = $this->retrieve_data_from_api($name);

        $file = fopen($this->csvFile, 'a');
        fputcsv($file, [$pokemon['id'], $pokemon['name'], $pokemon['type1'], $pokemon['type2']]);
        fclose($file);
        
        return $this->get($id);
    }

    public function delete($id) {
        $pokemons = $this->getAll();
        $file = fopen($this->csvFile, 'w');
        
        // Write headers
        fputcsv($file, ['id', 'name', 'type1', 'type2']);
        
        $found = false;
        foreach ($pokemons as $pokemon) {
            if ($pokemon['id'] != $id) {
                fputcsv($file, [
                    $pokemon['id'],
                    $pokemon['name'],
                    $pokemon['type1'],
                    $pokemon['type2']
                ]);
            } else {
                $found = true;
            }
        }
        
        fclose($file);
        return $found;
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
            "type2" => $data['types'][1] ? $data['types'][1]['name'] : null
        ];

        return $pokemon;
    }
}
