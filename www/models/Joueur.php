<?php


namespace warhammerScoreBoard\models;


class Joueur extends Model
{
    protected $idJoueur;
    protected $nomJoueur;
    protected $gagnant;
    protected $idUtilisateur;
    protected $idArmee;
    protected $idPartie;

    public function setIdJoueur(int $idJoueur)
    {
        $this->idJoueur = $idJoueur;
    }

    public function setNomJoueur(string $nomJoueur)
    {
        $this->nomJoueur = $nomJoueur;
    }

    public function setGagnant(bool $gagnant)
    {
        $this->gagnant = $gagnant;
    }

    public function setIdUtilisateur(int $idUtilisateur)
    {
        $this->idUtilisateur = $idUtilisateur;
    }

    public function setIdArmee(int $idArmee)
    {
        $this->idArmee = $idArmee;
    }

    public function setIdPartie(int $idPartie)
    {
        $this->idPartie = $idPartie;
    }

    public function getId()
    {
        return $this->idJoueur;
    }

    public function getIdNomJoueur()
    {
        return $this->nomJoueur;
    }

    public function getGagnant()
    {
        return $this->gagnant;
    }

    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    public function getIdArmee()
    {
        return $this->idArmee;
    }

    public function getIdPartie()
    {
        return $this->idPartie;
    }
}