<?php
  /**
   * Application CTF Hackathon 2022
   * BTS SIO
   * Lycée de Bellepierre
   */

  require_once("include/fct.inc.php");
  require_once("include/class.pdoctf.inc.php");
  include("vues/v_entete.php");
  session_start();

  $pdo = PdoCtf::getPdoCtf();
  $estConnecte = estConnecte();
  if (!isset($_REQUEST['uc']) || !$estConnecte) {
    $_REQUEST['uc'] = 'connexion';
  }
  $uc = $_REQUEST['uc'];
  echo $uc;
  switch ($uc) {
    case 'connexion': {
      include("controleur/c_connexion.php");
      break;
    }
    case 'enigme': {
      include("controleur/c_enigmes.php");
      break;
    }
    case 'connexionProf':{
      include("controleur/c_connexionProf.php");
      break;
    }
  }
  include("vues/v_pied.php");
?>