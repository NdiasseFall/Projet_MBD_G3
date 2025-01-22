

<?php

require_once(__DIR__ . '/requette.php');

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gestion des Prêts</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
            crossorigin="anonymous"
        />
    </head>
    <body>
        <div class="container">
        <?php

require_once(__DIR__ . '/header.php');

?>
            <h1 class="mt-5">Gestion des Prêts</h1>

            <!-- Section d'enregistrement des prêts -->
            <div class="card mt-4">
                <div class="card-header">Enregistrer un Prêt</div>
                <div class="card-body">
                    <form id="enregistrement-form">
                        <div class="form-group">
                            <label for="client-id">ID Client</label>
                            <input
                                type="number"
                                class="form-control"
                                id="client-id"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="montant">Montant du Prêt</label>
                            <input
                                type="number"
                                class="form-control"
                                id="montant"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="duree">Durée du Prêt (mois)</label>
                            <input
                                type="number"
                                class="form-control"
                                id="duree"
                                required
                            />
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Enregistrer
                        </button>
                    </form>
                </div>
            </div>

            <!-- Section d'affichage des informations sur les clients et les remboursements -->
            <div class="card mt-4">
                <div class="card-header">
                    Informations des Clients et Remboursements
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Client</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Prêt en cours</th>
                                <th>N° Demandes de Prêt</th>
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
                                        <td><?php echo $client["status"]?></td>
                                        <td><?php ?></td>
                                     </tr>
                            <?php
                                }
                             ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
