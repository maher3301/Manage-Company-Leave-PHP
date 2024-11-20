<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'administrateur') {
    header("Location: espace_personnel.php");
    exit();
}

// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "utilisateur");

// Vérifier la connexion
if (!$connexion) {
    die("Erreur de connexion à la base de données: " . mysqli_connect_error());
}

// Vérifier si une demande est traitée
if (isset($_GET['id_demande']) && isset($_GET['statut'])) {
    // Récupérer l'ID de la demande et le statut de l'URL
    $id_demande = $_GET['id_demande'];
    $statut = $_GET['statut'];

    // Mettre à jour le statut de la demande dans la base de données
    $requete_update = "UPDATE demandes_conge SET statut='$statut' WHERE id_demande=$id_demande";
    if (mysqli_query($connexion, $requete_update)) {
        echo "Le statut de la demande a été mis à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour du statut de la demande: " . mysqli_error($connexion);
    }
}

// Récupérer toutes les demandes de congé de la table demandes_conge
$requete_demandes = "SELECT * FROM demandes_conge";
$resultat_demandes = mysqli_query($connexion, $requete_demandes);

// Vérifier si des demandes sont trouvées
if ($resultat_demandes && mysqli_num_rows($resultat_demandes) > 0) {
    // Afficher les demandes de congé avec des options pour approuver ou rejeter
    $demandes_html = "<h2>Liste des demandes de congé</h2><table class='table'>";
    $demandes_html .= "<thead class='thead-light'>";
    $demandes_html .= "<tr>";
    $demandes_html .= "<th>ID Demande</th>";
    $demandes_html .= "<th>Date Début</th>";
    $demandes_html .= "<th>Date Fin</th>";
    $demandes_html .= "<th>Motif</th>";
    $demandes_html .= "<th>Statut</th>";
    $demandes_html .= "<th>Actions</th>";
    $demandes_html .= "</tr>";
    $demandes_html .= "</thead>";
    $demandes_html .= "<tbody>";
    while ($demande = mysqli_fetch_assoc($resultat_demandes)) {
        $demandes_html .= "<tr>";
        $demandes_html .= "<td>{$demande['id_demande']}</td>";
        $demandes_html .= "<td>{$demande['date_debut']}</td>";
        $demandes_html .= "<td>{$demande['date_fin']}</td>";
        $demandes_html .= "<td>{$demande['motif']}</td>";
        $demandes_html .= "<td>{$demande['statut']}</td>";
        $demandes_html .= "<td>";
        // Options pour approuver ou rejeter la demande
        $demandes_html .= "<a href='demandes.php?id_demande={$demande['id_demande']}&statut=approuver'>Approuver</a> | ";
        $demandes_html .= "<a href='demandes.php?id_demande={$demande['id_demande']}&statut=rejeter'>Rejeter</a>";
        $demandes_html .= "</td>";
        $demandes_html .= "</tr>";
    }
    $demandes_html .= "</tbody>";
    $demandes_html .= "</table>";
} else {
    $demandes_html = "<p>Aucune demande de congé trouvée.</p>";
}

// Fermer la connexion
mysqli_close($connexion);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demandes de Congé</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        /* Styles pour le footer */
        footer {
            background-color: #f8f9fa;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 15;
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
    <?php echo $demandes_html; ?>
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
