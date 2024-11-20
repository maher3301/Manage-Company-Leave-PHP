<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: connexion.php");
    exit();
}

// Assurez-vous d'avoir une connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "utilisateur");

if (!$connexion) {
    die("Erreur de connexion à la base de données: " . mysqli_connect_error());
}

// Récupérer l'email de l'utilisateur connecté
$email = $_SESSION['email'];

// Récupérer les informations personnelles de l'utilisateur depuis la base de données
$requete = "SELECT * FROM utilisateurs WHERE email='$email'";
$resultat = mysqli_query($connexion, $requete);
$ligne = mysqli_fetch_assoc($resultat);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mettre à jour les informations personnelles de l'utilisateur dans la base de données
    $nouveau_nom = $_POST['nom'];

    $requete_maj = "UPDATE utilisateurs SET nom='$nouveau_nom' WHERE email='$email'";
    $resultat_maj = mysqli_query($connexion, $requete_maj);

    if ($resultat_maj) {
        header("Location: espace_personnel.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour du profil.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
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
    </style>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">HAFNAOUI Arij</a>
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
<body>
    <hr>
    <div class="container">
        <h2 class="text-center">Profil utilisateur</h2>
        <form method="post" action="modifier_profil.php">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" class="form-control" name="nom" value="<?php echo $ligne['nom']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" name="email" value="<?php echo $ligne['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Mot de Passe :</label>
                <input type="" class="form-control" name="mot_de_passe" value="<?php echo $ligne['mot_de_passe']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Modifier le profil</button>
        </form>
    </div>
    <footer>
        <div class="container">
            <p>&copy; 2024 Hafnaoui Arij - Tous droits réservés</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
