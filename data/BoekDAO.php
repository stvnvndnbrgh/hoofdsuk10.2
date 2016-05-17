<?php
//data/BoekDAO.php

require_once 'DBConfig.php';
require_once 'entities/Genre.php';
require_once 'entities/Boek.php';

class BoekDAO {
    public function getAll() {
        $sql = "select mvc_boeken.id as boek_id, titel, genre_id, genre from mvc_boeken, mvc_genres where genre_id = mvc_genres.id";
        $dbh = new PDO (DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $resultSet = $dbh->query($sql);
        $lijst = array();
        foreach ($resultSet as $rij) {
            $genre = Genre::create($rij["genre_id"], $rij["genre"]);
            $boek = Boek::create($rij["boek_id"], $rij["titel"], $genre);
            array_push($lijst, $boek);
        }
        $dbh = null;
        return $lijst;
    }
    
    public function getByID($id){
        $sql = "select mvc_boeken.id as boek_id, titel, genre_id, genre from mvc_boeken, mvc_genres where genre_id = mvc_genres.id and mvc_boeken.id = :id" ;
        $dbh = new PDO (DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':id' => $id));
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $genre = Genre::create($rij["genre_id"], $rij["genre"]);
        $boek = Boek::create($rij["boek_id"], $rij["titel"], $genre);
        $dbh = null;
        return $boek;
    }
    
    public function getByTitel($titel){
        $sql = "select mvc_boeken.id as boek_id, titel, genre_id, genre from mvc_boeken, mvc_genres where mvc_boeken.titel = :titel";
        $dbh = new PDO (DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':titel' => $titel));
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!$rij){
            return null;
        }else{
            $genre = Genre::create($rij["genre_id"], $rij["genre"]);
            $boek = Boek::create($rij["boek_id"], $rij["titel"], $genre);
            $dbh = null;
            return $boek;            
        }        
    }
    
    public function create($titel, $genreId) {
        $bestaandboek = $this->getByTitel($titel);
        if (!is_null($bestaandboek)){
            throw new TitelBestaatException();
        }
        $sql = "insert into mvc_boeken (titel, genre_id) values (:titel, :genreID)";
        $dbh = new PDO (DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':titel' => $titel, ':genreID' => $genreId));
        
        $boekId = $dbh->lastInsertId();
        $dbh = null;
        
        $genreDAO = new GenreDAO();
        $genre = $genreDAO->getById($genreId);
        $boek = Boek::create($boekId, $titel, $genre);
        return $boek;
    }
    
    public function delete($id) {
        $sql = "delete from mvc_boeken where id = :id";
        $dbh = new PDO (DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':id' => $id));
        $dbh = null;
    }
    
    public function update($boek) {
        $bestaandBoek = $this->getByTitel($boek->getTitel());
        if (!is_null($bestaandBoek) && ($bestaandBoek->getID() != $boek->getId())) {
            throw new TitelBestaatException();
        }
        $sql = "update mvc_boeken set titel = :titel, genre_id = :genreId where id = :id";
        $dbh = new PDO (DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':titel' => $boek->getTitel(), ':genreId' => $boek->getGenre()->getId(), ':id' => $boek->getId()));
        $dbh = null;
    }
}