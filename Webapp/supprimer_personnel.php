<?php
session_start();

// Vérifier si l'administrateur est connecté
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'administrateur') {
    header("Location: connexion.php");
    exit();
}

// Vérifier si l'ID de l'utilisateur à supprimer est passé en paramètre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Rediriger avec un message d'erreur si l'ID n'est pas spécifié
    header("Location: espace_admin.php?error=missing_id");
    exit();
}

// Récupérer l'ID de l'utilisateur à supprimer
$id_utilisateur = $_GET['id'];

// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "utilisateur");

// Vérifier la connexion
if (!$connexion) {
    die("Erreur de connexion à la base de données: " . mysqli_connect_error());
}

// Préparer et exécuter la requête de suppression
$requete_suppression = "DELETE FROM utilisateurs WHERE id_utilisateur = $id_utilisateur";

if (mysqli_query($connexion, $requete_suppression)) {
    // Rediriger avec un message de succès si la suppression réussit
    header("Location: espace_admin.php?success=user_deleted");
    exit();
} else {
    // Rediriger avec un message d'erreur si la suppression échoue
    header("Location: espace_admin.php?error=delete_failed");
    exit();
}
?>
