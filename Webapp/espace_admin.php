<?php
session_start();

// Vérifier si l'administrateur est connecté
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'administrateur') {
    header("Location: espace_admin.php");
    exit();
}

// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "utilisateur");

// Vérifier la connexion
if (!$connexion) {
    die("Erreur de connexion à la base de données: " . mysqli_connect_error());
}

// Récupérer la liste du personnel
$requete_personnel = "SELECT * FROM utilisateurs WHERE role='personnel'";
$resultat_personnel = mysqli_query($connexion, $requete_personnel);

// Vérifier si des utilisateurs sont trouvés
if (mysqli_num_rows($resultat_personnel) > 0) {
    // Afficher la liste du personnel
    $liste_personnel = "<table class='table'>";
    $liste_personnel .= "<thead class='thead-light'>";
    $liste_personnel .= "<tr>";
    $liste_personnel .= "<th>Nom</th>";
    $liste_personnel .= "<th>Actions</th>";
    $liste_personnel .= "</tr>";
    $liste_personnel .= "</thead>";
    $liste_personnel .= "<tbody>";
    while ($ligne = mysqli_fetch_assoc($resultat_personnel)) {
        $liste_personnel .= "<tr>";
        $liste_personnel .= "<td><h6>{$ligne['nom']}</h6></td>";
        $liste_personnel .= "<td>
                                <a href='supprimer_personnel.php?id={$ligne['id_utilisateur']}' method='POST'>
                                    <button type='submit' class='btn btn-danger'>
                                        <i class='fas fa-trash'></i> Supprimer
                                    </button>
                            </td>";
        $liste_personnel .= "</tr>";
    }
    $liste_personnel .= "</tbody>";
    $liste_personnel .= "</table>";
} else {
    $liste_personnel = "<p>Aucun personnel trouvé.</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Administrateur</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        footer {
            background-color: #f8f9fa;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 12;
            font-size: 14px; 
        }
        .container {
            margin-top: 50px;
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
                <a class="nav-link" href="espace_admin.php">Espace Administrateur</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="demandes.php">Demandes de Congé</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="deconnexion.php">Déconnexion</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <h2 class="text-center">Espace Administrateur</h2>
    
    <h3>Liste du personnel</h3>
    <?php echo $liste_personnel; ?>
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