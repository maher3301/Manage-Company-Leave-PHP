<?php
// Code pour gérer l'inscription d'un nouvel utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $role = $_POST['role']; // Récupérer le rôle sélectionné

    // Connexion à la base de données
    $connexion = mysqli_connect("localhost", "root", "", "utilisateur");

    // Préparer et exécuter la requête d'insertion
    $requete = "INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES ('$nom', '$email', '$mot_de_passe', '$role')";
    mysqli_query($connexion, $requete);
// Après l'insertion dans la table utilisateurs
// Initialiser le solde de congé à 30 jours
$requete_solde = "UPDATE utilisateurs SET solde_conges = 30 WHERE email = '$email'";
mysqli_query($connexion, $requete_solde);

    // Rediriger l'utilisateur vers une page de succès ou de connexion
    header("Location: connexion.php");
    exit();
}
?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"  />
    <style>
        footer {
    background-color: #f8f9fa;
    padding: 5px 0;
    text-align: center;
    width: 100%;
    bottom: 15px;
}
    
        .container {
            margin-top: 50px;
        }
        form {
            max-width: 400px;
            margin: auto;
        }
        .message-container {
            border: 1px solid paleturquoise;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Maher</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="inscription.php" id="inscription">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="connexion.php" id="connexion">Connexion</a>
            </li>
        </ul>
    </div>
</nav>
<hr>
    <div class="container">
        <h2 class="text-center">Inscription</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" class="form-control" name="nom" required>
            </div>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" class="form-control" name="mot_de_passe" required>
            </div>
            <div class="form-group">
                <label for="role">Rôle :</label>
                <select class="form-control" name="role">
                    <option value="personnel">Personnel</option>
                    <option value="administrateur">Administrateur</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
        </form>
    </div>
    <hr>
    <div class="container message-container">
        <h2 class="text-center">Informations nécessaires</h2>
        <hr>
        <p>Pour vous inscrire, veuillez remplir tous les champs requis : nom, email, mot de passe et rôle.
        Assurez-vous de saisir votre email correctement dans le champ "Email", en veillant à inclure le domaine approprié (votreadresse@example.com). 
    </br>Dans le champ "Mot de passe", saisissez un mot de passe sécurisé que vous pourrez facilement mémoriser. Assurez-vous que votre mot de passe est confidentiel et ne le partagez pas avec d'autres personnes. 
        Sélectionnez ensuite le rôle approprié dans le menu déroulant "Rôle", soit "Administrateur" ou "Personnel". 
        Une fois que vous avez rempli tous les champs, cliquez sur le bouton "S'inscrire" pour terminer le processus d'inscription.</p>
        <div class="alert alert-info mt-4" role="alert">
            <i class="fas fa-info-circle"></i>  Si vous rencontrez des difficultés pour vous inscrire, veuillez contacter le support technique pour obtenir de l'aide.
            </br><i class="fas fa-envelope"></i>  E-mail : Maheer3301@gmail.com </p>
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
