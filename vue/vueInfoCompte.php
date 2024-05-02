<?php
require_once "includes/html/formulaire.class.php";
$titre = "Edit Infos";
$style = '<link rel="stylesheet" href="style/info_compte.style.css">';
$script = '<script src="js/infoCompte.script.js"></script>
<script>
    DonneesTraductionMain(localStorage.getItem("lang"));
</script>'; ?>

<h2 id="ed_acc_t">Edit Account</h2>

<div class="account_edit">
    <?php
    if (!empty($message))
        echo "<div class='message'>" . $message . "</div>";

    echo '<form method="post" action="index.php?action=updateCompte">';
    $form = new formulaire($membre);
    echo $form->inputText('prenom', 'Prénom');
    echo $form->inputText('nom', 'Nom');
    echo $form->inputMail('email', 'Email');
    echo $form->inputText('num_tel', 'Num tel', FALSE);
    echo $form->submit('ok', 'SUMBIT');
    echo '</form>';
    ?>
</div>



<h2 id="ed_pas_t">Edit Password</h2>
<div class="password_edit">
    <p class='passmc'>Password must contain <span class="must">uppercase, lowercase, symbols, numbers and at least 8 characters</span></p>
    <?php
    echo '<form method="post" action="index.php?action=updatePwd">';
    echo $form->inputPassword('mdp', 'mot de passe');
    echo $form->inputPassword('mdpCheck', 'mot de passe');
    echo $form->submit('ok', 'SUBMIT');
    echo '</form>'; ?>
</div>

<div class="space"></div>
<div class="space"></div>