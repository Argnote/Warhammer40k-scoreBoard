<?php


namespace warhammerScoreBoard\controllers;

use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\tools\Message;
use warhammerScoreBoard\core\tools\TransformArrayToSelected;
use warhammerScoreBoard\core\Validator;
use warhammerScoreBoard\core\View;
use warhammerScoreBoard\forms\InitialisationPartieForm;
use warhammerScoreBoard\forms\ValidationTourForm;
use warhammerScoreBoard\getData\GetListDataPartie;
use warhammerScoreBoard\managers\ArmeeManager;
use warhammerScoreBoard\managers\JoueurManager;
use warhammerScoreBoard\managers\MissionJoueurManager;
use warhammerScoreBoard\managers\MissionManager;
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
    //Création d'une nouvelle partie
    public function initialisationPartieAction()
    {
        //Création du formulaire 
        $missions = new MissionManager();
        $armees = new ArmeeManager();
        $myView = new View("partie/initialisationPartie", "front");
        $initPartie = InitialisationPartieForm::getForm();
        $myView->assign("initPartie", $initPartie);

        //Vérification des données puis création et enregistrement des différents éléments de la partie
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
                    $joueur[$i] = new Joueur();
                    $joueur[$i]  = $joueur[$i] ->hydrate($joueur);
                    $_SESSION["idJoueur" . $i] = $joueurManager->save($joueur[$i] );

                    //attribution des missions du joueur
                    //attribution de la mission principal
                    $missionJoueur = new MissionJoueur();
                    $associationMission = ["idJoueur" => $_SESSION["idJoueur" . $i]];
                    $associationMission["idMission"] = $_POST["missionPrincipal"];
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
        //récupération des missions principales et formatage pour select
        $missionsPrincipal = $missions->getManyMission(["idMission","nomMission"],[["typeCategorie","=","1"]],true);
        $missionsPrincipal = TransformArrayToSelected::transformArrayToSelected($missionsPrincipal,"idMission", "nomMission");
        $myView->assign("missionPrincipal", $missionsPrincipal);

        //récupération des armées et formatage pour select
        $armee = $armees->getManyArmee(null,true);
        $armee = TransformArrayToSelected::transformArrayToSelected($armee,"idArmee", "nomArmee", "nomFaction");
        $myView->assign("armee", $armee);

        //récupération des missions secondaires et formatage pour select
        $missionsSecondaire = $missions->getManyMission(["idMission","nomMission","nomCategorie"],[["typeCategorie","=","2"]],true);
        $missionsSecondaire = TransformArrayToSelected::transformArrayToSelected($missionsSecondaire,"idMission", "nomMission", "nomCategorie");
        $myView->assign("missionSecondaire", $missionsSecondaire);
    }

    //Création d'un nouveau tour une partie 
    public function validationTourAction()
    {
        Helper::checkPartie();

        //Récupération du nombre de tours de la partie
        $pointManager = new PointManager();
        $tourManager = new TourManager();
        $missionsJoueurManager = new MissionJoueurManager();
        $tourInfo = count($tourManager->getTour(["idTour"],[["idPartie","=",$_SESSION['idPartie'],"tour"]]))+1;

        //Une partie dure 5 tours + un tour de fin de partie
        if ($tourInfo == 6)
        {
            //Dans le cas du tour de fin de partie
            $tourInfo = "Points de fin de partie";
            $finPartie = 2;
            $missionManager = new MissionManager();
            $missionJoueur = new MissionJoueur();

            //Ajoute a chaques joueurs les Missions de catégorie 3 (des missions bonus)
            $missions = $missionManager->getManyMission(["idMission"],[["typeCategorie","=","3"]],true);
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
        }
        elseif ($tourInfo > 6)
        {
            //Si on dépasse le 6ème tour redirige vers la finalisation de la partie
            $this->redirectTo("Partie", "finPartie");
        }

        else
        {
            //Si on est entre le tour 1 et le tour 5 (inclus)
            $tourInfo = "Round ".$tourInfo;
            $finPartie = 1;
        }

        //Récupère les missions de chaques joueurs afin d'en faire un formulaire
        for($j=1;$j<=2;$j++)
        {
            $missionsJoueur[$j] = $missionsJoueurManager->getMissionJoueur([DB_PREFIXE."joueur.idJoueur","nomJoueur",DB_PREFIXE."mission.idMission AS idMission","nomMission","nombrePointPossiblePartie","nombrePointPossibletour","typeCategorie","marquageFinPartie"],[[DB_PREFIXE."joueur.idJoueur","=",$_SESSION["idJoueur".$j]]]);
        }

        $missionsJoueur1 = ValidationTourForm::getForm($missionsJoueur["1"] ,$finPartie);
        $missionsJoueur2 = ValidationTourForm::getForm($missionsJoueur["2"],$finPartie);

        $configForm = $missionsJoueur1;
        $configForm["fields"] = array_merge($configForm["fields"],$missionsJoueur2["fields"]);
        $configForm["config"]["nbFields"] = $configForm["config"]["nbFields"] + $missionsJoueur2["config"]["nbFields"];
        $myView = new View("partie/validationTour", "front");

        //Sauvegarde d'un nouveau tour
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $validator = new Validator();
            $errors = $validator->checkAddPoint($configForm, $_POST);
            if (empty($errors))
            {
                //Sauvegarde des points dans la session afin de les utiliser dans la sauvegarde des points
                $_SESSION['savePoint'] = $_POST;
                 $this->redirectTo("Partie", "savePoint");
            }
            else
            {
                $errors = array_unique($errors);
                $myView->assign("errors", $errors);
            }
        }

        //Récupère des informations des tours passé
        $scoreJoueur1 = $pointManager->getPoint(["*"],[[DB_PREFIXE."tour.idPartie","=",$_SESSION['idPartie']],[DB_PREFIXE."point.idJoueur","=",$_SESSION['idJoueur1']]]);
        $scoreJoueur2 = $pointManager->getPoint(["*"],[[DB_PREFIXE."tour.idPartie","=",$_SESSION['idPartie']],[DB_PREFIXE."point.idJoueur","=",$_SESSION['idJoueur2']]]);

        //Ajout de toutes les données a la vue
        $myView->assign("tourInfo", $tourInfo);
        $myView->assign("missionsJoueur1", $missionsJoueur1);
        $myView->assign("missionsJoueur2", $missionsJoueur2);
        $myView->assign("scoreJoueur1", $scoreJoueur1);
        $myView->assign("scoreJoueur2", $scoreJoueur2);

    }

    //sauvegarde les points d'un tour
    public function savePointAction()
    {
        Helper::checkPartie();
        if(empty($_SESSION['savePoint']))
        {
            $_SESSION["messageError"] = Message::erreurChargementPartie();
            $this->redirectTo("Errors", "errorMessage");
        }

        //Récupère le nombre de tours existant et ajoute 1
        $tourManager = new TourManager();
        $pointManager = new PointManager();
        $missionManager = new MissionManager();
        $tourInfo = $tourManager->getTour(["idTour"],[["idPartie","=",$_SESSION['idPartie'],"tour"]]);
        $numeroTour = count($tourInfo)+1;

        //En registre un nouveau tour
        $nouveauTour = [
            "numeroTour"=> $numeroTour,
            "idPartie"=>$_SESSION['idPartie']
        ];
        $tour = new Tour();
        $tour = $tour->hydrate($nouveauTour);
        $idTour = $tourManager->save($tour);

        //Enregistre tous les points des joueurs sur le tour qui viens d'être crée
        foreach ($_SESSION['savePoint'] as $data)
        {
            if(empty($data["nombrePoint"]))
                $data["nombrePoint"] = 0;

            //Vérifie que l'ajout de point a une mission ne dépasse pas le score maximum de cette mission
            $totalMission = $pointManager->totalPoint($data["idJoueur"],$data["idMission"])["total"];
            $max = $missionManager->getManyMission(["nombrePointPossiblePartie"],[["idMission","=",$data["idMission"]]])[0]["nombrePointPossiblePartie"];
            //Fais la différence de points entre la valeur entré et le max possible
            if(($totalMission + $data["nombrePoint"]) > $max )
            $data["nombrePoint"] = $max - $totalMission;
            //Si la différence donne un nombre inférieur, le remplace par 0
            if($data["nombrePoint"] < 0)
            {
                $data["nombrePoint"] = 0;
            }

            //Enregistre le point marqué sur la mission
            $point = new Point();
            $point = $point->hydrate($data);
            $point->setIdTour($idTour);
            $pointManager->save($point);
        }
        //Détruit le save point et redirige vers la création de tour afin de recommencer l'enregistrement d'un nouveau tour 
        $_SESSION['savePoint'] = null;
        $this->redirectTo("Partie", "validationTour");
    }

    public function finPartieAction()
    {
        Helper::checkPartie();
        $pointManager = new PointManager();
        $joueurManager = new JoueurManager();
        $partieManager = new PartieManager();

        //Met à jour la date de fin de la parti
        $finPartie = [
            "idPartie" => $_SESSION['idPartie'],
            "dateFin" => date("Y-m-m H:i:s")
        ];
        $partie = new Partie();
        $partie = $partie->hydrate($finPartie);
        $partieManager->save($partie);

        //Récupere le total de points des 2 joueurs
        $totalJoueur1 = $pointManager->totalPoint($_SESSION["idJoueur1"]);
        $totalJoueur2 = $pointManager->totalPoint($_SESSION["idJoueur2"]);


        // Met a jour le statue de victoire des 2 joueurs
        if ($totalJoueur1["total"] > $totalJoueur2["total"])
            $joueurManager->defGagnantStatue($_SESSION["idJoueur1"], $_SESSION["idJoueur2"]);
        elseif ($totalJoueur1["total"] < $totalJoueur2["total"])
            $joueurManager->defGagnantStatue($_SESSION["idJoueur2"], $_SESSION["idJoueur1"]);
        else
            $joueurManager->defGagnantStatue($_SESSION["idJoueur1"], $_SESSION["idJoueur2"], 1);
        $this->redirectTo("Partie", "scorePartie");
    }

    public function scorePartieAction()
    {
        Helper::checkPartie();
        if (!isset($_SESSION['idJoueur1']) && !isset($_SESSION['idJoueur2']))
            $this->redirectTo("Home","default");

        $pointManager = new PointManager();
        $joueurManager = new JoueurManager();
        //Affiche le tableau de score final
        $scoreJoueur1 = $pointManager->getPoint(["*"], [[DB_PREFIXE . "tour.idPartie", "=", $_SESSION['idPartie']], [DB_PREFIXE . "point.idJoueur", "=", $_SESSION['idJoueur1']]]);
        $scoreJoueur2 = $pointManager->getPoint(["*"], [[DB_PREFIXE . "tour.idPartie", "=", $_SESSION['idPartie']], [DB_PREFIXE . "point.idJoueur", "=", $_SESSION['idJoueur2']]]);
        $myView = new View("partie/scoreFinalPartie", "front");
        $myView->assign("scoreJoueur1", $scoreJoueur1);

        if(isset($_SESSION['ConsultPseudoJoueur2']))
            $pseudoJoueur2 = $_SESSION['ConsultPseudoJoueur2'];
        elseif(isset($_SESSION['PseudoJoueur2']))
            $pseudoJoueur2 = $_SESSION['PseudoJoueur2'];
        else
            $pseudoJoueur2 = "Joueur 2";

        $myView->assign("pseudoJoueur2", $pseudoJoueur2);
        $myView->assign("scoreJoueur2", $scoreJoueur2);

        //récupère le statut gagnant du joueur relié au compte principale
        if(isset($_SESSION["idUtilisateur1"])) {
            $redirect = $joueurManager->getJoueur($_SESSION["idJoueur1"], ["gagnant"]);

            //si il n'a pas de statu, lien de reprise de partie
            if (empty($redirect->getGagnant()))
                $myView->assign("reprisePartie", Helper::getUrl("Partie", "reprendrePartie") . "?idPartie=" . $_SESSION['idPartie']);

            //lien pour archiver la partie
            $myView->assignLink("archived", Helper::getUrl("Partie", "archivedPartie")."?idPartieUtilisateur=" . $_SESSION['idJoueur1'], "Archiver la partie");
        }
        //vide les variable de session concernant la partie

        unset($_SESSION['ConsultPseudoJoueur2']);
        unset($_SESSION['idJoueur1']);
        unset($_SESSION['idJoueur2']);
        unset($_SESSION['idPartie']);
    }

    //Affiche la liste de sparties d'un utilisateur
    public function getListPartieAction()
    {
        Helper::checkConnected();

        //récupère les joueurs et adversaire des parties de l'utilisateur pricipale connecté
        $joueurManager = new JoueurManager();
        $result = $joueurManager->getPartiePlayedWithAdversaire(true);

        //formate les données pour les afficher dans la liste des parties
        $partie = array();
        foreach ($result as $key => $value)
        {
            if(!isset($partie[$value["idPartie"]]))
                $partie[$value["idPartie"]] = array();

            if($value["idUtilisateur"] == $_SESSION["idUtilisateur1"])
            {
                $partie[$value["idPartie"]] += $value;
                $partie[$value["idPartie"]]["dateDebut"] = date('d-m-Y', strtotime($value["dateDebut"]));
                unset($result[$key]);
            }
            else
            {
                $joueur = [
                    "idUtilisateur2" => $value["idUtilisateur"],
                    "nomJoueur2" => $value["nomJoueur"],
                    "ArmeeJoueur2" => $value["nomArmee"]
                ];
                $partie[$value["idPartie"]] += $joueur;
            }

        }
        $listPartie = GetListDataPartie::getData($partie);
        $myView = new View("listData","front");
        $myView->assign("title","Liste des parties");
        $myView->assign("listData",$listPartie);
    }

    //Consulter une partie de l'utilisateur connecté
    public function historiquePartieAction()
    {
        Helper::checkConnected();
        if(!isset($_SESSION["idUtilisateur1"]) || !isset($_GET["partie"]) || !is_numeric($_GET["partie"]))
        {
            $_SESSION["messageError"] = Message::erreurChargementPartie();
            $this->redirectTo("Errors", "errorMessage");
        }
        else
        {
            $joueurManager = new JoueurManager();
            $result = $joueurManager->getJoueurPartie($_GET["partie"]);

            //Vérifie que les données récupérer sont bonnes et que la partie appartient bien à l'utilisateur connecté
            if(empty($result) || count($result) > 2 || ($result[0]["idUtilisateur"] != $_SESSION["idUtilisateur1"] && $result[1]["idUtilisateur"] != $_SESSION["idUtilisateur1"]))
            {
                $_SESSION["messageError"] = Message::erreurChargementPartie();
                $this->redirectTo("Errors", "errorMessage");
            }
            else
            {
                $_SESSION["idPartie"] = $_GET["partie"];

                //Ajoute le idJoueur1 corespondant à l'id de l'utilisateur principale connecté
                if($_SESSION["idUtilisateur1"] == $result[0]["idUtilisateur"])
                {
                    $_SESSION["idJoueur1"] = $result[0]["idJoueur"];
                    $_SESSION["idJoueur2"] = $result[1]["idJoueur"];
                    $_SESSION["ConsultPseudoJoueur2"] = $result[1]["nomJoueur"];
                }
                else
                {
                    $_SESSION["idJoueur1"] = $result[1]["idJoueur"];
                    $_SESSION["idJoueur2"] = $result[0]["idJoueur"];
                    $_SESSION["ConsultPseudoJoueur2"] = $result[0]["nomJoueur"];
                }
                $this->redirectTo("Partie","scorePartie" );
            }
        }
    }

    //Reprise d'une partie non fini
    public function reprendrePartieAction()
    {
        Helper::checkConnected();
        if(!isset($_SESSION["idUtilisateur1"]) || !isset($_GET["idPartie"]) || !is_numeric($_GET["idPartie"]))
        {
            $_SESSION["messageError"] = Message::erreurChargementPartie();
            $this->redirectTo("Errors", "errorMessage");
        }
        else
        {
            //Récupère les joueurs de la partie 
            $joueurManager = new JoueurManager();
            $result = $joueurManager->getJoueurPartie($_GET["idPartie"],["idUtilisateur","idJoueur"]);

            if(empty($result) || count($result) > 2)
            {
                $_SESSION["messageError"] = Message::erreurChargementPartie();
                $this->redirectTo("Errors", "errorMessage");
            }
            else
            {
                $comptePricipaleConnecte = false;
                foreach ($result as $joueur)
                {
                    //Si un utilisateur est rataché à un compte
                    if(!empty($joueur["idUtilisateur"]))
                    {
                        //Ajouter l'idJoueur1 corespondant à l'id de l'utilisateur connecté
                        if($joueur["idUtilisateur"] == $_SESSION["idUtilisateur1"])
                        {
                            $_SESSION["idJoueur1"] = $joueur["idJoueur"];
                            $comptePricipaleConnecte = true;

                            //Vérifie que la partie n'est pas terminé sinon redirige vers le tableau des scores
                            $redirect = $joueurManager->getJoueur($_SESSION["idJoueur1"],["gagnant"]);
                            if(!empty($redirect->getGagnant()))
                                $this->redirectTo("Partie","historiquePartie","?idPartie=".$_GET["idPartie"]);
                        }
                        elseif($joueur["idUtilisateur"] == $_SESSION["idUtilisateur2"])
                        {
                            //Ajoute le joueur au compte invité
                            $_SESSION["idJoueur2"] = $joueur["idJoueur"];
                        }
                        else
                        {
                            //Erreur
                            $_SESSION["messageError"] = Message::erreurInviteNonConnecte();
                            $this->redirectTo("Errors", "errorMessage");
                        }
                    }
                    else
                    {
                        //Si il n'y a pas de compte rataché, ajoute idJoueur2
                        $_SESSION["idJoueur2"] = $joueur["idJoueur"];
                    }
                }

                //Vérifie que la partie appartient bien au compte principale
                if(!$comptePricipaleConnecte)
                {
                    $_SESSION["messageError"] = Message::erreurComptePrincipalNonConnecte();
                    $this->redirectTo("Errors", "errorMessage");
                }
                else
                {
                    //Redirige vers l'ajout d'un tour
                    $_SESSION["idPartie"] = $_GET["idPartie"];
                    $this->redirectTo("Partie","validationTour" );
                }
            }
        }
    }

    //Archive le joueur d'une partie pour ne plus le voir dans ses parties et ne plus le compté dans les stats
    public function archivedPartieAction()
    {
        Helper::checkConnected();
        if(!isset($_SESSION["idUtilisateur1"]) || !isset($_GET["idPartieUtilisateur"]) || !is_numeric($_GET["idPartieUtilisateur"]))
        {
            $_SESSION["messageError"] = Message::erreurChargementPartie();
            $this->redirectTo("Errors", "errorMessage");
        }

        //Récupère le joueur demander rattaché au compte principale
        $joueurManager = new JoueurManager();
        $result = $joueurManager->getJoueur($_GET["idPartieUtilisateur"],["*"],[["idUtilisateur","=",$_SESSION["idUtilisateur1"]]]);
        if(empty($result))
        {
            $_SESSION["messageError"] = Message::erreurChargementPartie();
            $this->redirectTo("Errors", "errorMessage");
        }

        //Archive la patie
        $joueur = new Joueur();
        $joueur->setIdJoueur($_GET["idPartieUtilisateur"]);
        $joueur->setArchived(1);
        $joueurManager->save($joueur);
        $this->redirectTo("Partie","getListPartie");
    }
}