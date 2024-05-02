<?php
require_once "modele/infoGen.class.php";
require_once "vue/vue.class.php";

class ctlPage{

    private $infoGen;

        /*******************************************************
    Initialise les variables contenant tous les fonctions du modele infoGen
    Entrée : 

    Retour : 
    
    *******************************************************/

    public function __construct() {
        $this->infoGen = new infoGen();
    }

    //Instancie la vue contact
    public function contact(){
        $infoGen = $this->infoGen->getInfoGen();

        $vue = new vue("Contact"); // Instancie la vue appropriée
        $vue->afficher(array("infoGen"=>$infoGen)); 
    }

    //Instancie la vue FAQ
    public function FAQ(){
        $vue = new vue("FAQ"); // Instancie la vue appropriée
        $vue->afficher(array()); 
    }


    //Instancie la vue erreur
    public function erreur($message){
        $vue = new vue("Erreur"); // Instancie la vue appropriée
        $vue->afficher(array("message"=> $message)); 
    }

    //Instancie la vue mention légal
    public function mentleg(){
        $vue = new vue("MentLeg"); // Instancie la vue appropriée
        $vue->afficher(array()); 
    }

    //Instancie la vue politique confidentialité
    public function confidentiality(){
        $vue = new vue("PolConf"); // Instancie la vue appropriée
        $vue->afficher(array()); 
    }

    //Instancie la vue cgv
    public function cgv(){
        $vue = new vue("CGV"); // Instancie la vue appropriée
        $vue->afficher(array()); 
    }


}