<?php
session_start();

// Détruire toutes les données de session
session_unset();
session_destroy();

// Redirection vers la page de connexion
header("Location: connexion.php");
exit();
?>
