<?php
require_once "modele/aventure.class.php";
require_once "vue/vue.class.php";

class ctlAventure{

    private $aventure ;
    private $traduction;

    /*******************************************************
    Initialise les variables contenant tous les fonctions du modele aventure ainsi que la traduction
    Entrée : 

    Retour : 
    
    *******************************************************/


    public function __construct() {
        $this->aventure = new aventure();

        $this->traduction = include "donnees/data_message_trad.php";
    }


    //Prend les données des aventures et la vue aventures
    public function aventures(){
        $aventures = $this->aventure->getAventures() ;
        $vue = new vue("Aventures"); // Instancie la vue appropriée
        $vue->afficher(array("aventures" => $aventures)); 
    }
    
    //Prend les données d'un aventure et la vue aventure
    public function aventure($id_aventure, $message =''){
        $aventure = $this->aventure->getAventure($id_aventure);

        if (!empty($aventure)){
            $vue = new vue("Aventure"); // Instancie la vue appropriée
            $vue->afficher(array("aventure" => $aventure, "message"=> $message));           
        }
        else
            throw new Exception($this->traduction['failed_get_aventure']."$id_aventure");
    }

    //Vérifie si la reservation n'est pas déjà pris, si ce n'est pas le cas, il retourne true
    public function checkReservation(){
        $liste_reservation_DH = $this->aventure->liste_reservation_DH($_POST['id_game']);

        if(!empty($liste_reservation_DH)){
            foreach ($liste_reservation_DH as $value) {
                if(($value['date'] == $_POST['appointmentDate']) && ($value['crenaux']== $_POST['timeSlot'])){
                    return $this->aventure($_POST['id_game'],'Reservation déjà pris');
                }
            }
        }

        return true ;

    }

    //Vérifie si on a les data en session, sinon il l'instancie et instancie la bonne vue
    public function paiement($message = ""){
        if(isset($_SESSION['infoReservation'])) $infoReservation = $_SESSION['infoReservation'];
        else $infoReservation = $_POST;
        if(isset($_SESSION['infoAventure'])) $infoAventure = $_SESSION['infoAventure'];
        else $infoAventure = $this->aventure->getAventure($_POST['id_game']);

        $vue = new vue("Paiement");
        $vue->afficher(array("infoReservation"=>$infoReservation, "infoAventure" => $infoAventure, "message"=>$message));

    }

    //Ici on fais le payement quand un membre reserve un escape game
    public function payer(){
        //Ici normalement on traite les donnés du cb pour s'assurer que c'est bien un vrai etc

        //On retire les info du CB car on en veut pas
        unset($_SESSION['infoCard']);


        //On prend les info qui nous interresse pour déclarer la réservation :
        $id_membre = $_SESSION['membre'];
        $id_game = $_SESSION['infoAventure']['id_game'];
        $nbrPeople = $_SESSION['infoReservation']['numberOfPeople'];
        $date = $_SESSION['infoReservation']['appointmentDate'];
        $crenaux = $_SESSION['infoReservation']['timeSlot'];

        //On supprimer les info du session car plus besoin
        unset($_SESSION['infoAventure']);
        unset($_SESSION['infoReservation']);

        $this->aventure->addReservation($id_membre,$id_game,$nbrPeople,$date,$crenaux);

        //Une fois fini on l'envoie a la page acceui membre connecté
        header("Location: index.php?action=acceuilMembre");

    }
    //Prend les données des reservations et la vue reservation pour admin
    public function reservationAdmin($message = ''){
        $reservations = $this->aventure->getReservationsAdmin();
        $vue = new vue("ReservationAdmin"); // Instancie la vue appropriée
        $vue->afficher(array("reservations" => $reservations, "message"=>$message)); 
    }

    //Fais le traitement du choix Admin d'accepté ou rejeté la demande d'annulation de reservation
    public function reservationAnnulationAdmin(){
        if(!empty($_POST['id_reservation'])){
            if(isset($_POST['supp'])){
                if($this->aventure->suppReservation($_POST['id_reservation'])){
                    $message = $this->traduction['succes_revocation'];
                }
                else $message = $this->traduction['failed_revocation_admin'];
                
            }
            else if(isset($_POST['reject'])){
                if($this->aventure->rejectAnnulationReservation($_POST['id_reservation'])) {
                    $message = $this->traduction['succes_reject_revocation'];
                }
                else $message = $this->traduction['invalid_email_format'];
            }
            else 
                throw new Exception($this->traduction['failure_revocation_reservation']);
        }
        else 
            throw new Exception($this->traduction['failure_revocation_reservation']);

        $this->reservationAdmin($message);
    }

    //Prend les données aventures et instancie la vue aventures pour admin
    public function aventuresAdmin(){
        $aventures = $this->aventure->getAventures() ;
        $vue = new vue("AventuresAdmin"); // Instancie la vue appropriée
        $vue->afficher(array("aventures" => $aventures)); 
    }

    //Prend les données aventure et instancie la vue aventure pour admin
    public function aventureAdmin($id_aventure,$message=''){
        $aventure = $this->aventure->getAventure($id_aventure);
        $jsonData = file_get_contents('donnees/structure.json');
        $data = json_decode($jsonData, true);

        $dataAventure = $data['Aventures'][$id_aventure];

        if (!empty($aventure)){
            $vue = new vue("AventureAdmin"); // Instancie la vue appropriée
            $vue->afficher(array("aventure" => $aventure,"dataAventure"=>$dataAventure, 'message'=>$message));            
        }
        else
            throw new Exception($this->traduction['failed_get_aventure']."$id_aventure");
    }

    //Véréfie si les informations sont cohérents et retourne une liste de tous les anomalies des informations
    public function checkInfo(){
        $aventures = $this->aventure->getAventures();

        extract($_POST);
        $message = '';


        if (empty($nom)) $message .= $this->traduction['name_missing'].'<br>';
        if (empty($detailEN)) $message .= $this->traduction['detail_en_missing'].'<br>';
        if (empty($detailFR)) $message .= $this->traduction['detail_fr_missing'].'<br>';
        if (empty($detailDE)) $message .= $this->traduction['detail_de_missing'].'<br>';
        if (empty($histoireEN)) $message .= $this->traduction['history_en_missing'].'<br>';
        if (empty($histoireFR)) $message .= $this->traduction['history_fr_missing'].'<br>';
        if (empty($histoireDE)) $message .= $this->traduction['history_de_missing'].'<br>';
        if (empty($descriptionEN)) $message .= $this->traduction['description_en_missing'].'<br>';
        if (empty($descriptionFR)) $message .= $this->traduction['description_fr_missing'].'<br>';
        if (empty($descriptionDE)) $message .= $this->traduction['description_de_missing'].'<br>';
        if (empty($infoLangues)) $message .= $this->traduction['info_lang_missing'].'<br>';
        if (empty($emporterEN)) $message .= $this->traduction['info_en_emporter_missing'].'<br>';
        if (empty($emporterFR)) $message .= $this->traduction['info_fr_emporter_missing'].'<br>';
        if (empty($emporterDE)) $message .= $this->traduction['info_de_emporter_missing'].'<br>';
        if (empty($importantEN)) $message .= $this->traduction['info_en_important_missing'].'<br>';
        if (empty($importantFR)) $message .= $this->traduction['info_fr_important_missing'].'<br>';
        if (empty($importantDE)) $message .= $this->traduction['info_de_important_missing'].'<br>';
        if (!empty($puzzleDificult)){
            if(($puzzleDificult != 'facil')&& ($puzzleDificult != 'moyen') && ($puzzleDificult != 'dur')) $message .= $this->traduction['failed_puzzle_lvl_format']."<br>" ;
        }else $message .= $this->traduction['puzzle_lvl_missing'].'<br>';

        if (!empty($walkDificult)){
            if(($walkDificult != 'facil') && ($walkDificult != 'moyen')&&($walkDificult != 'dur')) $message .= $this->traduction['failed_walk_lvl_format']."<br>" ;
        }else $message .= $this->traduction['walk_lvl_missing'].'<br>';

        if (empty($cibleEN)) $message .= $this->traduction['target_en_grp_missing'].'<br>';
        if (empty($cibleFR)) $message .= $this->traduction['target_fr_grp_missing'].'<br>';
        if (empty($cibleDE)) $message .= $this->traduction['target_de_grp_missing'].'<br>';
        if (empty($trainBusEN)) $message .= $this->traduction['train_en_bus_missing'].'<br>';
        if (empty($trainBusFR)) $message .= $this->traduction['train_en_bus_missing']. '<br>';
        if (empty($trainBusDE)) $message .= $this->traduction['train_en_bus_missing'].'<br>';
        if (empty($localisation)) $message .= $this->traduction['localisation_missing'].'<br>';

        if (!empty($latitude)){
            if (!preg_match('/^-?((([0-8]?[0-9])(\.\d+)?)|(90(\.0+)?))$/',$latitude)) $message .= $this->traduction['failed_latitude_format']."<br>";
        }else {
            $message .= $this->traduction['latitude_missing']."<br>";
        } 
        if (!empty($longitude)){
            if (!preg_match('/^-?((([0-9]?[0-9]?[0-9])|([1-9][0-9][0-9]?))(\.\d+)?|(1[0-7][0-9](\.\d+)?|180(\.0+)?))$/',$longitude)) $message .= $this->traduction['failed_longitude_format']."<br>";
        }else {
            $message .= $this->traduction['longitude_missing']."<br>";
        } 

        if (empty($adresse)) $message .= $this->traduction['address_missing'].'<br>';

        if (!empty($prix)){
            if($prix <= 0)
            $message .= $this->traduction['failed_price_format']."<br>" ;
        }
        else $message .= $this->traduction['price_missing'].'<br>';
        if (!empty($duree)){
            if (!preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/',$duree)) $message .= $this->traduction['failed_duration_format']."<br>";
        }else {
            $message .= $this->traduction['duration_missing']."<br>";
        } 

        if (isset($parking) && $parking!= '') {
            if(($parking != '0') && ($parking != '1')) $message .= $this->traduction['failed_parking_format']."<br>";
        }else {
            $message .= $this->traduction['parking_missing']."<br>";
        }
        if (isset($accebilite) && $accebilite!= '') {
            if(($accebilite != '0') && ($accebilite != '1')) $message .= $this->traduction['failed_accebilite_format']."<br>";
        }else {
            $message .= $this->traduction['accebilite_missing']."<br>";
        }

        return $message;
    }

    //Véréfie si les informations sont cohérents et retourne une liste de tous les anomalies des informations
    public function checkPhoto(){
        $message = '';
        extract($_FILES);

        if(isset($nouvelle_photo_profil) && $nouvelle_photo_profil['size']>0){
            if($nouvelle_photo_profil['error']==0){
                if($nouvelle_photo_profil['size']>5000000) $message .= $this->traduction['photo_pp_lourd']."<br>";
            }else $message .= $this->traduction['failed_send_photo_pp']."<br>";
        }

        if(isset($nouvelles_photos) && $nouvelles_photos['size'][0]>0){
            foreach($nouvelles_photos['error'] as $index => $value){
                if($value != 0){
                    $nom_file = $nouvelles_photos['name'][$index];
                    $message .= $this->traduction['failed_send_photo']. $nom_file . "<br>";
                }
            }

            foreach($nouvelles_photos['size'] as $index => $value){
                if($value > 5000000){
                    $nom_file = $nouvelles_photos['name'][$index];
                    $message .= $this->traduction['photo_lourd_part1'] . $nom_file . $this->traduction['photo_lourd_part2']."<br>";
                }
            }

            foreach($nouvelles_photos['type'] as $index => $value){
                if(!preg_match('/^image\/(png|jpg|webp)$/i',$value)){
                    $nom_file = $nouvelles_photos['name'][$index];
                    $message .= $nom_file . $this->traduction['photo_wrong_format'] ."<br>";
                }
            }
        }

        if(isset($photos_a_supprimer) && !empty($photos_a_supprimer)){
            if(!file_exists($photos_a_supprimer)){
                $message .= $this->traduction['failed_find_photo_del'] ."<br>";
            }
        }

        return $message ;
    }
    //Mets à jours les data d'un aventure
    public function updateAventureAdmin()
    {
        extract($_POST);
        $message = "";
        if(empty($id_game)) throw new Exception($this->traduction['missing_id_game']);

        if(isset($info)){

        $message .= $this->checkInfo();



            if (empty($message)) {
            $this->aventure->updateAventure($nom,$localisation,$latitude,$longitude,$adresse,$prix,$duree,$parking,$accebilite,$linkYTB,$id_game);
    
                    switch ($puzzleDificult){
                        case 'facil' : 
                            $puzzleEN = 'Perfect for puzzle beginners';
                            $puzzleFR = 'Parfait pour les débutants en puzzles' ;
                            $puzzleDE = 'Perfekt für Puzzleanfänger';
                            break;
                        case 'moyen':
                            $puzzleEN = 'For puzzle fans';
                            $puzzleFR = 'Pour les amateurs de puzzles' ;
                            $puzzleDE = 'Für Rätselfans';
                            break;
                        case 'dur':
                            $puzzleEN = 'For puzzle lovers';
                            $puzzleFR = 'Pour les passionnés de puzzles' ;
                            $puzzleDE = 'Für Puzzlebegeisterte';
                            break;
                    }
    
                    switch ($walkDificult){
                        case 'facil' : 
                            $marcheEN = 'Easy walk';
                            $marcheFR = 'Marche facile' ;
                            $marcheDE = 'Leichter Spaziergang';
                            break;
                        case 'moyen':
                            $marcheEN = 'Moderate walk';
                            $marcheFR = 'Marche modérée' ;
                            $marcheDE = 'Mäßiges Gehen';
                            break;
                        case 'dur':
                            $marcheEN = 'Advanced walk';
                            $marcheFR = 'Marche avancée' ;
                            $marcheDE = 'Fortgeschrittener Marsch';
                            break;
                    }
    
                    if ($this->aventure->insertAndUpdateAventureAdminJSON($id_game,$detailEN,$detailFR,$detailDE,$histoireEN,$histoireFR,$histoireDE,$descriptionEN,$descriptionFR,$descriptionDE,$infoLangues,$emporterEN,$emporterFR,$emporterDE,$importantEN,$importantFR,$importantDE,$puzzleEN,$puzzleFR,$puzzleDE,$marcheEN,$marcheFR,$marcheDE,$cibleEN,$cibleFR,$cibleDE,$trainBusEN,$trainBusFR,$trainBusDE)) {
                        $message = $this->traduction['data_send'];
                    } else {
                        throw new Exception($this->traduction['failed_data_send']);
                    }
                } 
            }
            else if (isset($photo)){

                $message .= $this->checkPhoto();
                if(empty($message)){
                    extract($_FILES);
                    //ici on va s'occuper du traitement de photo

                    if(isset($nouvelle_photo_profil) && !empty($nouvelle_photo_profil) && $nouvelle_photo_profil['size']>0){
                        if($this->aventure->addAventurePP($nouvelle_photo_profil,$id_game));
                        else throw new Exception($this->traduction['failed_photo_pp_save']);
                    }

                    if(isset($nouvelles_photos) &&  !empty($nouvelles_photos) && $nouvelles_photos['size'][0]>0){
                        if($this->aventure->addAventurePhotos($nouvelles_photos,$id_game));
                        else throw new Exception($this->traduction['failed_photo_save']);
                    }

                    if(isset($photos_a_supprimer)){
                        if($this->aventure->delAventurePhotos($photos_a_supprimer,$id_game));
                        else throw new Exception($this->traduction['failed_del_photo']);
                    }

                    $message .= $this->traduction['change_succes'];
                }

            }

            else $message .= $this->traduction['bug_form'];

            $this->aventureAdmin($id_game,$message);
            
    }

    //Instancie la vue ajouter un aventure pour les admins
    public function addAventureAdmin($message='')
    {
        $vue = new vue("AddAventureAdmin"); // Instancie la vue appropriée         
        $vue->afficher(array("message"=>$message));  
    }

    //Ajoute un nouveau escape game
    public function insertAventureAdmin()
    {
        extract($_POST);
        extract($_FILES);
        $message = "";


        if (!empty($nom)){
            //Regarde si le nom n'est pas déjà utilisé
            foreach($aventures as $aventure){
                if($aventure['nom'] == $nom){
                    $message .= $this->traduction['name_already_take'].'<br>';
                    break ;
            }}
        }
        $message .= $this->checkInfo();
        $message .= $this->checkPhoto();

        if (empty($message)) {
            $resultatInsertAventure = $this->aventure->insertAventure($nom,$localisation,$latitude,$longitude,$adresse,$prix,$duree,$parking,$accebilite,$linkYTB);
            if ($resultatInsertAventure['succes']) {
                $id_game = $resultatInsertAventure['id_game'];
                if(!$this->aventure->addAventurePP($nouvelle_photo_profil,$id_game)) throw new Exception("Échec de l'insertion de l'aventure");
                if(!$this->aventure->addAventurePhotos($nouvelles_photos,$id_game))throw new Exception("Échec de l'insertion de l'aventure");
                switch ($puzzleDificult){
                    case 'facil' : 
                        $puzzleEN = 'Perfect for puzzle beginners';
                        $puzzleFR = 'Parfait pour les débutants en puzzles' ;
                        $puzzleDE = 'Perfekt für Puzzleanfänger';
                        break;
                    case 'moyen':
                        $puzzleEN = 'For puzzle fans';
                        $puzzleFR = 'Pour les amateurs de puzzles' ;
                        $puzzleDE = 'Für Rätselfans';
                        break;
                    case 'dur':
                        $puzzleEN = 'For puzzle lovers';
                        $puzzleFR = 'Pour les passionnés de puzzles' ;
                        $puzzleDE = 'Für Puzzlebegeisterte';
                        break;
                }

                switch ($walkDificult){
                    case 'facil' : 
                        $marcheEN = 'Easy walk';
                        $marcheFR = 'Marche facile' ;
                        $marcheDE = 'Leichter Spaziergang';
                        break;
                    case 'moyen':
                        $marcheEN = 'Moderate walk';
                        $marcheFR = 'Marche modérée' ;
                        $marcheDE = 'Mäßiges Gehen';
                        break;
                    case 'dur':
                        $marcheEN = 'Advanced walk';
                        $marcheFR = 'Marche avancée' ;
                        $marcheDE = 'Fortgeschrittener Marsch';
                        break;
                }

                if ($this->aventure->insertAndUpdateAventureAdminJSON($id_game,$detailEN,$detailFR,$detailDE,$histoireEN,$histoireFR,$histoireDE,$descriptionEN,$descriptionFR,$descriptionDE,$infoLangues,$emporterEN,$emporterFR,$emporterDE,$importantEN,$importantFR,$importantDE,$puzzleEN,$puzzleFR,$puzzleDE,$marcheEN,$marcheFR,$marcheDE,$cibleEN,$cibleFR,$cibleDE,$trainBusEN,$trainBusFR,$trainBusDE)) {
                    $message = $this->traduction['data_send'];
                    $this->aventuresAdmin($message);
                } else {
                    throw new Exception($this->traduction['failed_data_send']);
                }
            } else {
                throw new Exception($this->traduction['failed_insert_escape']);
            }
        } else {
            $this->addAventureAdmin($message);
        }
    }

    //Supprime un aventure
    public function deleteAventureAdmin(){
        $id_game = $_POST['id_game'];

        if ($this->aventure->deleteAventure($id_game)){
            if($this->aventure->deletePhotosAventure($id_game)){
                if($this->aventure->deleteJSONAventure($id_game)){
                $this->aventuresAdmin();
                }
                else throw new Exception($this->traduction['failed_del_escape']);
            }
            else throw new Exception($this->traduction['failed_del_escape']);
        }
        else throw new Exception($this->traduction['failed_del_escape']);

    }
    
}