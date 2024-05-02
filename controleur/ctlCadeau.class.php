<?php
require_once "modele/cadeau.class.php";
require_once "vue/vue.class.php";

class ctlCadeau{


    private $cadeau ;
    private $traduction;
    /*******************************************************
    Initialise les variables contenant tous les fonctions du modele cadeau ainsi que la traduction
    Entrée : 

    Retour : 
    
    *******************************************************/


    public function __construct() {
        $this->cadeau = new cadeau();

        $this->traduction = include "donnees/data_message_trad.php";
    }

    public function cadeaux(){
        $cadeaux = $this->cadeau->getCadeauxPuzzle();
        $vue = new vue("Cadeaux"); // Instancie la vue appropriée
        $vue->afficher(array("cadeaux" => $cadeaux)); 
    }

    public function cadeau($id_cadeau){
        $cadeau = $this->cadeau->getCadeau($id_cadeau);

        if (!empty($cadeau)){
            $vue = new vue("Cadeau"); // Instancie la vue appropriée
            $vue->afficher(array("cadeau"=>$cadeau));           
        }
        else
        throw new Exception("Echec de l'affichage du cadeau N°$id_cadeau");

    }

    public function coupons(){
        $cadeau = $this->cadeau->getCoupon();
        $vue = new vue("Cadeau"); // Instancie la vue appropriée
        $vue->afficher(array('cadeau'=>$cadeau)); // Affiche les info d'un cadeau dans la vue       
    }

    public function paiement($message = ""){
        if(isset($_SESSION['infoCommande'])) $infoCommande = $_SESSION['infoCommande'];
        else $infoCommande = $_POST;
        if(isset($_SESSION['infoCadeau'])) $infoCadeau = $_SESSION['infoCadeau'];
        else $infoCadeau = $this->cadeau->getCadeau($_POST['id_package']);

        $vue = new vue("Paiement");
        $vue->afficher(array("infoCommande"=>$infoCommande, "infoCadeau" => $infoCadeau, "message"=>$message));

    }

    public function payer(){

        //Ici normalement on traite les donnés du cb pour s'assurer que c'est bien un vrai etc


        //On prend les info qui nous interresse pour déclarer la commande :
        $id_membre = $_SESSION['membre'];
        $id_package = $_SESSION['infoCadeau']['id_package'];
        $temps_livré = $_SESSION['infoCadeau']['temps_livré'];
        $tempsAddition = "P". strval($temps_livré)  . "D";

        $date = new DateTime(); // Création d'un objet DateTime représentant la date actuelle
        $date->add(new DateInterval($tempsAddition)); // Ajout de 20 jours à la date actuelle
        $dateFormat =  $date->format('Y-m-d'); // Affichage de la nouvelle date au format YYYY-MM-DD
        


        $prix = floatval($_SESSION['infoCadeau']['prix'])  + floatval($_SESSION['infoCommande']['prix']);

        $adresse = $_SESSION['infoCard']['streetAdress']. " " . $_SESSION['infoCard']['city']. " ". $_SESSION['infoCard']['country'];

        //On supprimer les info du session car plus besoin
        unset($_SESSION['infoCard']);
        unset($_SESSION['infoCadeau']);
        unset($_SESSION['infoCommande']);

        $this->cadeau->addCommande($id_membre,$id_package,$dateFormat,$adresse,$prix);

        //Une fois fini on l'envoie a la page acceui membre connecté
        header("Location: index.php?action=acceuilMembre");

    }

    public function cadeauxAdmin($message=''){
        $cadeaux = $this->cadeau->getCadeauxPuzzle();
        $vue = new vue("CadeauxAdmin"); // Instancie la vue appropriée
        $vue->afficher(array("cadeaux" =>$cadeaux, "message"=>$message)); // Affiche la liste des aventures dans la vue
    }

    public function cadeauAdmin($id_cadeau,$message=''){
        $cadeau = $this->cadeau->getCadeau($id_cadeau);
        $jsonData = file_get_contents('donnees/structure.json');
        $data = json_decode($jsonData, true);

        $dataCadeau = $data['Packages'][$id_cadeau];

        if (!empty($cadeau)){
            $vue = new vue("CadeauAdmin"); // Instancie la vue appropriée         
            $vue->afficher(array("cadeau"=>$cadeau,"dataCadeau" => $dataCadeau, "message"=>$message)); // Affiche les info d'un cadeau dans la vue            
        }
        else
        throw new Exception($this->traduction['failed_get_id_package'] . $id_cadeau);

    }

    public function checkInfo(){
        extract($_POST);
        $message = "";

        if (empty($nom)) $message .= $this->traduction['name_missing'] .'<br>';
        if (empty($descriptionEN)) $message .= $this->traduction['description_en_missing'] .'<br>';
        if (empty($descriptionFR)) $message .= $this->traduction['description_fr_missing'] .'<br>';
        if (empty($descriptionDE)) $message .= $this->traduction['description_de_missing'] .'<br>';
        if(!empty($hauteur)){
            if($hauteur < 0)$message .= $this->traduction['failed_hauteur_format'] .'<br>';
        }
        if(!empty($largeur)){
            if($largeur < 0)$message .= $this->traduction['failed_largeur_format'] .'<br>';
        }
        else $message .= $this->traduction['hauteur_missing'] ."<br>";
        if (!empty($prix)){
            if (!preg_match('/^\d+(,\d{0,2}|\.\d{0,2})?$/', $prix))
            $message .= $this->traduction['largeur_missing'] ."<br>" ;
        }
        else $message .= $this->traduction['price_missing'] .'<br>';
        if (empty($temps_livré)) $message .= $this->traduction['tps_livre_missing'] .'<br>';


        return $message;
    }

    public function checkPhoto(){
        $message = '';
        extract($_FILES);

        if(isset($nouvelle_photo_profil) && $nouvelle_photo_profil['size']>0){
            if($nouvelle_photo_profil['error']==0){
                if($nouvelle_photo_profil['size']>5000000) $message .= $this->traduction['photo_pp_lourd'] ."<br>";
            }else $message .= $this->traduction['failed_send_photo_pp'] ."<br>";
        }

        if(isset($nouvelles_photos) && $nouvelles_photos['size'][0]>0){
            foreach($nouvelles_photos['error'] as $index => $value){
                if($value != 0){
                    $nom_file = $nouvelles_photos['name'][$index];
                    $message .= $this->traduction['failed_send_photo']  . $nom_file . "<br>";
                }
            }

            foreach($nouvelles_photos['size'] as $index => $value){
                if($value > 5000000){
                    $nom_file = $nouvelles_photos['name'][$index];
                    $message .= $this->traduction['photo_lourd_part1']  . $nom_file . $this->traduction['photo_lourd_part2']."<br>";
                }
            }

            foreach($nouvelles_photos['type'] as $index => $value){
                if(!preg_match('/^image\/(png|jpg|webp)$/i',$value)){
                    $nom_file = $nouvelles_photos['name'][$index];
                    $message .= $nom_file .$this->traduction['photo_wrong_format']  . "<br>";
                }
            }
        }

        if(isset($photos_a_supprimer) && !empty($photos_a_supprimer)){
            if(!file_exists($photos_a_supprimer)){
                $message .= $this->traduction['failed_find_photo_del']  ."<br>";
            }
        }

        return $message ;
    }

    public function updateCadeauAdmin()
    {
        extract($_POST);
        $message = '';

        if(empty($id_package)) throw new Exception($this->traduction['missing_id_package'] );

        

        if(isset($info)){
            $message .= $this->checkInfo();
            if (empty($message)) {
                $this->cadeau->updateCadeau($nom,$prix,$temps_livré,$hauteur,$largeur,$id_package);
                if ($this->cadeau->insertAndUpdateCadeauAdminJSON($id_package,$descriptionEN,$descriptionFR,$descriptionDE)) {
                    $message = $this->traduction['data_send'];
                    $this->cadeauAdmin($id_package,$message);
                } else {
                    throw new Exception($this->traduction['failed_data_send']);
                }


                $this->cadeauAdmin($id_package,$message);
            } else {
                $this->cadeauAdmin($id_package,$message);
            }}
        else if(isset($photo)){
            $message .= $this->checkPhoto();
            if(empty($message)){
                extract($_FILES);
                //ici on va s'occuper du traitement de photo

                if(isset($nouvelle_photo_profil) && !empty($nouvelle_photo_profil) && $nouvelle_photo_profil['size']>0){
                    if($this->cadeau->addCadeauPP($nouvelle_photo_profil,$id_package));
                    else throw new Exception($this->traduction['failed_photo_pp_save']);
                }

                if(isset($nouvelles_photos) &&  !empty($nouvelles_photos) && $nouvelles_photos['size'][0]>0){
                    if($this->cadeau->addCadeauPhotos($nouvelles_photos,$id_package));
                    else throw new Exception($this->traduction['failed_photo_save']);
                }

                if(isset($photos_a_supprimer)){
                    if($this->cadeau->delCadeauPhotos($photos_a_supprimer,$id_package));
                    else throw new Exception($this->traduction['failed_del_photo']);
                }

                $message .= $this->traduction['change_succes'];
            }
        }else $message .= $this->traduction['bug_form'];

        $this->cadeauAdmin($id_package,$message);

    }

    public function addCadeauAdmin($message=''){
        $vue = new vue("AddCadeauAdmin"); // Instancie la vue appropriée         
        $vue->afficher(array("message"=>$message)); // Affiche les info d'un cadeau dans la vue    
    }

    public function insertCadeauAdmin()
    {
        extract($_POST);
        extract($_FILES);
        $message = '';

        $message .= $this->checkInfo();
        $message .= $this->checkPhoto();

        if (empty($message)) {
            $resultatInsertCadeau = $this->cadeau->insertCadeau($nom,$prix,$temps_livré,$hauteur,$largeur);
            if($resultatInsertCadeau['succes']){
                $id_package = $resultatInsertCadeau['id_package'];
                if(!$this->cadeau->addCadeauPP($nouvelle_photo_profil,$id_package)) throw new Exception($this->traduction['failed_insert_package']);
                if(!$this->cadeau->addCadeauPhotos($nouvelles_photos,$id_package))throw new Exception($this->traduction['failed_insert_package']);

                if ($this->cadeau->insertAndUpdateCadeauAdminJSON($id_package,$descriptionEN,$descriptionFR,$descriptionDE)) {
                    $message = $this->traduction['data_send'];
                    $this->cadeauxAdmin($message);
                } else {
                    throw new Exception($this->traduction['failed_save_data_package']);
                }
            }
            else throw new Exception($this->traduction['failed_insert_package']);

        } else {
            $this->addCadeauAdmin($message);
        }
    }

    public function deleteCadeauAdmin(){
        //fonction delete
        $id_package = $_POST['id_package'];

        if ($this->cadeau->deleteCadeau($id_package)){
            if($this->cadeau->deletePhotosCadeau($id_package)){
                if($this->cadeau->deleteJSONCadeau($id_package)){
                $this->cadeauxAdmin();
                }
                else throw new Exception($this->traduction['failed_del_package']);
            }
            else throw new Exception($this->traduction['failed_del_package']);
        }
        else throw new Exception($this->traduction['failed_del_package']);

    }
}



