<?php
require_once "modele/infoGen.class.php";
require_once "vue/vue.class.php";



class ctlInfoGen
{


    private $infoGen;
    private $traduction;

        /*******************************************************
    Initialise les variables contenant tous les fonctions du modele aventure ainsi que la traduction
    Entrée : 

    Retour : 
    
    *******************************************************/

    public function __construct()
    {
        $this->infoGen = new infoGen();
        $this->traduction = include "donnees/data_message_trad.php";
    }

    public function infoGenAdmin($message = '')
    {
        $information = $this->infoGen->getInfoGen();
        $vue = new vue("InfoGenAdmin"); // Instancie la vue appropriée
        $vue->afficher(array("information" => $information, "message" => $message)); 
    }

    //Mets a jours les datas des informations général
    public function updateInfoGenAdmin()
    {
        extract($_POST);
        $message = '';

        if (empty($num_tel)) $message .= $this->traduction['num_tel_missing'].'<br>';
        else {
            require_once "includes/html/telephone.class.php";
            $telephone = new telephone();
            if (!$telephone->checkFormatNum($num_tel)) $message .= $this->traduction['invalid_tel_format']."<br>";
        }
        if (!filter_var($mail,FILTER_VALIDATE_EMAIL)) $message .= $this->traduction['email_missing'].'<br>';

        if (empty($adresse)) $message .= $this->traduction['address_missing'].'<br>';

        if (empty($message)) {
            if($this->infoGen->updateInfoGen($num_tel,$mail,$adresse)){
                $message = $this->traduction['data_send'];
                $this->infoGenAdmin($message);
            }
            else throw new Exception($this->traduction['failed_save_data']);

        } else {
            $this->infoGenAdmin($message);
        }
}}
