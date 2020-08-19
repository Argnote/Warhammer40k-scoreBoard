<?php


namespace warhammerScoreBoard\models;


class MissionJoueur extends Model
{
    protected $idJoueur;
    protected $idMission;

    public function setIdJoueur(int $idJoueur)
    {
        $this->idJoueur = $idJoueur;
    }

    public function setIdMission(int $idMission)
    {
        $this->idMission = $idMission;
    }

    public function getId()
    {
        return null;
    }

    public function getIdJoueur()
    {
        return $this->idJoueur;
    }

    public function getIdMission()
    {
        return $this->idMission;
    }
}