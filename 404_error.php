<?php
// Page d'erreur 404

http_response_code(404);
$root = $_SERVER['DOCUMENT_ROOT']


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include($root . "/includes/metadata.php"); ?>
    <?php include($root . "/includes/header_js.php"); ?>
    <title>Erreur 404 | TCO</title>
</head>
<body>
<?php include($root . "/includes/header.php"); ?>
<main>
    <h1>Erreur 404</h1>
    <p>
        La page ou le document n'existe pas.
    </p>
</main>
<?php include($root . "/includes/footer.php"); ?>
</body>
</html>
