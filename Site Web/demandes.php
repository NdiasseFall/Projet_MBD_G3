

<?php

require('requette.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['client-id']) && !empty($_POST['client-id']) && isset($_POST['montant']) && !empty($_POST['montant']) && 
        isset($_POST['duree']) && !empty($_POST['duree'])) {
            is_numeric($_POST['client-id']);
            is_numeric($_POST['montant']);
            is_numeric($_POST['duree']);
          
            $numCli = $_POST['client-id'];
            $montant = $_POST['montant'];
            $duree = $_POST['duree'];

           foreach ($clients as $client){
            if($client['NumClient'] == $numCli){
                $isererDeStament = ("INSERT INTO demandesprets( Montant, Duree, NumClient) VALUES ('$montant','$duree','$numCli')");
                $isererDe = $mysqlClient->prepare($isererDeStament);
                $isererDe->execute();
            }
           }
           
           
    }
}


?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gestion des Prêts</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container mt-5">
            <?php require_once(__DIR__ . '/header.php');?>
            <h1 class="mt-5">Gestion des Demandes</h1>

            <!-- Section d'enregistrement des prêts -->
            <div class="card mt-4">
                <div class="card-header">Enregistrer une Demandes</div>
                <div class="card-body">
                    <form id="enregistrement-form" method="POST">
                        <div class="form-group">
                            <label for="client-id">N° Client</label>
                            <input
                                type="number"
                                class="form-control"
                                name="client-id"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="montant">Montant du Prêt</label>
                            <input
                                type="number"
                                class="form-control"
                                name="montant"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="duree">Durée du Prêt (mois)</label>
                            <input
                                type="number"
                                class="form-control"
                                name="duree"
                                required
                            />
                        </div>
                        <button type="submit" class="btn mt-3 btn-primary">
                            Enregistrer
                        </button>
                    </form>
                </div>
            </div>

            <!-- Section d'affichage des informations sur les clients et les remboursements -->
            <div class="card mt-4 mb-5">
                <div class="card-header">
                    Informations des Clients 
                </div>
                <div class="card-body">
                <input
                class="form-control mt-3 mb-5 "
                id="searchInput"
                type="text"
                placeholder="Rechercher un client..."
            />
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>N° Client</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>N° Téléphnoe</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody id="clients-table-body">
                            <!-- Les données des clients seront ajoutées ici dynamiquement -->
                             <?php
                                foreach ($clients as $client) {?>
                                    <tr>
                                        <td><?php echo $client["NumClient"]?></td>
                                        <td><?php echo $client["nom"]?></td>
                                        <td><?php echo $client["prenom"]?></td>
                                        <td><?php echo $client["tel"]?></td>
                                        <td><?php echo $client["status"] ?></td>
                                     </tr>
                            <?php
                                }
                             ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="script/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#searchInput").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("#clients-table-body tr").filter(function () {
                        $(this).toggle(
                            $(this).text().toLowerCase().indexOf(value) > -1
                        );
                    });
                });
            });
        </script>
    </body>
</html>
