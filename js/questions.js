
var donnees = "donnees/structure.json";

//récupérer les traductions
async function DonneesRecupe() {
    let Rdonnees = await fetch(donnees);
    Rdonnees = await Rdonnees.json();
    return Rdonnees;

}
//partie à traduire
async function DonneesTraductionMain(lg) {  // lg = langue
    let donnees = await DonneesRecupe();
    traduire(lg, donnees.Questions);
}

/*/changement de langue
document.querySelectorAll("header>div>nav>div").forEach(div => {
    div.addEventListener("click", function () {
        DonneesTraductionMain(this.dataset.langue);
    });
});*/

function sizeEcran() {
    if (window.innerWidth<500) {
        return "310px";
    }
    else if (window.innerWidth<700) {
        return "200px";
    }
    else if (window.innerWidth<900) {
        return "186px";
    }
    else if (window.innerWidth<1000) {
        return "160px";
    }
    else if (window.innerWidth>1000) {
        return "130px";
    }
}

async function AfficheQuestions() {  // lg = langue
    let donnees = await DonneesRecupe();
    let nbrQ = (Object.keys(donnees.Questions).length-1)/2;

    for (let i = 1; i < nbrQ; i++) {
        document.querySelector(".questions").appendChild(template_Questions(i));
    }
}



//créer les questions
function template_Questions(i) {
    // Création du conteneur
    let div = document.createElement("div");


    // Ajout des attributs
    div.className = "question";


    // Insertion du contenu
    div.innerHTML = `<button type="button" class="collapsible"><span class="question${i}"></span> <img class="Picone" src="images_ke/flecheQ.svg"></button>
                    <div class="content">
                        <p class="reponse${i}"></p>
                    </div>`;

    div.querySelector(".content").style.height = "0px";

    // Gestion des événements     ${groupe.group_name}
    div.querySelector(".collapsible").addEventListener("click", function() {
        this.classList.toggle("active");
        this.querySelector('.Picone').classList.toggle('retourneF');
        var content = this.nextElementSibling;
        let sizeRep = sizeEcran();
        if (content.style.height === sizeRep) {
        content.style.height= "0px";
        } else {
        content.style.height = sizeRep;
        }
    });


    // Renvoie du conteneur
    return div;
}





