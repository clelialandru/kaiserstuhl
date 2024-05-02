<div class="space"></div>
<?php
require_once "includes/html/formulaire.class.php";
$titre = "Cancel Booking";
$style = '<link rel="stylesheet" href="style/annulation_membre.style.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />';
$script = '<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>';
$lat = $reservation['latitude'];
$lon = $reservation['longitude'];

$script .= "<script>
    var lat = $lat;
    var lon = $lon;

    var lang = localStorage.getItem('lang');
    var indi = '';

    switch(lang){
        case 'en':
            indi = 'Here!';
            break;
        case 'fr':
            indi = 'Ici !';
            break;
        case'de':
            indi='Hier!';
            break;
        default:
            indi = 'Here!';
            break;
    }

    var map = L.map('map').setView([lat, lon],13)
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href=\'https://www.openstreetmap.org/copyright\'>OpenStreetMap</a> contributors'
    }).addTo(map);
    L.marker([lat, lon]).addTo(map)
        .bindPopup(indi)
        .openPopup();
    </script>";

$script .= '<script src="js/reservationMembre.script.js"></script>
    <script>
        DonneesTraductionMain(localStorage.getItem("lang"));
    </script>';
?>


<h2 class="titre_es"><?= $reservation['nom'] ?></h2>
<div class="line"></div>
<h2 id="det_t">Details</h2>
<div class="infos">
    <div class="info">
        <div class="location">
            <div id="location">
                <h3 id="loc_t">Location</h3>
                <?= $reservation['localisation'] ?>
            </div>
            <div id="address">
                <h3 id="adr_t">Address</h3>
                <?= $reservation['adresse'] ?>
            </div>
        </div>

        <div class="price">
            <div id="price">
                <h3 id="pri_t">
                    Price
                </h3>
                <?= $reservation['prix'] ?> € <span id="per_per">per person</span>
            </div>
        </div>

        <div class="duration">
            <div id="duration">
                <h3 id="dur_t">
                    Duration
                </h3>
                <?= $reservation['duree'] ?> <span id='hour'>hours</span>
            </div>
        </div>

        <div class="radio">
            <div id="parking">
                <h3 id="par_t">
                    Parking
                </h3>
                <?php
                if ($reservation['parking'] == 0) {
                    echo "<span id='ONparking' data-onpark='No'></span>";
                } else if ($reservation['parking'] == 1) {
                    echo "<span id='ONparking' data-onpark='Yes'></span>";
                } else {
                    echo "Error";
                }
                ?>
            </div>
            <div id="access">
                <h3 id="acc_t">Accessibility</h3>
                <?php if ($reservation['accebilite'] == 0) {
                    echo "<span id='ONhandi' data-onpark='No'></span>";
                } else if ($reservation['accebilite'] == 1) {
                    echo "<span id='ONhandi' data-onpark='Yes'></span>";
                } else {
                    echo "Error";
                } ?>
            </div>
        </div>
    </div>
    <div id="map"></div>
</div>
<div class="line"></div>
<h2 id="yo_b_t">Your Booking</h2>
<div class="reservation">
    <div class="nbper">
        <h3 id="nb_t">
            Number of people:
        </h3>
        <p><?= $reservation['nbr_personne'] ?></p>
    </div>
    <?php
    $date = date_create($reservation['date']);
    $d = date_format($date, 'd/m/Y'); // Formatage de la date de la réservation
    ?>
    <div class="date">
        <h3 id="da_t">
            Date of the escape game:
        </h3>
        <div class="flex_p">
            <p><?= $d ?></p>
            <p id="at"> at </p>
            <p><?= $reservation['crenaux'] ?></p>
        </div>

    </div>

    <div class="price">
        <h3 id="total">
            Total Price:
        </h3>
        <p><?php $prix = $reservation['prix'];
            $nb = $reservation['nbr_personne'];
            $prix_f = $prix * $nb - (1 * $nb);
            echo $prix_f ?> €
        </p>
    </div>

</div>


<?php
if (!empty($message))
    echo $message;



?>


<form method='post' action="index.php?action=annulerReservationMembre" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
    <?php
    $forms = new formulaire($reservation);
    echo $forms->inputHidden('id_reservation');
    echo $forms->submit('ok', 'Cancel');
    ?>
</form>
<div class="line"></div>
<?php

echo "<a href='index.php?action=acceuilMembre' class='button_b'>Back</a>";
