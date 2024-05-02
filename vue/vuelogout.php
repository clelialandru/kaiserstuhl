<div class="space"></div>
<?php
$style = '<link rel="stylesheet" href="style/logout.style.css">';
$script = '<script src="js/logout.script.js"></script>
<script>
    DonneesTraductionMain(localStorage.getItem("lang"));
</script>';
$titre = 'Logout?';

?>

<div class="warning">Do you wish to log out?</div>
<div class="flex_button">
    <a href="index.php?action=leave" class="button yes">Yes</a>
    <?php
    if (isset($_SESSION['admin'])) {
        echo '<a href="index.php?action=acceuilAdmin" class="button no">No</a>';
    } else {
        echo '<a href="index.php?action=acceuilMembre" class="button no">No</a>';
    }


    ?>
</div>