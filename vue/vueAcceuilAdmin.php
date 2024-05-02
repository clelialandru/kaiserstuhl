<?php 
    $style = '<link rel="stylesheet" href="style/acceuilAdmin.style.css"> ';
    $script='';

?>
<div class="space"></div>

<div class="choice_admin">
    <?php

    $titre = 'Acceuil admin';

    echo '   
    <h1 class="left">Hello, ' . $_SESSION['nom'] . ' ' . $_SESSION['prenom'] . ' ☕</h1>';

    echo '<div class="posBtnAdmin">
        <a href="index.php?action=reservationAdmin" class="btnAdmin">
            <img class="Picone" src="img/calendrier.svg" loading="lazy">
            <span class="menu0"></span>
        </a>
        <a href="index.php?action=cadeauxAdmin" class="btnAdmin">
            <img class="Picone" src="img/cadeaux.svg" loading="lazy">
            <span class="menu2"></span>
        </a>
        <a href="index.php?action=aventuresAdmin" class="btnAdmin">
            <img class="Picone" src="img/chaussure.svg" loading="lazy">
            <span class="menu1"></span>
        </a>
        <a href="index.php?action=infoGenAdmin" class="btnAdmin">
            <img class="Picone" src="img/information_svgrepo.com.svg" loading="lazy">
            <span class="menu3"></span>
        </a>
        </div>';

    ?>
</div>

<div class="space"></div>

<div class="space"></div>
<div class="space"></div>
<div class="space"></div>
<div class="space"></div>
