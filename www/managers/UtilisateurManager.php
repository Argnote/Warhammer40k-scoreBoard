<?php

namespace warhammerScoreBoard\managers;

use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\models\Role;
use warhammerScoreBoard\models\Utilisateur;


class UtilisateurManager extends Manager {


    public function __construct()
    {
        parent::__construct(Utilisateur::class, 'utilisateur');
    }

    public function getUilisateur(array $data = ["*"], array $conditions = null)
    {
        $requete = new QueryBuilder(Utilisateur::class, 'utilisateur');
        $requete->querySelect($data);
        $requete->queryFrom();
        $requete->queryJoin("utilisateur","role","idRole","idRole");
        if(!empty($conditions))
        {
            foreach ($conditions as $condition )
            {
                $requete->queryWhere($condition[0], $condition[1], $condition[2]);
            }
        }
        return $requete;
    }

    public function getUtilisateurToObject(array $data = ["*"], array $conditions = null)
    {
        $requete = $this->getUilisateur($data,$conditions);
        return $requete->queryGetValue();
    }

    public function getUtilisateurToArray(array $data = ["*"], array $conditions = null)
    {
        $requete = $this->getUilisateur($data,$conditions);
        return $requete->queryGetValueToArray();
    }

    public function getAllUtilisateur()
    {
        $requete = new QueryBuilder(Utilisateur::class, 'utilisateur');
        $requete->querySelect("*");
        $requete->queryFrom();
        $requete->queryJoin("utilisateur","role","idRole","idRole");
        $requete->queryOrderBy("dateInscription","DESC");
        return $requete->queryGetArray();
    }
    public function manageUserToken($id,$token,$values = null)
    {
        $user = new Utilisateur();
        //utilisation de l'hydrate si on veux passer d'autres attribut en plus que l'id et le token
        if(!empty($values))
        {
            $user = $user->hydrate($values);
        }
        //innitialisation du token dans la db pour l'id indiqué
        $user->setIdUtilisateur($id);
        $user->setToken($token);
        $this->save($user);
    }

    public function getAllRole()
    {
        $requete = new QueryBuilder(Role::class, 'role');
        $requete->querySelect("*");
        $requete->queryFrom();
        return $requete->queryGetArrayToArray();
    }

    public function getRole(int $idRole)
    {
        $requete = new QueryBuilder(Role::class, 'role');
        $requete->querySelect("*");
        $requete->queryFrom();
        $requete->queryWhere("idRole","=",$idRole);
        return $requete->queryGetValue();
    }
}