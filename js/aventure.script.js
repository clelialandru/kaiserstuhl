var donnees = "donnees/structure.json";

//récupérer les traductions
async function DonneesRecupe2() {
    let Rdonnees = await fetch(donnees);
    Rdonnees = await Rdonnees.json();
    return Rdonnees;

}
//partie à traduire
async function DonneesTraductionAv(lg, idG) {  // lg = langue
    let donnees = await DonneesRecupe2();

    traduire(lg, donnees.Aventures[parseInt(idG)].info);
    tradLangues(lg, donnees.Aventures[parseInt(idG)].infoLangues, donnees.details.langues);
    tradOuiNon(lg, donnees.details.oui_non, "ONparking");
    tradOuiNon(lg, donnees.details.oui_non, "ONhandi");
    traduire(lg, donnees.PageAdventure);
}

function tradLangues(lg, donnee, donLangTrad) {
    var repLang = "";
    donnee.forEach(langue => {
        switch (langue) {
            case "en":
                repLang += "<li>" + donLangTrad.en[lg] + "</li>";
                break;

            case "de":
                repLang += "<li>" + donLangTrad.de[lg] + "</li>";
                break;

            case "fr":
                repLang += "<li>" + donLangTrad.fr[lg] + "</li>";
                break;

            default:
                break;
        }
    });

    document.querySelector("#language_list").innerHTML = repLang;
}
function submitForms() {
    // Créer un formulaire dynamiquement
    var form = document.createElement('form');

    // Spécifier la méthode POST et l'URL du script PHP
    form.method = 'POST';
    form.action = 'index.php?action=paiement';

    // Créer les champs du formulaire pour chaque donnée à envoyer
    var appointmentDateInput = document.createElement('input');
    appointmentDateInput.type = 'hidden';
    appointmentDateInput.name = 'appointmentDate';
    appointmentDateInput.value = document.getElementById('book_date').value;
    form.appendChild(appointmentDateInput);

    var timeSlotInput = document.createElement('input');
    timeSlotInput.type = 'hidden';
    timeSlotInput.name = 'timeSlot';
    timeSlotInput.value = document.querySelector('input[name="time_slot"]:checked').value;
    form.appendChild(timeSlotInput);

    var infoSelect = document.querySelector('.custom-select-people').value;
    var parts = infoSelect.split('-');
    var prix = parts[0];
    var nbrPeople = parts[1];

    var numberOfPeopleInput = document.createElement('input');
    numberOfPeopleInput.type = 'hidden';
    numberOfPeopleInput.name = 'numberOfPeople';
    numberOfPeopleInput.value = nbrPeople;
    form.appendChild(numberOfPeopleInput);

    var price = document.createElement('input');
    price.type = 'hidden';
    price.name = 'prix';
    price.value = prix;
    form.appendChild(price);



    var id_escape_game = document.createElement('input');
    id_escape_game.type = 'hidden';
    id_escape_game.name = 'id_game';
    id_escape_game.value = document.querySelector('input[type="hidden"]').value;

    form.appendChild(id_escape_game);

    // Ajouter le formulaire à la page et le soumettre
    document.body.appendChild(form);
    form.submit();
}



function tradOuiNon(lg, donneeON, nomid) {
    let rep = "";
    var infoON = document.getElementById(nomid);
    var iON = infoON.dataset.onpark;
        switch (iON) {
            case "Yes":
                rep += donneeON["Yes"][lg];
                break;

            case "No":
                rep += donneeON["No"][lg];
                break;

            default:
                break;
        }

    document.getElementById(nomid).innerHTML = rep;
}