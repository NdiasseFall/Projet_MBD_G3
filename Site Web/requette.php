<?php 
require_once(__DIR__ . "/connectDataBase.php");


$pretStament= $mysqlClient->prepare('SELECT * FROM prets');
$pretStament->execute();
$prets = $pretStament->fetchAll();

$clientStament = $mysqlClient->prepare('SELECT * FROM clients');
$clientStament->execute();
$clients = $clientStament->fetchAll();

$demandeStament = $mysqlClient->prepare('SELECT * FROM demandesprets');
$demandeStament->execute();
$demandes = $clientStament->fetchAll();

$remStament = $mysqlClient->prepare('SELECT * FROM Remboursement');
$remStament->execute();
$Remboursement = $remStament->fetchAll();

$taxeStament = $mysqlClient->prepare('SELECT * FROM Taxe');
$taxeStament->execute();
$taxe = $taxeStament->fetchAll();


function randomFloat($min, $max) {
    return $min + mt_rand() / mt_getrandmax() * ($max - $min);
}


$nombreAleatoire = randomFloat(0, 10); // Génère un nombre réel aléatoire entre 0 et 10
$nombreAleatoireFormatte = number_format($nombreAleatoire, 2); // Limite les chiffres après la virgule à 2

// foreach($demandes as $demande){
//     $Montant['Montant'];
//     $Duree['Duree'];
//     $NumClient = $demande['NumClient'];
//     $Montant_mens = $Montant * $nombreAleatoireFormatte / $Duree ;
//     foreach ($affPrets as $pret) {
//         if ($NumClient != $pret['NumClient']) {
//             $queryPret = $mysqlClient->prepare ("INSERT INTO Prets ( Montant, Taux, Duree, Montant_mens, Num_Rem, NumClient, Num_taxe, status) 
//                 VALUES ( '$Montant', '$nombreAleatoireFormatte' , '$Duree', '$Montant_mens', 3001,'$NumClient' , 4001, 'actif' )");
//             $queryPret->execute();
//             echo 'ok';
//         }
//     }
    
  

// }

$sqlPrets = $mysqlClient->prepare( 'SELECT 
    p.Num_Prets, 
    p.Montant, 
    p.Taux, 
    p.Duree, 
    p.Montant_mens, 
    p.Status, 
    r.Montant AS Montant_Remboursement, 
    r.Date_R AS Date_Remboursement, 
    c.Nom AS Nom_Client, 
    c.Prenom AS Prenom_Client, 
    t.Montant AS Montant_Taxe, 
    t.Date_T AS Date_Taxe 
FROM 
    Prets p
JOIN 
    Remboursement r ON p.Num_Rem = r.Num_Rem
JOIN 
    Clients c ON p.NumClient = c.NumClient
JOIN 
    Taxe t ON p.Num_taxe = t.Num_taxe;
');
$sqlPrets->execute();
$affPrets = $sqlPrets->fetchAll();

