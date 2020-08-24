<?php

namespace warhammerScoreBoard\core;

use warhammerScoreBoard\forms\InitialisationPartieForm;
use warhammerScoreBoard\managers\MissionJoueurManager;
use warhammerScoreBoard\managers\missionManager;
use warhammerScoreBoard\models\MissionJoueur;
use warhammerScoreBoard\models\Utilisateur;
use function Sodium\compare;

class Validator
{
    public function checkForm($configForm, $data)
    {
        $errosMsg = [];
//        echo "<pre>";
//        print_r($configForm["fields"]);
//        print_r($data);
//        echo "</pre>";
//echo count($configForm["fields"])."<br/>";
        echo count($data);
        if (count($configForm["fields"]) == count($data)) {
            foreach ($configForm["fields"] as $key => $config) {
                $this->$key = $data[$key];
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
                    if (!$this->$method($data[$key], $config)) {
                        $errosMsg[$key] = $config["errorMsg"];
                    }
                }
            }
        }
        else
        {
            return ["Un problème est survenue dans le nombre de champs remplis"];
        }
        return $errosMsg;
    }

    public function checkAddPoint($configForm, $data)
    {
//        echo "<pre>";
//        print_r($configForm);
//        print_r($data);
//        echo "</pre>";
        $errosMsg = [];
        if (count($data) == 8)
        {
            foreach ($data as $key => $value)
            {

                //echo $configForm[$key]["errorMsg"];
                if(!$this->checkScore($value["nombrePoint"],$configForm[$key]))
                    $errosMsg[$key] = $configForm[$key]["errorMsg"];
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
        return $errosMsg;
    }

    private function checkFirstname($firstname)
    {
        if (!preg_match("#^[\p{Latin}' -]+$#u", $firstname) || count_chars($firstname) < 50)
            return false;
        return true;
    }

    private function checkName($name)
    {
        if (!preg_match("#^[\p{Latin}' -]+$#u", $name) || count_chars($name) < 100)
            return false;
        return true;
    }

    private function checkEmail($email, $config)
    {
        if(array_key_exists("uniq",$config))
            if(!$this->uniq($email,$config["uniq"]))
                return false;

        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function checkPassword($password)
    {
        return preg_match('#(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,20}$#', $password);
    }

    private function checkPasswordConfirm($passwordConfirm)
    {
        return $this->password == $passwordConfirm;
    }

    private function checkCaptcha($captcha)
    {
        return strtolower($captcha) == $_SESSION["captcha"];
    }

    private function checkBirthdate($birthdate)
    {
        $birthdate = new \DateTime($birthdate);
        $date = new \DateTime("now");
        $date->modify('-18 years');
        return $date >= $birthdate;
    }

    private function uniq($data,$table)
    {
        $requete = new QueryBuilder(Utilisateur::class, $table["table"]);
        $requete->querySelect($table["column"]);
        $requete->queryWhere($table["column"], "=", $data);
        $result = $requete->queryGetValue();
        if($result == $data)
            return false;
        return true;
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
        foreach ($config["compare"] as $value)
        {
            $config["compare"] = array_merge($config["compare"],[$this->$value]);
            unset($config["compare"][array_search($value,$config["compare"])]);

        }
        if($config["compare"] != array_unique($config["compare"]))
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
        $result = $missionJoueurManager->checkMissionJoueur($joueur,$mission);
        if(empty($result))
            return false;
        return true;
    }

}
