<?php 
$hote = 'localhost';
$identifiant = 'root';
$pass = '';
$database = 'gestion_pretsbank';
 
try {
    $mysqlClient = new PDO("mysql:host=$hote;dbname=$database","$identifiant","$pass",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
} catch (Exception $e) {
    die('Erreur : ' .$e->getMessage());
}
