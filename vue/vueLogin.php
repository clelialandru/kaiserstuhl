<?php
// TODO: BOUTON LOGOUT
$titre = "Login";
$style = '<link rel="stylesheet" href="style/login.style.css">';
$script = '<script src="js/formulaire.script.js"></script>
<script src="js/login.script.js"></script>
<script>
    DonneesTraductionMain(localStorage.getItem("lang"));
</script>';
?>

<div class="space"></div>
<div class="space"></div>
<div class="space"></div>
<div class="formulaires">
  <div class="connect">
    <button onclick='se_connecter()' class="button_login signin" id="signin">Sign In</button>
    <?php
    if (!empty($message))
      echo "<div class='message'>" . $message . "</div>";
    ?>
    <form method="post" action="index.php?action=connection" class="connecter">
      <?php
      require_once "includes/html/formulaire.class.php";


      $forms = new formulaire($_POST);


      echo $forms->inputMail('mail', 'Email');
      echo $forms->inputPassword('mdp', 'Password');
      echo $forms->submit('ok', 'submit');
      ?>
    </form>
  </div>
  <div class="create">
    <button onclick='creer_compte()' class="button_login signup" id="signup">Sign Up</button>
    <form method="post" action="index.php?action=newCompte" class="creer_compte">
      <?php


      $forms = new formulaire($_POST);

      echo $forms->inputText('firstName', "First Name");
      echo $forms->inputText('name', 'Name');
      echo $forms->inputMail('mail', 'Email');
      echo $forms->inputPassword('mdp', 'Password');
      echo $forms->inputPassword('mdpCheck', 'Confirm your password');
      echo $forms->submit('ok', 'SUBMIT');
      ?>
    </form>
  </div>
</div>
<div class="space"></div>