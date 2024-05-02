<?php
$titre = "Exemple cours";
$style = '';
$script = '';
?>

<div class="resultat">
  <?php
  if (count($clients)) {
    require_once "includes/html/tableau.class.php";

    echo tableau::head(array_keys($clients[0]));
    echo tableau::body($clients);
    echo tableau::foot();
    echo "<p><a href='index.php?action=ajoutClient'><button class='valid'>Ajouter un client</button></a></p>";
  } else
    echo "<div class='reponse'>Aucun client n'est enregistré dans la liste</div>";
  ?>
</div>