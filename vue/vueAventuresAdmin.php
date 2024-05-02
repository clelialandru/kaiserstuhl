<div class="space"></div>


<?php
$style = '<link rel="stylesheet" href="style/aventures_admin.style.css">';
$script = '<script src="js/aventuresAdmin.script.js"></script>
<script>
    DonneesTraductionMain(localStorage.getItem("lang"));
</script>';

$titre = "Adventures";
if (!empty($message))
    echo "<div class='message'>" . $message . "</div>";
$resultat = "<div class='list_adventures'>";

foreach ($aventures as $value) {
    $resultat .= "<div id='adventure_" . $value['id_game'] . "'>
    <div>
    <h3 class='nom'>" . $value['nom'] . "</h3>
    <div class='details'><img src='".$value['chemin_photo_PP'][0]."' loading='lazy' width='100%' class='cover'></div>
    </div>
    <a href='index.php?action=aventureAdmin&id_aventure=" . $value['id_game'] . "' class='edit'>✎ Edit</a></div>";
}

$resultat .= '</div>';

echo '<div><a href="index.php?action=addAventureAdmin" class="button">✚   Add Adventure</a></div>';;
echo '<div class="space"></div>';
echo '<div><h2 class="AdvcL">Adventure List</h2></div>';
echo $resultat;
