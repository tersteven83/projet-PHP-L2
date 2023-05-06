<?php

namespace App\Core;

use App\Controllers\Controller;
use App\Controllers\MainController;

/**
 * Notre routeur principal
 */
class Main
{
    public function start()
    {
        //on démarre la session
        session_start();

        
        //on rétire le "trailing slash de l'URL"
        // on récupère l'URL
        $uri = $_SERVER['REQUEST_URI'];

        //On vérifie que l'URL n'est pas vide et se termine par un '/'
        if(!empty($uri) && $uri != "/" && $uri[-1] == '/'){
            //on enlève le '/'

            $uri = substr($uri, 0, -1);

            //on envoie une code de redirection permanente
            http_response_code(301);

            //on redirige vers l'url sans '/'
            header("Location: " . $uri);
        }

        //On gère les params 
        //p=controller/methode/parametres
        //on sépare les paramètres dans un tableau
        if(isset($_GET['p'])) $params = explode('/', $_GET['p']);

        if (isset($params[0]) && $params[0] != ''){
            
            //on récupère le nom du controlleur à instancier
            // On met un majuscul en premier lettre, on ajoute le namespace complet devant et on ajoute 'controller' après

            $controller = '\\App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';

            $controller = new $controller();

            //on récupère le 2e param de l'url et on le met dans action
            //if(isset($_SESSION['user']['roles']))
            $action = (isset($params[0])) ? array_shift($params) : 'index';


            //on verifie si le methode existe dans le controller
            if(method_exists($controller, $action)){
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            }else{
                //la methode n'existe pas
                http_response_code(404);
                echo "La page que vous cherchez n'existe pas";
            }


        }else{
            //on n'a pas de paramètres
            //si l'user est déjà connecté, on le dirige vers son profil
            $controller = new Controller;
            if($controller->isConnected()){
                
                if(isset($_SESSION['user']['roles'])){
                    header('Location: /pers/profil');
                }else{
                    header('Location: /etudiant/profil');
                }
            }else{
                var_dump($_SESSION);die;
            }
        }
    }
}