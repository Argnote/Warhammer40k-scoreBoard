<?php


namespace warhammerScoreBoard\controllers;


use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\core\View;
use warhammerScoreBoard\managers\JoueurManager;
use warhammerScoreBoard\managers\LivreManager;
use warhammerScoreBoard\managers\MissionManager;
use warhammerScoreBoard\managers\PointManager;
use warhammerScoreBoard\models\Joueur;

class StatistiqueController extends \warhammerScoreBoard\core\Controller
{
    //Choix des statisques
    public function chooseStatistiqueAction()
    {
        new View("chooseStatistique", "front");
    }

    //Affiche les Statistiques généraux
    public function getStatisqueGeneraleAction()
    {
        $livreManager = new LivreManager();
        $myView = new View("statistiques", "front");
        $myView->assignTitle("Statistiques générales");
        $livre = $livreManager->getAllLivre();
        $myView->assign("livres", $livre);

        //récupère les missions des joueurs non archivé et rattaché à un compte
        $statMissionClassement = $this->statMissionSelected(true,null,[["typeCategorie","=",2]],true);
        if(!empty($statMissionClassement))
        {
            $myView->assign("statMissionClassement", $statMissionClassement);
        }

        //Récupère les points des missions des joueurs non archivé et rattaché à un compte
        $condition = [
            [DB_PREFIXE."joueur.idUtilisateur","IS NOT"," NULL"],
            [DB_PREFIXE."joueur.archived","=",0]
            ];
        $statMissionParPointClassement = $this->statMissionPoints($condition);
        if(!empty($statMissionClassement))
        {
            $myView->assign("statMissionClassementParPoint", $statMissionParPointClassement);
        }
        //Message d'avertissement
        $avertissement = "Attention, les statistiques générales sont effectués grace aux données fournies par la communauté.<br/>
 Par conséquent ces statistiques peuvent manquer d'exactitude.<br/>
 Afin de limiter cela et fournir des statistiques les plus précises possibles, seules les données fournies par les membres inscrits sont utilisées.<br/>
 Merci de votre compréhension";

        $myView->assign("avertissement",$avertissement);
    }

    //Récupère les statisiques de compte connecté
    public function getStatistiqueUtilisateurAction()
    {
        Helper::checkConnected();
        $livreManager = new LivreManager();
        $myView = new View("statistiques", "front");
        $myView->assignTitle("Statistiques utilisateurs");
        $livre = $livreManager->getAllLivre();
        $myView->assign("livres", $livre);
        $joueurManager = new JoueurManager();

        //Récupère les joueurs non archivé rattaché à l'utilisateur connecté
        $joueurs = $joueurManager->getPartiePlayed(true);
        if (!empty($joueurs)) {
            $statVictoire = [
                "victoire" => 0,
                "defaite" => 0,
                "egalite" => 0,
                "enCours" => 0
            ];
            foreach ($joueurs as $joueur) {
                switch ($joueur->getGagnant()) {
                    case -1:
                        $statVictoire["defaite"]++;
                        break;
                    case 0:
                        $statVictoire["enCours"]++;
                        break;
                    case 1:
                        $statVictoire["victoire"]++;
                        break;
                    case 2:
                        $statVictoire["egalite"]++;
                        break;
                }
            }

            //Récupère seulement les valeurs
            $statVictoireData = [$statVictoire["victoire"], $statVictoire["defaite"], $statVictoire["egalite"], $statVictoire["enCours"]];
            $statVictoireData = json_encode($statVictoireData);
            $myView->assign("statVictoireData", $statVictoireData);
        }

        //Récupère les missions des joueurs non archivé et rattaché au compte utilisateur connecté
        $statMissionClassement = $this->statMissionSelected(true,$_SESSION["idUtilisateur1"],[["typeCategorie","=",2]],true);
        if(!empty($statMissionClassement))
        {
            $myView->assign("statMissionClassement", $statMissionClassement);
        }

        //Récupère les points des missions des joueurs non archivé et rattaché au compte utilisateur connecté
        $condition = [
            [DB_PREFIXE."joueur.idUtilisateur","=",$_SESSION["idUtilisateur1"]],
            [DB_PREFIXE."joueur.archived","=",0],
        ];
        $statMissionParPointClassement = $this->statMissionPoints($condition);
        if(!empty($statMissionClassement))
        {
            $myView->assign("statMissionClassementParPoint", $statMissionParPointClassement);
        }
    }

    private function statMissionSelected(bool $activeOnly = true, int $idUtilisateur = null, array $conditions = null,bool $onlyMember = true)
    {
        $missionManager = new MissionManager();

        //Récupère les missions des joueurs 
        $missionClassement= $missionManager->getMissionChooseByJoueur($activeOnly,$idUtilisateur,$conditions,$onlyMember);
        //Récupère toutes les missions
        $allMission = $missionManager->getManyMission(["nomMission","codeLivre"],$conditions,$activeOnly);
        foreach ($allMission as $key => $value)
        {
            $mission = $value["nomMission"]." ".$value["codeLivre"];
            $allMission[$key]["nomMission"] = $mission;
        }

        if(!empty($missionClassement) && !empty($allMission))
        {
            //Créer un tableau avec le nom des missions comme identifiants
            $statMissionClassement = array();
            foreach ($allMission as $mission)
            {
                $statMissionClassement[$mission["nomMission"]] = 0;
            }

            //Ajoute 1 à l'index correspondant au nom de la mission
            foreach ($missionClassement as $mission)
            {
                $statMissionClassement[$mission->getNomMission()." ".$mission->getCodeLivre()] ++;
            }

            //trie de tableau en décroissant
            arsort($statMissionClassement);
            $statMissionClassementLabel = array();
            $statMissionClassementData = array();

            //sépare les clefs des valeurs
            foreach ($statMissionClassement as $key=>$value)
            {
                $statMissionClassementLabel[] = $key;
                $statMissionClassementData[] = $value;
            }
            $statMissionClassement = array();
            $statMissionClassement["label"] = $statMissionClassementLabel;
            $statMissionClassement["data"] = $statMissionClassementData;
            $statMissionClassement = htmlspecialchars(json_encode($statMissionClassement));
            return $statMissionClassement;
        }
        return null;
    }

    private function statMissionPoints(array $conditions = null,bool $activeOnly = true)
    {
        $missionManager = new MissionManager();
        $pointManager = new PointManager();

        //Récupère les points des missions
        $missionClassementPoints= $pointManager->getPoint(["nomMission","nombrePoint","codeLivre"],$conditions);
        foreach ($missionClassementPoints as $key => $value)
        {
            $mission = $value["nomMission"]." ".$value["codeLivre"];
            $missionClassementPoints[$key]["nomMission"] = $mission;
        }

        //Récupère toutes les missions
        $allMission = $missionManager->getManyMission(["nomMission","codeLivre"],null,$activeOnly);
        foreach ($allMission as $key => $value)
        {
            $mission = $value["nomMission"]." ".$value["codeLivre"];
            $allMission[$key]["nomMission"] = $mission;
        }

        if(!empty($missionClassementPoints) && !empty($allMission))
        {
            //Créer un tableau avec le nom des missions comme identifiants
            $statMissionClassement = array();
            foreach ($allMission as $mission)
            {
                $statMissionClassement[$mission["nomMission"]] = 0;
            }

            //Ajoute 1 à l'index correspondant au nom de la mission
            foreach ($missionClassementPoints as $points)
            {
                $statMissionClassement[$points["nomMission"]] += $points["nombrePoint"];
            }

            //trie de tableau en décroissant
            arsort($statMissionClassement);
            $statMissionClassementLabel = array();
            $statMissionClassementData = array();

            //sépare les clefs des valeurs
            foreach ($statMissionClassement as $key=>$value)
            {
                $statMissionClassementLabel[] = $key;
                $statMissionClassementData[] = $value;
            }
            $statMissionClassement = array();
            $statMissionClassement["label"] = $statMissionClassementLabel;
            $statMissionClassement["data"] = $statMissionClassementData;
            $statMissionClassement = htmlspecialchars(json_encode($statMissionClassement));
            return $statMissionClassement;
        }
        return null;
    }
}