<?php
// Code pour gérer l'authentification d'un utilisateur

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Connexion à la base de données
    $connexion = mysqli_connect("localhost", "root", "", "utilisateur");

    // Préparer et exécuter la requête de vérification des identifiants
    $requete = "SELECT * FROM utilisateurs WHERE email='$email' AND mot_de_passe='$mot_de_passe'";
    
    $resultat = mysqli_query($connexion, $requete);

    // Vérifier si l'utilisateur existe
    if (mysqli_num_rows($resultat) == 1) {
        // Récupérer le rôle de l'utilisateur
        $ligne = mysqli_fetch_assoc($resultat);
        $role = $ligne['role'];

        // Ajouter cette ligne pour stocker le rôle de l'utilisateur dans la session
        $_SESSION['role'] = $role;

        // Redirection en fonction du rôle de l'utilisateur
        if ($role == 'administrateur') {
            // Rediriger vers l'espace administrateur
            $_SESSION['email'] = $email;
            header("Location: espace_admin.php");
            exit();
        } elseif ($role == 'personnel') {
            // Rediriger vers l'espace personnel
            $_SESSION['email'] = $email;
            header("Location: espace_personnel.php");
            exit();
        }
    } else {
        // Identifiants incorrects, afficher un message d'erreur
        $erreur = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"  />

    <style>
        .container {
    margin-top: 50px;
    margin-bottom: 100px; 
}

footer {
    background-color: #f8f9fa;
    padding: 5px 0;
    text-align: center;
    width: 100%;
    bottom: 10px;
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
    <h2 class="text-center">Connexion</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" class="form-control" name="mot_de_passe" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
    </form>
    <?php if(isset($erreur)) echo "<p class='text-danger'>$erreur</p>"; ?>
</div>
<hr>
<div class="container message-container">
<h2 class="text-center">Informations nécessaires</h2>
    <hr>
    <br>Pour vous connecter à votre espace personnel, veuillez remplir les champs requis avec votre email et votre mot de passe associé à votre compte.</br>
     Assurez-vous de saisir votre email correctement dans le champ "Email", en veillant à inclure le domaine approprié (votreadresse@example.com). </br>
     Dans le champ "Mot de passe", saisissez le mot de passe que vous avez créé lors de l'inscription, en respectant la casse des lettres. </br>Assurez-vous que votre mot de passe est confidentiel et ne le partagez pas avec d'autres personnes. </br>
     Une fois que vous avez entré vos informations correctement, cliquez sur le bouton "Se connecter" pour accéder à votre espace personnel.
     <div class="alert alert-info mt-4" role="alert">
        <i class="fas fa-info-circle"></i>  Si vous rencontrez des difficultés pour vous connecter, veuillez vérifier à nouveau vos informations ou contactez le support technique pour obtenir de l'aide.
        </br><i class="fas fa-envelope"></i>  E-mail : maheer3301@gmail.com </p>
    </div> </div>
    </p>
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
