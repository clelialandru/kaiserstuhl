<div class="space"></div>
<?php
require_once "includes/html/formulaire.class.php";
$titre = "cadeau admin";
$style = '<link rel="stylesheet" href="style/addAdmin.style.css">';
$script = '<script src="js/gestionPhoto.script.js"></script>
    <script src="js/packageModif.script.js"></script>
    <script>
        DonneesTraductionMain(localStorage.getItem("lang"));
    </script>';

if (!empty($message))
    echo "<div class='message'>" . $message . "</div>";

$dataJSON = array(
    "descriptionEN" => $dataCadeau['.description']['en'],
    "descriptionFR" => $dataCadeau['.description']['fr'],
    "descriptionDE" => $dataCadeau['.description']['de']
);

?>



<form method="post" action="index.php?action=updateCadeauAdmin">
    <?php
    $formsSQL = new formulaire($cadeau);
    $formsJSON = new formulaire($dataJSON);

    $forms = new formulaire($cadeau);

    echo $formsSQL->inputText('nom', 'Nom');
    echo $formsJSON->inputTextArea('descriptionEN', 'DescriptionEN');
    echo $formsJSON->inputTextArea('descriptionFR', 'DescriptionFR');
    echo $formsJSON->inputTextArea('descriptionDE', 'DescriptionDE');
    echo $formsSQL->inputNum('hauteur', 'hauteur (en cm)');
    echo $formsSQL->inputNum('largeur', 'largeur (en cm)');
    echo $formsSQL->inputText('prix', 'Prix');
    echo $formsSQL->inputNum('temps_livré', 'Temps de livraison (En jours)');
    echo $formsSQL->inputHidden('id_package');
    echo $forms->inputHidden('info');
    echo $formsSQL->submit('ok','SUBMIT');

    ?>
</form>

<form method="post" action="index.php?action=updateCadeauAdmin" enctype="multipart/form-data">
    <!-- Champ pour changer la photo de profil -->
    <?php echo $forms->inputFilePhoto('nouvelle_photo_profil','nouvelle_photo_profil', 'Nouvelle photo principale', $cadeau['chemin_photo_PP'], 'image/jpeg, image/png, image/webp', false, false); ?>

    <!-- Liste des photos existantes -->
    <h3 id="leTitre">Photos existantes :</h3>
    <div class="existing-photos">
        <?php foreach ($cadeau['chemin_photos'] as $photo) : ?>
            <div class="photo-container">
                <img src="<?php echo $photo; ?>" class="existing-photo">
                <input type="checkbox" name="photos_a_supprimer[]" value="<?php echo $photo; ?>">
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Champ pour ajouter de nouvelles photos -->
    <?php echo $forms->inputFilePhoto('nouvelles_photos[]','nouvelles_photos', 'Nouvelles photos à ajouter', [], 'image/jpeg, image/png, image/webp', true, false); ?>

    <?php echo $forms->inputHidden('photo'); ?>
    <?php echo $forms->inputHidden('id_package'); ?>
    <!-- Bouton de soumission -->
    <?php echo $forms->submit2('ok', 'Soumettre'); ?>
</form>



    <form method = 'post' action="index.php?action=deleteCadeauAdmin" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce package ?');">
        <?php
    echo $forms->inputHidden('id_package');
    echo $forms->submit('ok','DELETE');
    ?>
    </form>