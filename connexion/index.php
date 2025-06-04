<?php
// Page de connexion - /connexion

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . "/includes/sql_request.php";

session_start();

// Si l'on est déjà connecté
if (isset($_SESSION["adh"])) {
    // Redirection
    header('Location: ' . (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/adherent");
    exit();
}


$message = $_GET["message"] ?? "";

// Si le formulaire a été transmis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['numadh']) && isset($_POST['pass'])) {
    $numadh = $_POST['numadh'];
    $pass = $_POST['pass'];

    // Numéro adhérent vide
    if (empty($numadh)) {
        $message = "Veuillez saisir un numéro adhérent.";
    }

    // Mot de passe vide
    elseif (empty($pass)) {
        $message = "Veuillez saisir un mot de passe.";
    }

    // Données valides, vérification des identifiants
    else {
        // Requête sur la BDD
        $responses = SqlRequest::new(<<< EOF
SELECT
    *
FROM
    tco_adh
WHERE
    numadh = ?
EOF
        )->execute([$numadh]);

        // Numéro adhérent invalide
        if (empty($responses)) {
            $message = "Le numéro d'adhérent " . $numadh . " n'existe pas.";
        }

        // Numéro adhérent valide
        else {
            $hashpass = $responses[0]->hashpass;
            $hashsalt = $responses[0]->hashsalt;

            // Identifiants incorrects
            if (!password_verify($pass . $hashsalt, $hashpass)) {
                $message = "Mot de passe incorrect.";
            }

            else {
                // Connecté !

                // Création de la session
                session_unset();
                session_destroy();
                session_start(['cookie_lifetime' => 43200 /* 12h */]);
                $_SESSION["adh"] = $responses[0];

                // Redirection
                header('Location: ' . (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/adherent");
                exit();
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include($root . "/includes/metadata.php"); ?>
    <?php include($root . "/includes/header_js.php"); ?>
    <title>Connexion | TCO</title>
</head>
<body>
<?php include($root . "/includes/header.php"); ?>
<main>
    <h1>Connexion</h1>
    <form method="post" action="">
        <?php if (!empty($message)): ?>
        <p class="message">
            <?= $message ?>
        </p>
        <?php endif; ?>
        <div class="field">
            <label for="numadh">Numéro d'adhérent</label>
            <input id="numadh" type="text" name="numadh" placeholder="">
        </div>
        <div class="field">
            <label for="pass">Mot de passe</label>
            <input id="pass" type="password" name="pass" placeholder="">
        </div>
        <p class="hint"><a href="/activation">Activer mon compte ou mot de passe oublié</a></p>
        <div class="field">
            <input type="submit" value="Connexion">
        </div>
    </form>
</main>
<?php include($root . "/includes/footer.php"); ?>
</body>
</html>
