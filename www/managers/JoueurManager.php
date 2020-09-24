<?php


namespace warhammerScoreBoard\managers;


use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\models\Joueur;
use warhammerScoreBoard\models\modelsFusion\GetPartiePlayed;

class JoueurManager extends Manager
{
    public function __construct()
    {
        parent::__construct(Joueur::class, 'joueur');
    }

    public function defGagnantStatue(int $idGagnant, int $idPerdant, bool $egalite = false)
    {
        $victoire = 1;
        $defaite = -1;
        if($egalite == true)
        {
            $victoire = 2;
            $defaite = 2;
        }

        $joueur = new Joueur();
        $gagnant = [
            "idJoueur" => $idGagnant,
            "gagnant" => $victoire
        ];
        $joueur = $joueur->hydrate($gagnant);
        $this->save($joueur);

        $perdant = [
            "idJoueur" => $idPerdant,
            "gagnant" => $defaite
        ];
        $joueur = $joueur->hydrate($perdant);
        $this->save($joueur);

    }

    public function getPartiePlayedWithAdversaire(bool $activeOnly = null)
    {
        $requeteIn = new QueryBuilder(GetPartiePlayed::class, "joueur");
        $requeteIn->querySelect(["idPartie"]);
        $requeteIn->queryFrom();
        $requeteIn->queryWhere("idUtilisateur", "=", $_SESSION["idUtilisateur1"]);
        if($activeOnly == true)
        {
            $requeteIn->queryWhere("archived","=", "0");
        }
        $resultIn = $requeteIn->queryGet();

        $requete = new QueryBuilder(GetPartiePlayed::class, "joueur");
        $requete->querySelect(["idUtilisateur","nomJoueur","nomArmee" ,"gagnant", "dateDebut", DB_PREFIXE."partie.idPartie"]);
        $requete->queryFrom();
        $requete->queryLeftJoin("joueur","armee","idArmee","idArmee");
        $requete->queryJoin("joueur","partie","idPartie","idPartie");
        $requete->queryWhere(DB_PREFIXE."partie.idPartie", "in", $resultIn);


        $requete->queryOrderBy("dateDebut","DESC");
        return $requete->queryGetArrayToArray();
    }

    public function getPartiePlayed(bool $activeOnly = null)
    {
        $requete = new QueryBuilder(Joueur::class, "joueur");
        $requete->querySelect(["*"]);
        $requete->queryFrom();
        $requete->queryWhere("idUtilisateur", "=", $_SESSION["idUtilisateur1"]);
        if($activeOnly == true)
        {
            $requete->queryWhere("archived","=", "0");
        }
        return $requete->queryGetArray();
    }

    public function getJoueurPartie(int $idPartie, array $data = ["idJoueur","idUtilisateur","nomJoueur"])
    {
        $requete = new QueryBuilder(Joueur::class, "joueur");
        $requete->querySelect($data);
        $requete->queryFrom();
        $requete->queryWhere("idPartie", "=", $idPartie);
        return $requete->queryGetArrayToArray();
    }

    public function getJoueur(int $idJoueur,array $data = ["*"],array $conditions = null)
    {
        $requete = new QueryBuilder(Joueur::class, "joueur");
        $requete->querySelect($data);
        $requete->queryFrom();
        if(!empty($conditions))
        {
            foreach ($conditions as $condition )
            {
                $requete->queryWhere($condition[0], $condition[1], $condition[2]);
            }
        }
        $requete->queryWhere("idJoueur", "=", $idJoueur);
        return $requete->queryGetValue();
    }
}