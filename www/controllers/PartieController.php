<?php


namespace warhammerScoreBoard\controllers;

use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\Validator;
use warhammerScoreBoard\core\View;
use warhammerScoreBoard\forms\InitialisationPartieForm;
use warhammerScoreBoard\forms\ValidationTourForm;
use warhammerScoreBoard\managers\ArmeeManager;
use warhammerScoreBoard\managers\JoueurManager;
use warhammerScoreBoard\managers\MissionJoueurManager;
use warhammerScoreBoard\managers\missionManager;
use warhammerScoreBoard\managers\PartieManager;
use warhammerScoreBoard\managers\PointManager;
use warhammerScoreBoard\managers\TourManager;
use warhammerScoreBoard\models\Joueur;
use warhammerScoreBoard\models\MissionJoueur;
use warhammerScoreBoard\models\Partie;
use warhammerScoreBoard\models\Point;
use warhammerScoreBoard\models\Tour;

class PartieController extends Controller
{
    public function initialisationPartieAction()
    {
        $missions = new missionManager();
        $armees = new ArmeeManager();
        $myView = new View("partie/initialisationPartie", "front");
        $initPartie = InitialisationPartieForm::getForm();
        $myView->assign("initPartie", $initPartie);


        $missionsPrincipale = $missions->getMission(["idMission","nomMission"],[["typeCategorie","=","1"]]);
//        echo "<pre>";
//        print_r($missionsPrincipale);
//        echo "</pre>";
        $myView->assign("missionPrincipale", $missionsPrincipale);

        $armee = $armees->getArmee();
        $myView->assign("armee", $armee);

        $missionsSecondaire = $missions->getMission(["idMission","nomMission","nomCategorie"],[["typeCategorie","=","2"]]);
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
                        "nomJoueur" => $_SESSION['pseudoJoueur' . $i] ?? 'Joueur ' . $i,
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
                $this->redirectTo("Partie","validationTour");
            }
            else
            {
                $errors = array_unique($errors);
                $myView->assign("errors", $errors);
            }
        }
    }

    public function validationTourAction()
    {
        if (!isset($_SESSION['idPartie']))
            $this->redirectTo("Home","default");
        $pointManager = new PointManager();
        $tourManager = new TourManager();
        $missionsJoueurManager = new MissionJoueurManager();
        $tourInfo = count($tourManager->getTour(["idTour"],[["idPartie","=",$_SESSION['idPartie'],"tour"]]))+1;
        if ($tourInfo == 7)
        {
            $tourInfo = "Points de fin de partie";
            $finPartie = 1;
            $missionManager = new missionManager();
            $missionJoueur = new MissionJoueur();
            $missions = $missionManager->getMission(["idMission"],[["typeCategorie","=","3"]]);
            foreach ($missions as $mission)
            {
                for ($i = 1; $i <= 2; $i++)
                {
                    $associationMission = ["idJoueur" => $_SESSION["idJoueur".$i]];
                    $associationMission["idMission"] = $mission["idMission"];
                    $missionJoueur = $missionJoueur->hydrate($associationMission);
                    $missionsJoueurManager->save($missionJoueur);
                }
            }
//            $associationMission = ["idJoueur" => $_SESSION["idJoueur1"]];
//            $associationMission["idMission"] = $_POST["missionPrincipale"];
//            $missionJoueur = $missionJoueur->hydrate($associationMission);
//            $missionJoueurManager->save($missionJoueur)
        }
        elseif ($tourInfo > 7)
        {
            $this->redirectTo("Partie", "finPartie");
        }
        else
        {
            $tourInfo = "Round ".$tourInfo;
            $finPartie = 0;
        }
        $joueurs = array();
        for($j=1;$j<=2;$j++)
        {
            $missionsJoueur{$j} = $missionsJoueurManager->getMissionJoueur([DB_PREFIXE."joueur.idJoueur","nomJoueur",DB_PREFIXE."mission.idMission AS idMission","nomMission","nombrePointPossiblePartie","nombrePointPossibletour","typeCategorie","marquageFinPartie"],[[DB_PREFIXE."joueur.idJoueur","=",$_SESSION["idJoueur".$j]]]);
            $joueurs = array_merge($joueurs,[$missionsJoueur{$j}[0]["nomJoueur"]]);
        }

        $missionsJoueur1 = ValidationTourForm::getForm($missionsJoueur{$j=1},$finPartie);
        $missionsJoueur2 = ValidationTourForm::getForm($missionsJoueur{$j=2},$finPartie);

        $configForm = $missionsJoueur1;
        $configForm["fields"] = array_merge($configForm["fields"],$missionsJoueur2["fields"]);
        $configForm["config"]["nbFields"] = $configForm["config"]["nbFields"] + $missionsJoueur2["config"]["nbFields"];
        $myView = new View("partie/validationTour", "front");
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $validator = new Validator();
            $errors = $validator->checkAddPoint($configForm, $_POST);
            if (empty($errors))
            {
                //print_r($_POST);
                    $_SESSION['savePoint'] = $_POST;
                    $this->redirectTo("Partie", "savePoint");
            }
            else
            {
                $errors = array_unique($errors);
                $myView->assign("errors", $errors);
            }
        }
        $scoreJoueur1 = $pointManager->getPoint(["*"],[[DB_PREFIXE."tour.idPartie","=",$_SESSION['idPartie']],[DB_PREFIXE."point.idJoueur","=",$_SESSION['idJoueur1']]]);
        $scoreJoueur2 = $pointManager->getPoint(["*"],[[DB_PREFIXE."tour.idPartie","=",$_SESSION['idPartie']],[DB_PREFIXE."point.idJoueur","=",$_SESSION['idJoueur2']]]);
        //$nomMissionJoueur1 = $missionsJoueurManager->getMission(["nomMission"],[[DB_PREFIXE."tour.idPartie","=",$_SESSION['idPartie']],[DB_PREFIXE."point.idJoueur","=",$_SESSION['idJoueur1']]]);
//        foreach ($missionsJoueur{$j=1} as $score)
//        {
//            $score["idMission"];
//            echo "<pre>";
//            print_r($score);
//            echo "</pre>";
//
//        }

        $myView->assign("scoreJoueur1", $scoreJoueur1);
        $myView->assign("scoreJoueur2", $scoreJoueur2);

//     echo "<pre>";
//     print_r($tourInfo);
//     echo "</pre>";
        $myView->assign("tourInfo", $tourInfo);
        $myView->assign("joueurs", $joueurs);
        //echo count($tourInfo);
        $myView->assign("missionsJoueur1", $missionsJoueur1);
        $myView->assign("missionsJoueur2", $missionsJoueur2);

        //$myView->assign("initTour", $initTourJ2);
//             echo "<pre>";
//             print_r($configForm);
//             echo "</pre>";
    }

    public function savePointAction()
    {
        $tourManager = new TourManager();
        $tourInfo = $tourManager->getTour(["idTour"],[["idPartie","=",$_SESSION['idPartie'],"tour"]]);

        $numeroTour = count($tourInfo)+1;
//        echo $numeroTour;
            $nouveauTour = [
                "numeroTour"=> $numeroTour,
                "idPartie"=>$_SESSION['idPartie']
            ];
            $tour = new Tour();
            $tour = $tour->hydrate($nouveauTour);
            $idTour = $tourManager->save($tour);

            $pointManager = new PointManager();
            foreach ($_SESSION['savePoint'] as $data)
            {
                $point = new Point();
                $point = $point->hydrate($data);
                $point->setIdTour($idTour);
                //print_r($point);
                $pointManager->save($point);


            }
            $_SESSION['savePoint'] = null;
            $this->redirectTo("Partie", "validationTour");
    }

    public function finPartieAction()
    {
        //redirige à l'acceuil si aucune partie n'est en cours
        if (!isset($_SESSION['idPartie']))
        {
            $this->redirectTo("Home","default");
        }
        else {
            $pointManager = new PointManager();
            $joueurManager = new JoueurManager();
            $partieManager = new PartieManager();

            //met à jour la date de fin de la parti
            $finPartie = [
                "idPartie" => $_SESSION['idPartie'],
                "dateFin" => date("Y-m-m H:i:s")
            ];
            $partie = new Partie();
            $partie = $partie->hydrate($finPartie);
            $partieManager->save($partie);

            //récupere le total de points des 2 joueurs
            $totalJoueur1 = $pointManager->totalPoint($_SESSION["idJoueur1"]);
            $totalJoueur2 = $pointManager->totalPoint($_SESSION["idJoueur2"]);


            // Met a jour le statue de victoire des 2 joueurs
            if ($totalJoueur1["total"] > $totalJoueur2["total"])
                $joueurManager->defGagnantStatue($_SESSION["idJoueur1"], $_SESSION["idJoueur2"]);
            elseif ($totalJoueur1["total"] < $totalJoueur2["total"])
                $joueurManager->defGagnantStatue($_SESSION["idJoueur2"], $_SESSION["idJoueur1"]);
            else
                $joueurManager->defGagnantStatue($_SESSION["idJoueur1"], $_SESSION["idJoueur2"], 1);

            //affiche le tableau de score final
            $scoreJoueur1 = $pointManager->getPoint(["*"], [[DB_PREFIXE . "tour.idPartie", "=", $_SESSION['idPartie']], [DB_PREFIXE . "point.idJoueur", "=", $_SESSION['idJoueur1']]]);
            $scoreJoueur2 = $pointManager->getPoint(["*"], [[DB_PREFIXE . "tour.idPartie", "=", $_SESSION['idPartie']], [DB_PREFIXE . "point.idJoueur", "=", $_SESSION['idJoueur2']]]);
            $myView = new View("partie/finPartie", "front");
            $myView->assign("scoreJoueur1", $scoreJoueur1);
            $myView->assign("scoreJoueur2", $scoreJoueur2);

            //vide les variable de session concernant la partie
            unset($_SESSION['idPartie']);
            unset($_SESSION['idJoueur1']);
            unset($_SESSION['idJoueur2']);
        }
    }
}