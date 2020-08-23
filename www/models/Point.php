<?php


namespace warhammerScoreBoard\models;


class Point extends Model
{
    protected $idPoint;
    protected $nombrePoint;
    protected $idJoueur;
    protected $idMission;
    protected $idTour;

    public function setIdPoint(int $idPoint)
    {
        $this->idPoint = $idPoint;
    }

    public function setNombrePoint(int $nombrePoint)
    {
        $this->nombrePoint = $nombrePoint;
    }

    public function setIdJoueur(int $idJoueur)
    {
        $this->idJoueur = $idJoueur;
    }

    public function setIdMission(int $idMission)
    {
        $this->idMission = $idMission;
    }

    public function setIdTour(int $idTour)
    {
        $this->idTour = $idTour;
    }

    public function getId()
    {
        return $this->idPoint;
    }

    public function getNombrePoint()
    {
        return $this->nombrePoint;
    }

    public function getIdJoueur()
    {
        return $this->idJoueur;
    }

    public function getIdMission()
    {
        return $this->idMission;
    }

    public function getIdPoint()
    {
        return $this->idPoint;
    }
}