<?php
// Page d'activation ou de changement de mdp - /activation

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . "/includes/sql_request.php";

session_start();

$message = $_GET["message"] ?? "";

// Si le formulaire a été transmis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['numadh']) && isset($_POST['email'])) {
    $numadh = $_POST['numadh'];
    $email = $_POST['email'];

    // Numéro adhérent vide
    if (empty($numadh)) {
        $message = "Veuillez saisir un numéro d'adhérent.";
    }

    // E-mail vide
    elseif (empty($email)) {
        $message = "Veuillez saisir une adresse e-mail.";
    }

    // Données valides, vérification
    else {
        // Requête sur la BDD
        $responses = SqlRequest::new(<<< EOF
SELECT
    numadh,
    prenom,
    nom,
    email
FROM
    tco_adh
WHERE
    numadh = ?
EOF
        )->execute([$numadh]);

        // Numéro adhérent invalide
        if (empty($responses)) {
            $message = "Le numéro d'adhérent $numadh n'existe pas.";
        }

        // E-mail incorrect
        elseif ($email != $responses[0]->email) {
            $message = "L'adresse e-mail $email n'est pas l'adresse renseignée pour le numéro d'adhérent $numadh.";
        }

        // E-mail correct
        else {
            $nom = $responses[0]->nom;
            $prenom = $responses[0]->prenom;

            $code = "test";

            // Préparation de l'e-mail
            $from = "nepasrepondre@" . $_SERVER["HTTP_HOST"];
            $lien = htmlspecialchars((isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/initialisation?code=$code" . $code);

            $message_email = <<< EOF
Bonjour $nom $prenom,

Suite à ta demande sur le site du Tutorat des Carabins d'Orléans, voici ci-dessous un lien d'initialisation ou de réinitialisation de mot de passe. Ce dernier n'est valide que pendant 1h.

<a href="$lien">$lien</a>

Si tu n'as pas été à l'origine de cette demande, alors tu n'as rien à faire : le lien n'est accessible que depuis l'e-mail que tu as sous les yeux.

Bien à toi,

Le Tutorat des Carabins d'Orléans.
EOF;
            $headers = "From: $from\r\nMIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nX-Mailer: PHP/" . phpversion();

            // Envoi de l'e-mail
            mail($email, "TCO (ré)-initialisation de mot de passe", $message_email, $headers);

            $message = "Le lien vous a bien été envoyé par e-mail. Il peut prendre quelques minutes à arriver et peut tomber dans votre boîte de spams.";
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
    <h1>Envoi d'un lien</h1>
    <form method="post" action="">
        <?php if (!empty($message)): ?>
        <p class="message">
            <?= $message ?>
        </p>
        <?php endif; ?>
        <p>
            Ce formulaire vous enverra par e-mail un lien de (ré)-initialisation de mot de passe.
        </p>
        <p>
            Pour des raisons de sécurité, ce lien ne sera valide que 1h après l'envoi de l'e-mail.
        </p>
        <div class="field">
            <label for="numadh">Numéro d'adhérent</label>
            <input id="numadh" type="text" name="numadh" placeholder="">
        </div>
        <div class="field">
            <label for="email">Adresse e-mail</label>
            <input id="email" type="text" name="email" placeholder="">
        </div>
        <div class="field">
            <input type="submit" value="Envoyer">
        </div>
    </form>
</main>
<?php include($root . "/includes/footer.php"); ?>
</body>
</html>
