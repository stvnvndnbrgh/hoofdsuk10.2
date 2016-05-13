<?php
//verwijderboek.php
require_once 'business/BoekService.php';

$boekSvc = new BoekService();
$boekSvc->verwijderBoek($_GET["id"]);
header("location: toonalleboeken.php");
exit(0);