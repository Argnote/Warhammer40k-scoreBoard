<?php

namespace warhammerScoreBoard\core;

use DateTime;
use warhammerScoreBoard\forms\InitialisationPartieForm;
use warhammerScoreBoard\managers\ArmeeManager;
use warhammerScoreBoard\managers\LivreManager;
use warhammerScoreBoard\managers\MissionJoueurManager;
use warhammerScoreBoard\managers\MissionManager;
use warhammerScoreBoard\managers\UtilisateurManager;
use warhammerScoreBoard\models\Mission;
use warhammerScoreBoard\models\MissionJoueur;
use warhammerScoreBoard\models\Utilisateur;
use function Sodium\compare;

class Validator
{
protected $errosMsg;
    public function checkForm($configForm, $data)
    {
        if (count($configForm["fields"]) == count($data)) {
            foreach ($configForm["fields"] as $key => $config)
            {
                $this->$key = $data[$key];
            }
            foreach ($configForm["fields"] as $key => $config) {
                //Vérifie que l'on a bien les champs attendus
                //Vérifier les required
                if (!array_key_exists($key, $data) || ($config["required"] && empty($data[$key]))) {
                    return ["Un problème est survenue dans le nombre de champs remplis"];
                }
                if (isset($config["contrainte"]))
                    $method = 'check' . ucfirst($config["contrainte"]);
                else
                    $method = 'check' . ucfirst($key);
                //echo $method . "<br/>";
                if (method_exists(get_called_class(), $method)) {
                    if(!empty($this->$key) || $config["required"])
                    {
                        if (!$this->$method($this->$key, $config)) {
                            $this->errosMsg[$key] = $config["errorMsg"];
                        }
                    }
                }
            }
        }
        else
        {
//            echo count($configForm["fields"])."</br>".count($data);
//            print_r($data);
            return ["Un problème est survenue dans le nombre de champs remplis"];
        }
        return $this->errosMsg;
    }

    public function checkAddPoint($configForm, $data)
    {
//        echo "<pre>";
//        print_r($configForm["fields"]);
//        print_r($data);
//        echo "</pre>";
        $fields = $configForm["fields"];
        //echo count($data)."<br/>".$configForm["config"]["nbFields"];
        if (count($data) == $configForm["config"]["nbFields"])
        {
            foreach ($data as $key => $value)
            {

                //echo $configForm[$key]["errorMsg"];
                if(!$this->checkScore($value["nombrePoint"],$fields[$key]))
                    $errosMsg[$key] = $fields[$key]["errorMsg"];
                if(!$this->checkJoueur($value["idJoueur"]))
                    $errosMsg[$key."_joueur"] = "Aucun joueur portant l'id ".$value["idJoueur"]." n'est connecté, merci de ne pas modifier le DOM!";
                if(!$this->checkMissionJoueur($value["idMission"],$value["idJoueur"]))
                    $errosMsg[$key."_missionJoueur"] = "Cette mission n'a pas été selectionnée par un joueur, merci de ne pas modifier le DOM!";
                //echo $key;
            }
        }
        else
        {
            return ["Un problème est survenue dans le nombre de champs remplis"];
        }
        return $this->errosMsg;
    }

    private function checkPrenom($prenom)
    {
        if (!preg_match("#^[\p{Latin}' -]+$#u", $prenom) || strlen($prenom) > 50)
            return false;
        return true;
    }

    private function checkNomUtilisateur($nom)
    {
        if (!preg_match("#^[\p{Latin}' -]+$#u", $nom) || strlen($nom) > 100)
            return false;
        return true;
    }

    private function checkEmail($email, $config)
    {
        if(array_key_exists("uniq",$config))
            $this->uniq($email,$config["uniq"]);

        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function checkMotDePasse($motDePasse)
    {
        return preg_match('#(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,20}$#', $motDePasse);
    }

    private function checkConfirmationMotDePasse($confirmationMotDePasse)
    {
        if(empty($this->motDePasse))
        {
            $this->errosMsg["motDePasseNull"] = "le mot de passe n'a pas été remplis";
            return true;
        }
        return $this->motDePasse == $confirmationMotDePasse;
    }

    private function checkCaptcha($captcha)
    {
        return strtolower($captcha) == $_SESSION["captcha"];
    }

    private function checkDateDeNaissance($dateDeNaissance,$config)
    {
        $this->checkValidateDate($dateDeNaissance,"Y-m-d");
        return true;
    }

    private function checkValidateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        if(!($d && $d->format($format) == $date))
            $this->errosMsg[$date] = $date." est une date nom valide";
    }

    private function uniq($data,$table)
    {
        $requete = new QueryBuilder($table["class"], $table["table"]);
        $requete->querySelect($table["column"]);
        $requete->queryFrom();
        $requete->queryWhere($table["column"], "=", $data);
        $result = $requete->queryGetValueToArray();
        if(!empty($result[$table["column"]]))
            $this->errosMsg[$data."Unique"] = "\"".$data."\" est déja utilisé";
    }

    private function checkNumeric($number)
    {
        if(!is_numeric($number) || $number < 0)
            return false;
        return true;
    }

    private function checkFormat($format)
    {
        if(!$this->checkNumeric($format) && !empty($armee))
            return false;
        if($format > 100000)
            return false;
        return true;
    }
    private function checkArmee($armee)
    {
        if(!$this->checkNumeric($armee) && !empty($armee))
            return false;
        return true;
    }

    private function checkMission($mission, $config)
    {

        if(!$this->checkNumeric($mission))
            return false;
        $missionManager = new MissionManager();
        $missions = array();
        $categories = array();
        foreach ($config["compare"] as $value)
        {
            if(empty($missionManager->getCategorieMission($this->$value)["idCategorie"]))
            {
                $this->errosMsg["missioninconnue"] = "mission inconnue";
                return false;
            }

            array_push($missions,$this->$value);
            //unset($config["compare"][array_search($value,$config["compare"])]);
            array_push($categories,$missionManager->getCategorieMission($this->$value)["idCategorie"]);
        }
        if(($missions != array_unique($missions))||($categories != array_unique($categories)))
            return false;
        return true;
    }

    private function checkScore($score, $config)
    {
        if(!$this->checkNumeric($score))
            return false;
        if($score > $config["nombrePointPossibletour"])
            return false;
        return true;
    }

    private function checkJoueur($joueur)
    {
        if(!$this->checkNumeric($joueur))
            return false;
        //echo $joueur."<br/>";
        if($_SESSION["idJoueur1"] != $joueur && $_SESSION["idJoueur2"] != $joueur)
            return false;
        return true;
    }

    private function checkMissionJoueur($mission, $joueur)
    {
        if(!$this->checkNumeric($mission))
            return false;
        $missionJoueurManager = new MissionJoueurManager();
        $result = $missionJoueurManager->missionJoueurExist($joueur,$mission);
        if(empty($result))
            return false;
        return true;
    }

    private function checkPseudo($pseudo,$config)
    {
        if(array_key_exists("uniq",$config))
            $this->uniq($pseudo,$config["uniq"]);
        if (!preg_match("#[a-zA-Z0-9]+$#", $pseudo) || strlen($pseudo) > 50)
            return false;
        return true;
    }

    private function checkIdRole($role)
    {
        if(!$this->checkNumeric($role))
            return false;

        $utilisateurManager = new UtilisateurManager();
        $role = $utilisateurManager->getRole($role);
        if (empty($role))
            return false;
        return true;
    }

    private function checkNomMission($mission,$config)
    {
       $requete = new QueryBuilder(Mission::class,"mission");
       $requete->querySelect(["nomMission","nomLivre"]);
       $requete->queryFrom();
       $requete->queryJoin("mission", "livre", "idLivre", "idLivre");
       $requete->queryWhere(DB_PREFIXE."mission.idLivre", "=",$this->idLivre);
       $requete->queryWhere("nomMission", "=",$mission);
       $result = $requete->queryGetValue();
       if(!empty($result))
           return false;
        return true;
    }

    private function checkIdLivre($livre,$config)
    {
        $livreManager = new LivreManager();
        if(empty($livreManager->getLivre($livre)))
            return false;
        return true;
    }

    private function checkNombrePointPossiblePartie($point)
    {
        if(!is_numeric($point) || $point > 45)
            return false;
        return true;
    }

    private function checkNombrePointPossibleTour($point)
    {
        if(!is_numeric($point) || $point > 15)
            return false;
        return true;
    }

    private function checkMarquageFinPartie($point)
    {
        if(!is_numeric($point) || $point > 3 || $point < 1)
            return false;
        return true;
    }
    private function checkIdCategorie($id)
    {
        if(!is_numeric($id))
            return false;
        $missionManager = new MissionManager();
        $result = $missionManager->categoriExist($id);
        if(empty($result->getIdCategorie()))
            return false;
        return true;
    }

    private function checkNomArmee($armee,$config)
    {
        if(array_key_exists("uniq",$config))
            $this->uniq($armee,$config["uniq"]);
        return true;
    }

    private function checkIdFaction($id)
    {
        if(!is_numeric($id))
            return false;
        $armeeManager = new ArmeeManager();
        $result = $armeeManager->factionExist($id);
        if(empty($result->getIdFaction()))
            return false;
        return true;
    }
}
