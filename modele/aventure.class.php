<?php
require_once "modele/database.class.php";
require_once "includes/html/photo.class.php";

/***************************************************************
Classe chargée de la gestion des escapes games dans la base de données
 ***************************************************************/
class aventure extends database
{

  /*******************************************************
  Retourne la liste des escapes de la bdd sql
    Entrée : 
  
    Retour : 
      [array] : Tableau associatif contenant la liste des escapes games
   *******************************************************/
  public function getAventures()
  {
    $req = "SELECT id_game, nom, localisation, adresse, prix, DATE_FORMAT(duree, '%H:%i') AS duree, parking, accebilite FROM `escape_game` ";
    $escapes = $this->execReq($req);

    $photo = new photo();

    // Ajoute le chemin de la photo pour chaque escape game
    foreach ($escapes as &$escape) {
      $escape['chemin_photo_PP'] = $photo->getPPAventure($escape['id_game']);
      $escape['chemin_photos'] = $photo->getPhotosAventure($escape['id_game']);
    }

    return $escapes;
  }

  /*******************************************************
  Retourne la liste des escapes montant X de la bdd sql
    Entrée : 
      X [int] : montant correspondant au nbr d'escapes games voulu
  
    Retour : 
      [array] : Tableau associatif contenant X nbr d'escapes games
   *******************************************************/
  public function getAventuresX($X)
  {
    $req = "SELECT id_game, nom, localisation, adresse, prix, DATE_FORMAT(duree, '%H:%i') AS duree, parking, accebilite FROM `escape_game`   ORDER BY id_game DESC LIMIT " . $X;
    $escapes = $this->execReq($req);

    $photo = new photo();

        // Ajoute le chemin de la photo pour chaque escape game
    foreach ($escapes as &$escape) {
      $escape['chemin_photo_PP'] = $photo->getPPAventure($escape['id_game']);
      $escape['chemin_photos'] = $photo->getPhotosAventure($escape['id_game']);
    }
    return $escapes;
  }


  /*******************************************************
  Retourne les informations d'un escape de la bdd sql
    Entrée : 
      idEscape [int] : Identifiant du escape game

    Retour : 
      [array] : Tableau associatif contenant les information du escape ou FALSE en cas d'erreur
      /Ou alors/
      [FALSE] : Répond faux
   *******************************************************/
  public function getAventure($idEscape)
  {
    $req = "SELECT id_game, nom, localisation, latitude, longitude , linkYTB,adresse, prix,  DATE_FORMAT(duree, '%H:%i') AS duree, parking, accebilite FROM `escape_game`  WHERE id_game=?";
    $resultat = $this->execReqPrep($req, array($idEscape));

    if (isset($resultat[0])) {  // L'escape game se trouve dans la 1ère ligne de $resultat

    $photo = new Photo(); // Instanciation de la classe Photo
        
    // Récupération du chemin de la photo principale et ajout à l'array de résultat
    $resultat[0]['chemin_photo_PP'] = $photo->getPPAventure($resultat[0]['id_game']);

    // Récupération des chemins de toutes les photos et ajout à l'array de résultat
    $resultat[0]['chemin_photos'] = $photo->getPhotosAventure($resultat[0]['id_game']);

    return $resultat[0];
  }
    else
      return FALSE;           // Retourne FALSE si le l'aventure n'existe pas

  }

  /*******************************************************
  Mets à jours les données d'un escape game dans la bdd sql
    Entrée : 
      nom [string] : Nom du escape game
      localisation [string] : Lieu de l'escape game
      latitude [float] : Position latitude du début de l'escape game
      longitude [float] : Position longitude du début de l'escape game
      adresse [string] : adresse du début de l'escape game
      prix [float] : Le prix unitaire de l'escape game
      duree [string] : La durée estimé de l'escape game
      parking [int] : Bool pour savoir s'il y a une place de parking
      accebilite[int] : Bool pour savoir si c'est accessible tous publique
      idAventure[int] : Identifiant unique de l'escape game
      linkYTB[string] : Contient le lien youtube de la présentation de l'escape, si non renseigné alors il est null

    Retour : 
      [FALSE - TRUE] : Retourne true ou false en fonction de si l'update a fonctionné
   *******************************************************/
  public function updateAventure($nom, $localisation, $latitude, $longitude, $adresse, $prix, $duree, $parking, $accebilite, $idAventure, $linkYTB = null)
  {
      // Commencez par construire la partie de la requête qui ne dépend pas de $linkYTB
      $req = 'UPDATE escape_game SET nom = ?, localisation = ?, latitude = ?, longitude = ?, adresse = ?, prix = ?, duree = ?, parking = ?, accebilite = ?';
  
      // Si $linkYTB est spécifié, ajoutez-le à la requête
      if ($linkYTB !== null) {
          $req .= ', linkYTB = ?';
          // Ajoutez également $linkYTB à la liste des valeurs à lier
          $params = array($nom, $localisation, $latitude, $longitude, $adresse, $prix, $duree, $parking, $accebilite, $linkYTB, $idAventure);
      } else {
          // Sinon, utilisez uniquement les paramètres sans $linkYTB
          $params = array($nom, $localisation, $latitude, $longitude, $adresse, $prix, $duree, $parking, $accebilite, $idAventure);
      }
  
      // Terminez la requête
      $req .= ' WHERE id_game = ?';
  
      // Exécutez la requête avec les paramètres appropriés
      $reponse = $this->execReqPrep($req, $params);
  
      // Vérifiez si la requête a été exécutée avec succès
      return ($reponse == 1) ? TRUE : FALSE;
  }
  

  /*******************************************************
  Ajoute les données d'un escape game dans la bdd sql
    Entrée : 
      nom [string] : Nom du escape game
      localisation [string] : Lieu de l'escape game
      latitude [float] : Position latitude du début de l'escape game
      longitude [float] : Position longitude du début de l'escape game
      adresse [string] : adresse du début de l'escape game
      prix [float] : Le prix unitaire de l'escape game
      duree [string] : La durée estimé de l'escape game
      parking [int] : Bool pour savoir s'il y a une place de parking
      accebilite[int] : Bool pour savoir si c'est accessible tous publique
      linkYTB[string] : Contient le lien youtube de la présentation de l'escape, si non renseigné alors il est null

    Retour : 
      [array id_game => id_game/null , succes => true/false] : Retourne un array qui contient l'id de l'escape game et true/false en fonction de si l'insertion à fonctionné 
   *******************************************************/

  public function insertAventure($nom, $localisation, $latitude, $longitude, $adresse, $prix, $duree, $parking, $accebilite, $linkYTB = null)
  {
      // Commencez par construire la partie de la requête qui ne dépend pas de $linkYTB
      $req = 'INSERT INTO escape_game(nom, localisation, latitude, longitude, adresse, prix, duree, parking, accebilite';
  
      // Initialisez un tableau pour stocker les valeurs à lier
      $params = array($nom, $localisation, $latitude, $longitude, $adresse, $prix, $duree, $parking, $accebilite);
  
      // Si $linkYTB est spécifié, ajoutez-le à la requête et aux paramètres
      if ($linkYTB !== null) {
          $req .= ', linkYTB)';
          $req .= ' VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);'; // Complétez la requête
          // Ajoutez également $linkYTB à la liste des valeurs à lier
          $params[] = $linkYTB;
      } else {
          // Sinon, complétez simplement la requête sans $linkYTB
          $req .= ')';
          $req .= ' VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);'; // Complétez la requête
      }
  
      // Exécutez la requête avec les paramètres appropriés
      $reponse = $this->execReqPrep($req, $params);
  
      // Vérifiez si l'insertion s'est bien déroulée
      if ($reponse == 1) {
          // Si oui, récupérez l'ID de la dernière insertion
          $id_game = $this->lootLastIdInsert();
          // Retournez l'ID de jeu et un indicateur de succès
          return array('id_game' => $id_game, 'succes' => true);
      } else {
          // Sinon, retournez null pour l'ID de jeu et un indicateur d'échec
          return array('id_game' => null, 'succes' => false);
      }
  }
  
  
  /*******************************************************
  Ajoute la photo de profil d'un escape game
    Entrée : 
      nouvelle_photo_profil[array] : Contien les information du file photo profil
      id_game[int] : Contient l'identifiant de l'escape game

    Retour : 
      [FALSE - TRUE] : Retourne true ou false en fonction de si ajout a fonctionné
   *******************************************************/

  public function addAventurePP($nouvelle_photo_profil,$id_game){
    //On regarde si le dossier existe, sinon on le crée
    if(!is_dir('img/escape_game/'.$id_game)){
      if(!mkdir('img/escape_game/'.$id_game, 0777, true)) return FALSE ;
    }
    //On regarde si le dossier existe, sinon on le crée
    if(!is_dir('img/escape_game/'.$id_game.'/PP')){
      if(!mkdir('img/escape_game/'.$id_game.'/PP', 0777, true)) return FALSE ;
    }
    //On regarde s'il y a déjà un photo, s'il y a, on le supprime
    $cheminImage = glob('img/escape_game/'.$id_game.'/PP/' . "*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);
    if (!empty($cheminImage)) {
      unlink($cheminImage[0]);
    }
    //On renomme le nouveau fichier
    $extension = pathinfo($nouvelle_photo_profil['name'], PATHINFO_EXTENSION);
    $nouveauNom = uniqid() . '.' . $extension;
    $cheminTemporaire = $nouvelle_photo_profil['tmp_name'];
    $nouveauChemin = 'img/escape_game/'.$id_game.'/PP/' . $nouveauNom;

    if(move_uploaded_file($cheminTemporaire, $nouveauChemin)) return TRUE;
    else return FALSE;

  }

    /*******************************************************
  Ajoute les photos d'un escape game
    Entrée : 
      nouvelles_photos[array] : Contien une liste de file des photos
      id_game[int] : Contient l'identifiant de l'escape game

    Retour : 
      [FALSE - TRUE] : Retourne true ou false en fonction de si ajout a fonctionné
   *******************************************************/

  public function addAventurePhotos($nouvelles_photos,$id_game){
    //Regarde si le dossier existe, sinon on le crée
    if(!is_dir('img/escape_game/'.$id_game)){
      if(!mkdir('img/escape_game/'.$id_game, 0777, true)) return FALSE ;
    }

    $cheminDossier = 'img/escape_game/'.$id_game.'/';
    //On renomme les photos par le time exact puis on l'ajoute dans le dossier de l'escape game
    foreach($nouvelles_photos['name'] as $index => $nomFichier){
      $cheminTemporaire = $nouvelles_photos['tmp_name'][$index];
      $extension = pathinfo($nomFichier, PATHINFO_EXTENSION);
      $nouveauNom = uniqid() . '.' . $extension;
      $nouveauChemin = $cheminDossier . $nouveauNom;
      if(!move_uploaded_file($cheminTemporaire, $nouveauChemin)) return FALSE ;
}
      return TRUE ;
  }

      /*******************************************************
    Supprime les photos d'une aventure
    Entrée : 
      photos_a_supprimer[array] : contient tous les chemins des fichers a supprimer
      id_game[int] : Contient l'identifiant de l'escape game

    Retour : 
      [FALSE - TRUE] : Retourne true ou false en fonction de si la suppression a fonctionné
   *******************************************************/

  public function delAventurePhotos($photos_a_supprimer){
    foreach($photos_a_supprimer as $value){
      if(!unlink($value)) return FALSE ;
    }

    return TRUE;
  }

      /*******************************************************
  Ajoute/ Update les informations d'un escape game en json
    Entrée : 
      tous les entrés sont des strings, on les ajoutes en json

    Retour : 
      [FALSE - TRUE] : Retourne true ou false en fonction de si ajout a fonctionné
   *******************************************************/

  public function insertAndUpdateAventureAdminJSON(
    $id_game,
    $detailEN,
    $detailFR,
    $detailDE,

    $histoireEN,
    $histoireFR,
    $histoireDE,

    $descriptionEN,
    $descriptionFR,
    $descriptionDE,

    $infoLangues,

    $emporterEN,
    $emporterFR,
    $emporterDE,

    $importantEN,
    $importantFR,
    $importantDE,

    $puzzleEN,
    $puzzleFR,
    $puzzleDE,

    $marcheEN,
    $marcheFR,
    $marcheDE,

    $cibleEN,
    $cibleFR,
    $cibleDE,

    $trainBusEN,
    $trainBusFR,
    $trainBusDE
  ) {
    $jsonData = file_get_contents("donnees/structure.json");

    // Décoder le JSON en un tableau PHP associatif
    $data = json_decode($jsonData, true);

    $data['Aventures'][$id_game]['info']['.détail']['en'] = $detailEN;
    $data['Aventures'][$id_game]['info']['.détail']['fr'] = $detailFR;
    $data['Aventures'][$id_game]['info']['.détail']['de'] = $detailDE;

    $data['Aventures'][$id_game]['info']['.histoireAV']['en'] = $histoireEN;
    $data['Aventures'][$id_game]['info']['.histoireAV']['fr'] = $histoireFR;
    $data['Aventures'][$id_game]['info']['.histoireAV']['de'] = $histoireDE;

    $data['Aventures'][$id_game]['info']['.descriptionAV']['en'] = $descriptionEN;
    $data['Aventures'][$id_game]['info']['.descriptionAV']['fr'] = $descriptionFR;
    $data['Aventures'][$id_game]['info']['.descriptionAV']['de'] = $descriptionDE;

    $data['Aventures'][$id_game]['infoLangues'] = $infoLangues;

    $data['Aventures'][$id_game]['info']['.info1']['en'] = $emporterEN;
    $data['Aventures'][$id_game]['info']['.info1']['fr'] = $emporterFR;
    $data['Aventures'][$id_game]['info']['.info1']['de'] = $emporterDE;

    $data['Aventures'][$id_game]['info']['.info2']['en'] = $importantEN;
    $data['Aventures'][$id_game]['info']['.info2']['fr'] = $importantFR;
    $data['Aventures'][$id_game]['info']['.info2']['de'] = $importantDE;

    $data['Aventures'][$id_game]['info']['.info3']['en'] = $puzzleEN;
    $data['Aventures'][$id_game]['info']['.info3']['fr'] = $puzzleFR;
    $data['Aventures'][$id_game]['info']['.info3']['de'] = $puzzleDE;

    $data['Aventures'][$id_game]['info']['.info4']['en'] = $marcheEN;
    $data['Aventures'][$id_game]['info']['.info4']['fr'] = $marcheFR;
    $data['Aventures'][$id_game]['info']['.info4']['de'] = $marcheDE;

    $data['Aventures'][$id_game]['info']['.info5']['en'] = $cibleEN;
    $data['Aventures'][$id_game]['info']['.info5']['fr'] = $cibleFR;
    $data['Aventures'][$id_game]['info']['.info5']['de'] = $cibleDE;

    $data['Aventures'][$id_game]['info']['.info6']['en'] = $trainBusEN;
    $data['Aventures'][$id_game]['info']['.info6']['fr'] = $trainBusFR;
    $data['Aventures'][$id_game]['info']['.info6']['de'] = $trainBusDE;


    // Encodez le tableau PHP en JSON
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);

    // Vérifiez si l'encodage s'est bien passé
    if ($jsonData === false) {
      return false; // Retourne false si l'encodage JSON a échoué
    }

    // Écrivez les données dans le fichier
    $result = file_put_contents("donnees/structure.json", $jsonData);

    // Vérifiez si l'écriture s'est bien passée
    if ($result === false) {
      return false; // Retourne false si l'écriture dans le fichier a échoué
    }

    // Retourne true si tout s'est bien passé
    return true;
  }
    /*******************************************************
  Supprime un escape game dans la bdd sql
    Entrée : 
      id_game[int] : Contient l'identifiant de l'escape game

    Retour : 
      [FALSE - TRUE] : Retourne true ou false en fonction de si ajout a fonctionné
   *******************************************************/
  public function deleteAventure($id_game)
  {
    $req = "DELETE FROM `escape_game` WHERE id_game = ?   ";
    $resultat = $this->execReqPrep($req, array($id_game));
    return $resultat !== false; // Retourne true si $resultat est différent de false, sinon false
  }

      /*******************************************************
  Supprime de manière récursive le dossier qui contient les photos d'un escape game
    Entrée : 
      id_game[int] : Contient l'identifiant de l'escape game

    Retour : 
      [FALSE - TRUE] : Retourne true ou false en fonction de si ajout a fonctionné
   *******************************************************/

  public function deletePhotosAventure($id_game){
    $cheminDossier = 'img/escape_game/' . $id_game;

    if (!is_dir($cheminDossier)) {
        // Le dossier n'existe pas, donc il est déjà supprimé
        return true;
    }

    $contenu = scandir($cheminDossier);
    foreach ($contenu as $element) {
        if ($element != '.' && $element != '..') {
            $cheminElement = $cheminDossier . '/' . $element;
            if (is_dir($cheminElement)) {
                // Appel récursif pour supprimer les sous-dossiers et leurs contenus
                if (!$this->deletePhotosAventure($id_game . '/' . $element)) {
                    // En cas d'échec, retourne false
                    return false;
                }
            } else {
                unlink($cheminElement);
            }
        }
    }

    // Une fois tous les éléments supprimés, on peut supprimer le dossier lui-même
    return rmdir($cheminDossier);
  }

      /*******************************************************
  Supprime les data d'un escape game en json
    Entrée : 
      nouvelles_photos[array] : Contien une liste de file des photos
      id_game[int] : Contient l'identifiant de l'escape game

    Retour : 
      [FALSE - TRUE] : Retourne true ou false en fonction du resultat
   *******************************************************/
  public function deleteJSONAventure($id_game)
  {
    $jsonData = file_get_contents("donnees/structure.json");

    // Décoder le JSON en un tableau PHP associatif
    $data = json_decode($jsonData, true);

    // Fonction récursive pour supprimer l'élément spécifié
    $recursiveArrayDelete = function (&$array, $keyToDelete) use (&$recursiveArrayDelete) {
      foreach ($array as $key => &$value) {
        if ($key === $keyToDelete) {
          unset($array[$key]);
        } elseif (is_array($value)) {
          $recursiveArrayDelete($value, $keyToDelete);
        }
      }
    };

    // Appel de la fonction récursive
    $recursiveArrayDelete($data, $id_game);

    // Encoder le tableau modifié en JSON
    $newJsonData = json_encode($data, JSON_PRETTY_PRINT);

    // Vérifiez si la suppression s'est bien passée en vérifiant si l'encodage en JSON réussit
    if ($newJsonData === false) {
      return false; // Retourne false si la suppression dans le fichier a échoué
    }

    // Écrire le JSON modifié dans le fichier
    $result = file_put_contents("donnees/structure.json", $newJsonData);

    // Retourne true si l'écriture dans le fichier s'est bien passée
    return $result !== false;
  }

  public function getReservationsMembre($id_membre)
  {
    $req = "SELECT reserver.id_game,id_reservation, nom, date, crenaux,annulation FROM reserver INNER JOIN escape_game ON reserver.id_game = escape_game.id_game WHERE id_membre = ?; ";
    $reservations = $this->execReqPrep($req, array($id_membre));

    if(!empty($reservations)){
    $photo = new photo();

    // Ajoute le chemin de la photo pour chaque escape game
    foreach ($reservations as &$reservation) {
      $reservation['chemin_photo_PP'] = $photo->getPPAventure($reservation['id_game']);
      $reservation['chemin_photos'] = $photo->getPhotosAventure($reservation['id_game']);}

    return $reservations;      
    }

  }

      /*******************************************************
  Retourne la liste des reservation d'un escape game
    Entrée : 
      id_game[int] : Contient l'identifiant de l'escape game

    Retour : 
      liste [array] : Un array qui contient toutes les reservation d'un reservation
   *******************************************************/

  public function liste_reservation_DH($id_game){
    $req = "SELECT date, crenaux FROM `reserver` WHERE id_game = ?";
    return $liste = $this->execReqPrep($req,array($id_game));

  }

      /*******************************************************
  Retourne les reservations d'un membre
    Entrée : 
      id_reservation[int] : Contient l'identifiant de la reservation
      id_membre[int]: Contient l'identifiant d'un membre

    Retour : 
      reservation [array] : Contient tous les informations d'un reservation
   *******************************************************/

  public function getReservationMembre($id_membre, $id_reservation)
  {
    $req = "SELECT reserver.id_game, nom,localisation,adresse,prix,DATE_FORMAT(duree, '%H:%i') AS duree,parking,accebilite,latitude,longitude,id_reservation,id_membre,nbr_personne, date, crenaux, annulation FROM reserver INNER JOIN escape_game ON reserver.id_game = escape_game.id_game WHERE id_membre = ? AND id_reservation=?; ";
    $reservations = $this->execReqPrep($req, array($id_membre, $id_reservation));


    return $reservations[0];
  }

      /*******************************************************
  Retourne toutes les reservations
    Entrée : 

    Retour : 
      reservation[array]: Contien la liste de tous les reservations
   *******************************************************/
  public function getReservationsAdmin(){
    $req = "SELECT reserver.id_game,id_reservation, escape_game.nom AS nomGame, date, crenaux,annulation, membre.nom, membre.prenom, membre.email, membre.num_tel FROM reserver INNER JOIN escape_game ON reserver.id_game = escape_game.id_game INNER JOIN membre ON membre.id_membre = reserver.id_membre; " ;
    $reservations = $this->execReq($req);
    return $reservations ;
  }

      /*******************************************************
  Ajoute la demande de suppression d'une reservation
    Entrée : 
      id_reservation[int] : Contient l'identifiant de la reservation

    Retour : 
      [FALSE - TRUE] : Retourne true ou false en fonction du resultat
   *******************************************************/
  public function annulerReservation($id_reservation){
    $req = "UPDATE reserver SET annulation = 1 WHERE id_reservation =  ?";
    $reponse = $this->execReqPrep($req, array($id_reservation));
    if ($reponse == 1)
      return TRUE;
    return FALSE;
  }

      /*******************************************************
  Supprime une reservation
    Entrée : 
      id_reservation[int] : Contient l'identifiant de la reservation

    Retour : 
      [FALSE - TRUE] : Retourne true ou false en fonction du resultat
   *******************************************************/

  public function suppReservation($id_reservation){
    $req = "DELETE FROM reserver  WHERE id_reservation =  ?";
    $reponse = $this->execReqPrep($req, array($id_reservation));
    if ($reponse == 1)
      return TRUE;
    return FALSE; 
  }

      /*******************************************************
  Refuse la demande de suppression d'une reservation
    Entrée : 
      id_reservation[int] : Contient l'identifiant de la reservation

    Retour : 
      [FALSE - TRUE] : Retourne true ou false en fonction du resultat
   *******************************************************/

  public function rejectAnnulationReservation($id_reservation){
    $req = "UPDATE reserver SET annulation = 0 WHERE id_reservation =  ?";
    $reponse = $this->execReqPrep($req, array($id_reservation));
    if ($reponse == 1)
      return TRUE;
    return FALSE;
  }

        /*******************************************************
    Ajoute une reservation
    Entrée : 
      id_membre[int] : Contient l'identifiant du membre
      id_game[int] : Contient l'identifiant de l'escape game
      nbrPeople[string] : Contient le nbr de personne qui participe a l'escape game
      date [string] : Contient la date de la reservation
      crenaux [string] : contient le creneau de la reservation

    Retour : 
   *******************************************************/

  public function addReservation($id_membre,$id_game,$nbrPeople,$date,$crenaux){
    $req = "INSERT INTO `reserver` (`id_reservation`, `id_membre`, `id_game`, `nbr_personne`, `date`, `crenaux`, `annulation`) VALUES (NULL, ?, ?, ?, ?, ?, '0')";
    $this->execReqPrep($req,array($id_membre,$id_game,$nbrPeople,$date,$crenaux));
  }


}   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement