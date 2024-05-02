var donnees = "donnees/structure.json";

//récupérer les traductions
async function DonneesRecupe2() {
    let Rdonnees = await fetch(donnees);
    Rdonnees = await Rdonnees.json();
    return Rdonnees;

}
//partie à traduire
async function DonneesTraductionMain(lg, idC) {  // lg = langue
    let donnees = await DonneesRecupe2();

    traduire(lg, donnees.Packages[parseInt(idC)]);
    traduire(lg, donnees.PagePackage);
}

function submitForms() {
    // Créer un formulaire dynamiquement
    var form = document.createElement('form');

    // Spécifier la méthode POST et l'URL du script PHP
    form.method = 'POST';
    form.action = 'index.php?action=paiement'; 


    var price = document.createElement('input');
    price.type = 'hidden';
    price.name = 'prix';
    price.value =  document.querySelector('#select_price').value;
    form.appendChild(price);

    var id_cadeau = document.createElement('input');
    id_cadeau.type = 'hidden';
    id_cadeau.name = 'id_package';
    id_cadeau.value =  document.querySelector('input[type="hidden"]').value;

    form.appendChild(id_cadeau);

    // Ajouter le formulaire à la page et le soumettre
    document.body.appendChild(form);
    form.submit();
}
