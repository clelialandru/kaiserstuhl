var donnees = "donnees/structure.json";

//récupérer les traductions
async function DonneesRecupe2() {
    let Rdonnees = await fetch(donnees);
    Rdonnees = await Rdonnees.json();
    return Rdonnees;

}
//partie à traduire
async function DonneesTraductionMain(lg) {  // lg = langue
    let donnees = await DonneesRecupe2();

    traduire(lg, donnees.PageReservationMembre);
    tradOuiNon(lg, donnees.details.oui_non, "ONparking");
    tradOuiNon(lg, donnees.details.oui_non, "ONhandi");
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

