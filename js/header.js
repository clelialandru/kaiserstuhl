var donnees = "donnees/structure.json";
var params = new URLSearchParams(window.location.search);
var action = params.get('action');
var regex = /Admin$/ ;

if(regex.test(action)){
    isAdmin = 'Admin'
}
else {
    isAdmin = 'noAdmin';
}

if (localStorage.getItem("lang")== null) {
    localStorage.setItem("lang", "en");
}

//récupérer les traductions
async function DonneesRecup() {
    let Rdonnees = await fetch(donnees);
    Rdonnees = await Rdonnees.json();
    return Rdonnees;
}

//partie à traduire
async function DonneesTraduction(lg) {  // lg = langue
    let donnees = await DonneesRecup();

    if(isAdmin == 'Admin')
        traduire(lg, donnees.header.Admin);
    else 
        traduire(lg,donnees.header.notAdmin)

    traduire(lg, donnees.footer);
}



//récupérer les traductions
async function DonneesRecup() {
    let Rdonnees = await fetch("donnees/structure.json");
    Rdonnees = await Rdonnees.json();
    return Rdonnees;
}

//afficher la traduction
function traduire(lg, donnee) {
    for (let key in donnee) {
        document.querySelectorAll(`${key}`).forEach(nomClass => {
            nomClass.innerHTML = donnee[key][lg];
        });
        
    }
}

//afficher la traduction
function tradPlaceholder(lg, donnee) {
    for (let key in donnee) {
        document.getElementsByName(`${key}`).forEach(nomName => {
            nomName.placeholder=donnee[key][lg];
        });
    }
}

DonneesTraduction(localStorage.getItem("lang"));


function langSelect(localLg) {
    let url = document.querySelector("#lg1").href;
    url = url.substring(0, url.length - 2);

    let menuLang = "";
    switch (localLg) {
        case "en":
            menuLang = `<a href="${url}de" id="lg1" class="langue" data-langue="de">DE</a>
                        <a href="${url}en" data-langue="en">EN <img class="Picone" src="img/fleche.svg" loading="lazy"></a>
                        <a href="${url}fr" class="langue"  data-langue="fr">FR</a>`;
            break;
        case "de":
            menuLang = `<a href="${url}en" id="lg1" class="langue" data-langue="en">EN</a>
                        <a href="${url}de" data-langue="de">DE <img class="Picone" src="img/fleche.svg" loading="lazy"></a>
                        <a href="${url}fr" class="langue"  data-langue="fr">FR</a>`;
            break;
        case "fr":
            menuLang = `<a href="${url}de" id="lg1" class="langue" data-langue="de">DE</a>
                        <a href="${url}fr" data-langue="fr">FR <img class="Picone" src="img/fleche.svg" loading="lazy"></a>
                        <a href="${url}en" class="langue"  data-langue="en">EN</a>`;
            break;
    
        default:
            break;
    }

    document.querySelector("#choixlang").innerHTML = menuLang;
}

langSelect(localStorage.getItem("lang"));

//changement de langue
document.querySelectorAll("header>div>nav>a").forEach(div => {
    div.addEventListener("click",function() {
        localStorage.setItem("lang", this.dataset.langue);
    });
});




/*

puzzle

                    "en": "Perfect for puzzle beginners",
   facile           "fr": "Parfait pour les débutants en puzzles",
                    "de": "Perfekt für Puzzleanfänger"

                    "en": "For puzzle fans",
   moyen            "fr": "Pour les amateurs de puzzles",
                    "de": "Für Rätselfans"

                    "en": "For puzzle lovers",
   difficile        "fr": "Pour les passionnés de puzzles",
                    "de": "Für Puzzlebegeisterte"


marche

                    "en": "Easy walk",
   facile           "fr": "Marche facile",
                    "de": "Leichter Spaziergang"

                    "en": "Moderate walk",
   moyen            "fr": "Marche modérée",
                    "de": "Mäßiges Gehen"

                    "en": "Advanced walk",
   difficile        "fr": "Marche avancée",
                    "de": "Fortgeschrittener Marsch"
*/
