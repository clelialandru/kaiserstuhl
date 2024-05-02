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
    
    traduire(lg, donnees.PagePackageAdmin.Info);
    tradPlaceholder(lg, donnees.PagePackageAdmin.placeholder);
}


