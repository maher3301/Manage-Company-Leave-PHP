<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: connexion.php");
    exit();
}
$connexion = mysqli_connect("localhost", "root", "", "utilisateur");


// Vérifier si le solde de congé est suffisant avant de soumettre la demande
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $motif = $_POST['motif'];
    $email_utilisateur = $_SESSION['email'];
    
    // Récupérer le solde de congé de l'utilisateur
    $requete_solde = "SELECT solde_conges FROM utilisateurs WHERE email = '$email_utilisateur'";
    $resultat_solde = mysqli_query($connexion, $requete_solde);
    $ligne_solde = mysqli_fetch_assoc($resultat_solde);
    $solde_conges = $ligne_solde['solde_conges'];

    // Afficher le solde de congé récupéré pour débogage
    echo "Solde de congé récupéré : " . $solde_conges . "<br>";
    
    // Calculer le nombre de jours demandés
    $date_debut_timestamp = strtotime($date_debut);
    $date_fin_timestamp = strtotime($date_fin);
    $nombre_jours_demandes = floor(($date_fin_timestamp - $date_debut_timestamp) / (60 * 60 * 24)) + 1;
    
    // Vérifier si le solde de congé est suffisant
    if ($solde_conges >= $nombre_jours_demandes) {
        // Insérer la demande de congé dans la table demandes_conge
        $requete_insertion = "INSERT INTO demandes_conge (date_debut, date_fin, motif, email_utilisateur, statut) VALUES ('$date_debut', '$date_fin', '$motif', '$email_utilisateur', 'en attente')";
        mysqli_query($connexion, $requete_insertion);

        // Mettre à jour le solde de congé de l'utilisateur
        $nouveau_solde = $solde_conges - $nombre_jours_demandes;
        $requete_maj_solde = "UPDATE utilisateurs SET solde_conges = $nouveau_solde WHERE email = '$email_utilisateur'";
        mysqli_query($connexion, $requete_maj_solde);
        
        // Rediriger l'utilisateur vers l'espace personnel
        header("Location: espace_personnel.php");
        exit();
    } else {
        $erreur = "Solde de congé insuffisant. Veuillez demander un nombre de jours de congé inférieur ou égal à votre solde de congé actuel.";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle demande de congé</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
         footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        .container {
            margin-top: 50px;
        }
        form {
            max-width: 400px;
            margin: auto;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Maher</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                
                <li class="nav-item">
                    <a class="nav-link" href="espace_personnel.php">Espace Personnel</a>
                </li>
               
                
                <li class="nav-item">
                    <a class="nav-link" href="nouvelle_demande.php">Nouvelle Demande</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profil.php">Profil</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="deconnexion.php">Déconnexion</a>
            </li>
            </ul>
        </div>
    </nav>
    <hr>
    <div class="container">
        <h2 class="text-center">Nouvelle demande de congé</h2>
        <?php if(isset($erreur)) echo "<div class='alert alert-danger'>$erreur</div>"; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="date_debut">Date de début :</label>
                <input type="date" class="form-control" name="date_debut" required>
            </div>
            <div class="form-group">
                <label for="date_fin">Date de fin :</label>
                <input type="date" class="form-control" name="date_fin" required>
            </div>
            <div class="form-group">
                <label for="motif">Motif :</label>
                <select name="motif" class="form-control" required>
                    <option value="Vacances">Vacances</option>
                    <option value="Maladie">Maladie</option>
                    <option value="Rendez-vous médical">Rendez-vous médical</option>
                    <option value="Matérnité">Matérnité</option>
                    <option value="Congé pour enfant malade">Congé pour enfant malade</option>
                    <option value="Congé pour évènements familiaux">Congé pour évènements familiaux</option>
                    <!-- Ajoutez autant d'options que nécessaire -->
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Soumettre la demande</button>
        </form>
    </div>
    
    <footer>
        <div class="container">
            <p>&copy; 2024 Maher - Tous droits réservés</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
