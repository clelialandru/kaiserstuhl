<div class="space"></div>

<?php

require_once "includes/html/formulaire.class.php";
$titre = "Aventure admin" ;
$script = '<script src="js/gestionPhoto.script.js"></script>
    <script src="js/aventureAdmin.script.js"></script>

    <script>
        DonneesTraductionMain(localStorage.getItem("lang"));
    </script>';
$style = '<link rel="stylesheet" href="style/addAdmin.style.css">';

if (!empty($message))
    echo "<div class='message'>" . $message . "</div>";

//puzzle
$puzzleDifficult = "";
switch ($dataAventure['info']['.info3']['fr']) {
    case "Parfait pour les débutants en puzzles":
        $puzzleDifficult = 'facil';
        break;
    case "Pour les amateurs de puzzles":
        $puzzleDifficult = 'moyen';
        break;
    case "Pour les passionnés de puzzles":
        $puzzleDifficult = 'dur';
        break;
}
//marche
$marcheDifficult = "";
switch ($dataAventure['info']['.info4']['fr']) {
    case "Marche facile":
        $marcheDifficult = 'facil';
        break;
    case "Marche modérée":
        $marcheDifficult = 'moyen';
        break;
    case "Marche avancée":
        $marcheDifficult = 'dur';
        break;
}


$dataJSON = array(
    "detailEN" => $dataAventure['info']['.détail']['en'],
    "detailFR" => $dataAventure['info']['.détail']['fr'],
    "detailDE" => $dataAventure['info']['.détail']['de'],
    "histoireEN" => $dataAventure['info']['.histoireAV']['en'],
    "histoireFR" => $dataAventure['info']['.histoireAV']['fr'],
    "histoireDE" => $dataAventure['info']['.histoireAV']['de'],
    "descriptionEN" => $dataAventure['info']['.descriptionAV']['en'],
    "descriptionFR" => $dataAventure['info']['.descriptionAV']['fr'],
    "descriptionDE" => $dataAventure['info']['.descriptionAV']['de'],
    "emporterEN" => $dataAventure['info']['.info1']['en'],
    "emporterFR" => $dataAventure['info']['.info1']['fr'],
    "emporterDE" => $dataAventure['info']['.info1']['de'],
    "importantEN" => $dataAventure['info']['.info2']['en'],
    "importantFR" => $dataAventure['info']['.info2']['fr'],
    "importantDE" => $dataAventure['info']['.info2']['de'],
    "puzzleDificult" => $puzzleDifficult,
    "walkDificult" => $marcheDifficult,
    "cibleEN" => $dataAventure['info']['.info5']['en'],
    "cibleFR" => $dataAventure['info']['.info5']['fr'],
    "cibleDE" => $dataAventure['info']['.info5']['de'],
    "trainBusEN" => $dataAventure['info']['.info6']['en'],
    "trainBusFR" => $dataAventure['info']['.info6']['fr'],
    "trainBusDE" => $dataAventure['info']['.info6']['de'],
    "infoLangues" => $dataAventure['infoLangues']
);

//Data SQL 
$formsSQL = new formulaire($aventure);
//Data JSON
$formsJSON = new formulaire($dataJSON);

$forms = new formulaire($aventure);



$listeInput = "";
$listeInput .=
    $formsSQL->inputText('nom', 'Nom').
    $formsJSON->inputText('detailEN', 'Détail EN').
    $formsJSON->inputText('detailFR', 'Détail FR').
    $formsJSON->inputText('detailDE', 'Détail DE').
    $formsJSON->inputTextArea('histoireEN', 'HistoireEN').
    $formsJSON->inputTextArea('histoireFR', 'HistoireFR').
    $formsJSON->inputTextArea('histoireDE', 'HistoireDE').
    $formsJSON->inputTextArea('descriptionEN', 'DescriptionEN').
    $formsJSON->inputTextArea('descriptionFR', 'DescriptionFR').
    $formsJSON->inputTextArea('descriptionDE', 'DescriptionDE').
    $formsJSON->inputCheckbox('infoLangues',array("en" => "Anglais", "fr" => "Français", "de" => "Allemand"),'Info langues').
    $formsSQL->inputNum('prix', 'Prix').
    $formsJSON->inputTextArea('emporterEN', 'A emporterEN').
    $formsJSON->inputTextArea('emporterFR', 'A emporterFR').
    $formsJSON->inputTextArea('emporterDE', 'A emporterDE').
    $formsJSON->inputText('importantEN', 'Information importantEN').
    $formsJSON->inputText('importantFR', 'Information importantFR').
    $formsJSON->inputText('importantDE', 'Information importantDE').
    $formsJSON->inputSelect('puzzleDificult', array('Choose'=>'Veuillez choisir un niveau de difficulté', 'facil'=>'Facil','moyen'=>'Moyen', 'dur'=>'dur'),'puzzleDificult').
    $formsJSON->inputSelect('walkDificult', array('Choose'=>'Veuillez choisir un niveau de difficulté', 'facil'=>'Facil','moyen'=>'Moyen', 'dur'=>'dur'),'walkDificult').
    $formsJSON->inputTextArea('cibleEN', 'Le groupe cibleEN').
    $formsJSON->inputTextArea('cibleFR', 'Le groupe cibleFR').
    $formsJSON->inputTextArea('cibleDE', 'Le groupe cibleDE').
    $formsJSON->inputText('trainBusEN', 'Station de train/busEN').
    $formsJSON->inputText('trainBusFR', 'Station de train/busFR').
    $formsJSON->inputText('trainBusDE', 'Station de train/busDE').
    $formsSQL->inputText('localisation', 'Localisation').
    $formsSQL->inputLatitude('latitude','latitude').
    $formsSQL->inputLongitude('longitude','longitude').
    $formsSQL->inputText('adresse', 'adresse').
    $formsSQL->inputTime('duree', 'Durée').
    $formsSQL->inputRadio('parking',array(0=>'No',1=>'Yes'),'Parking').
    $formsSQL->inputRadio('accebilite',array(0=>'No',1=>'Yes'),'Accebilité').
    $formsSQL->inputText('linkYTB','Lien de la vidéo youtube', FALSE).
    $formsSQL->inputHidden('id_game').
    $formsSQL->inputHidden('info').
    $formsSQL->submit('ok','SUBMIT') ;

?>


<form method="post" action="index.php?action=updateAventureAdmin">
    <?php

    echo $listeInput;

    ?>
</form>

    <form method="post" action="index.php?action=updateAventureAdmin" enctype="multipart/form-data">
    <!-- Champ pour changer la photo de profil -->
    <?php echo $forms->inputFilePhoto('nouvelle_photo_profil','nouvelle_photo_profil', 'Nouvelle photo de profil', $aventure['chemin_photo_PP'], 'image/jpeg, image/png, image/webp', false, false); ?>

    <!-- Liste des photos existantes -->
    <h3 id="leTitre">Photos existantes :</h3>
    <div class="existing-photos">
        <?php foreach ($aventure['chemin_photos'] as $photo) : ?>
            <div class="photo-container">
                <img src="<?php echo $photo; ?>" class="existing-photo">
                <input type="checkbox" name="photos_a_supprimer[]" value="<?php echo $photo; ?>">
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Champ pour ajouter de nouvelles photos -->
    <?php echo $forms->inputFilePhoto('nouvelles_photos[]','nouvelles_photos', 'Nouvelles photos à ajouter', [], 'image/jpeg, image/png, image/webp', true, false); ?>

    <?php echo $forms->inputHidden('photo'); ?>
    <?php echo $forms->inputHidden('id_game'); ?>
    <!-- Bouton de soumission -->
    <?php echo $forms->submit('ok', 'Soumettre'); ?>
</form>



    <form method = 'post' action="index.php?action=deleteAventureAdmin" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette aventure ?');">
        <?php
    echo $forms->inputHidden('id_game');
    echo $forms->submit2('ok', 'DELETE');
    ?>
</form>