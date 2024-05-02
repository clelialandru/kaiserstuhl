<?php
require_once "modele/aventure.class.php";
require_once "vue/vue.class.php";

class ctlAccueil{

    private $aventure ;

        /*******************************************************
    Initialise les variables contenant tous les fonctions du modele aventure ainsi que la traduction
    Entrée : 

    Retour : 
    
    *******************************************************/
    
    public function __construct() {
        $this->aventure = new aventure();
    }

    //Prend les informations de 3 escapes games et instancie la vue accueil
    public function accueil(){
        $aventures = $this->aventure->getAventuresX(3);
        $vue = new vue("Accueil"); // Instancie la vue appropriée
        $vue->afficher(array("aventures" => $aventures)); 
    }


}