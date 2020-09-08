<?php


namespace warhammerScoreBoard\models;

class Tour extends Model
{
    protected $idTour;
    protected $numeroTour;
    protected $debutTour;
    protected $finTour;
    protected $idPartie;

    public function setIdTour( $idTour)
    {
        $this->idTour = $idTour;
    }

    public function setNumeroTour(int $numeroTour)
    {
        $this->numeroTour = $numeroTour;
    }

    public function setDebutTour( $debutTour)
    {
        $this->debutTour = $debutTour;
    }

    public function setFinTour( $finTour)
    {
        $this->finTour = $finTour;
    }

    public function setIdPartie(int $idPartie)
    {
        $this->idPartie = $idPartie;
    }

    public function getId()
    {
        return $this->idTour;
    }

    public function getNumeroTour()
    {
        return $this->numeroTour;
    }

    public function getDebutTour()
    {
        return $this->debutTour;
    }

    public function getFinTour()
    {
        return $this->finTour;
    }

    public function getIdPartie()
    {
        return $this->idPartie;
    }
}