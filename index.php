<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include("includes/metadata.php"); ?>
    <title>Accueil | TCO</title>
    <script>
        function toggle_nav() {
            let nav = document.getElementById('navigation');
            let curtain = document.getElementById('curtain');
            if (nav.classList.contains('active')) {
                nav.classList.remove('active');
                curtain.classList.remove('active');
            }
            else {
                nav.classList.add('active');
                curtain.classList.add('active');
            }
        }

        function quit_nav() {
            let nav = document.getElementById('navigation');
            let curtain = document.getElementById('curtain');
            nav.classList.remove('active');
            curtain.classList.remove('active');
        }
    </script>
</head>
<body>
<?php include("includes/header.php"); ?>
<main>
    <h1>Accueil</h1>
</main>
<?php include("includes/footer.php"); ?>
</body>
</html>
