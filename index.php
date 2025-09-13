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
    <div class="image-background" style="background-image:url('files/stethoscope.jpg');">
        <h1>Le Tutorat des Carabins d'Orléans</h1>
        <p>
            Le TCO est une association étudiante qui accompagne les étudiants en médecine, de la 2ème année jusqu’à
            l'internat, durant leurs enseignements et leurs stages.
        </p>
    </div>
    <div class="image-legend">
        <img src="files/bureau-25-26.JPG" alt="Photo du Bureau">
        <p>Le bureau du TCO pour l'année 2025-2026.</p>
    </div>
    <h1>Nous contacter</h1>
    <div class="cards-container">
        <div class="card">
            <h2><img class="icon black mail" alt="icon">E-Mail</h2>
            <p><a href="mailto:tutocorleans@gmail.com">tutocorleans@gmail.com</a></p>
        </div>
        <!--<div class="card">
            <h2><img class="icon black location" alt="icon">Local</h2>
            <p>Salle ???</p>
        </div>-->
        <div class="card">
            <h2><img class="icon black sphere" alt="icon">Réseaux sociaux</h2>
            <p><i>Instagram</i> : <a href="https://www.instagram.com/tco.rleans/">@tco.rleans</a></p>
        </div>
    </div>
</main>
<?php include($root . "/includes/footer.php"); ?>
</body>
</html>
