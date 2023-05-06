<?php

use App\Autoloader;
use App\Core\Main;

//On définit une constante contenant la racine du directory
define('ROOT', dirname(__DIR__));

//On importe l'autoloader
require_once(ROOT . '/Autoloader.php');
Autoloader::register();

//On instancie Main.. notre routeur
$app = new Main();
//on démarre l'app
$app->start();