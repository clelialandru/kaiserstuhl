// Créé une référence pour le modal
var modal = document.getElementById('myModal');
// pour toutes les images
var images = document.getElementsByClassName('myImg');
// les images dans le modal
var modalImg = document.getElementById("img01");
// et la description dans le modal

// Passe dans toutes les images contenant la classe myImg
for (var i = 0; i < images.length; i++) {
    var img = images[i];
    // et attache un event listener à l'image
    img.onclick = function (evt) {
        modal.style.display = "block";
        modalImg.src = this.src;
    }
} 
var span = document.getElementsByClassName("close")[0];
var close_pp = document.querySelector(".pp_close");

span.onclick = function () {
    modal.style.display = "none";
}