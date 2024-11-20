<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: connexion.php");
    exit();
}

// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "utilisateur");

// Récupérer l'email de l'utilisateur connecté
$email = $_SESSION['email'];

// Récupérer les informations personnelles de l'utilisateur depuis la base de données
$requete = "SELECT * FROM utilisateurs WHERE email='$email'";
$resultat = mysqli_query($connexion, $requete);
$ligne = mysqli_fetch_assoc($resultat);

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Mettre à jour les informations personnelles de l'utilisateur dans la base de données
    $requete_update = "UPDATE utilisateurs SET nom='$nom', email='$email', mot_de_passe='$mot_de_passe' WHERE email='$email'";
    mysqli_query($connexion, $requete_update);

    // Rediriger vers espace_personnel.php après la mise à jour
    header("Location: espace_personnel.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Profil</title>
</head>
<body>
    <h2>Modifier Profil</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" class="form-control" name="nom" value="<?php echo $ligne['nom']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" class="form-control" name="email" value="<?php echo $ligne['email']; ?>" required>
        </div>
        <div class="form-group">
            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" class="form-control" name="mot_de_passe" value="<?php echo $ligne['mot_de_passe']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Enregistrer les modifications</button>
    </form>
</body>
</html>
