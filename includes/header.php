<header>
    <a href="/"><img src="/logo.png" alt="TCO"></a>
    <h1 class="short-title"><a href="/">T.C.O.</a></h1>
    <h1 class="long-title"><a href="/">Tutorat des Carabins d'Orléans</a></h1>
    <div class="space"></div>
    <div class="burger" onclick="toggle_nav();">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <?php if(isset($_SESSION["adh"])): ?>
    <div class="long-user">
        <a class="avatar" href="/adherent"><img src="/icons/user.svg" class="white" alt="[user]"></a>
        <div class="long-user-menu">
            <p><?= $_SESSION["adh"]->prenom ?> <?= $_SESSION["adh"]->nom ?></p>
            <a href="/deconnexion"><img src="/icons/key.svg" class="white" alt="[key]"><p>Déconnexion</p></a>
        </div>
    </div>
    <?php else: ?>
    <a class="long-connect" href="/connexion"><img src="/icons/key.svg" class="white" alt="[key]"><p>Connexion</p></a>
    <?php endif; ?>
    <div id="curtain" onclick="quit_nav();"></div>
    <nav class="small-nav" id="navigation">
        <h1>Tutorat des Carabins d'Orléans</h1>
        <?php if(isset($_SESSION["adh"])): ?>
            <div class="user">
                <p><?= $_SESSION["adh"]->prenom ?> <?= $_SESSION["adh"]->nom ?></p>
                <a class="red" href="/deconnexion"><img src="/icons/key.svg" class="white" alt="[key]">Déconnexion</a>
            </div>
            <a href="/">Accueil</a>
            <a href="/">Informations</a>
            <a href="/adherent"><img src="/icons/unlock.svg" class="green" alt="[unlock]">Espace adhérent</a>
            <?php if($_SESSION["adh"]->referent): ?><a href="/referent"><img src="/icons/unlock.svg" class="green" alt="[unlock]">Espace référent</a><?php endif ?>
            <?php if($_SESSION["adh"]->bureau): ?><a href="/bureau"><img src="/icons/unlock.svg" class="green" alt="[unlock]">Espace bureau</a><?php endif ?>
            <?php if($_SESSION["adh"]->superadmin): ?><a href="/superadmin"><img src="/icons/unlock.svg" class="green" alt="[unlock]">Espace super-admin</a><?php endif ?>
        <?php else: ?>
            <div class="user">
                <a class="green" href="/connexion"><img src="/icons/key.svg" class="white" alt="[key]">Se connecter</a>
            </div>
            <a href="/">Accueil</a>
            <a href="/">Informations</a>
            <a href="/adherent"><img src="/icons/lock.svg" class="red" alt="[lock]">Espace adhérent</a>
        <?php endif ?>
    </nav>
</header>
<nav class="big-nav" id="navigation">
    <a href="/">Accueil</a>
    <a href="/">Informations</a>
    <a href="/adherent"><img src="/icons/unlock.svg" class="green" alt="[unlock]">Espace adhérent</a>
    <?php if(isset($_SESSION["adh"]) && $_SESSION["adh"]->referent): ?><a href="/referent"><img src="/icons/unlock.svg" class="green" alt="[unlock]">Espace référent</a><?php endif ?>
    <?php if(isset($_SESSION["adh"]) && $_SESSION["adh"]->bureau): ?><a href="/bureau"><img src="/icons/unlock.svg" class="green" alt="[unlock]">Espace bureau</a><?php endif ?>
    <?php if(isset($_SESSION["adh"]) && $_SESSION["adh"]->superadmin): ?><a href="/superadmin"><img src="/icons/unlock.svg" class="green" alt="[unlock]">Espace super-admin</a><?php endif ?>
</nav>
