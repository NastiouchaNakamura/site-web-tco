<?php
// Page de déconnexion - /deconnexion

$root = $_SERVER['DOCUMENT_ROOT'];

session_start();

// Si l'on est connecté
if (isset($_SESSION["adh"])) {
    session_unset();
    session_destroy();
}


// Redirection
header('Location: ' . (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/connexion");
exit();
