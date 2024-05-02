<?php

$titre = 'Cadeau';
//var_dump($cadeau);
$style = '<link rel="stylesheet" href="style/package.style.css">
<link rel="stylesheet" href="style/modal.style.css">';

$script = '<script src="js/modal.script.js"></script>';
$script = '<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script src="js/cadeau.script.js"></script>
<script src="js/modal.script.js"></script>';

$script .= "<script>
    let param = new URLSearchParams(location.search);
    let idCadeau = param.get('id_cadeau');
    DonneesTraductionMain(localStorage.getItem('lang'), idCadeau);
</script>";
?>



<div class="landing" style="background-image:url('<?=$cadeau['chemin_photo_PP'][0]?>')">
    <h1 class="titre_package"><?= $cadeau['nom'] ?></h1>
</div>

<aside>
    <?php
    if ($_GET['action'] == 'giftcard') {
        echo "<h2 class='Tpack'>Please Select a Price</h2>";
        echo "<form action='post'>";
        require_once 'includes/html/formulaire.class.php';
        $forms = new formulaire();
        echo $forms->select_price_gift('select_price', "Select a Price");
        
        $forms = new formulaire($cadeau);
        echo $forms->inputHidden('id_package');
        echo "</form>";
    } else {
        echo "<h2>Please Select a Price</h2>";
        echo "<form action='post'>";
        require_once 'includes/html/formulaire.class.php';
        $forms = new formulaire();
        echo $forms->select_price_gift_box('select_price', "Select a Price");
        
        $forms = new formulaire($cadeau);
        echo $forms->inputHidden('id_package');
        echo "</form>";
    }

    $liste_photo = "<div class='liste-photo'>";

    foreach($cadeau['chemin_photos'] as $value){
        $liste_photo .= "<img src='".$value."' alt='' class='package_img myImg'>";
    }
    $liste_photo .= '</div>';
    echo $liste_photo ;
    ?>
    <!-- <img src="img/package_test/Rectangle 25.png" alt="" class='package_img myImg'>
    <img src="img/package_test/Rectangle 26.png" alt="" class='package_img myImg'>
    <img src="img/package_test/Rectangle 27.png" alt="" class='package_img myImg'> -->

</aside>
<div class="text_package">
    <h2 class="pack_title"><?= $cadeau['nom'] ?></h2>
    <h2 id="desc_title">Description</h2>
    <p class="description">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum placeat vero,
        esse ullam eum optio tenetur repellendus veniam incidunt nisi quam id sit praesentium, impedit quia
        consequuntur. Quas, ipsum et. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Libero
        placeat illo dignissimos voluptas aut perferendis incidunt, a corrupti, similique architecto amet.
        Voluptatibus voluptates eligendi dolores commodi nemo iusto magni minus!</p>
    <h2 id="possib_occasions">Possible Occasions</h2>
    <p id="occasions">Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt qui sint dolorem harum eligendi eos sed,
        quia maiores minus aliquid. Fuga veniam reiciendis hic odio nihil earum placeat animi dolorem!</p>
    <h2 id="details_title">Details</h2>
    <ul id="details">
        <li><span class="orange" id="price">Price:</span> <?php
                                                            if ($cadeau['prix'] != 0 && $cadeau['prix'] > 0) {
                                                                echo $cadeau['prix'] . " €";
                                                            } else {
                                                                echo "Up to the customer";
                                                            } ?> </li>
        <li><span class="orange" id="dt">Delivery Time:</span> <?= $cadeau['temps_livré'] ?> <span id="days">day<?php
                                                                                                                if ($cadeau['temps_livré'] > 1) {
                                                                                                                    echo "s";
                                                                                                                } ?></span></li>
        <li><span class="orange" id="size">Size:</span> <?php
                                                        if ($cadeau['type'] == 'carte') {
                                                            echo "N/A";
                                                        } else {
                                                            $size = $cadeau['hauteur'];
                                                            $size .= " X " . $cadeau['largeur'] . " cm";
                                                            echo $size;
                                                        }

                                                        ?></li>
    </ul>
    <div class="space"></div>
    <div class="space"></div>

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- The Close Button -->
        <span class="close">&times;</span>

        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="img01">

        <!-- Modal Caption (Image Text) -->
        <div id="caption"></div>
    </div>
    <p><a href="#" onclick="submitForms()" id="link_buy">BUY</a></p>
    <div class="space"></div>
</div>


<?php

?>