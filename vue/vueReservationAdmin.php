<div class="space"></div>

<?php

$titre = "Bookings";
$style = '<link rel="stylesheet" href="style/bookings_admin.style.css">';
$script = '<script src="js/reservationAdmin.script.js"></script>
<script>
    DonneesTraductionMain(localStorage.getItem("lang"));
</script>';

require_once "includes/html/formulaire.class.php"; ?>

<?php
//var_dump($reservations);
if (!empty($message))
    echo "<div class='message'>" . $message . "</div>"; ?>

<?php
$listeReservation = "<div class='liste_ann'>";

foreach ($reservations as $value) {
    $forms = new formulaire($value);
    if ($value['annulation'] == 1) {
        $date = date_create($value['date']);
        $d = date_format($date, 'd/m/Y'); // Formatage de la date de la réservation
        //Cas où il y a une demande d'annulation
        $listeReservation .=

            "<div class='ann_card'>
            <form method='post' action='index.php?action=annulationCheck' onsubmit=\"return confirm('Êtes-vous sûr de votre choix ?');\">
            <div class='details'>
            
            <h3 id='game_name'>"
            . $value['nomGame'] .
            "</h3>
            <div class='list'>
            <div id='date'><span id='date_t'>Date:</span> "
            . $d . "<span id='at'> at </span>" . $value['crenaux'] . "</div>" .
            "<div id='name'>" .
            $value['nom'] . " "
            . $value['prenom'] . "</div>" .
            "<div id='mail'>"
            . $value['email'] . "</div><div id='num_tel'>"
            . $value['num_tel']
            . "</div></div></div><div id='form'>"
            . $forms->inputHidden('id_reservation')
            . $forms->submit('supp', "Cancel")
            . $forms->submit2('reject', "Reject")
            . "</div></form></div>";
    }
    //Cas où il n'y a pas de demande d'annulation
    else if ($value['annulation'] == 0) {

        $date = date_create($value['date']);
        $d = date_format($date, 'd/m/Y'); // Formatage de la date de la réservation
        //Cas où il y a une demande d'annulation
        $listeReservation .=

            "<div class='ann_card'>
        <form method='post' action='index.php?action=annulationCheck' onsubmit=\"return confirm('Êtes-vous sûr de votre choix ?');\">
        <div class='details'>
        
        <h3 id='game_name'>"
            . $value['nomGame'] .
            "</h3>
        <div class='list'>
        <div id='date'><span id='date_t'>Date:</span> "
            . $d . "<span id='at'> at </span>" . $value['crenaux'] . "</div>" .
            "<div id='name'>" .
            $value['nom'] . " "
            . $value['prenom'] . "</div>" .
            "<div id='mail'>"
            . $value['email'] . "</div><div id='num_tel'>"
            . $value['num_tel']
            . "</div></div></div><div id='form'>"
            . $forms->inputHidden('id_reservation')
            . $forms->submit('supp', "Cancel")
            . "</div></div></form>";
    }
}

$listeReservation .= '</div>';
echo ($listeReservation);
?>