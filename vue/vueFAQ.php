<?php
$titre = "FAQ";
$script = '<script src="js/questions.js"></script>
<script>
    AfficheQuestions(); //mettre fichier avant header.js
    DonneesTraductionMain(localStorage.getItem("lang"));
</script>';
$style = '<link rel="stylesheet" href="style/questions.style.css">'
?>

<h1 class="title"></h1>
<div class="questions"></div>