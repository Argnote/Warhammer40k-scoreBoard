<?php


namespace warhammerScoreBoard\models;


class Point extends Model
{
    protected $idPoint;
    protected $nombrePoint;
    protected $idJoueur;
    protected $idMission;
    protected $idTour;
    protected $total;

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

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getIdPoint()
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

    public function getTotal()
    {
        return $this->total;
    }

}