<?php
//entities/Genre.php

class Genre {
    private static $idMap = array();
    
    private $id;
    private $genreNaam;
    
    private function __construct($id, $genreNaam) {
        $this->id = $id;
        $this->genreNaam = $genreNaam;
    }
    
    public static function create($id, $genreNaam) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Genre($id, $genreNaam);
        }
        return self::$idMap[$id];
    }
    
    function getId() {
        return $this->id;
    }

    function getGenreNaam() {
        return $this->genreNaam;
    }

    function setGenreNaam($genreNaam) {
        $this->genreNaam = $genreNaam;
    }
}