<?php
//voegboektoe.php
require_once 'business/GenreService.php';
require_once 'business/BoekService.php';

if (isset($_GET["action"]) && $_GET["action"] == "process"){
    $boekSvc = new BoekService();
    $boekSvc->voegNieuwBoekToe($_POST["txtTitel"], $_POST["selGenre"]);
    header("location: toonalleboeken.php");
    exit(0);
}else{
    $genreSvc = new GenreService();
    $genreLijst = $genreSvc->getGenresOverzicht();
    include("presentation/nieuwboekForm.php");
}