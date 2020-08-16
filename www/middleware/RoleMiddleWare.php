<?php

namespace warhammerScoreBoard\middleware;

use warhammerScoreBoard\core\Request;

class RoleMiddleWare
{
    public function onRequest(Request $request)
    {
        //SI j'ai pas le rôle USER alors redirection
        //echo "Je suis sur la Request avant mon controlleur !!!!<br>";
    }

    public function onController()
    {
        //echo "Je suis sur le controlleur !!!!<br>";
    }

    public function onView(Request $request)
    {
        // assigner la valeur request => $request
        //echo "Je peux agir sur la view<br>";
    }
}