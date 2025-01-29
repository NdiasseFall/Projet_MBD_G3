<?php
require('requette.php');

// Fonction pour enregistrer une nouvelle demande de prêt
function enregistrerDemande($montant_demande, $duree_demande, $num_client) {
    global $mysqlClient;
    $sql = "INSERT INTO demandesprets( Montant, Duree, NumClient) VALUES ( $montant_demande, $duree_demande, $num_client)";
    $stmt = $mysqlClient->prepare($sql);
    $stmt->execute();
}


function enregistrerPret($Montant, $Taux, $Duree, $Montant_mens, $NumClient) {
    global $mysqlClient;
    global $Remboursement;
    global $taxe;

    $Num_R = 0;
    $Num_t = 0;

    foreach($Remboursement as $rem){
        if($rem['Num_Rem'] > 0){
            $Num_R = $rem['Num_Rem'];
        }
    }

    foreach($taxe as $row){
        if($row['Num_taxe'] > 0){
            $Num_t = $row['Num_taxe'];
        }
    }

    // Supprimez les virgules et convertissez en nombre double
    $Montant_mens = str_replace(",", "", $Montant_mens);
    $Montant_mens = (double) $Montant_mens;

    $sql = "INSERT INTO Prets (Montant, Taux, Duree, Montant_mens, Num_Rem, NumClient, Num_taxe, status) VALUES 
    (:Montant, :Taux, :Duree, :Montant_mens, :Num_Rem, :NumClient, :Num_taxe, 'actif')";
    $stmt = $mysqlClient->prepare($sql);

    // Liez les paramètres
    $stmt->bindParam(':Montant', $Montant);
    $stmt->bindParam(':Taux', $Taux);
    $stmt->bindParam(':Duree', $Duree);
    $stmt->bindParam(':Montant_mens', $Montant_mens);
    $stmt->bindParam(':Num_Rem', $Num_R);
    $stmt->bindParam(':NumClient', $NumClient);
    $stmt->bindParam(':Num_taxe', $Num_t);

    // Exécutez la requête
    $stmt->execute();
}



// Fonction pour consulter les informations sur un client
function consulterClient($num_client) {
    global $mysqlClient;
    $sql = "SELECT * FROM clients WHERE NumClient = $num_client";
    $stmt = $mysqlClient->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}
function consulterPrets($num_pret) {
    global $mysqlClient;
    $sql = "SELECT * FROM Prets WHERE Num_Prets = $num_pret";
    $stmt = $mysqlClient->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}
function consulterRem($num_pret) {
    global $mysqlClient;
    $sql = "SELECT * FROM Remboursement WHERE Num_Rem = $num_pret";
    $stmt = $mysqlClient->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}


function enregistrerRemboursement($montant, $date_remboursement) {
    global $mysqlClient;
    // Préparez l'instruction SQL avec des paramètres
    $sql = "INSERT INTO Remboursement (Montant, Date_R) VALUES (:montant, :date_remboursement)";
    $stmt = $mysqlClient->prepare($sql);

    // Liez les valeurs aux paramètres
    $stmt->bindParam(':montant', $montant);
    $stmt->bindParam(':date_remboursement', $date_remboursement);

    // Exécutez la requête
    $stmt->execute();

}
function enregistrerRemboursement2($montant, $date_remboursement, $num_pret) {
    global $mysqlClient;
    $result = consulterPrets($num_pret);
    foreach ($result as $key) {
 
        if($key['Num_Prets'] == $num_pret){

            $result2 = consulterRem($key['Num_Rem']);
            foreach($result2 as $val){
            $Num_Rem = $val['Num_Rem'];
                // Préparez l'instruction SQL avec des paramètres
                $sql = "UPDATE Remboursement SET Montant = :montant , Date_R = :date  WHERE Num_Rem = $Num_Rem";
                // Exécutez la requête et gérez les erreurs
                try {
                    $stmt = $mysqlClient->prepare($sql);
                    $stmt->bindParam( ':montant',$montant);
                    $stmt->bindParam( ':date', $date_remboursement);
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo "Erreur lors de l'enregistrement du remboursement : " . $e->getMessage();
                    return false;
                }
            }
        
        }
    }
       // Récupérer l'ID du dernier enregistrement inséré
    //    $num_remboursement = $mysqlClient->lastInsertId();

       // Vérifier si le remboursement entraîne une révision ou une suspension du prêt
       verifierRevisionSuspension($num_pret, $Num_Rem);
   
       return true;
   
}



function calculerInterets($montant_pret, $taux, $duree) {
    // Calcul des intérêts selon la méthode choisie (simples, composés, etc.)
    // Ici, exemple de calcul d'intérêts simples annuels
    $interets = $montant_pret * $taux * $duree / 100;
    return $interets;
}

function calculerTaxes($montant_remboursement, $mensualite_normale,$date) {
    global $mysqlClient;
        // Supprimez les virgules
        $mensualite_normale = str_replace(",", "", $mensualite_normale);

        // Convertir en type double
        $mensualite_normale = (double) $mensualite_normale;


    if ($montant_remboursement < $mensualite_normale / 3) {
        // Calcul du montant de la taxe (à adapter selon les règles de votre banque)
        $taxe = $mensualite_normale * 0.1; // Exemple : 10% de la mensualité normale

        // Enregistrement de la taxe
        $sql = "INSERT INTO Taxe ( Date_T, Montant) VALUES (:date, :taxe)";
        $stmt = $mysqlClient->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':taxe', $taxe);
        $stmt->execute();
        // Marquer le client comme "suspendu" (à implémenter dans votre application)
    }
}



function verifierRevisionSuspension($Num_Prets, $Num_Rem) {
    global $mysqlClient;

    // Préparer la requête pour éviter les injections SQL
    $sql = "SELECT * FROM Prets WHERE Num_Prets = :Num_Prets";
    $stmt = $mysqlClient->prepare($sql);
    $stmt->bindParam(':Num_Prets', $Num_Prets);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $pret = $result;

    // Préparer la requête pour calculer le montant total remboursé
    $sql = "SELECT Montant FROM Remboursement WHERE Num_Rem = :Num_Rem"; 
    $stmt = $mysqlClient->prepare($sql);
    $stmt->bindParam(":Num_Rem", $Num_Rem);
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach ($result as $key ) {
        $total_rembourse = $key['Montant'];
    }

    // Calculer la mensualité normale
    foreach ($pret as $key ) {
        $mensualite_normale = calculerMensualite($key['Montant'], $key['Taux'], $key['Duree']);
        $dureePret = $key['Duree'];
    }

    // Calculer le nombre de mensualités théoriques payées
    $nb_mensualites_theoriques = ceil($total_rembourse / $mensualite_normale);

    // Seuils de révision et de suspension
    $seuil_revision = 3;
    $seuil_suspension = 0.33;

    // Vérifier si le prêt doit être révisé ou suspendu
    if ($nb_mensualites_theoriques > $dureePret + $seuil_revision) {
        // Révision du prêt
        $nouveau_montant = $pret['montant'] - $total_rembourse; 
        $nouvelle_duree = $pret['duree'] - $nb_mensualites_theoriques; 
        $nouvelle_mensualite = calculerMensualite($nouveau_montant, $pret['taux'], $nouvelle_duree);

        // Mettre à jour les informations dans la table Pret
        $sql = "UPDATE Prets SET montant = ?, duree = ?, mensualite = ? WHERE Num_Prets = ?";
        $stmt = $mysqlClient->prepare($sql);
        $stmt->bindParam("didi", $nouveau_montant, $nouvelle_duree, $nouvelle_mensualite, $Num_Prets);
        $stmt->execute();
    } elseif ($total_rembourse < $mensualite_normale * $seuil_suspension) {
        
        calculerTaxes($total_rembourse, $mensualite_normale, $Num_Prets);
        // Par exemple, ajouter un champ "statut" dans la table Clients et le mettre à "suspendu"
        $sql = "UPDATE clients SET status = 'suspendu' WHERE num_client = ?";
        $stmt = $mysqlClient->prepare($sql);
        $stmt->bindParam("i", $pret['num_client']);
        $stmt->execute();
    }
}

function calculerMensualite($montant_pret, $taux, $duree) {
    $taux_mensuel = $taux / 12 / 100;
    $denominateur = pow(1 + $taux_mensuel, $duree) - 1;
    $mensualite = $montant_pret * $taux_mensuel * pow(1 + $taux_mensuel, $duree) / $denominateur;
    return number_format($mensualite, 2);
}