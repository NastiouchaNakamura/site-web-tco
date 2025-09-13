<?php
// Page d'affichage des QCM - /qcm

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . "/includes/sql_request.php";

session_start();

// Si l'utilisateur n'est pas connecté
if (!isset($_SESSION["adh"]) || $_SESSION["adh"]->bureau != 1) {
    $message = urlencode("Veuillez vous connecter.");
    header('Location: ' . (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/connexion?message=$message");
    exit();
}

else {
    $message = urlencode("La page est actuellement inaccessible.");
    header('Location: ' . (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/connexion?message=$message");
    exit();
}
