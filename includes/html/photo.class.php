<?php

//ici on va faire l'algo pour les photo

class photo {

    //Retourne la photo principale :
    function getPPAventure($id_game){
        $cheminPP = "img/escape_game/". $id_game ."/PP" ;

        $photos = glob($cheminPP . "/*");
        return $photos;
    }


    function getPhotosAventure($id_game){
        $cheminEscapeGame = "img/escape_game/" . $id_game;
    
        // Recherche tous les fichiers dans le dossier de l'escape game
        $photos = glob($cheminEscapeGame . "/*.{jpg,jpeg,png,webp}", GLOB_BRACE);
        
        return $photos;
    }

    function getPPPackage($id_package){
        $cheminPP = "img/package/". $id_package ."/PP" ;

        $photos = glob($cheminPP . "/*");
        return $photos;
    }

    function getPhotosPackage($id_package){
        $cheminEscapeGame = "img/package/" . $id_package;
    
        // Recherche tous les fichiers dans le dossier de l'escape game
        $photos = glob($cheminEscapeGame . "/*.{jpg,jpeg,png,webp}", GLOB_BRACE);
        
        return $photos;
    }
}