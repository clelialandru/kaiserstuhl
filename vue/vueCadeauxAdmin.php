<?php
$titre = "Packages";
$style = '<link rel="stylesheet" href="style/cadeaux_admin.style.css">';
$script = '<script src="js/cadeauxAdmin.script.js"></script>
<script>
    DonneesTraductionMain(localStorage.getItem("lang"));
</script>'; ?>

<div class="space"></div>
<?php


if (!empty($message))
    echo "<div class='message'>" . $message . "</div>";

$resultat = "<div class='pack_list'>";

foreach ($cadeaux as $value) {
    $resultat .= "<div id='voucher_" . $value['id_package'] . "'>
    <div><h3 class='title'>" . $value['nom'] . "</h3></div>
    <div class='details'><img src='".$value['chemin_photo_PP'][0]."' loading='lazy' width='100%' class='cover'></div>
    <a href='index.php?action=cadeauAdmin&id_cadeau=" . $value['id_package'] . "' class='edit'>✎ Edit</a></div>";
}

$resultat .= "</div>";

echo '<div><a href="index.php?action=addCadeauAdmin" class="button AddP">✚  Add Package</a></div>';
echo '<div class="space"></div>';
echo '<div><h2 class="PacL">Package List</h2></div>';
echo $resultat;
