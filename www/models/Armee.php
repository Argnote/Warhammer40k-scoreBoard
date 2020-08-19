<?php


namespace warhammerScoreBoard\models;


class Armee extends Model
{
    protected $idArmee;
    protected $nomArmee;
    protected $idFaction;
    protected $nomFaction;

    public function setIdArmee($idArmee)
    {
        $this->idArmee=$idArmee;
    }

    public function setNomArmee($nomArmee)
    {
        $this->nomArmee=$nomArmee;
    }

    public function setIdFaction($idFaction)
    {
        $this->idFaction=$idFaction;
    }

    public function setNomFaction($nomFaction)
    {
        $this->nomFaction=$nomFaction;
    }

    public function getId()
    {
        return $this->idArmee;
    }

    public function getNomArmee()
    {
        return $this->nomArmee;
    }

    public function getIdFaction()
    {
        return $this->idFaction;
    }

    public function getNomFaction()
    {
        return $this->nomFaction;
    }
}