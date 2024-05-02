<?php
$style = '<link rel="stylesheet" href="style/accueil.style.css">
<link rel="stylesheet" href="style/reviews.style.css">
<link rel="stylesheet" href="style/partners.style.css">';
$script = '<script src="js/reviews.script.js"></script>
<script src="js/accueil.script.js"></script>
<script>
    DonneesTraductionMain(localStorage.getItem("lang"));
</script>';
?>


<div class="landing"><img src="img/Kaiserstuhl-Escape-logo.png" alt="Kaiserstuhl Escape logo" loading="lazy" width="100%"></div>
<h1 class="texte1">YOUR ADVENTURES WITH KAISERSTUHL</h1>
<p class="sous-titre">NATURE - MOVEMENT - THE PLEASURE OF THE ENIGMA</p>

<iframe width="560" height="315" src="https://www.youtube.com/embed/nB4EnEo39N8?si=8vVpq2RQeYKKqQwJ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

<div class="line"></div>

<div class="adventures">
    <h2 id="adv"><span class="bolder">OUR</span> ADVENTURES</h2>
    <?php
    $titre = "Accueil";

    $liste_Aventure = "<div class='liste_escape'>";

    foreach ($aventures as $value) {

        $id = $value['id_game'];
        $nom = $value['nom'];
        $duration = $value['duree'];
        $ville = $value['localisation'];
        $photo = $value['chemin_photo_PP'][0];

        $liste_Aventure .= "
        <div class='card_escape'>
        <h3>" . $nom . "</h3>
        <img src = '" . $photo . "' loading='lazy' width='100%' class='cover_escape' alt='outdoor escape game'>
        <p class='title_game' id='title_" . $id . "'><span class='orange'>" . $nom . "</span> - <span class='infoType'>Escape Walk (Outdoor)</span></p>
        <ul class='details'>
        <li id='duration_" . $id . "'><span class='duree'>Duration</span>: " . $duration . " <span class='durer2'>heures</span></li>
        <li id='location_" . $id . "'><span class='loc'>Location</span>: " . $ville . "</li></ul>
        <a href='index.php?action=aventure&id_aventure=" . $id . "' class='book'>
        Book a session</a>
        </div>
        ";
    }

    $liste_Aventure .= "</div>";

    echo $liste_Aventure;
    ?>

    <a href="index.php?action=aventures" class="see_more">See our Adventures</a>
</div>
<div class="customer_reviews">
    <h2 class="texte4">Reviews</h2>
    <div class="testimonial-list" role="region" aria-label="Testimonials">
        <!-- Testimonial -->
        <div class="testimonial">

            <blockquote>
                Many thanks to the super team that developed this idea, especially in these times a great
                change in the open air. We had the INVINO Veritas tour, simply fantastic, highly recommended.
                We will now do the same with our company 🙂
            </blockquote>

            <!-- User Info -->
            <div class="user-info">
                <div class="user-details">
                    <p class="name">Sascha J. </p>
                    <p class="company">CEO, Zapf Garages</p>
                </div>
            </div>
        </div>

        <!-- Testimonial -->
        <div class="testimonial">

            <blockquote>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores
                quos laborum nesciunt, eveniet illum eum neque vitae perspiciatis
                nemo quo, molestias placeat sunt dignissimos nulla. Omnis
                consectetur aliquam ab incidunt!
            </blockquote>

            <!-- User Info -->
            <div class="user-info">
                <div class="user-details">
                    <p class="name">John Doe</p>
                    <p class="company">CEO, Company XYZ</p>
                </div>
            </div>
        </div>

        <!-- Testimonial -->
        <div class="testimonial">

            <blockquote>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores
                quos laborum nesciunt, eveniet illum eum neque vitae perspiciatis
                nemo quo, molestias placeat sunt dignissimos nulla. Omnis
                consectetur aliquam ab incidunt!
            </blockquote>

            <!-- User Info -->
            <div class="user-info">
                <div class="user-details">
                    <p class="name">John Doe</p>
                    <p class="company">CEO, Company XYZ</p>
                </div>
            </div>
        </div>

    </div>


    <!-- Button Navigation -->
    <button class="navigation prev" aria-label="Previous Testimonial">
        < </button>

            <button class="navigation next" aria-label="Next Testimonial">>
            </button>


            <!-- Dot Navigation -->
            <div class="dots-container"></div>


</div>

<div class="space"></div>

<p class="partners">These <span class="bold">companies</span> celebrated their <span class="bold">company escape adventure</span> with us. <br>
    <span class="bold">Thank you very much</span> for your support and the great contacts.
</p>
<div class="slider">
    <div class="slide-track">
        <div class="slide">
            <img src="img/partners/aldi.png" alt="aldi logo" class="partner" width="100%">
        </div>
        <div class="slide">
            <img src="img/partners/caritas.png" alt="caritas logo" class="partner" width="100%">
        </div>
        <div class="slide">
            <img src="img/partners/daimler.png" alt="daimler logo" class="partner" width="100%">
        </div>
        <div class="slide">
            <img src="img/partners/dm.png" alt="dm logo" class="partner" width="100%">
        </div>
        <div class="slide">
            <img src="img/partners/edeka.png" alt="edeka logo" class="partner" width="100%">
        </div>
        <div class="slide">
            <img src="img/partners/endresshauser.png" alt="endress+hauser logo" class="partner" width="100%">
        </div>
        <div class="slide">
            <img src="img/partners/haufe.png" alt="haufe logo" class="partner" width="100%">
        </div>
        <div class="slide">
            <img src="img/partners/miele.png" alt="miele logo" class="partner" width="100%">
        </div>
        <div class="slide">
            <img src="img/partners/sap.png" alt="sap logo" class="partner" width="100%">
        </div>
        <div class="slide">
            <img src="img/partners/zapfdiegarage.png" alt="zapf die garage" class="partner" width="100%">
        </div>
        <div class="slide">
            <div class="space"></div>
        </div>
    </div>
</div>

<div class="space"></div>

<div class="voucher">
    <div class="flex">
        <div>
            <h2 class="gift_ad">GIFT AN ADVENTURE NOW!</h2>
            <a href="index.php?action=giftcard" class="see_vouch">See Vouchers</a>
        </div>

        <img src="img/voucher.png" alt="kaiserstuhl escape gift voucher" width="100%" loading="lazy">
    </div>
    <div class="experiences">
        <h3 class="texte7">BECAUSE EXPERIENCES ARE MORE VALUABLE THAN MATERIAL GIFTS</h3>
        <p class="texte8">Unforgettable moments - full of excitement and adventure.</p>
    </div>
</div>

<div class="space">

</div>