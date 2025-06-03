<header>
    <img src="/logo.png" alt="TCO">
    <h1 class="short-title"><a href="/">T.C.O.</a></h1>
    <h1 class="long-title"><a href="/">Tutorat des Carabins d'Orléans</a></h1>
    <div class="space"></div>
    <div class="burger" onclick="toggle_nav();">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <div id="curtain" onclick="quit_nav();"></div>
    <nav id="navigation">
        <h1>Tutorat des Carabins d'Orléans</h1>
        <?php if(isset($_SESSION["adh"])): ?>
        <div class="user">
            <p><?= $_SESSION["adh"]->prenom ?> <?= $_SESSION["adh"]->nom ?></p>
            <a class="red" href="/deconnexion"><img src="/icons/key.svg" class="white" alt="[key]">Déconnexion</a>
        </div>
        <?php else: ?>
        <div class="user">
            <a class="green" href="/connexion"><img src="/icons/key.svg" class="white" alt="[key]">Connexion</a>
        </div>
        <?php endif ?>
        <a href="/">Accueil</a>
        <a href="/">Informations</a>
        <a href="/espace-adherent"><?php if(isset($_SESSION["adh"])): ?><img src="/icons/unlock.svg" class="green" alt="[unlock]"><?php else: ?><img src="/icons/lock.svg" class="red" alt="[lock]"><?php endif ?>Tableau de bord</a>
        <a href="/espace-referent"><?php if(isset($_SESSION["adh"])): ?><img src="/icons/unlock.svg" class="green" alt="[unlock]"><?php else: ?><img src="/icons/lock.svg" class="red" alt="[lock]"><?php endif ?>Espace référent</a>
    </nav>
</header>
