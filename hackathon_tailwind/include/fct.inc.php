<?php

/**
 * Fonctions pour l'application Hackathon 2022
 * 
 * @package default
 * @author SIO2 : Bryce, Dimitri, Fardeen, Victor
 * @version    1.0
 */

/**
 * Teste si une quelconque équipe est connecté
 * 
 * @return vrai ou faux 
 */
function estConnecte()
{
    return isset($_SESSION['id']);
}

/**
 * Détruit la session active
 */
function deconnecter()
{
    session_destroy();
}

/**
 * Enregistre dans une variable session les infos d'une équipe
 
 * @param $id 
 * @param $nom
 */
function connecter($id, $nom)
{
    $_SESSION['id'] = $id;
    $_SESSION['login'] = $nom;

}


/**
 * Ajoute le libellé d'une erreur au tableau des erreurs 
 * 
 * @param $msg : le libellé de l'erreur 
 */
function ajouterErreur($msg)
{
    if (!isset($_REQUEST['erreurs'])) {
        $_REQUEST['erreurs'] = array();
    }
    $_REQUEST['erreurs'][] = $msg;
}

/**
 * Retoune le nombre de lignes du tableau des erreurs 
 
 * @return le nombre d'erreurs
 */
function nbErreurs()
{
    if (!isset($_REQUEST['erreurs'])) {
        return 0;
    } else {
        return count($_REQUEST['erreurs']);
    }
}

/**
         * Retourne vrai si l'équipe a déjà résolu l'énigme (idEnigme et idEquipe existe dans la table concerner)
         * @param $idChallenge, $idEquipe
         * @return vrai ou faux
         */
    // function estResolu($idChallenge, $idEquipe){
    //     global $pdo;
    //     return $pdo->estResolu($idChallenge, $idEquipe);
    
    //     }

