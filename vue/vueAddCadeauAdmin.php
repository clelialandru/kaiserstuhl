<div class="space"></div>
<?php
require_once "includes/html/formulaire.class.php";
$titre = "Add package";
$script = '<script src="js/gestionPhoto.script.js"></script>
    <script src="js/addPackage.script.js"></script>
    <script>
        DonneesTraductionMain(localStorage.getItem("lang"));
    </script>';
$style = '<link rel="stylesheet" href="style/addAdmin.style.css">';
if (!empty($message))
    echo "<div class='message'>" . $message . "</div>";
?>

<form method="post" action="index.php?action=insertCadeau" enctype="multipart/form-data">
    <?php
    $forms = new formulaire($_POST);

    echo $forms->inputText('nom', 'Nom');
    echo $forms->inputTextArea('descriptionEN', 'DescriptionEN');
    echo $forms->inputTextArea('descriptionFR', 'DescriptionFR');
    echo $forms->inputTextArea('descriptionDE', 'DescriptionDE');
    echo $forms->inputNum('hauteur', 'hauteur (en cm)');
    echo $forms->inputNum('largeur', 'largeur (en cm)');
    echo $forms->inputFilePhoto('nouvelle_photo_profil','nouvelle_photo_profil', 'Nouvelle photo de profil', []);
    echo $forms->inputFilePhoto('nouvelles_photos[]','nouvelles_photos', 'Nouvelles photos à ajouter', [], 'image/jpeg, image/png, image/webp', true);
    echo $forms->inputText('prix', 'Prix');
    echo $forms->inputNum('temps_livré', 'Temps de livraison (En jours)');
    echo $forms->submit('ok', 'submit');

    ?>
</form>