<?php
require_once "modele/membre.class.php";
require_once "modele/aventure.class.php";
require_once "controleur/ctlAventure.class.php";
require_once "controleur/ctlCadeau.class.php";
require_once "vue/vue.class.php";

class ctlMembre{

    private $membre ;
    private $aventure;
    private $ctlAventure;
    private $ctlCadeau;
    
    private $traduction;

        /*******************************************************
    Initialise les variables contenant tous les fonctions du modele aventure, cadeau et membre a
    Initialise les varables contenant tous les methods du controleurs aventure et cadeau
    Inilialise le variable contenant la traduction
    Entrée : 

    Retour : 
    
    *******************************************************/

    public function __construct() {
        $this->membre = new membre();
        $this->aventure = new aventure();
        $this->ctlAventure = new ctlAventure();
        $this->ctlCadeau = new ctlCadeau();

        $this->traduction = include "donnees/data_message_trad.php";
    }

    //Instancie la vue login
    public function login($message = ''){
        $vue = new vue("Login"); // Instancie la vue appropriée
        $vue->afficher(array("message" => $message)); // Affiche la liste des clients dans la vue
    }

    //Instancie la vue logout
    public function logout(){
        $vue = new vue("Logout"); // Instancie la vue appropriée
        $vue->afficher(array()); // Affiche la liste des clients dans la vue
    }

    //Déconnecté l'utisateur et supprime les valeurs dans la session
    public function leave(){
        session_destroy();
        header("Location: index.php?action=login");
    }

    //Vérifie la cohérence des informations et retourne la liste des anomalies
    public function checkConnect(){
        extract($_POST);
        $message = "";

        if(!empty($mail)){
            if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",$mail)) $message .= $this->traduction['invalid_email_format'].'<br>';
        }
        else  $message .= $this->traduction['email_missing'].'<br>';
        if(empty($mdp)) $message .= $this->traduction['password_missing'].'<br>';

        return $message;
    }

    //Vérifie la cohérence des informatios et retourne la liste des anomalies
    public function checkCreate(){
        extract($_POST);
        $message = "";

        if(empty($firstName))$message.= $this->traduction['firstname_missinig']."<br>" ;
        if(empty($name))$message.= $this->traduction['name_missing']."<br>" ;
        if(!empty($mail)){
            if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",$mail)) $message .= $this->traduction['invalid_email_format'].'<br>';
        }
        else$message.= $this->traduction['email_missing']."<br>" ;
        if(empty($mdp))$message.= $this->traduction['password_missing']."<br>" ;
        if(empty($mdpCheck))$message.= $this->traduction['check_password_missing']."<br>" ;

        return $message ;
    }

    //Te connecte en membre ou admin si le formulaire est bien remplis
    public function connection()
    {   
        $message = $this->checkConnect();
        if(empty($message)){
            extract($_POST);
            $membre = $this->membre->getMembreLogin($mail,$mdp) ;
            if(!empty($membre))
                {
                    //crée une session
                    if($membre['role']== 'admin') {
                        $_SESSION['admin']= $membre['id_membre'];
                        $_SESSION['nom']= $membre['nom'];
                        $_SESSION['prenom']= $membre['prenom'];
                        header("Location: index.php?action=acceuilAdmin");
                    }
                    else if ($membre['role'] == 'client'){
                        $_SESSION['membre']= $membre['id_membre'];
                        $_SESSION['nom']= $membre['nom'];
                        $_SESSION['prenom']= $membre['prenom'];
                        header("Location: index.php?action=acceuilMembre");
                    }
                    else 
                        throw new Exception($this->traduction['bug_bdd']);
                }
            else {
                $message = $this->traduction['email_or_password_wrong'];
                $this->login($message);
            }
        }
        else {
            $this->login($message);
        }
    }


    //Crée un nouveau compte et te fais connecté
    public function newCompte(){

            $message = $this->checkCreate();
            if(empty($message)){
                extract($_POST);
                if($mdp == $mdpCheck){
                    if($this->checkMdp($mdp)){
                        //on check si l'email n'est pas déjà utilisé
                        if(!$this->membre->checkEmail($mail)){
                            if($this->membre->addMember($firstName,$name,$mail,$mdp)) {
                                $membre = $this->membre->getMembreLogin($mail,$mdp);
                                $_SESSION['membre']= $membre['id_membre'];
                                $_SESSION['nom']= $membre['nom'];
                                $_SESSION['prenom']= $membre['prenom'];
                                return header("Location: index.php?action=acceuilMembre");   
                        }
                    }
                    else $message = $this->traduction['registration_failed'];
                    }
                    else $message = $this->traduction['invalid_password_format'];
                    
                }
                else $message = $this->traduction['check_password_different_password'];
            }
        $this->login($message);
    }

    //Te connecte pour effectuer un achat
    public function connectToPay(){
        $message = $this->checkConnect();
        if(empty($message)){
            extract($_POST);
            $membre = $this->membre->getMembreLogin($mail,$mdp) ;
            if(!empty($membre))
                {   
                    //crée une session
                    if($membre['role']== 'client') {
                        $_SESSION['membre']= $membre['id_membre'];
                        $_SESSION['nom']= $membre['nom'];
                        $_SESSION['prenom']= $membre['prenom'];
                    }
                    else 
                        throw new Exception($this->traduction['bug_bdd']);
                }
            else {
                $message = $this->traduction['email_or_password_missing']."Mail ou mot de passe incorrecte";
            }
        if(isset($_SESSION['infoAventure']['id_game']))
        $this->ctlAventure->paiement($message);
        else if(isset($_SESSION['infoCadeau']['id_package']))
        $this->ctlCadeau->paiement($message);
    }}

    //Crée un compte membre pour payer
    public function createToPay(){
        $message = $this->checkCreate();
        if(empty($message)){
            extract($_POST);
            if($mdp == $mdpCheck){
                if($this->checkMdp($mdp)){
                    //on check si l'email n'est pas déjà utilisé
                    if(!$this->membre->checkEmail($mail)){
                        if($this->membre->addMember($firstName,$name,$mail,$mdp)) {
                            $membre = $this->membre->getMembreLogin($mail,$mdp);
                            $_SESSION['membre']= $membre['id_membre'];
                            $_SESSION['nom']= $membre['nom'];
                            $_SESSION['prenom']= $membre['prenom'];  
                    }
                }
                else $message = $this->traduction['registration_failed'];
                }
                else $message = $this->traduction['invalid_password_format'];
                
            }
            else $message = $this->traduction['check_password_different_password'];
        }

        if(isset($_SESSION['id_game']))
        $this->ctlAventure->paiement($message);
        else if(isset($_SESSION['id_package']))
        $this->ctlCadeau->paiement($message);
    }

    //Procède au étape du payement, instancie le bon méthode en fonction de l'achat
    public function nextToPay(){
        //Normalement ici on traite les info du cb attention à être en accord avec le RGPD et la proctetion des données
        //Dans le cas a nous, on a pas de vrais paiement mais il existe des api pour ça comme https://developer.squareup.com/fr/fr/online-payment-apis
        $_SESSION['infoCard'] = $_POST;

        if(isset($_SESSION['infoAventure']['id_game']))
        $this->ctlAventure->paiement();

        else if(isset($_SESSION['infoCadeau']['id_package']))
        $this->ctlCadeau->paiement();
    }

    //Prend les données du membre en question et instancie la vue acceuil quand on est connecté
    public function acceuilMembre()
    {
        $id_membre = $_SESSION['membre'];
        $infoMembre = $this->membre->getMembre($id_membre);
        $infoReservations = $this->aventure->getReservationsMembre($id_membre);
        $vue = new vue("AcceuilMembre"); // Instancie la vue appropriée
        $vue->afficher(array('membre'=>$infoMembre , 'reservations'=>$infoReservations)); 
    }

    //Prend les données des reservations d'un membre et instancie la vue des reservation
    public function reservationMembre($id_reservation,$message = ""){
        $id_membre = $_SESSION['membre'];
        $infoReservation = $this->aventure->getReservationMembre($id_membre,$id_reservation);
        $vue = new vue("ReservationMembre"); // Instancie la vue appropriée
        $vue->afficher(array('reservation'=>$infoReservation, "message"=>$message)); 
    }

    //Mets a jours la reservation pour indiqué qu'il y a une demande d'anulation de reservation
    public function annulerReservationMembre(){

        if($this->aventure->annulerReservation($_POST['id_reservation'])){
            $message = $this->traduction['send_request_revocation'];
        }
        else $message = $this->traduction['revocation_failed'];

        $this->reservationMembre($_POST['id_reservation'],$message);
    }

    //Prend les informations du compte d'un membre et instancie la vue compte
    public function infoCompte($message = ''){
        $id_membre = $_SESSION['membre'];
        $infoMembre = $this->membre->getMembre($id_membre);
        $vue = new vue("InfoCompte"); // Instancie la vue appropriée
        $vue->afficher(array('membre'=>$infoMembre,'message' => $message)); 
    }

    //Mets a jours les informations d'un compte
    public function updateCompteMembre(){
        $message = "";
        if(empty($_POST['prenom'])) $message .= $this->traduction['firstname_missing']."<br>";
        if(empty($_POST['nom'])) $message .= $this->traduction['name_missing']."<br>";
        if(empty($_POST['email'])) $message .= $this->traduction['email_missing']."<br>";
        if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",$_POST['email'])) $message .= $this->traduction['invalid_email_format'].'<br>';

        if(!empty($_POST['num_tel'])){
            require_once "includes/html/telephone.class.php" ;
            $checkTell = new telephone();
            if($checkTell->checkFormatNum($_POST['num_tel'])){
                $tel = $_POST['num_tel'];
            }
            else $message .= $this->traduction['invalid_tel_format']."<br>";
        }
        else $tel = NULL;

        if(empty($message)){
            $id_membre = $_SESSION['membre'];
            if($this->membre->updateCompte($_POST['prenom'],$_POST['nom'],$_POST['email'],$tel,$id_membre)) $message = $this->traduction['modification_succes'];
            else $message = $this->traduction['modification_failed'];
        }

        $this->infoCompte($message);
        
    }
    //Mets à jours le mot de passe d'un membre
    public function updatePwdMembre(){
        if(isset($_POST['mdp'])&&isset($_POST['mdpCheck'])&&!empty($_POST['mdp'])&&!empty($_POST['mdpCheck'])){
            if($this->checkMdp($_POST['mdp'])){
                if($_POST['mdp'] !=$_POST['mdpCheck']){
                    $message = $this->traduction['check_password_different_password'];
                }
            }
            else $message = $this->traduction['invalid_password_format'];
        }
        else $message = $this->traduction['invalid_password_format'];

        if(empty($message)){
            $id_membre = $_SESSION['membre'];
            if($this->membre->updatePwd($_POST['mdp'],$id_membre)){
                $message = $this->traduction['modification_succes'];
            }
            else $message = $this->traduction['modification_failed'];
        }

        $this->infoCompte($message);
    }

    //Vérifie les informations et retourne une liste d'anomalie
    public function checkMdp($mdp)
    {
        // Vérifier la longueur minimale
        if (strlen($mdp) < 8) {
            return false;
        }
        // Vérifier la présence d'au moins une lettre majuscule
        if (!preg_match("/[A-Z]/", $mdp)) {
        return false;
        }
        // Vérifier la présence d'au moins une lettre minuscule
        if (!preg_match("/[a-z]/", $mdp)) {
            return false;
        }
        // Vérifier la présence d'au moins un chiffre
        if (!preg_match("/[0-9]/", $mdp)) {
            return false;
        }
        // Vérifier la présence d'au moins un caractère spécial
        if (!preg_match("/[^a-zA-Z0-9]/", $mdp)) {
            return false;
        }
        // Si toutes les conditions sont remplies, retourner vrai
        return true;
    }

    //Instancie la vue acceuil pour les admin
    public function acceuilAdmin()
    {
        $vue = new vue("AcceuilAdmin"); // Instancie la vue appropriée
        $vue->afficher(array()); // Affiche la liste des clients dans la vue
    }
}