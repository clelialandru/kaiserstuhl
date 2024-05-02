<?php
require_once "includes/html/formulaire.class.php";
$titre = "General Info";
$style = '<link rel="stylesheet" href="style/info_gen_admin.style.css">
';
$script = '<script src="js/infoGenAdmin.script.js"></script>
<script>
    DonneesTraductionMain(localStorage.getItem("lang"));
</script>';

if (!empty($message))
    echo "<div class='message'>" . $message . "</div>";
?>
<div class="space"></div>


<form method="post" action="index.php?action=updateInfoGenAdmin">
    <?php
    $forms = new formulaire($information[0]);

    echo $forms->inputText('num_tel', 'Numéro de téléphone');
    echo $forms->inputMail('mail', 'Adresse mail');
    echo $forms->inputText('adresse', 'Adresse');
    echo $forms->submit('ok', 'SUBMIT');

    ?>
</form>

<div class="space"></div>
<div class="space"></div>
<div class="space"></div>
<div class="space"></div>