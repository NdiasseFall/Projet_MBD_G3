
<?php 
    require('fonction.php');
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['numPret']) && !empty($_POST['numPret']) && isset($_POST['montant']) && !empty($_POST['montant'])) {
                floatval($_POST['montant']);
                $numpret = $_POST['numPret'];
                $montant = $_POST['montant'];
                $date = date("d M Y");  

               foreach ($prets as $pret){
                if($pret['Num_Prets'] == $numpret){
                    enregistrerRemboursement2($montant,$date,$numpret);
                    
                }
               }
        }
        
    }


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<body>
    
<div class="container mt-5">
            <?php require_once(__DIR__ . '/header.php');?>
            <h1 class="mt-5">Gestion des Remboursements</h1>

            <!-- Section d'enregistrement des prêts -->
            <div class="card mt-4">
                <div class="card-header">Faire un Remboursement</div>
                <div class="card-body">
                    <form id="enregistrement-form" method="POST">
                        <div class="form-group">
                            <label for="numPret">N° Prêt</label>
                            <input
                                type="number"
                                class="form-control"
                                name="numPret"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="montant">Montant </label>
                            <input
                                type="number"
                                class="form-control"
                                name="montant"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="duree">
                            <?php
                            // Affiche la date actuelle au format "Jour Mois Année"
                            $date = date("d M Y");
                            echo $date;
                             ?>
                            </label>
                            
                        </div>
                        

                        <button type="submit" class="btn mt-3 btn-primary">
                            Enregistrer
                        </button>
                    </form>
                </div>
            </div>

</div>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>