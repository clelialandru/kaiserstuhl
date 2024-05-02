<?php
//var_dump($_SESSION);

require "controleur/ctlAventure.class.php";
require "controleur/ctlCadeau.class.php";
require "controleur/ctlAccueil.class.php";
require "controleur/ctlMembre.class.php";
require "controleur/ctlPage.class.php";
require "controleur/ctlInfoGen.class.php";


/*******************************************************
Class chargée du routage des requêtes
 *******************************************************/

class Routeur
{

  private $ctlPage;
  private $ctlAccueil;
  private $ctlAventure;
  private $ctlCadeau;
  private $ctlInfoGen;
  private $ctlMembre;


  /*******************************************************
  Instancie les objets utilisés par la class
    Entrée : 
  
    Retour : 
      $ctlClient [object] : objets controleur "client"
      $ctlArticle [object] : objets controleur "article"
      $ctlCommande [object] : objets controleur "commande"
      $ctlPage [object] : objets controleur "page"
   *******************************************************/


  public function __construct()
  {

    $this->ctlPage = new ctlPage();

    $this->ctlAccueil = new ctlAccueil();

    $this->ctlAventure = new ctlAventure();

    $this->ctlCadeau = new ctlCadeau();

    $this->ctlMembre = new ctlMembre();

    $this->ctlInfoGen = new ctlInfoGen();
  }

  /*******************************************************
    Selectionne le controleur en fonction de la requête GET
    Entrée : 
      GET[array]

    Retour : 

   *******************************************************/


  public function routerRequete()
  {

    if(isset($_SESSION['infoReservation']) ||
      isset($_SESSION['infoCommande']) &&

    (!empty($_SESSION['infoReservation'] || 
    $_SESSION['infoAventure'] || 
    $_SESSION['infoCommande'] || 
    $_SESSION['infoCadeau'] )) &&(
    $_GET["action"] != "paiement"||
    $_GET["action"] != "connectToPay"||
    $_GET["action"] != "createToPay"||
    $_GET["action"] != "nextToPay"||
    $_GET["action"] != "payer")){
      if($_SESSION['infoReservation']){
        unset($_SESSION['infoAventure']);
        unset($_SESSION['infoReservation']);
      }
      else {
        unset($_SESSION['infoCadeau']);
        unset($_SESSION['infoCommande']);        
      }
      unset($_SESSION['infoCard']);


    }




    try {
      if (isset($_GET["action"])) {
        switch ($_GET['action']) {

          case 'clients':
            $this->ctlClient->clients();
            break;

          case 'aventures':
            $this->ctlAventure->aventures();
            break;

          case 'aventure':
            if (isset($_GET['id_aventure'])) {
              $id_aventure = (int)$_GET['id_aventure'];
              if ($id_aventure >= 0)
                $this->ctlAventure->aventure($id_aventure);
              else
                throw new Exception("Identifiant d'aventure invalide");
            } else
              throw new Exception("Aucun identifiant d'aventure");
            break;

          case 'paiement' : 
            if(isset($_POST)){
              if(isset($_POST['id_game'])){
                if($this->ctlAventure->checkReservation()){
                $this->ctlAventure->paiement();}
              }else if(isset($_POST['id_package'])){
                $this->ctlCadeau->paiement();
              }

              

            } else
              throw new Exception("Aucun identifiant d'aventure");
            break;

          case 'cadeaux':
            $this->ctlCadeau->cadeaux();
            break;

          case 'cadeau':
            if (isset($_GET['id_cadeau'])) {
              $id_cadeau = (int)$_GET['id_cadeau'];
              if ($id_cadeau > 0)
                $this->ctlCadeau->cadeau($id_cadeau);
              else
                throw new Exception("Identifiant de cadeau invalide");
            } else
              throw new Exception("Aucun identifiant de cadeau");
            break;
          
            case 'giftcard':
              $this->ctlCadeau->coupons();
              break;

          case 'contact':
            $this->ctlPage->contact();
            break;

          case 'FAQ':
            $this->ctlPage->FAQ();
            break;

          case 'mentleg':
            $this->ctlPage->mentleg();
            break;
          
          case 'confidentiality':
            $this->ctlPage->confidentiality();
            break;

          case 'cgv':
            $this->ctlPage->cgv();
            break;


          case 'login':
            if (isset($_SESSION['membre']) || isset($_SESSION['admin'])) {
              $this->ctlMembre->logout();
            } else
              $this->ctlMembre->login();
            break;

          case 'leave':
            $this->ctlMembre->leave();

          case 'connection':
            if(isset($_POST)){
            $this->ctlMembre->connection();              
            } else $this->ctlMembre->login("Connection impossible");

            break;

          case 'newCompte' :
            $this->ctlMembre->newCompte();
            break;

          case 'connectToPay' :
            if(isset($_POST)){
              $this->ctlMembre->connectToPay();
            }else header("Location: index.php?action=paiement");

            break;

          case 'createToPay' :
            if(isset($_POST)){
              $this->ctlMembre->createToPay();
            }else header("Location: index.php?action=paiement");

            break;

          case 'nextToPay' :
            if(isset($_POST)){
              $this->ctlMembre->nextToPay();
            }else header("Location: index.php?action=paiement");

            break;

          case 'payer' :
            if(isset($_POST)){
              if(isset($_SESSION['infoAventure']['id_game']))
              $this->ctlAventure->payer();
              else if(isset($_SESSION['infoCadeau']['id_package']))
              $this->ctlCadeau->payer();

            }else {
              header("Location: index.php?action=paiement");
            }
            break ;


          case 'acceuilMembre':
            if (isset($_SESSION['membre'])) {
              $this->ctlMembre->acceuilMembre();
            } else
              throw new Exception("Action non valide");
            break;

          case 'infoCompte':
            if (isset($_SESSION['membre'])) {
              $this->ctlMembre->infoCompte();
            } else
              throw new Exception("Action non valide");
            break;

          case 'updateCompte':
            if (isset($_SESSION['membre'])) {
              $this->ctlMembre->updateCompteMembre();
            } else
              throw new Exception("Action non valide");
            break;

          case 'updatePwd':
            if (isset($_SESSION['membre'])) {
              $this->ctlMembre->updatePwdMembre();
            } else
              throw new Exception("Action non valide");
            break;

          case 'reservationMembre':
            if (isset($_SESSION['membre']) && isset($_GET['id_reservation'])) {
              $this->ctlMembre->reservationMembre($_GET['id_reservation']);
            } else
              throw new Exception("Action non valide");
            break;

          case 'annulerReservationMembre':
            if (isset($_SESSION['membre'])) {
              $this->ctlMembre->annulerReservationMembre();
            } else
              throw new Exception("Action non valide");
            break;

          case 'acceuilAdmin':
            if (isset($_SESSION['admin'])) {
              $this->ctlMembre->acceuilAdmin();
            } else
              throw new Exception("Action non valide");
            break;

          case 'cadeauxAdmin':
            if (isset($_SESSION['admin'])) {
              $this->ctlCadeau->cadeauxAdmin();
            } else
              throw new Exception("Action non valide");
            break;


          case 'cadeauAdmin':
            if (isset($_SESSION['admin'])) {
              if (isset($_GET['id_cadeau'])) {
                $id_cadeau = (int)$_GET['id_cadeau'];
                if ($id_cadeau > 0)
                  $this->ctlCadeau->cadeauAdmin($id_cadeau);
                else
                  throw new Exception("Identifiant de cadeau invalide");
              } else
                throw new Exception("Aucun identifiant de cadeau");
            } else
              throw new Exception("Action non valide");
            break;

          case 'updateCadeauAdmin' :
            if(isset($_SESSION['admin']) && isset($_POST)){
                $this->ctlCadeau->updateCadeauAdmin();
                  }
            else 
              throw new Exception("Action non valide");
              break ;

          case 'addCadeauAdmin' :
            if(isset($_SESSION['admin'])){
              $this->ctlCadeau->addCadeauAdmin();
            }
            else 
            throw new Exception("Action non valide");
            break ;

          case 'deleteCadeauAdmin' :
            if(isset($_SESSION['admin']) && isset($_POST)){
              $this->ctlCadeau->deleteCadeauAdmin();
              }
            else 
              throw new Exception("Action non valide");

            break ;

          case 'insertCadeau' :
            if(isset($_SESSION['admin']) && isset($_POST)){
                $this->ctlCadeau->insertCadeauAdmin();
                  }
            else 
              throw new Exception("Action non valide");
              break ;

          case 'reservationAdmin':
            if (isset($_SESSION['admin'])) {
              $this->ctlAventure->reservationAdmin();
            } else
              throw new Exception("Action non valide");
            break;

          case 'annulationCheck' :
            if (isset($_SESSION['admin'])) {
              $this->ctlAventure->reservationAnnulationAdmin();
            } else
              throw new Exception("Action non valide");
            break;

          case 'aventuresAdmin':
            if (isset($_SESSION['admin'])) {
              $this->ctlAventure->aventuresAdmin();
            } else
              throw new Exception("Action non valide");
            break;

            case 'aventureAdmin':
              if (isset($_SESSION['admin'])) {
                if (isset($_GET['id_aventure'])) {
                  $id_aventure = (int)$_GET['id_aventure'];
                  if ($id_aventure > 0)
                    $this->ctlAventure->aventureAdmin($id_aventure);
                  else
                    throw new Exception("Identifiant d'aventure invalide");
                } else
                  throw new Exception("Aucun identifiant de aventure");
              } else
                throw new Exception("Action non valide");
              break;

          case 'updateAventureAdmin' :
            if(isset($_SESSION['admin']) && isset($_POST)){
              $this->ctlAventure->updateAventureAdmin();
              }
            else 
              throw new Exception("Action non valide");
              break ;
            
          case 'addAventureAdmin' :
            if(isset($_SESSION['admin'])){
              $this->ctlAventure->addAventureAdmin();
            }
            else 
            throw new Exception("Action non valide");
            break ;

          case 'deleteAventureAdmin' :
            if(isset($_SESSION['admin']) && isset($_POST)){
              $this->ctlAventure->deleteAventureAdmin();
              }
            else 
              throw new Exception("Action non valide");
              break ;

          case 'insertAventure' :
            if(isset($_SESSION['admin']) && isset($_POST)){
                $this->ctlAventure->insertAventureAdmin();
                  }
            else 
              throw new Exception("Action non valide");
              break ;

          case 'infoGenAdmin':
            if (isset($_SESSION['admin'])) {
              $this->ctlInfoGen->infoGenAdmin();
            } else
              throw new Exception("Action non valide");
            break;

          case 'updateInfoGenAdmin' :
            if(isset($_SESSION['admin']) && isset($_POST)){
              $this->ctlInfoGen->updateInfoGenAdmin();
              }
            else 
              throw new Exception("Action non valide");
              break ;

          default :
            throw new Exception("Action non valide");
            break;
          }}
          else
            $this->ctlAccueil->accueil();
          
          
          }
          catch (Exception $e) {                                                      // Page d'erreur
            $this->ctlPage->erreur($e->getMessage());
          }   // Balise PHP non fermée pour éviter de retourner des caractères "parasites" en fin de traitement
          
          
    }


  }
