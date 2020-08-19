<?php


namespace warhammerScoreBoard\models;


class mission
{
    protected $idMission;
    protected $nomMission;
    protected $description;
    protected $nombrePointPossiblePartie;
    protected $nombrePointPossibleTour;
    protected $idCategorie;
    protected $marquageFinPartie;

    public function setIdMission(int $idMission)
    {
        $this->idMission = $idMission;
    }

    public function setNomMission(string $nomMission)
    {
        $this->nomMission = $nomMission;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function setNombrePointPossiblePartie(int $nombrePointPossiblePartie)
    {
        $this->nombrePointPossiblePartie = $nombrePointPossiblePartie;
    }

    public function setNombrePointPossibleTour(int $nombrePointPossibleTour)
    {
        $this->nombrePointPossibleTour = $nombrePointPossibleTour;
    }

    public function setIdCategorie(int $idCategorie)
    {
        $this->idCategorie = $idCategorie;
    }

    public function setMarquageFinPartie($marquageFinPartie)
    {
        $this->marquageFinPartie = $marquageFinPartie;
    }

    public function getId()
    {
        return $this->idMission;
    }

    public function getNomMission()
    {
        return $this->nomMission;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getNombrePointPossiblePartie()
    {
        return $this->nombrePointPossiblePartie;
    }

    public function getNombrePointPossibleTour()
    {
        return $this->nombrePointPossibleTour;
    }

    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    public function getMarquageFinPartie()
    {
        return $this->marquageFinPartie;
    }
}