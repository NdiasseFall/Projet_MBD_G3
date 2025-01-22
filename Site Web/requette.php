<?php 
require_once(__DIR__ . "/connectDataBase.php");


$pretStament= $mysqlClient->prepare('SELECT * FROM prets');
$pretStament->execute();
$prets = $pretStament->fetchAll();

$clientStament = $mysqlClient->prepare('SELECT * FROM clients');
$clientStament->execute();
$clients = $clientStament->fetchAll();

