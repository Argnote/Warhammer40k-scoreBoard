<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
session_start();

use warhammerScoreBoard\core\ConstantLoader;
use warhammerScoreBoard\core\MiddleWareManager;
use warhammerScoreBoard\core\Router;

function myAutoloader($class)
{
    $class = str_replace('warhammerScoreBoard','',$class);
    $class = str_replace('\\', '/', $class).'.php';
    if($class[0] == '/')
        $class = substr($class, 1);
    if (file_exists($class))
        include ($class);
    else
        die("class ".$class." non trouvé");
}

spl_autoload_register("myAutoloader");

$environnement = "prod";
new ConstantLoader($environnement);

$uri = $_SERVER["REQUEST_URI"];
if(!isset($_SERVER["HTTPS"]) && $environnement == "prod")
    header("Location:".URL_HOST);
MiddleWareManager::launch('onRequest');
new Router();