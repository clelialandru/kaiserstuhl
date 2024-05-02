<?php
$style = '<link rel="stylesheet" href="style/paiment.style.css">';
$script = '<script src="js/formulaire.script.js"></script>
<script src="js/paiement.script.js"></script>
<script>
    DonneesTraductionMain(localStorage.getItem("lang"));
</script>';




if (empty($_SESSION['infoReservation']) && isset($infoReservation)) $_SESSION['infoReservation'] = $infoReservation;
if (empty($_SESSION['infoAventure']) && isset($infoAventure)) $_SESSION['infoAventure'] = $infoAventure;

if (empty($_SESSION['infoCommande']) && isset($infoCommande)) $_SESSION['infoCommande'] = $infoCommande;
if (empty($_SESSION['infoCadeau']) && isset($infoCadeau)) $_SESSION['infoCadeau'] = $infoCadeau;

//if (isset($infoAventure) && isset($infoReservation)) var_dump($infoReservation, $infoAventure);
//if (isset($infoCadeau) && isset($infoCommande)) var_dump($infoCommande, $infoCadeau);

?>

<h1 class="book_title">Payement Page</h1>
<aside>
    <div class="cart">
        <img src="img/cart.svg" loading="lazy" alt="cart icon" width="100%" class="svg_aside">
        <h3 id="cart">Cart</h3>
    </div>
    <div class="product_list">
        <h3 id="prod">Products</h3>
        <?php
        $infos = '<div class="flex"><div class="infos">';
        // Si c'est une réservation
        $subtotal = 0;
        if (isset($infoReservation) && isset($infoAventure)) {
            $nb_people = $infoReservation['numberOfPeople'];
            // Nom de l'escape game
            $infos .= "<p id='name'>";
            $infos .= $infoAventure['nom'] . "</p>";
            // Nombre de personnes qui participent à l'escape game
            $infos .= "<p id='nb_peo'>";
            if ($nb_people == 1) {
                $prix_f = $infoReservation['prix'];
                $subtotal += $prix_f;
                $infos .= "<span id ='for'>For</span> 1 <span id ='person'>person</span>";
            } else if ($nb_people > 1 && $nb_people < 13) {
                $prix = $infoReservation['prix'];
                $nb = $infoReservation['numberOfPeople'];
                $prix_f = $prix * $nb - (1 * $nb);
                $subtotal += $prix_f;
                $infos .= "<span id ='foragroup'>For a group of </span>";
                $infos .= $nb_people;
                $infos .= "<span id = 'people'> people </span>";
            } else if ($nb_people == 13) {
                $prix = $infoReservation['prix'];
                $nb = $infoReservation['numberOfPeople'];
                $prix_f = $prix * $nb - (1 * $nb);;
                $subtotal += $prix_f;
                $infos .= "<span id = 'foragroupofmore'> For a group of more than 12 people</span>";
            }
            $infos .= "</p>";
            // Date et horaire
            $date = date_create($infoReservation['appointmentDate']);
            $d = date_format($date, 'd/m/Y'); // Formatage de la date de la réservation
            $infos .= "<div class='app_d_h'><div class='date'>
            <img src= 'img/calendar.svg' loading='lazy' width='100%' id='calendar' alt ='calendar' class='svg_aside'>
            <p id='date'>";
            $infos .= $d;
            $infos .= "</p></div>
            <div class='hour'>
            <img src='img/clock.svg' loading='lazy' width='100%' id='clock' alt='clock' class='svg_aside'>";
            $infos .= $infoReservation['timeSlot'];
            $infos .= "</div>
            </div></div>
            <img src = '" . $infoAventure["chemin_photo_PP"][0] . "' loading='lazy' width='100%' alt='" . $infoAventure['nom'] . " cover' class='cover'>
            </div>";
            $infos .= '<div class="prix">' . $prix_f . " €</div>";

            $infos .= "<div class='subt'>
            <h3 id='subtotal'>Subtotal</h3><p id='sub_price'>" . $subtotal . " €</p></div>";
            //var_dump($infoAventure);
            //var_dump($infoReservation);
        }

        if (isset($infoCommande)) {
            $prix_f = $infoCadeau['prix'];
            $subtotal = $prix_f;

            $infos .= "<p id='name_pack'>";
            $infos .= $infoCadeau['nom'] . "</p>";
            if ($infoCadeau['id_package'] > 1) {
                $infos .= "<div class='app_d_h'><div class='date'>
            <img src= 'img/calendar.svg' loading='lazy' width='100%' id='calendar' alt ='calendar' class='svg_aside'>
            <p id='deliv_time'>Delivery time : ";
                $infos .= $infoCadeau['temps_livré'];
                if ($infoCadeau['temps_livré'] > 1) {
                    $infos .= " days";
                }
                $infos .= "</p></div>";
            }
            $infos .= "<img src = '" . $infoCadeau["chemin_photo_PP"][0] . "' loading='lazy' width='100%' alt='" . $infoCadeau['nom'] . " cover' class='cover'>";
            $infos .= '<div class="prix">' . $prix_f . " €</div>";

            $infos .= "<div class='subt'>
            <h3 id='subtotal'>Subtotal</h3><p id='sub_price'>" . $subtotal . " €</p></div>";
        } // Si c'est un cadeau


        //var_dump($infoCadeau);

        echo $infos;
        ?>
    </div>
</aside>

<?php
//d'abord on demande de se connecter
$zoneConnect = '
<div>
    <div class="formulaires">
    <div class="flex_button">
    <h2 id="prvv">Pour reserver veuillez vous connectez :</h2>
        
            <button onclick=\'se_connecter()\' class="button_login signin" id="signin">Sign In</button></div><div class="connect"> ';
if (!empty($message))
    $zoneConnect .= "<div class='message'>" . $message . "</div>";
$zoneConnect .= '
            <form method="post" action="index.php?action=connectToPay" class="connecter">';
if (!empty($message))
    $zoneConnect .= "<div class='message'>" . $message . "</div>";

require_once "includes/html/formulaire.class.php";

$forms = new formulaire($_POST);

$zoneConnect .= $forms->inputMail('mail', 'Email');
$zoneConnect .= $forms->inputPassword('mdp', 'Password');
$zoneConnect .= $forms->submit('ok', 'submit');

$zoneConnect .= '
            </form>
        </div>
        <div class="flex_button">
        <h2 id="pasCompte">Vous n\'avez pas encore de compte ? Inscrivez vous !</h2>
            <button onclick=\'creer_compte()\' class="button_login signup" id="signup">Sign Up</button></div>
            <div class="create">
            <form method="post" action="index.php?action=createToPay" class="creer_compte">';

$forms = new formulaire($_POST);

$zoneConnect .= $forms->inputText('firstName', "First Name");
$zoneConnect .= $forms->inputText('name', 'Name');
$zoneConnect .= $forms->inputMail('mail', 'Email');
$zoneConnect .= $forms->inputPassword('mdp', 'Password');
$zoneConnect .= $forms->inputPassword('mdpCheck', 'Confirm your password');
$zoneConnect .= $forms->submit('ok', 'SUBMIT');

$zoneConnect .= '
            </form>
        </div>
    </div>
</div>';

$zoneInfoPaiement = "<div><h2 id='pay_det'>Enter your payement details</h2>
<div class='payement_methods'>
<img src='img/credit_card.svg' loading='lazy' width='100%' class='pay_met' alt='credit card'>
<img src='img/paypal.svg' loading='lazy' width='100%' class='pay_met' alt='paypal'>
<img src='img/google_pay.svg' loading='lazy' width='100%' class='pay_met' alt='google pay'>
<img src='img/apple_pay.svg' loading='lazy' width='100%' class='pay_met' alt='apple pay'>

</div>
<div><form method='post' action='index.php?action=nextToPay'>";

$zoneInfoPaiement .= $forms->inputNum("numCard", "Card number");
$zoneInfoPaiement .= $forms->inputText("streetAdress", "Street Adress");
$zoneInfoPaiement .= $forms->inputText("appartement", "Appartement,Suite,Unit (optional)", FALSE);
$zoneInfoPaiement .= $forms->inputText("country", "Country");
$zoneInfoPaiement .= $forms->inputText("city", "City");
$zoneInfoPaiement .= $forms->inputText("state", "State");
$zoneInfoPaiement .= $forms->inputText("ZIP", "ZIP Code");
$zoneInfoPaiement .= $forms->submit2("next", "next");

$zonePayer = '<div class="warning_pay_q"><h2 id="pay_q">Do you want to pay?</h2>
<p id="pay_exp">By pressing the button below, you will accept our <a href="index.php?action=cgv" class="link" target="_blank">Terms and conditions of sale</a>.
<br>Please make sure you have filled the elements of the form correctly. You will also be able to cancel your booking at any time.
If you have any questions about the escape games, please check out our <a href="index.php?action=contact" class="link" target="_blank">contact form</a> 
and our <a href="index.php?action=FAQ" class="link" target="_blank">FAQ</a> </p>
    <div>
        <form method="post" action="index.php?action=payer" onsubmit="return confirm(\'Êtes-vous sûr de vouloir payer ?\');">';
$zonePayer .= $forms->submit3("payer", "Payer ?");
$zonePayer .= '
        </form>
    </div></div>';


if (empty($_SESSION['membre'])) {
    echo $zoneConnect;
} else if (empty($_SESSION['infoCard'])) {
    echo $zoneInfoPaiement;
} else echo $zonePayer;
