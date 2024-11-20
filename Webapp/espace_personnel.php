<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'personnel') {
    header("Location: espace_personnel.php");
    exit();
}

// Récupérer l'email de l'utilisateur connecté
$email = $_SESSION['email'];

// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "utilisateur");

// Récupérer les informations de l'utilisateur, y compris le solde de congé
$requete_info_utilisateur = "SELECT * FROM utilisateurs WHERE email='$email'";
$resultat_info_utilisateur = mysqli_query($connexion, $requete_info_utilisateur);
$ligne_info_utilisateur = mysqli_fetch_assoc($resultat_info_utilisateur);

// Récupérer le solde de congé de l'utilisateur
$solde_conges = $ligne_info_utilisateur['solde_conges'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Consultation des demandes de congé</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
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
    <div class="container">
        <h2 class="text-center">Historique des demandes de congé</h2>
        <div class="table-responsive">
        <label>Solde de congé :</label>
            <button type="button" class="btn btn-info"><?php echo $solde_conges; ?> jours</button>
        </div>          
        <hr>
          <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Motif</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $requete = "SELECT * FROM demandes_conge WHERE email_utilisateur='$email'";
                    $resultat = mysqli_query($connexion, $requete);
                    while ($ligne = mysqli_fetch_assoc($resultat)) {
                    ?>
                    <tr>
                        <td><?php echo $ligne['date_debut']; ?></td>
                        <td><?php echo $ligne['date_fin']; ?></td>
                        <td><?php echo $ligne['motif']; ?></td>
                        <td><?php echo $ligne['statut']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
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
