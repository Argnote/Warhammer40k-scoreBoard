<?php


namespace warhammerScoreBoard\models;


class Role extends Model
{
    protected $idRole;
    protected $nomRole;

    public function setIdRole($idRole)
    {
        $this->idRole = $idRole;
    }

    public function setNomRole($nomRole)
    {
        $this->nomRole = $nomRole;
    }

    public function getIdRole()
    {
        return $this->idRole;
    }

    public function getNomRole()
    {
        return $this->nomRole;
    }
}