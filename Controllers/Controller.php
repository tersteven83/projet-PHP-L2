<?php

namespace App\Controllers;

class Controller
{
    public function render(string $fichier, array $donnee = [], string $template = 'default')
    {
        //On extrait le contenu du donnée
        extract($donnee);

        //on démarre le buffet de sortie
        ob_start();

        //on crée le chemin vers la vue
        require_once ROOT . '/Views/' . $fichier . '.php';

        $content = ob_get_clean();

        require_once ROOT . '/Views/' . $template . '.php';
    }

    public function isConnected()
    {
        if (isset($_SESSION['user']['id'])) return true;
        else {
            header('Location: /etudiant/login');
            $_SESSION['info'] = "Veuillez vous connecter à un compte";
            exit;
        }
    }

    /**
     * Vérifie si on est admin
     * @return boolean
     */
    public function isAdmin()
    {
        //on vérifie si on est connecté et si "ROLE_ADMIN" est dans notre role
        if (isset($_SESSION['user']) && isset($_SESSION['user']['roles'])  && (strchr($_SESSION['user']['roles'], "ROLE_ADMIN"))) {
            //on est admin
            return true;
        }// else {
        //     //on n'est pas admin
        //     $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone.";
        //     //var_dump($_SESSION['user']);die;
        //     http_response_code(404);
        //     header('Location: ' . $_SERVER['HTTP_REFERER']);
        //     exit;
        // }
    }

    /**
     * mamerina ny date ho tonga lundi anle semaine
     * @param string $date
     * @return string lundi anle semaine
     */
    public function debutSemaine(string $date): string
    {
        $week = date('w', strtotime($date));
        $day = date('d', strtotime($date));
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        if ($week != 1) {
            $day = $day - $week + 1;
        }

        $date = $year . '-' . $month . '-' . $day;

        return $date;
    }
}
