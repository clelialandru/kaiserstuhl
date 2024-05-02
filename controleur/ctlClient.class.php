<?php
require_once "modele/client.class.php";
require_once "vue/vue.class.php";

class ctlClient {

    private $client  ;

    /*******************************************************
    Initialise le $clients qui est un objet contenant tous les clients
    Entrée : 

    Retour : 
    
    *******************************************************/


    public function __construct() {
        $this->client = new client();
    }

    /*******************************************************
    Affichage de la liste des clients dans la vue concernée
    Entrée : 

    Retour : 
    
    *******************************************************/
    public function clients() {

        $clients = $this->client->getClients();
        $vue = new vue("Clients"); // Instancie la vue appropriée
        $vue->afficher(array("clients" => $clients)); // Affiche la liste des clients dans la vue
    
    }

    public function ajoutClient($message=''){
        $vue = new vue("ajoutClient");
        $vue->afficher(array("message"=>$message)); // Affiche la liste des clients dans la vue
    }

    public function enregClient(){
        extract ($_POST);

        $message = "";

        if (empty($nom)) $message.= "Veuillez indiquer un nom<br>";
        if (empty($prenom)) $message.= "Veuillez indiquer un prenom<br>";
        if (empty($age)) $message.= "Veuillez indiquer un age<br>";
        if (empty($adresse)) $message.= "Veuillez indiquer une adresse<br>";
        if (empty($ville)) $message.= "Veuillez indiquer une ville<br>";
        if (!filter_var($mail,FILTER_VALIDATE_EMAIL)) $message.= "Veuillez indiquer une adresse mail<br>";

        if (empty($message)){
            if($this->client->insertClient($nom,$prenom,$age,$adresse,$ville,$mail))
                $this->clients();
            else throw new Exception("Echec de l'enrengistrement du nouveau client");
            
        }
        else {
            $this->ajoutClient($message);           
        }

        }




    

}