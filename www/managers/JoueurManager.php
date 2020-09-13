<?php


namespace warhammerScoreBoard\managers;


use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\models\Joueur;
use warhammerScoreBoard\models\mission;
use warhammerScoreBoard\models\Partie;
use warhammerScoreBoard\models\Utilisateur;

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

    public function getPartiePlayed()
    {
        $requeteIn = new QueryBuilder(Joueur::class, "joueur");
        $requeteIn->querySelect(["idPartie"]);
        $requeteIn->queryFrom();
        $requeteIn->queryWhere("idUtilisateur", "=", $_SESSION["idUtilisateur1"]);
        $resultIn = $requeteIn->queryGet();

        $requete = new QueryBuilder(Joueur::class, "joueur");
        $requete->querySelect(["idUtilisateur","nomJoueur","nomArmee" ,"gagnant", "dateDebut", DB_PREFIXE."partie.idPartie"]);
        $requete->queryFrom();
        $requete->queryJoin("joueur","armee","idArmee","idArmee");
        $requete->queryJoin("joueur","partie","idPartie","idPartie");
        $requete->queryWhere(DB_PREFIXE."partie.idPartie", "in", $resultIn);


        $requete->queryOrderBy("dateDebut","DESC");
        return $requete->queryGetArray();
    }
}