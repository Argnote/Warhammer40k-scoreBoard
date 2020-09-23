<?php


namespace warhammerScoreBoard\controllers;


use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\View;
use warhammerScoreBoard\managers\JoueurManager;
use warhammerScoreBoard\managers\MissionManager;
use warhammerScoreBoard\models\Joueur;

class StatistiqueController extends \warhammerScoreBoard\core\Controller
{
    public function chooseStatistiqueAction()
    {
        new View("chooseStatistique", "front");
    }

    public function getStatisqueGeneraleAction()
    {
        $myView = new View("statistiques", "front");
        $myView->assignTitle("Statistiques générales");
        $statMissionClassement = $this->statMissionSelected(true,null,[["typeCategorie","=",2]],true);
        if(!empty($statMissionClassement))
        {
            $myView->assign("statMissionClassementLabel", $statMissionClassement["label"]);
            $myView->assign("statMissionClassementData", $statMissionClassement["data"]);
        }
        $avertissement = "Attention, les statistiques générales sont effectués grace aux données fournies par la communauté.<br/>
 Par conséquent ces statistiques peuvent manquer d'exactitude.<br/>
 Afin de limiter cela et fournir des statistiques les plus précises possibles, seules les données fournies par les membres inscrits sont utilisées.<br/>
 Merci de votre compréhension";

        $myView->assign("avertissement",$avertissement);
    }

    public function getStatistiqueUtilisateurAction()
    {
        Helper::checkConnected();
        $myView = new View("statistiques", "front");
        $myView->assignTitle("Statistiques utilisateurs");
        $joueurManager = new JoueurManager();
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
            $statVictoireData = [$statVictoire["victoire"], $statVictoire["defaite"], $statVictoire["egalite"], $statVictoire["enCours"]];
            $statVictoireData = json_encode($statVictoireData);
            $myView->assign("statVictoireData", $statVictoireData);
        }
        $statMissionClassement = $this->statMissionSelected(true,$_SESSION["idUtilisateur1"],[["typeCategorie","=",2]],true);
        if(!empty($statMissionClassement))
        {
            $myView->assign("statMissionClassementLabel", $statMissionClassement["label"]);
            $myView->assign("statMissionClassementData", $statMissionClassement["data"]);
        }
    }

    private function statMissionSelected(bool $activeOnly = true, int $idUtilisateur = null, array $conditions = null,bool $onlyMember = true)
    {
        $missionManager = new MissionManager();
        $missionClassement= $missionManager->getMissionChooseByJoueur($activeOnly,$idUtilisateur,$conditions,$onlyMember);
        $allMission = $missionManager->getManyMission(["nomMission"],$conditions,$activeOnly);

        if(!empty($missionClassement) && !empty($allMission))
        {
            //print_r($missionUtilisateur);
            $statMissionClassement = array();
            foreach ($allMission as $mission)
            {
                $statMissionClassement[$mission["nomMission"]] = 0;
            }
            foreach ($missionClassement as $mission)
            {
                $statMissionClassement[$mission->getNomMission()] ++;
            }
            arsort($statMissionClassement);
            $statMissionClassementLabel = array();
            $statMissionClassementData = array();

            foreach ($statMissionClassement as $key=>$value)
            {
                $statMissionClassementLabel[] = $key;
                $statMissionClassementData[] = $value;
            }
            $statMissionClassement = array();
            $statMissionClassement["label"] = htmlspecialchars(json_encode($statMissionClassementLabel));
            $statMissionClassement["data"] = json_encode($statMissionClassementData);
            return $statMissionClassement;
        }
        return null;
    }
}