<?php


namespace warhammerScoreBoard\controllers;

use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\Validator;
use warhammerScoreBoard\core\View;
use warhammerScoreBoard\forms\InitialisationPartieForm;
use warhammerScoreBoard\managers\ArmeeManager;
use warhammerScoreBoard\managers\JoueurManager;
use warhammerScoreBoard\managers\MissionJoueurManager;
use warhammerScoreBoard\managers\missionManager;
use warhammerScoreBoard\managers\PartieManager;
use warhammerScoreBoard\models\Joueur;
use warhammerScoreBoard\models\MissionJoueur;
use warhammerScoreBoard\models\Partie;

class PartieController extends Controller
{
    public function initialisationPartieAction()
    {
        $missions = new missionManager();
        $armees = new ArmeeManager();
        $myView = new View("initialisationPartie", "front");
        $initPartie = InitialisationPartieForm::getForm();
        $myView->assign("initPartie", $initPartie);


        $missionsPrincipale = $missions->getMission(["idMission","nomMission"],[["typeCategorie","=","1"]]);
        $myView->assign("missionPrincipale", $missionsPrincipale);

        $armee = $armees->getArmee();
        $myView->assign("armee", $armee);

        $missionsSecondaire = $missions->getMission(["idMission","nomMission"],[["typeCategorie","=","2"]]);
        $myView->assign("missionSecondaire", $missionsSecondaire);

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $validator = new Validator();
            $errors = $validator->checkForm($initPartie, $_POST);
            if (empty($errors)) {
                //création de la partie
                $partieManager = new PartieManager();
                $partie = new Partie();
                if (isset($_POST)) {
                    $partie = $partie->hydrate($_POST);
                }
                $_SESSION["idPartie"] = $partieManager->save($partie);

                //création des 2 joueurs participant à la partie
                $missionJoueurManager = new MissionJoueurManager();
                $joueurManager = new JoueurManager();
                for ($i = 1; $i <= 2; $i++) {
                    //création d'un joueur
                    $joueur = [
                        "nomJoueur" => $_SESSION['pseudoJoueur' . $i] ?? 'joueur' . $i,
                        "idUtilisateur" => $_SESSION['idUtilisateur' . $i] ?? '',
                        "idArmee" => $_POST['armee' . $i] ?? '',
                        "idPartie" => $_SESSION['idPartie'],
                    ];
                    $joueur{$i} = new Joueur();
                    $joueur{$i} = $joueur{$i}->hydrate($joueur);
                    $_SESSION["idJoueur" . $i] = $joueurManager->save($joueur{$i});

                    //attribution des missions du joueur
                    //attribution de la mission principale
                    $missionJoueur = new MissionJoueur();
                    $associationMission = ["idJoueur" => $_SESSION["idJoueur" . $i]];
                    $associationMission["idMission"] = $_POST["missionPrincipale"];
                    $missionJoueur = $missionJoueur->hydrate($associationMission);
                    $missionJoueurManager->save($missionJoueur);
                    //attribution des missions secondaires
                    $m = 1;
                    foreach ($_POST as $key => $value) {
                        if ($key == "missionSecondaire" . $m . "_Joueur" . $i) {
                            $m++;
                            $associationMission["idMission"] = $value;
                            $missionJoueur = $missionJoueur->hydrate($associationMission);
                            $missionJoueurManager->save($missionJoueur);
                        }

                    }
                }
            }
            else
            {
                $errors = array_unique($errors);
                $myView->assign("erreurs", $errors);
            }
        }

    }
}