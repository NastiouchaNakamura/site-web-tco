<?php
// Page de gestion des membres - /membres

$root = $_SERVER['DOCUMENT_ROOT'];

session_start();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include($root . "/includes/metadata.php"); ?>
    <?php include($root . "/includes/header_js.php"); ?>
    <title>Membres | TCO</title>
    <script type="text/javascript">
        let nextPromiseId = 0;
        let promisesStatus = new Map();

        function updateStatus() {
            const status_bar = document.getElementById("status_bar");
            console.log(promisesStatus);
            if (promisesStatus.values().every(v => v === "success")) {
                status_bar.className = "synchronized";
                status_bar.children[0].children[1].innerText = "Tout est synchronisé.";
            } else if (promisesStatus.values().some(v => v === "failure")) {
                status_bar.className = "error";
                status_bar.children[0].children[1].innerText = "Une erreur s'est produite.";
                alert("Une erreur s'est produite lors de la communication avec le serveur.");
            } else {
                status_bar.className = "sending";
                status_bar.children[0].children[1].innerText = "Envoi en cours…";
            }
        }

        function changed(id) {
            let prenom = document.getElementById("member_" + id + "_prenom");
            let nom = document.getElementById("member_" + id + "_nom");
            let email = document.getElementById("member_" + id + "_email");
            let referent = document.getElementById("member_" + id + "_referent");
            let bureau = document.getElementById("member_" + id + "_bureau");
            let date = document.getElementById("member_" + id + "_date");
            let timestamp = 0;

            let promiseId = nextPromiseId++;
            promisesStatus.set(promiseId, "pending");
            updateStatus();

            new Promise((resolve, reject) => {
                setTimeout(() => {
                    if (Math.random() >= 0.5) {
                        resolve();
                    } else {
                        reject();
                    }
                }, Math.random() * 1000);
            }).then(() => {
                promisesStatus.set(promiseId, "success");
            }).catch(() => {
                promisesStatus.set(promiseId, "failure");
            }).finally(() => {
                updateStatus();
            })
        }

        function populate(n) {
            let element = document.getElementById("tbody").children[0];
            for (let i = 0; i < n; i++) {
                element.parentElement.appendChild(element.cloneNode(true));
            }
        }

        window.addEventListener("load", () => populate(50));
    </script>
</head>
<body>
<?php include($root . "/includes/header.php"); ?>
<main class="table-main">
    <div class="table-container">
        <table id="table">
            <thead id="thead">
            <tr>
                <th id="status_bar" class="synchronized" colspan="100%">
                    <div>
                        <img class="icon white spinner" alt="icon">
                        <p>Tout est synchronisé</p>
                    </div>
                </th>
            </tr>
            <tr>
                <th>NumAdh</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>e-mail</th>
                <th>Référent</th>
                <th>Bureau</th>
                <th>Date de création</th>
            </tr>
            </thead>
            <tbody id="tbody">
            <tr id="member_1">
                <td id="member_1_id">1</td>
                <td id="member_1_prenom"><input type="text" value="Anaël" name="prenom" onchange="changed(1)"></td>
                <td id="member_1_nom"><input type="text" value="BARODINE" name="nom" onchange="changed(1)"></td>
                <td id="member_1_email"><input type="text" value="anael@barodine.fr" name="email" onchange="changed(1)"></td>
                <td id="member_1_referent"><input type="checkbox" checked name="referent" onchange="changed(1)"></td>
                <td id="member_1_bureau"><input type="checkbox" checked name="bureau" onchange="changed(1)"></td>
                <td id="member_1_date">4 avril 2025</td>
            </tr>
            </tbody>
        </table>
    </div>
</main>
<?php include($root . "/includes/footer.php"); ?>
</body>
</html>
