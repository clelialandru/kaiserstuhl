<?php
$titre = "Customer Area"; // Titre de la page
$style = '<link rel="stylesheet" href="style/espace_client.style.css">'; // Feuilles de style
$script = '<script src="js/acceuilMembre.script.js"></script>
<script>
    DonneesTraductionMain(localStorage.getItem("lang"));
</script>'; // Scripts
?>

<p class="welcome"><span id="welcome">Welcome</span>, <span id="member_name"><?= $membre['nom'] . " " . $membre['prenom'] ?>! 🗝️</span></p>

<div class="line"></div>


<h2 id="your_profile">Your profile</h2>



<div class="profile">
    <div id="first_name" class="p_element">
        <p class="cat first_name">First Name:</p>
        <p><?= $membre['prenom'] ?></p>
    </div>
    <div id="name" class="p_element">
        <p class="cat name">Surname:</p>
        <p><?= $membre['nom'] ?></p>
    </div>
    <div id="mail" class="p_element">
        <p class="cat mail">Email:</p>
        <p><?= $membre['email'] ?></p>
    </div>
    <div id="phone_num" class="p_element">
        <p class="cat phone_num">Phone number (optional):</p>
        <p><?php
            if (!is_null($membre['num_tel'])) {
                $phone = $membre['num_tel'];
                $ph = str_replace('.', ' ', $phone); // Met en forme le numéro de téléphone du client (espaces à la place de points)
                echo "<span class='phon'>" . $ph . "</span>";
            } else {
                echo "<span class='not_sp'>Not specified</span>";
            }
            ?></p>
    </div>
    <div>
        <?php
        echo "<a href='index.php?action=infoCompte' class='button editInfo'>✎ Edit infos</a>";
        ?>
    </div>
</div>


<div class="line"></div>


<h2 id="bookings_t" class="bookings_t">Your bookings</h2>

<div class="booking_list">
    <?php
    if (!empty($reservations)) {

        $liste_reservation = "";


    foreach ($reservations as $value) {
        $date = date_create($value['date']);
        $d = date_format($date, 'd/m/Y'); // Formatage de la date de la réservation
        $liste_reservation .= "<div id='book_" . $value['id_reservation'] . "' class='booking_card'>
        <a href='index.php?action=aventure&id_aventure=" . $value['id_game'] . "'><img src = '".$value['chemin_photo_PP'][0]."' loading='lazy' width='100%'></a> 
        <div class='text_elements'>
            <h3>" . $value["nom"] . "</h3>
            <div class='date'>
                <div id='date'>
                <p id='date_t' class='det_t datez'>Date:</p>
                <p>" . $d . " </p>
                </div>
                <div id ='time'>
                <p id='time_t' class='det_t timez'>Time:</p>
                <p>" . $value['crenaux'] . "</p></div>
            </div>
            </div>
            <a href='index.php?action=reservationMembre&id_reservation=" . $value['id_reservation'] . "' class='button cansel'>Cancel</a>
        
        </div>";
        }

        echo $liste_reservation;
    } ?>
</div>


<div class="line"></div>

<h2 id="logout">Log Out?</h2>
<?php

//var_dump($reservations);



echo "<a href='index.php?action=login' class='log'>Log Out</a>";
