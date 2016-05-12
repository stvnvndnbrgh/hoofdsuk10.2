<?php
//test.php
require_once 'data/BoekDAO.php';

$doa = new BoekDAO();
$boek = $doa->getById(1);
print("<pre>");
print_r($boek);
print("</pre>");
var_dump($boek);