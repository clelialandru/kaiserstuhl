<?php
require_once "modele/database.class.php";

/***************************************************************
Classe chargée de la gestion des membres dans la base de données
***************************************************************/
class membre extends database {

  /*******************************************************
  Retourne les informations d'un memnre
    Entrée : 
      mail [int] : mail d'un membre

    Retour : 
      [array] : Tableau associatif contenant les information du membre ou FALSE en cas d'erreur
  *******************************************************/
  public function getMembreLogin($mail,$mdp) {
    $mdpHashed = hash('sha256',$mdp);
    $req = 'SELECT * FROM membre WHERE email=? AND mdp=?';
    $resultat = $this->execReqPrep($req, array($mail,$mdpHashed));

    if(isset($resultat[0]))   // Le membre se trouve dans la 1ère ligne de $resultat
      return $resultat[0];
    else
      return FALSE;           // Retourne FALSE si le membre n'existe pas
    
    // Ou :
    //return isset($resultat[0]) ? $resultat[0] : FALSE;    // Retourne FALSE si le membre n'existe pas
  }

  public function getMembre($id_membre) {
    $req = 'SELECT id_membre, nom, prenom, email, num_tel FROM membre WHERE id_membre = ?';
    $membre = $this->execReqPrep($req, array($id_membre));

    return $membre[0];

  }

  public function addMember($prenom, $nom, $mail, $mdp){
    $mdpHashed = hash('sha256', $mdp);
    $req = 'INSERT INTO membre (nom, prenom, mdp, email, role) VALUES (?, ?, ?, ?, "client")';
    $resultat = $this->execReqPrep($req, array($nom, $prenom, $mdpHashed, $mail));
    
    if ($resultat !== false) {
        return true;
    } else {
        return false;
    }
}


  public function checkEmail($mail) {
    $req = 'SELECT email FROM membre WHERE email = ?';
    $resultat = $this->execReqPrep($req, array($mail)) ;

    if(isset($resultat[0])) return TRUE ;
    else return FALSE ;
  }

  public function updateCompte($prenom,$nom,$email,$tel,$id_membre){
    $req = 'UPDATE membre SET prenom = ?, nom = ?, email=?,num_tel = ? WHERE id_membre = ?';
    $reponse = $this->execReqPrep($req, array($prenom,$nom,$email,$tel,$id_membre));
    var_dump($tel);
    if ($reponse ==1)
      return TRUE;
    return FALSE;
  }

  public function updatePwd($mdp,$id_membre){
    $mdpHashed = hash('sha256',$mdp);
    $req = 'UPDATE membre SET mdp = ? WHERE id_membre = ?';

    $reponse = $this->execReqPrep($req, array($mdpHashed,$id_membre));
    if ($reponse ==1)
      return TRUE;
    return FALSE;
  }

}   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement