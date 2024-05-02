<?php

$titre = 'Aventure';

$style = '<link rel="stylesheet" href="style/sildeshow.style.css">
<link rel="stylesheet" href="style/aventure.style.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
';

$script = '<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script src="js/aventure.script.js"></script>
<script src="js/slideshow.script.js"></script>';
// Map
$lat = $aventure['latitude'];
$lon = $aventure['longitude'];

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

$script .= "<script>
    // Gestion de la date sur le calendrier
    book_date.min = new Date().toISOString().split('T')[0];
    book_date.value = new Date().toISOString().split('T')[0];

    let param = new URLSearchParams(location.search);
    let idGame = param.get('id_aventure');
    DonneesTraductionAv(localStorage.getItem('lang'), idGame);
</script>";

if (!empty($message))
    echo "<div class='message'>" . $message . "</div>";
?>

<div class="landing" style='background-image:url(<?= $aventure['chemin_photo_PP'][0] ?>)'></div>

<div class="desc">
    <aside>
        <div class="price">
            <h2 id="booking" class='achat1'>Booking</h2>
            <p id="price"><span class="achat2">From</span> <?= $aventure['prix'] ?> €</p>
        </div>
        <p id="choose_a_date" class='achat3'>Choose a date and book the appointment</p>

        <div class="calendar">
            <div class="step1">
                <h3 class='achat4'>1. Appointment</h3>
                <div class="calendar">
                    <form>
                        <label for="book_date">Select a date for your appointment <br></label>
                        <input type="date" id="book_date" name="booking_date">
                    </form>
                </div>
            </div>
            <div class="time">
                <h3 class="achat5">2. Time</h3>
                <div>
                    <p class="achat6">Select a time slot</p>
                    <form class="time_slots">
                        <div>
                            <input type="radio" class="time_slot" name="time_slot" value="8:00" id="time8" label='08:00' checked>
                        </div>
                        <div>
                            <input type="radio" class="time_slot" name="time_slot" value="10:" id="time10" label='10:00'>
                        </div>
                        <div>
                            <input type="radio" class="time_slot" name="time_slot" value="14:00" id="time14" label='14:00'>
                        </div>
                        <div>
                            <input type="radio" class="time_slot" name="time_slot" value="16:00" id="time16" label='16:00'>
                        </div>
                        <div>
                            <input type="radio" class="time_slot" name="time_slot" value="18:00" id="time18" label='18:00'>
                        </div>
                    </form>
                </div>

                <!-- <button class="valid achat7">Validate</button> -->
            </div>
            <div class="option">
                <h3 class="achat8">3. Option</h3>
                <p class="achat7">Please select the number of people present for the escape game</p>

                <form>
                    <?php
                    require_once "includes/html/formulaire.class.php";

                    $price =  $aventure['prix'];
                    $valeurs = array();
                    for ($i = 1; $i <= 13; $i++) {
                        $prix = $price * $i;
                        if ($i > 1 && $i < 13) {
                            $prix -= 1 * $i;
                            $valeurs[$prix . '-' . $i] = "Group of <span class='orange'>" . $i . "</span> people - <span class='orange'>" . $prix . " €</span>";
                        } else if ($i == 13) {
                            $prix -= 1 * $i;
                            $valeurs[$prix . '-' . $i] = "Group of <span class='orange'> more than 12</span> people - <span class='orange'>" . $prix . " €</span>";
                        } else {
                            $valeurs[$prix . '-' . $i] = "<span class='orange'>One</span> person - <span class='orange'>" . $prix . " €</span>";
                        }
                    }

                    $forms = new formulaire();
                    echo $forms->inputSelect('price', $valeurs, '', 'custom-select-people');
                    $formss = new formulaire($aventure);
                    echo $formss->inputHidden('id_game')
                    ?>
                    <a href="#" class="valid achat9" onclick="submitForms()">Proceed to payment</a>
                </form>

            </div>
            <div class="space"></div>
        </div>
    </aside>
    <h1><?= $aventure['nom'] ?></h1>
    <div class="container">
        <?php
        $liste_photo = "";
        foreach ($aventure['chemin_photos'] as $value) {
            $liste_photo .= "<img src='" . $value . "' alt='adventure image' width='100%' loading='lazy' class='slide'>";
        }

        echo $liste_photo;
        ?>
        <!-- <img src="img/image_test.png" alt="adventure image" width="100%" loading="lazy" class="slide">
        <img src="img/slide_2_test.jpg" alt="adventure image" width="100%" loading="lazy" class="slide"> -->
        <!-- Next and previous buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>

    <div class="description">
        <div class="story">
            <p id="title_escape"><span id="story" class="histoire">Story</span> - <?= $aventure['nom'] ?> <span id="story" class="détail"></span></p>
            <p id="synopsis" class="histoireAV">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aperiam quasi voluptas dolor repellat
                eveniet. Exercitationem est doloremque ab, possimus eaque velit delectus obcaecati, sed, quidem doloribus
                explicabo quis! Officia, blanditiis?</p>
        </div>
        <div class="story">
            <h2 class="descriptionT">Description</h2>
            <p class="descriptionAV">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Laudantium sequi omnis nostrum accusantium quisquam
                corrupti culpa rerum itaque suscipit beatae aperiam, deleniti quidem quos id, voluptas voluptate repellendus
                quae a. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eligendi quaerat laudantium ut quidem,
                porro quisquam blanditiis recusandae a id, asperiores exercitationem iusto similique. Nam, nesciunt!
                Dolorum voluptate voluptatem quidem incidunt?</p>
        </div>
        <a href="<?= $aventure['linkYTB'] ?>" target="_blank" class="valid watrail">⯈ Watch Trailer</a>

    </div>
</div>
<div class="space"></div>

<h2 id="practical_information" class="titre1">Practical Information</h2>
<div class="picto">
    <div id="bring_along">
        <img src="img/details.svg" alt="details" loading="lazy" width="100%">
        <p><span class="bigger titre2" id="tobring">To Bring along</span><br>
            <span class="info1">Good footwear, a good mood and a thirst for adventure. Unfortunately, the adventures are not barrier-free</span>
        </p>
    </div>
    <div id="languages">
        <img src="img/languages.svg" alt="languages" loading="lazy" width="100%">
        <div>
            <p><span class="bigger titre3" id="lang">Languages</span></p>
            <ul id="language_list">
                <!--<li>English</li>
                <li>French</li>-->
            </ul>
        </div>
    </div>
    <div id="important">
        <img src="img/important.svg" alt="important information" loading="lazy" width="100%">
        <p><span class="bigger titre4" id="impo">Important Information</span><br><span class="info2">The locker is located in the parking lot of
                August-Meier-Wege in Ihringen.</span></p>
    </div>
    <div id="accessibility">
        <img src="img/disability.svg" alt="accessibility" loading="lazy" width="100%">
        <p><span class="bigger handi" id="access">Accessibility</span><br>
            <?php if ($aventure['accebilite'] == 0) {
                echo "<span id='ONhandi' data-onpark='No'>No</span>";
            } else if ($aventure['accebilite'] == 1) {
                echo "<span id='ONhandi' data-onpark='Yes'>Yes</span>";
            } else {
                echo "Error";
            }  ?>
        </p>
    </div>
    <div id="puzzle">
        <img src="img/puzzle.svg" alt="puzzle difficulty" loading="lazy" width="100%">
        <p><span class="bigger titre5" id="puzz">Puzzle difficulty</span><br><span class="info3">For puzzle fans</span></p>
    </div>
    <div id="route">
        <img src="img/run.svg" alt="route difficulty" loading='lazy' width="100%">
        <p><span class="bigger titre6" id="rd">Route difficulty</span><br><span class="info4">Easy walk</span></p>
    </div>
    <div id="duration">
        <img src="img/duration.svg" alt="duration" loading="lazy" width="100%">
        <p><span class="bigger titre7" id="dur">Duration</span><br><span class="durer1"></span><?= $aventure['duree'] ?><span class="durer2"></span></p>
    </div>
    <div id="target">
        <img src="img/team.svg" alt="target demographic" loading="lazy" width="100%">
        <p><span class="bigger titre8" id="tar">Target demographic</span><br><span class="info5">From three people, team events, stag
                parties, families with children aged 12 and over, birthdays, etc.</span></p>
    </div>
</div>
<div class="space"></div>
<h2 id="event_location_title" class="titre9">Event location</h2>

<div class="event_loc">
    <div id="infos">
        <div id="address">
            <img src="img/map.svg" alt="map" loading="lazy" width="100%">
            <p><span class="bigger titre10" id="address">Address</span> <br><?= $aventure['adresse'] ?></p>
        </div>
        <div id="location">
            <img src="img/pin.svg" alt="pin" loading="lazy" width="100%">
            <p><span class="bigger titre11" id="loca">Location / Meeting point</span><br><?= $aventure['localisation'] ?></p>
        </div>
        <div id="parking_space">
            <img src="img/parking.svg" alt="parking" loading="lazy" width="100%">
            <p><span class="bigger titre12" id="park">Parking space</span><br>
                <?php if ($aventure['parking'] == 0) {
                    echo "<span id='ONparking' data-onpark='No'>No</span>";
                } else if ($aventure['parking'] == 1) {
                    echo "<span id='ONparking' data-onpark='Yes'>Yes</span>";
                } else {
                    echo "No";
                } ?>
            </p>

        </div>
        <div id="train"><img src="img/train.svg" alt="train" loading="lazy" width="100%">
            <p><span class="bigger titre13" id="tra">Train stations & Bus stop</span><br><span class="info6">Ihringen station</span></p>
        </div>
    </div>
    <div id="map"></div>
</div>

<a href="index.php?action=FAQ" id="FAQ" class="question">Frequently Asked Questions</a>