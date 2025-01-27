<?php 
    require('requette.php');

 
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations sur les Prêts</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">

        <?php require('header.php')?>

        <h1 class="mt-4">Informations sur les Prêts</h1>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Numéro de Prêt</th>
                    <th>Prenom</th>
                    <th>Nom</th>
                    <th>Montant</th>
                    <th>Taux</th>
                    <th>Montant Taxe</th>
                    <th>Durée (mois)</th>
                    <th>Mensualité</th>
                    <th>Date Remboursement</th>
                    <th>Statut du Prêt</th>
                </tr>
            </thead>
            <tbody >
                <!-- Les données des prêts seront ajoutées ici dynamiquement -->
                 <?php foreach($affPrets as $pret){?>
                    <tr>
                        <td><?php echo $pret['Num_Prets'] ?></td>
                        <td><?php echo $pret['Prenom_Client'] ?></td>
                        <td><?php echo $pret['Nom_Client'] ?></td>
                        <td><?php echo $pret['Montant'] ?> CFA</td>
                        <td><?php echo $pret['Taux'] ?> %</td>
                        <td><?php echo $pret['Montant_Taxe'] ?> CFA</td>
                        <td><?php echo $pret['Duree'] ?> mois</td>
                        <td><?php echo $pret['Montant_mens'] ?> CFA</td>
                        <td><?php echo $pret['Date_Remboursement'] ?></td>
                        <td><?php echo $pret['Status'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="script/jquery.min.js"></script>
    <script src="bootstrap/bootstrap.min.js"></script>
    
</script>
</body>
</html>
