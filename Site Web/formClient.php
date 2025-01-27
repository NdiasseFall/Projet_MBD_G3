<?php
require('requette.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['inputNom']) && !empty($_POST['inputNom']) && isset($_POST['inputPrenom']) && !empty($_POST['inputPrenom']) && 
        isset($_POST['inputAddress']) && !empty($_POST['inputAddress']) && isset($_POST['inputTel']) && !empty($_POST['inputTel']) ) {
            htmlspecialchars($_POST['inputNom']);
            htmlspecialchars($_POST['inputPrenom']);
            htmlspecialchars($_POST['inputAddress']);

            $nom = $_POST['inputNom'];
            $prenom = $_POST['inputPrenom'];
            $address = $_POST['inputAddress'];
            $tel = $_POST['inputTel'];
            $status = $_POST['inputStatut'];

            $isererStament = ("INSERT INTO clients( Nom, Prenom, address,tel, status) VALUES ('$nom','$prenom','$address','$tel','$status')");
            $iserer = $mysqlClient->prepare($isererStament);
            $iserer->execute();
    }
}


?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container mt-5" id="enregistrement-form-client">

            <?php require_once(__DIR__ . '/header.php');?>

            <div id="error-message" class="alert alert-danger d-none mt-5 " role="alert">
                <p>Une erreur s'est produite lors de l'enregistrement</p>
            </div>

            <div id="success-message" class="alert alert-success d-none mt-5 " role="alert">
                <p>enregistré avec succès !</p>
            </div>
            <h1 class="mt-5">Enregistré un client</h1>
            <div class="card mt-5 ">
                <form  class="row g-3 m-3" method="post">
                    <div class="col-md-6">
                        <label for="inputNom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="inputNom" name="inputNom" required/>
                    </div>                
                    <div class="col-md-6">
                        <label for="inputPrenom" class="form-label">Prenom</label>
                        <input type="text" class="form-control" id="inputPrenom" name="inputPrenom" required />
                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="inputAddress" name="inputAddress" />
                    </div>

                    <div class="col-md-6">
                        <label for="inputTel" class="form-label">Telephone</label>
                        <input type="number" class="form-control" id="inputTel" name="inputTel"  />
                    </div>
                    <div class="col-md-4">
                        <label for="inputStatut" class="form-label" >Statut</label>
                        <select name="inputStatut" id="inputStatut" class="form-select">
                                <option selected value="actif">Actif</option>
                                <option value="suspendu">Suspendus</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <button id="liveAlertBtn" type="submit" class="btn btn-primary">
                            Enregistrer
                        </button>
                    </div>
                                
                </form>
            </div>
        </div>
    
        <script src="script/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
       <script>
            $(document).ready(function() {
                $('#enregistrement-form-client').submit(function(event) {
                   
                    const nom = $("#inputNom").val();
                    const prenom = $("#inputPrenom").val ();
                    const address = $("#inputAddress").val();
                    const tel = $("#inputTel").val();
                    const status = $("#inputStatut").val();
                        
                    
                    if ( !nom == '' && !prenom == '' && !address =='' && !tel == '' && !status == '') {
                    
                        $('#success-message').removeClass('d-none');
                        $('#error-message').addClass('d-none');
                        setTimeout(function() { $('#success-message').addClass('d-none'); }, 3000);
                        
                    } else {
                        $('#error-message').removeClass('d-none');
                        $('#success-message').addClass('d-none');
                        setTimeout(function() { $('#error-message').addClass('d-none'); }, 3000);
                    }
                    
                    
                });
            });

       </script>
    </body>
</html>
