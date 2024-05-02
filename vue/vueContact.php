<?php

$titre = 'Contact';
$style = '<link rel="stylesheet" href="style/contact.style.css">';
$script = '<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js">
</script>';
$script .= "<script>
    (function() {
        emailjs.init('_-5DOc2pS5qSKqiT4');
    })();

    function envoieMail() {
        var Nom = document.getElementsByName('nom')[0].value;
        var Message = document.getElementsByName('text_mail')[0].value;
        var Mail = document.getElementsByName('mail')[0].value;
        var Sujet = document.getElementsByName('subject')[0].value;
        var Phone = document.getElementsByName('phone')[0].value;

        var p = document.getElementById('status');

        var templateParams = {
            name: Nom,
            notes: Message,
            email: Mail,
            objet: Sujet,
            phone: Phone,
        };

        emailjs.send('service_lmmlcai', 'template_jebthdn', templateParams)
            .then(function(response) {
                p.textContent = 'Message envoyé'
                console.log('SUCCESS!', response.status, response.text);
            }, function(error) {
                p.textContent = 'Erreur lors de l\'envoi du message'
                console.log('FAILED...', error);
            });

    }
</script>";
$script .= '<script src="js/contact.js"></script>';
?>

<div class="landing_contact">
    <div class="text">
        <h1 class="texte1"></h1>
        <p class="texte2">
        </p>
    </div>

</div>

<h2 class="title_p texte3"></h2>
<div class="faq_link">
    <p class="texte4">
    </p>
    <a href='index.php?action=FAQ' class="button_orange">
        <p class="texte5">Check it out!</p>
    </a>
</div>


<form onsubmit="envoieMail(); return false;">
    <?php
    require_once "includes/html/formulaire.class.php";
    $form  = new formulaire($_POST);
    echo $form->inputText("nom", "Surname");
    echo $form->inputMail("mail", "Email");
    echo $form->select_subject_mail('subject', "Subject");
    echo $form->inputText('phone', "Phone Number", FALSE);
    echo $form->inputTextArea('text_mail', "Your issue");
    echo $form->submit("ok", 'SUBMIT');
    ?>
</form>
<p id="status"></p>

<div class="phone_mail">
    <div class="mail">
        <img src="img/mail.svg" alt="mail" loading="lazy">
        <p>
            <?= $infoGen[0]['mail'] ?>
        </p>
    </div>
    <div class="phone">
        <img src="img/phone.svg" alt="phone" loading="lazy">
        <p>
            <?= $infoGen[0]['num_tel'] ?>
        </p>
    </div>
    <div class="adresse">
        <?= $infoGen[0]['adresse'] ?>
    </div>
</div>