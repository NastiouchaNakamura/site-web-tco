<?php
// Page d'affichage d'une ressource - /ressource

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . "/includes/sql_request.php";

session_start();

// S'il n'y a pas d'ID de ressource, on renvoie vers l'accueil.
if (!isset($_GET["id"])) {
    header('Location: ' . (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"]);
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

// La ressource existe et on suppose que le fichier aussi
else {
    $ressource = $responses[0];

    // Génération du hash de la ressource pour vérifier que la miniature est à jour
    $hash = hash_file("xxh3", $_SERVER["DOCUMENT_ROOT"] . "/ressource/files/$ressource->id.pdf");

    // Si la miniature n'existe pas, on la crée
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/ressource/files/$ressource->id.$hash.jpg")) {
        // Suppression de l'ancienne miniature
        foreach (scandir($_SERVER['DOCUMENT_ROOT'] . "/ressource/files/") as $file) {
            if (preg_match("/$ressource->id\..{16}\.jpg/", $file)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . "/ressource/files/$file");
            }
        }

        // Génération de la miniature
        // https://ghostscript.com/docs/9.54.0/Use.htm
        exec("gs -sDEVICE=jpeg -g720x1024 -r86x86 -dNOPAUSE -dBATCH -sPageList=1 -sOutputFile=./files/$ressource->id.$hash.jpg  ./files/$ressource->id.pdf 2>&1");
    }

    // Affichage du JPG
    header("Content-type:image/jpeg");
    header("Content-Length: " . filesize($_SERVER['DOCUMENT_ROOT'] . "/ressource/files/$ressource->id.$hash.jpg"));
    readfile($_SERVER['DOCUMENT_ROOT'] . "/ressource/files/$ressource->id.$hash.jpg");
    exit();
}
