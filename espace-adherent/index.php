<?php
// Page d'espace adhérent - /espace-adherent

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . "/includes/sql_request.php";

session_start();

// Si l'on n'est pas connecté
if (!isset($_SESSION["adh"])) {
    // Redirection
    $message = "Vous n'êtes pas connecté ou votre session a expiré.";
    header('Location: ' . htmlspecialchars((isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/connexion?message=" . $message));
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include($root . "/includes/metadata.php"); ?>
    <?php include($root . "/includes/header_js.php"); ?>
    <title>Espace adhérent | TCO</title>
</head>
<body>
<?php include($root . "/includes/header.php"); ?>
<main>
    <h1>Espace adhérent</h1>
    <p>Bonjour <?= $_SESSION["adh"]->prenom ?> !</p>
</main>
<?php include($root . "/includes/footer.php"); ?>
</body>
</html>
