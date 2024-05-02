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

    traduire(lg, donnees.PageAdventures);
    traduireCardEscape(lg, donnees.Aventures);
}

//afficher la traduction
function traduireCardEscape(lg, donnee) {
    var titreV = {".descriptionAV": "yt", ".info3": "er" };
    for (let key in donnee) {
        for (let key2 in titreV) {
            document.querySelectorAll(`${key2}${key}`).forEach(nomClass => {
                nomClass.innerText = donnee[key].info[key2][lg];
            });

            
        }


        document.querySelectorAll(`descriptionAV${key}`).forEach(nomClass => {
            nomClass.innerText = donnee[key].info.descriptionAV[lg];
            //console.log(donnee[key].info.descriptionAV[lg])
        });
    }
}

