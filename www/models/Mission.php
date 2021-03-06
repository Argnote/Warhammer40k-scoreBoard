<?php


namespace warhammerScoreBoard\models;


class Mission extends Model
{
    protected $idMission;
    protected $nomMission;
    protected $description;
    protected $nombrePointPossiblePartie;
    protected $nombrePointPossibleTour;
    protected $idCategorie;
    protected $nomCategorie;
    protected $marquageFinPartie;
    protected $archived;
    protected $idLivre;
    protected $nomLivre;
    protected $codeLivre;

    public function setIdMission($idMission)
    {
        $this->idMission = $idMission;
    }

    public function setNomMission($nomMission)
    {
        $this->nomMission = $nomMission;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setNombrePointPossiblePartie($nombrePointPossiblePartie)
    {
        $this->nombrePointPossiblePartie = $nombrePointPossiblePartie;
    }

    public function setNombrePointPossibleTour($nombrePointPossibleTour)
    {
        $this->nombrePointPossibleTour = $nombrePointPossibleTour;
    }

    public function setIdCategorie($idCategorie)
    {
        $this->idCategorie = $idCategorie;
    }

    public function setMarquageFinPartie($marquageFinPartie)
    {
        $this->marquageFinPartie = $marquageFinPartie;
    }

    public function setNomCategorie($nomCategorie)
    {
        $this->nomCategorie = $nomCategorie;
    }

    public function setArchived($archived)
    {
        $this->archived = $archived;
    }

    public function setIdLivre($idLivre)
    {
        $this->idLivre = $idLivre;
    }

    public function setNomLivre($nomLivre)
    {
        $this->nomLivre = $nomLivre;
    }

    public function setCodeLivre($codeLivre)
    {
        $this->codeLivre = $codeLivre;
    }

    public function getIdMission()
    {
        return $this->idMission;
    }

    public function getNomMission()
    {
        return $this->nomMission;
    }

    public function getDescription()
    {
        return nl2br($this->description);
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

    public function getNomCategorie()
    {
        return $this->nomCategorie;
    }

    public function getArchived()
    {
        return $this->archived;
    }

    public function getIdLivre()
    {
        return $this->idLivre;
    }

    public function getNomLivre()
    {
        return $this->nomLivre;
    }

    public function getCodeLivre()
    {
        return $this->codeLivre;
    }
}