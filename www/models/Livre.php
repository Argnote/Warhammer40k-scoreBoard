<?php


namespace warhammerScoreBoard\models;


class Livre extends Model
{
    protected $idLivre;
    protected $nomLivre;
    protected $codeLivre;

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