<?php
//updateboek.php
require_once 'business/GenreService.php';
require_once 'business/BoekService.php';
require_once 'exceptions/TitelBestaatException.php';

if (isset($_GET["action"]) && $_GET["action"] == "process") {
    try {
        $boekSvc = new BoekService();
        $boekSvc->updateBoek($_GET["id"], $_POST["txtTitel"], $_POST["selGenre"]);
        header("location: toonalleboeken.php");
        exit(0);
    } catch (TitelBestaatException $ex) {
        header("location: updateboek.php?id=" . $_GET["id"] . "&error=titelbestaat");
        exit(0);
    }

} else {
    $genreSvc = new GenreService();
    $genreLijst = $genreSvc->getGenresOverzicht();
    $boekSvc = new BoekService();
    $boek = $boekSvc->haalBoekOp($_GET["id"]);
    if (isset($_GET["error"])){
        $error = $_GET["error"];
    }
    include("presentation/updateboekForm.php");
}