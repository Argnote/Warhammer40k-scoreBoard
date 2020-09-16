<?php

namespace warhammerScoreBoard\managers;

use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\models\Utilisateur;


class UtilisateurManager extends Manager {


    public function __construct()
    {
        parent::__construct(Utilisateur::class, 'utilisateur');
    }

    public function getUtilisateur(array $data = ["*"], array $conditions = null)
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
        return $requete->queryGetValueToArray();
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
}