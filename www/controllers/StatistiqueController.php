<?php


namespace warhammerScoreBoard\controllers;


use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\View;
use warhammerScoreBoard\managers\JoueurManager;
use warhammerScoreBoard\models\Joueur;

class StatistiqueController extends \warhammerScoreBoard\core\Controller
{
    public function getStatistiqueUtilisateurAction()
    {
        Helper::checkConnected();
        $myView = new View("statistiques", "front");
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
    }
}