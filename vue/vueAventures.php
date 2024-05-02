<div class="landing_adventures">
    <h1 class="menu1">Our Adventures</h1>
</div>
<?php
$style = '<link rel="stylesheet" href="style/our_adventures.style.css">';
$script = '<script src="js/aventures.script.js"></script>
<script>
    DonneesTraductionMain(localStorage.getItem("lang"));
</script>';
$titre = 'Aventures';

$liste_Aventure = "<div class='liste'>";

$count = 0;

foreach ($aventures as $value) {

    $id = $value['id_game'];
    $nom = $value['nom'];
    $duration = $value['duree'];
    $ville = $value['localisation'];
    $photo = $value['chemin_photo_PP'][0];
    $count++;

    $liste_Aventure .= "<div class='aventure' id='aventure_" . $count . "'>
        <h2 class='nom_escape'>" . $nom . "</h2>
        <div>
        <img src ='".$photo."' loading='lazy' width='100%' id='image_" . $id . "'>
        <div class='adventure_text'>
        <div><span class='orange histoire'>Story</span> - 
        " . $nom . " <span class='détail" . $id . "'></span><br>
        <div class='summary descriptionAV" . $id . "' id='summary_" . $id . "'></div>
        <div class='desc' id='desc_" . $id . "'>
        <span class='orange'>" . $nom . "</span> - <span class='infoType'>Escape Walk (Outdoor)</span><br>
        <ul class='details'>
        <li id='duration_" . $id . "'><span class='duree'>Duration</span>: " . $duration . " <span class='durer2'>heures</span></li>
        <li id='location_" . $id . "'><span class='loc'>Location</span>: " . $ville . "</li>
        <li id='suitability_" . $id . "' class='info3" . $id . "'></li></div>
        <a href='index.php?action=aventure&id_aventure=" . $id . "' class='see_details'>See details</a>
        </div></div>
        </div></div>
        ";
}

$liste_Aventure .= '</div>';

echo $liste_Aventure;
?>

<div class="space"></div>