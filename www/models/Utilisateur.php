<?php

namespace warhammerScoreBoard\models;

class Utilisateur extends Model
{
    protected $idUtilisateur;
    protected $nomUtilisateur;
    protected $prenom;
    protected $dateDeNaissance;
    protected $pseudo;
    protected $motDePasse;
    protected $email;
    protected $token;
    protected $equipe;
    protected $idRole;
    protected $dateInscription;


    /* SETTERS */

    public function setIdUtilisateur($id)
    {
        $this->idUtilisateur=$id;
    }

    public function setEmail($email)
    {
        $this->email=strtolower($email);
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }
    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse=sha1($motDePasse);
    }

    public function setNomUtilisateur($nomUtilisateur)
    {
        $this->nomUtilisateur=strtoupper($nomUtilisateur);
    }

    public function setPrenom($prenom)
    {
        $this->prenom=ucfirst(strtolower($prenom));
    }

    public function setDateDeNaissance( $dateDeNaissance)
    {
        $this->dateDeNaissance=$dateDeNaissance;
    }

    public function setIdRole($idRole)
    {
        $this->idRole = $idRole;
    }

    public function setEquipe($equipe)
    {
        $this->equipe = $equipe;
    }
    public function setToken($token)
    {
        $this->token = $token;
    }
    public function setDateInscription( $dateInscription)
    {
        $this->dateInscription = $dateInscription;
    }

    /* GETTERS */

    public function getId()
    {
        return $this->idUtilisateur;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    public function getNomUtilisateur()
    {
        return $this->nomUtilisateur;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getDateDeNaissance()
    {
        return $this->dateDeNaissance;
    }

    public function getIdRole()
    {
        return $this->idRole;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getEquipe()
    {
        return $this->equipe;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }
    public function getDateInscription()
    {
        return $this->dateInscription;
    }
}

?>