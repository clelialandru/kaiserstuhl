<?php
require_once "modele/database.class.php";
require_once "includes/html/photo.class.php";

/***************************************************************
Classe chargée de la gestion des cadeaux dans la base de données
 ***************************************************************/
class cadeau extends database
{

  /*******************************************************
  Retourne la liste des cadeaux 
    Entrée : 
  
    Retour : 
      [array] : Tableau associatif contenant la liste des cadeaux
   *******************************************************/
  public function getCadeaux()
  {
    $req = 'SELECT * FROM package';
    $cadeaux = $this->execReq($req);
    return $cadeaux;
  }

  /*******************************************************
  Retourne la liste des cadeaux 
    Entrée : 
  
    Retour : 
      [array] : Tableau associatif contenant la liste des cadeaux de type cadeau (différent des cartes cadeaux)
   *******************************************************/
  public function getCadeauxPuzzle()
  {
    $req = 'SELECT * FROM package WHERE type = "cadeau"';
    $cadeaux = $this->execReq($req);

    $photo = new photo();

    // Ajoute le chemin de la photo pour chaque package
    foreach ($cadeaux as &$cadeau) {
      $cadeau['chemin_photo_PP'] = $photo->getPPPackage($cadeau['id_package']);
      $cadeau['chemin_photos'] = $photo->getPhotosPackage($cadeau['id_package']);
    }
    return $cadeaux;
  }


  /*******************************************************
  Retourne les informations d'un cadeau
    Entrée : 
      idClient [int] : Identifiant du cadeau

    Retour : 
      [array] : Tableau associatif contenant les information du escape ou FALSE en cas d'erreur
   *******************************************************/
  public function getCadeau($idCadeau)
  {
    $req = 'SELECT * FROM package WHERE id_package=?';
    $resultat = $this->execReqPrep($req, array($idCadeau));

    if (isset($resultat[0])){  // Le cadeau se trouve dans la 1ère ligne de $resultat

      $photo = new Photo(); // Instanciation de la classe Photo (assurez-vous que la classe Photo est correctement définie)
        
      // Récupération du chemin de la photo principale et ajout à l'array de résultat
      $resultat[0]['chemin_photo_PP'] = $photo->getPPPAckage($resultat[0]['id_package']);
  
      // Récupération des chemins de toutes les photos et ajout à l'array de résultat
      $resultat[0]['chemin_photos'] = $photo->getPhotosPackage($resultat[0]['id_package']);

      return $resultat[0];} 
    else
      return FALSE;           // Retourne FALSE si le client n'existe pas

    // Ou :
    //return isset($resultat[0]) ? $resultat[0] : FALSE;    // Retourne FALSE si le escape n'existe pas
  }

  /*******************************************************
  Retourne les informations du coupon
    Entrée : 
      idClient [int] : Identifiant du cadeau

    Retour : 
      [array] : Tableau associatif contenant les information du escape ou FALSE en cas d'erreur
   *******************************************************/
  public function getCoupon()
  {
    $req = 'SELECT * FROM package WHERE type=?';
    $resultat = $this->execReqPrep($req, array("carte"));

    if (isset($resultat[0])){  // Le cadeau se trouve dans la 1ère ligne de $resultat

      $photo = new Photo(); // Instanciation de la classe Photo (assurez-vous que la classe Photo est correctement définie)
        
      // Récupération du chemin de la photo principale et ajout à l'array de résultat
      $resultat[0]['chemin_photo_PP'] = $photo->getPPPAckage($resultat[0]['id_package']);
  
      // Récupération des chemins de toutes les photos et ajout à l'array de résultat
      $resultat[0]['chemin_photos'] = $photo->getPhotosPackage($resultat[0]['id_package']);

      return $resultat[0];} 
    else
      return FALSE;           // Retourne FALSE si le client n'existe pas

    // Ou :
    //return isset($resultat[0]) ? $resultat[0] : FALSE;    // Retourne FALSE si le escape n'existe pas
  }

  public function updateCadeau($nom, $prix, $temps_livré,$hauteur, $largeur, $idCadeau)
  {
    $req = 'UPDATE package SET nom = ?, prix = ?, temps_livré = ?, hauteur = ?, largeur = ? WHERE id_package = ?';

    $reponse = $this->execReqPrep($req, array($nom, $prix, $temps_livré,$hauteur,$largeur, $idCadeau));
    if ($reponse == 1)
      return TRUE;
    return FALSE;
  }


  public function insertCadeau($nom, $prix, $temps_livré,$hauteur, $largeur)
  {
    $req = 'INSERT INTO package(nom,prix, temps_livré, type, hauteur, largeur) ' .
      'VALUES (?, ?, ?, ?,?,?);';

    $reponse = $this->execReqPrep($req, array($nom, $prix, $temps_livré, 'cadeau', $hauteur, $largeur));
      // Vérifiez si l'insertion s'est bien déroulée
      if ($reponse == 1) {
        // Si oui, récupérez l'ID de la dernière insertion
        $id_package = $this->lootLastIdInsert();
        // Retournez l'ID du package et un indicateur de succès
        return array('id_package' => $id_package, 'succes' => true);
    } else {
        // Sinon, retournez null pour l'ID du package et un indicateur d'échec
        return array('id_package' => null, 'succes' => false);
    }
  }

  public function addCadeauPP($nouvelle_photo_profil,$id_package){
    if(!is_dir('img/package/'.$id_package)){
      if(!mkdir('img/package/'.$id_package, 0777, true)) return FALSE ;
    }
    if(!is_dir('img/package/'.$id_package.'/PP')){
      if(!mkdir('img/package/'.$id_package.'/PP', 0777, true)) return FALSE ;
    }

    $cheminImage = glob('img/package/'.$id_package.'/PP/' . "*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);
    if (!empty($cheminImage)) {
      unlink($cheminImage[0]);
    }

    $extension = pathinfo($nouvelle_photo_profil['name'], PATHINFO_EXTENSION);
    $nouveauNom = uniqid() . '.' . $extension;
    $cheminTemporaire = $nouvelle_photo_profil['tmp_name'];
    $nouveauChemin = 'img/package/'.$id_package.'/PP/' . $nouveauNom;

    if(move_uploaded_file($cheminTemporaire, $nouveauChemin)) return TRUE;
    else return FALSE;

  }

  public function addCadeauPhotos($nouvelles_photos,$id_package){
    if(!is_dir('img/package/'.$id_package)){
      if(!mkdir('img/package/'.$id_package, 0777, true)) return FALSE ;
    }
    $cheminDossier = 'img/package/'.$id_package.'/';
    foreach($nouvelles_photos['name'] as $index => $nomFichier){
      $cheminTemporaire = $nouvelles_photos['tmp_name'][$index];
      $extension = pathinfo($nomFichier, PATHINFO_EXTENSION);
      $nouveauNom = uniqid() . '.' . $extension;
      $nouveauChemin = $cheminDossier . $nouveauNom;
      if(!move_uploaded_file($cheminTemporaire, $nouveauChemin)) return FALSE ;
}
      return TRUE ;
  }

  public function delCadeauPhotos($photos_a_supprimer){
    foreach($photos_a_supprimer as $value){
      if(!unlink($value)) return FALSE ;
    }

    return TRUE;
  }

  public function insertAndUpdateCadeauAdminJSON($id_package,$descriptionEN,$descriptionFR,$descriptionDE){
    $jsonData = file_get_contents("donnees/structure.json");

    // Décoder le JSON en un tableau PHP associatif
    $data = json_decode($jsonData, true);

    $data['Packages'][$id_package]['.description']['en'] = $descriptionEN;
    $data['Packages'][$id_package]['.description']['fr'] = $descriptionFR;
    $data['Packages'][$id_package]['.description']['de'] = $descriptionDE;

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

  public function deleteCadeau($id_package)
  {
    $req = "DELETE FROM `package` WHERE id_package = ?   ";
    $resultat = $this->execReqPrep($req, array($id_package));
    return $resultat !== false; // Retourne true si $resultat est différent de false, sinon false
  }

  public function deletePhotosCadeau($id_package){
    $cheminDossier = 'img/package/' . $id_package;

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
                if (!$this->deletePhotosCadeau($id_package . '/' . $element)) {
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

  public function deleteJSONCadeau($id_package)
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
    $recursiveArrayDelete($data, $id_package);

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


  public function addCommande($id_membre,$id_package,$date,$adresse,$prix){
    $req = "INSERT INTO `commander` ( `id_membre`, `id_package`, `date`, `adresse_postal`, `prix` ) VALUES (?, ?, ?, ?, ?)";
    $this->execReqPrep($req,array($id_membre,$id_package,$date,$adresse,$prix));
  }

}   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement