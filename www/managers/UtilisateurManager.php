<?php

namespace warhammerScoreBoard\managers;

use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\models\Utilisateur;


class UtilisateurManager extends Manager {


    public function __construct()
    {
        parent::__construct(Utilisateur::class, 'user');
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
        $user->setId($id);
        $user->setToken($token);
        $this->save($user);
    }
}