<div class="space"></div>


<?php
require_once "includes/html/formulaire.class.php";
$titre = "Add aventure";
$style = '<link rel="stylesheet" href="style/addAdmin.style.css">';

$script='<script src="js/gestionPhoto.script.js"></script>
    <script src="js/addAventure.script.js"></script>

    <script>
        DonneesTraductionMain(localStorage.getItem("lang"));
    </script>';

if (!empty($message))
    echo "<div class='message'>" . $message . "</div>";
?>

<form method="post" action="index.php?action=insertAventure" enctype="multipart/form-data">
    <?php
    $forms = new formulaire($_POST);
    echo $forms->inputText('nom', 'Nom') .
        $forms->inputText('detailEN', 'Détail EN') .
        $forms->inputText('detailFR', 'Détail FR') .
        $forms->inputText('detailDE', 'Détail DE') .
        $forms->inputTextArea('histoireEN', 'HistoireEN') .
        $forms->inputTextArea('histoireFR', 'HistoireFR') .
        $forms->inputTextArea('histoireDE', 'HistoireDE') .
        $forms->inputTextArea('descriptionEN', 'DescriptionEN') .
        $forms->inputTextArea('descriptionFR', 'DescriptionFR') .
        $forms->inputTextArea('descriptionDE', 'DescriptionDE') .
        $forms->inputFilePhoto('nouvelle_photo_profil','nouvelle_photo_profil', 'Nouvelle photo de profil', []) .
        $forms->inputFilePhoto('nouvelles_photos[]','nouvelles_photos', 'Nouvelles photos à ajouter', [], 'image/jpeg, image/png, image/webp', true) .
        $forms->inputCheckbox('infoLangues', array("en" => "Anglais", "fr" => "Français", "de" => "Allemand"), 'Info langues') .
        $forms->inputNum('prix', 'Prix') .
        $forms->inputTextArea('emporterEN', 'A emporterEN') .
        $forms->inputTextArea('emporterFR', 'A emporterFR') .
        $forms->inputTextArea('emporterDE', 'A emporterDE') .
        $forms->inputText('importantEN', 'Information importantEN') .
        $forms->inputText('importantFR', 'Information importantFR') .
        $forms->inputText('importantDE', 'Information importantDE') .
        $forms->inputSelect('puzzleDificult', array('Choose' => 'Veuillez choisir un niveau de difficulté', 'facil' => 'Facil', 'moyen' => 'Moyen', 'dur' => 'dur'), 'puzzleDificult') .
        $forms->inputSelect('walkDificult', array('Choose' => 'Veuillez choisir un niveau de difficulté', 'facil' => 'Facil', 'moyen' => 'Moyen', 'dur' => 'dur'), 'walkDificult') .
        $forms->inputTextArea('cibleEN', 'Le groupe cibleEN') .
        $forms->inputTextArea('cibleFR', 'Le groupe cibleFR') .
        $forms->inputTextArea('cibleDE', 'Le groupe cibleDE') .
        $forms->inputText('trainBusEN', 'Station de train/busEN') .
        $forms->inputText('trainBusFR', 'Station de train/busFR') .
        $forms->inputText('trainBusDE', 'Station de train/busDE') .
        $forms->inputText('localisation', 'Localisation') .
        $forms->inputLatitude('latitude', 'latitude') .
        $forms->inputLongitude('longitude', 'longitude') .
        $forms->inputText('adresse', 'adresse') .
        $forms->inputTime('duree', 'Durée') .
        $forms->inputRadio('parking', array(0 => 'No', 1 => 'Yes'), 'Parking') .
        $forms->inputRadio('accebilite', array(0 => 'No', 1 => 'Yes'), 'Accebilité') .
        $forms->inputText('linkYTB', 'Lien de la vidéo youtube', FALSE) .
        $forms->submit('ok', 'SUBMIT');

    ?>
</form>