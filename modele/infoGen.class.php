<?php
require_once "modele/database.class.php";

/***************************************************************
Classe chargée de la gestion des info générique dans la base de données
***************************************************************/
class infoGen extends database {

  /*******************************************************
  Retourne la liste des infos
    Entrée : 
  
    Retour : 
      [array] : Tableau associatif contenant la liste des info
  *******************************************************/
  public function getInfoGen() {
     $req = 'SELECT * FROM info_general';
    $infoGen = $this->execReq($req);
    return $infoGen;
  }

  public function updateInfoGen($num_tel,$mail,$adresse){
    $req = 'UPDATE info_general SET num_tel = ?, mail = ?, adresse = ?';

    $reponse = $this->execReqPrep($req, array($num_tel,$mail,$adresse));
    if ($reponse ==1)
      return TRUE;
    return FALSE;

  }

}   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement