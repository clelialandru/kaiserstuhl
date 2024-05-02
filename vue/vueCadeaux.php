<?php
$titre = 'Cadeaux';
$style = '<link rel="stylesheet" href="style/packages.style.css">';
$script = '<script src="js/cadeaux.script.js"></script>
<script>
    DonneesTraductionMain(localStorage.getItem("lang"));
</script>';
?>



<div class="landing">
    <h1 class="titre_package">PACKAGES</h1>
</div>

<h2 id="your_pack_as_puzz">Your <span>gift card</span> as a <span>puzzle</span>.</h2>

<div class="liste_cadeau">
    <?php
    $liste_Cadeau = "";

    foreach ($cadeaux as $value) {

        $id = $value['id_package'];
        $nom = $value['nom'];

        $liste_Cadeau .= "
    <a href='index.php?action=cadeau&id_cadeau=" . $id . "'><img src='".$value['chemin_photo_PP'][0]."' alt='package' class='images_pack_exemple'>
    </a>
    ";
    }

    echo $liste_Cadeau;

    ?>
</div>

<div>
    <p><a href="index.php?action=giftcard" class="see_gift_cards">See our gift cards</a></p>
</div>

<div class="space"></div>

<div id="special_gift">
    <div>
        <h3 class="texte4">A very <span>special gift</span></h3>
        <p class="texte5">Fun, joy & puzzles even when you're unwrapping it!</p>
    </div>
</div>

<div class="space"></div>

<h2 id="occasions">The <span>occasions</span></h2>

<div class="occasions_pic">
    <div id="birthday"><img src="img/birthday.svg" alt="birthday cake">
        <p class="texte7">Birthday</p>
    </div>
    <div id="wedding"><img src="img/wedding.svg" alt="heart">
        <p class="texte8">Wedding</p>
    </div>
    <div id="christmas"><img src="img/christmas.svg" alt="christmas tree">
        <p class="texte9">Christmas</p>
    </div>
</div>

<div class="space"></div>

<div class="your_gift_card">
    <div>
        <h3 class="texte10">Your gift card</h3>
        <p class="texte11">Experience a great adventure with us</p>

        <div>
            <p><a href="index.php?action=giftcard" class="see_voucher">See our gift cards</a></p>
        </div>
    </div>
    <img src="img/voucher.png" alt="voucher">
</div>

<div class="space"></div>