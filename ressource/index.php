<?php
// Page d'affichage d'une ressource - /ressource

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . "/includes/sql_request.php";

session_start();

// S'il n'y a pas d'ID de ressource, on renvoie vers l'accueil.
if (!isset($_GET["id"])) {
    header('Location: ' . htmlspecialchars((isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"]));
    exit();
}

// Récupération de la ressource depuis la BDD
$id = $_GET["id"];
$responses = SqlRequest::new(<<< EOF
SELECT
    *
FROM
    tco_ressource
WHERE
    id = ?
EOF
)->execute([$id]);

// Si aucune ressource ne correspond
if (empty($responses)) {
    include $_SERVER['DOCUMENT_ROOT'] . '/404_error.php';
}

else {
    $ressource = $responses[0];

    // Si la ressource est publique ou bien elle ne l'est pas mais on est bien connecté
    if ($ressource->public || isset($_SESSION["adh"])) {
        // On enregistre cette consultation
        SqlRequest::new(<<< EOF
UPDATE
    tco_ressource
SET
    consultations = consultations + 1
WHERE
    id = ?
EOF
        )->execute([$id]);

        // Affichage du PDF
        header("Content-type:application/pdf");
        header("'Content-disposition: inline; filename=\"$ressource->file_base_name.pdf\"");
        header("content-Transfer-Encoding:binary");
        header("Accept-Ranges:bytes");
        readfile($_SERVER['DOCUMENT_ROOT'] . "/ressource/$ressource->file_base_name.pdf");
        exit();
    }

    // Sinon, on demande à se connecter
    else {
        $message = "La ressource n'est accessible que pour les adhérents. Veuillez vous connecter.";
        header('Location: ' . htmlspecialchars((isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/connexion?message=$message"));
        exit();
    }
}
