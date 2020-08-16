<?php

namespace HotelFactory\core\tools;

class Token
{
    public static function getToken()
    {
        //création d'une suite de 15 chiffres puis cryptage afin d'être utilisé en token
        $token = '';
        for($i = 0; $i <15; $i++ )
        {
            $token .= mt_rand(0,9);
        }
        return sha1($token);
    }
}
