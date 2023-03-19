<?php
class PdoCtf
{
    /**
     * Propriétés privées de la classe PdoCtf pour les phases de tests
     */
    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=hackathon_v2';
    private static $user = 'root';
    private static $mdp = '';
    private static $monPdo;
    private static $monPdoCtf = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct()
    {
        PdoCtf::$monPdo = new PDO(PdoCtf::$serveur . ';' . PdoCtf::$bdd, PdoCtf::$user, PdoCtf::$mdp);
        PdoCtf::$monPdo->query("SET CHARACTER SET utf8");
    }

    public function __destruct()
    {
        PdoCtf::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoCtf = PdoCtf::getPdoCtf();
     * @return l'unique objet de la classe PdoCtf
     */
    public static function getPdoCtf()
    {
        if (PdoCtf::$monPdoCtf == null) {
            PdoCtf::$monPdoCtf = new PdoCtf();
        }
        return PdoCtf::$monPdoCtf;
    }

    /**
     * Retourne les informations d'une équipe
     * @param $login
     * @param $mdp
     * @return l'id, le libelle et le login sous la forme d'un tableau associatif 
     */
    public function getInfosEquipe($login, $mdp)
    {
        $hash = hash('sha512', $mdp);
        $req = "SELECT equipeID, libelle, login  
                    FROM equipe 
                    WHERE login=:login AND motDePasse=:mdp;";
        $req = PdoCtf::$monPdo->prepare($req);
        $req->execute([':login' => $login, ':mdp' => $hash]);
        $ligne = $req->fetch();
        return $ligne;
    }

    /**
     * Retourne les informations d'une équipe
     * @param $login
     * @param $mdp
     * @return l'id, le libelle et le login sous la forme d'un tableau associatif 
     */
    public function getInfosProfesseur($login, $mdp)
    {
        $req = "SELECT id, nom, prenom, login  
                    FROM professeurs 
                    WHERE login=:login AND mdp=SHA2(:mdp, 512);";
        $req = PdoCtf::$monPdo->prepare($req);
        $req->execute([':login' => $login, ':mdp' => $mdp]);
        $ligne = $req->fetch();
        return $ligne;
    }

    /**
     * Retourne les informations d'une enigme
     * @param $id
     * @return l'id, le libelle, le score, le flag et le type sous la forme d'un tableau associatif 
     */

    // public function getLesEnigmes()
    // {
    //     $req = "SELECT numero, libelle, url, categorie, thématique, contenu, nbPoints 
    //                 FROM challenge 
    //                 ORDER BY numero;";
    //     $req = PdoCtf::$monPdo->prepare($req);
    //     $req->execute();
    //     $lignes = $req->fetchAll();
    //     var_dump($lignes);
    //     die();

        // if (estResolu($lignes['numero'])) {
        //     $lignes['resolu'] = true;
        // } else {
        //     $lignes['resolu'] = false;
        // }

    //     return $lignes;
    // }

    /**
     * Retourne vrai si l'équipe a déjà résolu l'énigme (idEnigme et idEquipe existe dans la table concerner)
     * @param $idChallenge, $idEquipe
     * @return vrai ou faux
     */
    // public function estResolu($idChallenge, $idEquipe)
    // {
    //     $req = "SELECT count(*) as total
    //                 FROM concerner 
    //                 WHERE numChallenge=:numChallenge AND idEquipe=:idEquipe AND numPartie=:numPartie;";
    //     $req = PdoCtf::$monPdo->prepare($req);
    //     $req->execute([':numChallenge' => $idChallenge, ':idEquipe' => $idEquipe]);

        // si la requête retourne une ligne, alors l'équipe a déjà résolu l'énigme
    //     $ligne = $req->fetch();
    //     if ($ligne['total'] == 1) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function getEnigmesNonResolues($idEquipe)
    {
        // tout sauf le mot de passe et le flag
        $req = "select * from enigme inner join concerner on concerner.noEnigme = enigme.numEnigme where numEnigme not in (select noEnigme from validation where idEquipe=:idEquipe);";
        $req = PdoCtf::$monPdo->prepare($req);
        $req->execute([':idEquipe' => $idEquipe]);

        $lignes = $req->fetchAll();
        return $lignes;
    }

    public function getEnigmesResolues($idEquipe)
    {
        // tout sauf le mot de passe et le flag
        $req = "select * from enigme  inner join concerner on concerner.noEnigme = enigme.numEnigme where numEnigme in (select noEnigme from validation where idEquipe=:idEquipe)";
        $req = PdoCtf::$monPdo->prepare($req);
        $req->execute([':idEquipe' => $idEquipe]);

        $lignes = $req->fetchAll();
        return $lignes;
    }

    public function getEnigmesNonResoluesByCateg($idEquipe, $noCateg)
    {
        // tout sauf le mot de passe et le flag
        $req = "select * from enigme inner join concerner on concerner.noEnigme = enigme.numEnigme where numEnigme not in (select noEnigme from validation where idEquipe=:idEquipe) and noCategorie = :noCateg;";
        $req = PdoCtf::$monPdo->prepare($req);
        $req->execute([':idEquipe' => $idEquipe, ':noCateg' => $noCateg]);

        $lignes = $req->fetchAll();
        return $lignes;
    }

    public function getEnigmesResoluesByCateg($idEquipe, $noCateg)
    {
        // tout sauf le mot de passe et le flag
        $req = "select * from enigme  inner join concerner on concerner.noEnigme = enigme.numEnigme where numEnigme in (select noEnigme from validation where idEquipe=:idEquipe) and noCategorie = :noCateg;";
        $req = PdoCtf::$monPdo->prepare($req);
        $req->execute([':idEquipe' => $idEquipe,  ':noCateg' => $noCateg]);

        $lignes = $req->fetchAll();
        return $lignes;
    }

    public function getIdEquipe($login)
    {
        $req = "SELECT equipeID 
                FROM equipe
                WHERE login=:login;";
        $req = PdoCtf::$monPdo->prepare($req);
        $req->execute([':login' => $login]);
        $ligne = $req->fetch();
        return $ligne['equipeID'];
    }

    public function getUneEnigme($numChallenge)
    {
        $req = "SELECT numEnigme, libelle, url, thematique, contenu, nbPoints , noCategorie
                FROM enigme 
                WHERE numEnigme=:numero;";
        $req = PdoCtf::$monPdo->prepare($req);
        $req->execute([':numero' => $numChallenge]);
        $ligne = $req->fetch();
        return $ligne;
    }
    
    public function getSessionEnCours($idEquipe)
    {
        $req="select numSession as current_session from session where idEquipe = :idEquipe and dateDebut = (select MIN(dateDebut) FROM session where idEquipe = :idEquipe);";
        $req = PdoCtf::$monPdo->prepare($req);
        $req->execute([':idEquipe'=>$idEquipe]);
        $ligne = $req->fetch();
        return $ligne;
        
        
    }



    public function getIdPartie($idEquipe)
    {
        // recuperation de la session en cours avec la date la plus récente

        $req = "SELECT numero as numPartie
                FROM session
                WHERE idEquipe=:idEquipe;";
        $req = PdoCtf::$monPdo->prepare($req);
        $req->execute([':idEquipe' => $idEquipe]);
        $ligne = $req->fetch();
        return $ligne['numPartie'];
    }

    public function getCategories()
    {
        $req = "SELECT * from categorie;";
        $req = PdoCtf::$monPdo->prepare($req);
        $req->execute();
        $lignes = $req->fetchAll();
        return $lignes;

    }
    public function triEnigmes($noCatgorie){
        $req = "SELECT numEnigme, libelle, url, thematique, contenu, nbPoints, noCategorie
                    FROM enigme 
                    WHERE noCategorie=:noCategorie
                    ORDER BY numEnigme;";
        $req = PdoCtf::$monPdo->prepare($req);
        $req->execute([':noCategorie' => $noCatgorie]);
        $lignes = $req->fetchAll();
        return $lignes;
    }
}
