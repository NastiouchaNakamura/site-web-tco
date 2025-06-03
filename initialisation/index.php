<?php
// Page de (ré)initialisation de mdp - /initialisation

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . "/includes/sql_request.php";

session_start();

// Si aucun code n'est fourni.
if (!isset($_GET["code"])) {
    // Code d'activation inexistant
    header('Location: ' . htmlspecialchars((isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/activation"));
    exit();
}

// Vérification du code d'activation
$code = $_GET['code'];

$responses = SqlRequest::new(<<< EOF
SELECT
    code,
    numadh,
    validite
FROM
    tco_init_code
WHERE
    code = ?;
EOF
)->execute([$code]);

// Code d'activation invalide
if (empty($responses)) {
    $message = "Le lien utilisé est invalide.";
    header('Location: ' . htmlspecialchars((isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/activation?message=" . $message));
    exit();
}

$numadh = $responses[0]->numadh;
$validite = $responses[0]->validite;

// Code d'activation périmé
if ($validite < date("Y-m-d h:i:s")) {
    $message = "Le lien utilisé a expiré.";
    header('Location: ' . htmlspecialchars((isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/activation?message=" . $message));
    exit();
}

// Code d'activation valide, suite du programme

$message = $_GET["message"] ?? "";

// Si le formulaire a été transmis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['numadh']) && isset($_POST['pass']) && isset($_POST['pass_bis'])) {
    $pass = $_POST['pass'];
    $pass_bis = $_POST['pass_bis'];

    // Mot de passe vide
    if (empty($pass)) {
        $message = "Veuillez saisir un mot de passe.";
    }

    // Répétition de mot de passe vide
    elseif (empty($pass_bis)) {
        $message = "Veuillez répéter le mot de passe.";
    }

    // Si le mot de passe ne contient pas les caractères nécessaires.
    elseif (strlen($pass) < 8 || !preg_match("/\d/", $pass) || !preg_match("/[A-Z]/", $pass) || !preg_match("/[^\da-zA-Z]/", $pass)) {
        $message = "Le mot de passe doit contenir au moins un caractère spécial, un chiffre et une majuscule et doit faire plus de 8 caractères";
    }

    // Si le mot de passe et la répétition de mot de passe ne correspondent pas
    elseif ($pass != $pass_bis) {
        $message = "Le mot de passe répété ne correspond pas au mot de passe choisi.";
    }

    // Tout est correct !
    else {
        // Génération du hashsalt
        $hashsalt = bin2hex(random_bytes(8));

        // Génération du hashpass
        $hashpass = password_hash($pass . $hashsalt, PASSWORD_DEFAULT);

        // Enregistrement
        SqlRequest::new(<<< EOF
UPDATE
    tco_adh
SET
    hashpass = ?,
    hashsalt = ?
WHERE
    numadh = ?;
EOF
        )->execute([$hashpass, $hashsalt, $numadh]);

        // Redirection
        $message = "Mot de passe enregistré avec succès ! Veuillez maintenant vous connecter.";
        header('Location: ' . htmlspecialchars((isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/connexion?message=" . $message));
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include($root . "/includes/metadata.php"); ?>
    <?php include($root . "/includes/header_js.php"); ?>
    <title>Initialisation de mot de passe | TCO</title>
</head>
<body>
<?php include($root . "/includes/header.php"); ?>
<main>
    <h1>Initialisation de mot de passe</h1>
    <form method="post" action="/initialisation?code=<?= $code ?>">
        <?php if (!empty($message)): ?>
        <p class="message">
            <?= $message ?>
        </p>
        <?php endif; ?>
        <div class="field">
            <label for="numadh">Numéro d'adhérent</label>
            <input id="numadh" type="text" name="numadh" placeholder="" value="<?= $numadh ?>" readonly>
        </div>
        <div class="field">
            <label for="pass">Nouveau mot de passe</label>
            <input id="pass" type="password" name="pass" placeholder="">
        </div>
        <div class="field">
            <label for="pass_bis">Répéter le mot de passe</label>
            <input id="pass_bis" type="password" name="pass_bis" placeholder="">
        </div>
        <div class="field">
            <input type="submit" value="Envoyer">
        </div>
    </form>
</main>
<?php include($root . "/includes/footer.php"); ?>
</body>
</html>
