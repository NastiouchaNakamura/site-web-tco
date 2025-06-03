<?php
// Page d'accueil - /

$root = $_SERVER['DOCUMENT_ROOT'];

session_start();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include($root . "/includes/metadata.php"); ?>
    <?php include($root . "/includes/header_js.php"); ?>
    <title>Accueil | TCO</title>
</head>
<body>
<?php include($root . "/includes/header.php"); ?>
<main>
    <h1>Accueil</h1>
    <p>
        Blablabla
    </p>
</main>
<?php include($root . "/includes/footer.php"); ?>
</body>
</html>
