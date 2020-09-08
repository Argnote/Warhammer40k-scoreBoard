<?php


namespace warhammerScoreBoard\models;


class Partie extends Model
{
    protected $idPartie;
    protected $dateDebut;
    protected $dateFin;
    protected $format;

    public function setIdPartie($idPartie)
    {
        $this->idPartie = $idPartie;
    }

    public function setDateDebut( $dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    public function setDateFin( $dateFin)
    {
        $this->dateFin = $dateFin;
    }

    public function setFormat(int $format)
    {
        $this->format = $format;
    }

    public function GetId()
    {
        return $this->idPartie;
    }

    public function GetDateDebut()
    {
        return $this->dateDebut;
    }

    public function GetDateFin()
    {
        return $this->dateFin;
    }

    public function GetFormat()
    {
        return $this->format;
    }

}
