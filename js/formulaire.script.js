// Récupère les divs concernées
const connect = document.querySelector(".connecter");
const creer = document.querySelector(".creer_compte");
const cre = document.querySelector("#signup");
const log = document.querySelector("#signin");

// Pour afficher le formulaire de connexion
function se_connecter() {
    connect.style.display = "block";
    creer.style.display = "none";
    log.classList.add("active");
    cre.classList.remove("active");

}

// Pour afficher le formulaire de création de compte
function creer_compte() {
    log.classList.remove("active");
    cre.classList.add("active");
    creer.style.display = "block";
    connect.style.display = "none";
}

// Affiché de base
function init_form() {
    log.classList.add("active");
    connect.style.display = "block";
    creer.style.display = "none";
}

init_form();
